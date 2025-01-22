<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrannerWorkout extends Model
{
    protected $fillable = [
        'tranner_id',
        'workout_id'
    ];
    public function tranner(){
        return $this->belongsTo(Tranner::class);
    }
    public function workout(){
        return $this->belongsTo(Workout::class);
    }
}
