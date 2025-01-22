<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutCustomPlan extends Model
{
    protected $fillable = ['duration', 'incrimination', 'Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun', 'custom_plan_id', 'workout_id'];

    public function customplan()
    {
        return $this->belongsTo(CustomPlans::class);
    }
    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
}
