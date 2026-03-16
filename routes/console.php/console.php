<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('create:admin', function () {
    User::create([
        'name' => 'Admin',
        'email' => 'admin@555.az',
        'password' => Hash::make('admin123'),
        'role' => 'super-admin',
    ]);
    $this->info('Admin user created!');
})->purpose('Create admin user');
