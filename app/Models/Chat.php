<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Chat extends Model
{
    protected $fillable = [
        "sender_id",
        'sender_type',
        'recipient_id',
        'recipient_type',
    ];
    public function sender(): MorphTo
    {
        return $this->morphTo();
    }
    public function recipient(): MorphTo
    {
        return $this->morphTo();
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }


}
