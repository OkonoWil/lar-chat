<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class  DatabaseSeeder extends Seeder
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

        Message::factory(10000)->create();

        $messages = Message::whereNull('group_id')->orderBy('created_at')->get();

        $conversations = $messages->groupBy(function($message){
            return collect([$message->sender_id, $message->receiver_id])->sort()->implode('_');
        })->map(function ($groupMessages){
            return [
                'user_id1' => $groupMessages->first()->sender_id,
                'user_id2' => $groupMessages->first()->receiver_id,
                'last_message_id' => $groupMessages->last()->id,
                'created_at' => $groupMessages->first()->created_at,
                'updated_at' => $groupMessages->last()->updated_at
            ];
        })->values();

        Conversation::insertOrIgnore($conversations->toArray());
    }
}
