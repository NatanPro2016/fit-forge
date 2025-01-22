<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWorkout extends Model
{
    protected $fillable = [
        'user_id',
        'workout_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function workout(){
        return $this->belongsTo(Workout::class);
    }
    
    
}
