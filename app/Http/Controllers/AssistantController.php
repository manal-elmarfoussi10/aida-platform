<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Events\AssistantStatusUpdated;
use App\Events\AiResponded;
use App\Models\AiRequest;
use App\Models\Integration;
use OpenAI\Laravel\Facades\OpenAI; // ✅ Use OpenAI facade

class AssistantController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $prompt = $request->input('prompt', 'Hello');
        $response = "AI: I received your prompt: \"$prompt\"";

        AiRequest::create([
            'user_id' => $user->id,
            'message' => $prompt,
            'response' => $response,
        ]);

        $assistant = [
            'id' => 1,
            'name' => 'Humanoid Assistant',
            'status' => 'Online',
        ];

        broadcast(new AssistantStatusUpdated($assistant))->toOthers();

        $integrations = Integration::all();
        $logs = AiRequest::where('user_id', $user->id)->latest()->take(20)->get()->reverse();

        return view('assistants.index', compact('assistant', 'response', 'integrations', 'logs'));
    }

    public function history()
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $logs = AiRequest::where('user_id', $user->id)->latest()->get();
        return view('assistants.history', compact('logs'));
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $prompt = $request->input('prompt', '');
        $text = 'No response from AI.';

        try {
            $result = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a smart building assistant.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            Log::info('OpenAI response', ['response' => $result]);

            $text = $result->choices[0]->message->content ?? 'No response from AI.';
        } catch (\Exception $e) {
            $text = '⚠️ API Error: ' . $e->getMessage();
            Log::error('OpenAI API error', ['exception' => $e]);
        }

        AiRequest::create([
            'user_id' => $user->id,
            'message' => $prompt,
            'response' => $text,
        ]);

        broadcast(new AiResponded($text))->toOthers();

        return response()->json(['response' => $text]);
    }

    public function chatView()
    {
        return view('assistants.chat');
    }
}