<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIReportAssistantController extends Controller
{
    public function respond(Request $request)
    {
        $prompt = $request->input('prompt');

        $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an AI assistant for a smart building report system. Respond clearly and concisely.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return response()->json([
            'reply' => $response['choices'][0]['message']['content']
        ]);
    }
}
