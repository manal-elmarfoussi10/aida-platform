<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\AiRequest;
use App\Models\ZoneV2;
use App\Models\Device;
use App\Events\AiResponded;

class AssistantController extends Controller
{
    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $prompt = $request->input('prompt', '');

        // Step 1: Load live data
        $zones = ZoneV2::all()->toArray();
        $devices = Device::all()->toArray();

        // Step 2: Provide system context
        $systemMessage = "You are Aida, a smart assistant for building management. You control Zones and Devices.\n\n";
        $systemMessage .= "Zones:\n" . json_encode($zones, JSON_PRETTY_PRINT) . "\n\n";
        $systemMessage .= "Devices:\n" . json_encode($devices, JSON_PRETTY_PRINT);

        // Step 3: Send to OpenAI
        try {
            $openAiResponse = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => $systemMessage],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            $text = $openAiResponse->json('choices.0.message.content') ?? 'No response from AI.';
        } catch (\Exception $e) {
            $text = '⚠️ API Error: ' . $e->getMessage();
        }

        // Step 4: Try to apply any detected updates
        if (preg_match('/set (\w[\w\s\-]+) of device ([\w\s\-]+) to ([\w#\s\-]+)/i', strtolower($prompt), $m)) {
            $field = trim($m[1]);
            $deviceName = trim($m[2]);
            $value = trim($m[3]);

            $updateResult = $this->updateDeviceField($deviceName, $field, $value);
            $text .= "\n\n" . $updateResult;
        }

        // Step 5: Log request to database
        AiRequest::create([
            'user_id' => $user->id,
            'message' => $prompt,
            'response' => $text,
        ]);

        // Send to frontend
        broadcast(new AiResponded($text))->toOthers();

        return response()->json(['response' => $text]);
    }

    public function chatView()
    {
        return view('assistants.chat'); // Blade view
    }

    private function updateDeviceField($deviceName, $field, $value)
    {
        $device = Device::whereRaw('LOWER(device_name) = ?', [strtolower($deviceName)])->first();

        if (!$device) {
            return "❌ Device \"$deviceName\" not found.";
        }

        $allowedFields = [
            'temperature', 'dimmer', 'color_temperature',
            'rgb_color', 'shades', 'current_status', 'manual_control'
        ];

        $aliases = [
            'color' => 'rgb_color',
            'brightness' => 'dimmer',
            'status' => 'current_status',
        ];

        $normalizedField = $aliases[$field] ?? $field;

        if (!in_array($normalizedField, $allowedFields)) {
            return "⚠️ \"$field\" is not a valid field I can update.";
        }

        $device->$normalizedField = is_numeric($value) ? (float)$value : $value;
        $device->save();

        return "✅ \"$normalizedField\" of device \"$deviceName\" updated to \"$value\".";
    }
}