<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TelegramMessage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TelegramMessageController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                "telegram_message_id" => "required|integer",
                "date" => "required|integer",
                "text" => "nullable|string",
                "media" => "boolean",
                "media_type" => "nullable|string",
                "out" => "boolean",
                "mentioned" => "boolean",
                "views" => "nullable|integer",
                "forwards" => "nullable|integer",
            ]);

            $validated["date"] = date("Y-m-d H:i:s", $validated["date"]);
            $validated["received_at"] = now();
            
            $message = TelegramMessage::updateOrCreate(
                ["telegram_message_id" => $validated["telegram_message_id"]],
                $validated
            );

            return response()->json([
                "success" => true,
                "data" => $message,
                "message" => "Message saved successfully"
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "file" => $e->getFile(),
                "line" => $e->getLine()
            ], 500);
        }
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $messages = TelegramMessage::orderBy("date", "desc")->paginate(20);
            
            return response()->json([
                "success" => true,
                "data" => $messages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
