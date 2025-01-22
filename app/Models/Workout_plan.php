<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout_plan extends Model
{
    protected $fillable = ['duration', 'incrimination', 'Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun', 'plan_id', 'workout_id'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
}
