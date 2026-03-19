<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramMessage extends Model
{
    use HasFactory;

    protected $table = "telegram_messages";
    
    protected $fillable = [
        "telegram_message_id",
        "date",
        "text",
        "media",
        "media_type",
        "out",
        "mentioned",
        "views",
        "forwards",
        "received_at",
    ];

    protected $casts = [
        "date" => "datetime",
        "received_at" => "datetime",
        "media" => "boolean",
        "out" => "boolean",
        "mentioned" => "boolean",
    ];
}
