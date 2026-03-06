<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'reset:admin-password';
    protected $description = 'Reset admin password';

    public function handle()
    {
        $user = User::where('email', 'admin@admin.com')->first();
        
        if ($user) {
            $user->password = Hash::make('12345678');
            $user->save();
            $this->info('Пароль администратора изменен на 12345678');
        } else {
            $this->error('Пользователь admin@admin.com не найден');
        }
    }
}