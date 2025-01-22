<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $fillable = ['user_id', 'tranner_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tranner()
    {
        return $this->belongsTo(Tranner::class);
    }
}
