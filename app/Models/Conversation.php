<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    /**
     * The attributes that are mass not assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];


    public function lastMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }


    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id1');
    }


    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id2');
    }
}
