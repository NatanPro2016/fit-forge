<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomPlans extends Model
{
    protected $fillable = ['title', 'description', 'duration', 'type', 'count', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
