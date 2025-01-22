<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'email',
        'profile',
        'profile-hash',
        'sex',
        'height',
        "age",
        'weight'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // public function workouts()
    // {
    //     return $this->hasmany(Workout::class);
    // }
    public function user_plans()
    {
        return $this->hasMany(User_plan::class);
    }
    public function followers()
    {
        return $this->hasMany(Follower::class);
    }
    /**
     * Friends that this user has requested.
     */
    public function sentFriendRequests()
    {
        return $this->hasMany(Firend::class, 'requester');
    }

    /**
     * Friend requests this user has received.
     */
    public function receivedFriendRequests()
    {
        return $this->hasMany(Firend::class, 'receiver');
    }

    /**
     * Get all friends (approved friendships).
     */
    public function friends()
    {
        return $this->belongsToMany(
            User::class,
            'friends',
            'requester',
            'receiver'
        )->withPivot('status'); // Assuming you have a 'status' column to track approval
    }
    public function messages()
    {
        return $this->morphToMany(Message::class, 'sender');
    }
    public function userWorkouts()
    {
        return $this->hasMany(UserWorkout::class);
    }
    public function customPlans()
    {
        return $this->hasMany(CustomPlans::class);
    }
}
