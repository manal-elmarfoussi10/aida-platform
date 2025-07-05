<?php

namespace App\Ai;

use OpenAI\Laravel\Facades\OpenAI;
use App\Ai\Functions\ZoneFunctions;
use App\Ai\Functions\DeviceFunctions;

class AssistantService
{
    public static function handle($prompt)
    {
        $functions = [
            [
                "name" => "countZones",
                "description" => "Get the number of zones in the building",
                "parameters" => ["type" => "object", "properties" => new \stdClass()]
            ],
            [
                "name" => "getZoneNames",
                "description" => "List all zone names",
                "parameters" => ["type" => "object", "properties" => new \stdClass()]
            ],
            [
                "name" => "countDevices",
                "description" => "Get the number of devices",
                "parameters" => ["type" => "object", "properties" => new \stdClass()]
            ],
        ];

        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo-0613',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an assistant for a smart building. Use available functions if needed.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'functions' => $functions,
            'function_call' => 'auto',
        ]);

        $choice = $result['choices'][0]['message'];

        if (isset($choice['function_call'])) {
            $name = $choice['function_call']['name'];

            switch ($name) {
                case 'countZones':
                    $data = ZoneFunctions::countZones();
                    break;
                case 'getZoneNames':
                    $data = ZoneFunctions::getZoneNames();
                    break;
                case 'countDevices':
                    $data = DeviceFunctions::countDevices();
                    break;
                default:
                    $data = "Function not implemented.";
            }

            $result = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo-0613',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an assistant for a smart building.'],
                    ['role' => 'function', 'name' => $name, 'content' => $data],
                ]
            ]);

            return $result['choices'][0]['message']['content'];
        }

        return $choice['content'] ?? "I don't know how to answer that.";
    }
}

