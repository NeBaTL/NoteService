<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixMigrations extends Command
{
    protected $signature = 'fix:migrations';
    protected $description = 'Fix migrations and create missing tables';

    public function handle()
    {
        $this->info('Проверка и исправление миграций...');

        // Добавляем записи в таблицу migrations
        $migrations = [
            '2026_03_02_160535_create_notes_table',
            '2026_03_02_160544_create_note_categories_table',
            '2026_03_02_160549_create_note_category_table',
        ];

        foreach ($migrations as $migration) {
            $exists = DB::table('migrations')
                ->where('migration', $migration)
                ->exists();

            if (!$exists) {
                DB::table('migrations')->insert([
                    'migration' => $migration,
                    'batch' => 2
                ]);
                $this->info("✓ Миграция {$migration} отмечена как выполненная");
            } else {
                $this->info("• Миграция {$migration} уже отмечена");
            }
        }

        // Проверяем и создаем таблицу notes_category если её нет
        if (!Schema::hasTable('notes_category')) {
            $this->info('Создание таблицы notes_category...');
            Schema::create('notes_category', function ($table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('name');
                $table->timestamps();
            });
            $this->info('✓ Таблица notes_category создана');
        } else {
            $this->info('• Таблица notes_category уже существует');
        }

        // Проверяем и создаем таблицу category_note если её нет
        if (!Schema::hasTable('category_note')) {
            $this->info('Создание таблицы category_note...');
            Schema::create('category_note', function ($table) {
                $table->id();
                $table->foreignId('note_id')->constrained()->onDelete('cascade');
                $table->foreignId('category_id')->constrained('notes_category')->onDelete('cascade');
                $table->timestamps();
            });
            $this->info('✓ Таблица category_note создана');
        } else {
            $this->info('• Таблица category_note уже существует');
        }

        $this->info('✅ Все исправления завершены!');
        
        return Command::SUCCESS;
    }
}