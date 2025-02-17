<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'video',
        'type',
        'tranner_id'
    ];
    public function tranner()
    {
        return $this->belongsTo(Tranner::class);
    }
    public function workout_plans()
    {
        return $this->hasMany(Workout_plan::class);
    }
    public function user_workout()
    {
        return $this->belongsTo(UserWorkout::class, );
    }
    public function trannerWorkouts()
    {
        return $this->hasMany(TrannerWorkout::class);
    }
    public function userWorkouts()
    {
        return $this->hasMany(UserWorkout::class);
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_workouts', 'workout_id', 'user_id')
            ->withTimestamps();
    }

}
