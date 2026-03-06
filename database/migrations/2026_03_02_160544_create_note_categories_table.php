<?php
// database/migrations/[дата]_create_note_category_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('note_categories', function (Blueprint $table) {
            $table->id();
            $table->name();
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('note_categories');
    }
};