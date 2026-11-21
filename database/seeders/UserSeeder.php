<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Exactly one user record. Log in with juan.delacruz@example.com / demo1234
     * (the "hashed" cast on the model stores it as a bcrypt hash).
     */
    public function run(): void
    {
        User::create([
            'username' => 'jdelacruz',
            'full_name' => 'Juan Dela Cruz',
            'email' => 'juan.delacruz@example.com',
            'password' => 'demo1234',
        ]);
    }
}
