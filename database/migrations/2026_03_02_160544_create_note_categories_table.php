<?php
// database/migrations/[дата]_create_note_category_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('note_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('note_id')->constrained()->onDelete('cascade');
            $table->foreignId('note_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Заметка не может быть дважды привязана к одной категории
            $table->unique(['note_id', 'note_category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('note_category');
    }
};