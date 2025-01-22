<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Firend extends Model
{
    private $fillable =[
        "requester",
        "receiver"
    ];
    public function requester(){
        return $this->belongsTo(User::class);
    }
    public function receiver(){
        return $this->belongsTo(User::class);
    }
}
