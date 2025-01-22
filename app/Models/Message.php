<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'message',
        'image',
        'video',
        'message_id',
        'sender_id',
        'sender_type',
        'recipient_id',
        'recipient_type',
        'chat_id'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender()
    {
        return $this->morphedByMany(User::class ,'messages' );
    }

}
