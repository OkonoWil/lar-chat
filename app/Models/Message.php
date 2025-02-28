<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    /**
     * The attributes that are mass not assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];


    public function groups(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }


    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }


    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }


    public function attachements(): HasMany
    {
        return $this->hasMany(MessageAttachment::class);
    }

}
