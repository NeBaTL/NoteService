<?php

namespace App\Console\Commands\Telegram;

use Illuminate\Console\Command;

class ImportSavedMessages extends Command
{
    protected $signature = "telegram:import-saved 
                            {--limit= : Limit messages}
                            {--offset=0 : Offset ID}";
    
    protected $description = "Import saved messages from Telegram";

    public function handle()
    {
        $this->info("Starting Telegram import...");
        
        $limit = $this->option("limit");
        $offset = $this->option("offset");
        
        $pythonScript = base_path("telegram_import/saved_messages.py");
        
        $command = "python $pythonScript";
        
        if ($limit) {
            $command .= " --limit $limit";
        }
        
        if ($offset) {
            $command .= " --offset $offset";
        }
        
        $command .= " --laravel-url " . config("app.url");
        
        $this->info("Executing: $command");
        
        $output = shell_exec($command . " 2>&1");
        
        $this->line($output);
        
        $this->info("Import completed!");
        
        return Command::SUCCESS;
    }
}