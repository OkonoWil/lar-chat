<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Message User to User
        $senderId = $this->faker->randomElement([0, 1]);
        if ($senderId === 0) {
            $senderId = $this->faker->randomElement(User::where('id', '!=', 1)->pluck('id')->toArray());
            $receiverId = 1;

        } else {
            $receiverId = $this->faker->randomElement(User::where('id', '!=', 1)->pluck('id')->toArray());
        }

        // Message User to Group
        $groupId = null;

        if ($this->faker->boolean(30)) {
            $groupId = $this->faker->randomElement(Group::pluck('id')->toArray());
            $group = Group::find($groupId);

            $senderId = $this->faker->randomElement($group->users->pluck('id')->toArray());
            $receiverId = null;
        }

        return [
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'group_id' => $groupId,
            'content' => $this->faker->realText(500),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];

    }
}
