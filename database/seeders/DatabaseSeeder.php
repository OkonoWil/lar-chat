<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Okono Wilfried',
            'email' => 'okono@lar-chat.com',
            'password' => Hash::make('Test1234'),
            'is_admin' => true,
            'email_verified_at' => now()
        ]);

        User::factory()->create([
            'name' => 'Piper Mba',
            'email' => 'piper@gmail.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now()
        ]);

        User::factory()->create([
            'name' => 'Jowil',
            'email' => 'jowil@gmail.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now()
        ]);

        User::factory(28)->create();

        for ($i = 0; $i < 5; $i++) {
            $group = Group::factory()->create(['owner_id' => 1]);

            $users = User::inRandomOrder()->limit(rand(3, 7))->pluck('id');
            $group->users()->attach(array_unique([1, ...$users]));
        }

        Message::factory(1000)->creae();

        $messzzzzzz
    }
}
