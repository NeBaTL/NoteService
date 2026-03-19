<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("telegram_messages", function (Blueprint $table) {
            $table->id();
            $table->bigInteger("telegram_message_id")->unique();
            $table->timestamp("date");
            $table->text("text")->nullable();
            $table->boolean("media")->default(false);
            $table->string("media_type")->nullable();
            $table->boolean("out")->default(false);
            $table->boolean("mentioned")->default(false);
            $table->integer("views")->nullable();
            $table->integer("forwards")->nullable();
            $table->timestamp("received_at");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("telegram_messages");
    }
};