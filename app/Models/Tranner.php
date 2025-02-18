<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Tranner extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'name',
        'username',
        'email',
        'sex',
        'age',
        'profile',
        'profilehash',
        'height',
        'weight',
        'password'
    ];
    protected $hidden = [
        'password'
    ];


    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
    public function Followers()
    {
        return $this->hasMany(Follower::class);
    }
    public function messages()
    {
        return $this->morphToMany(Message::class, 'sender');
    }
    public function trannerWorkouts()
    {
        return $this->hasMany(TrannerWorkout::class);
    }


    protected $guarded = [];

}
