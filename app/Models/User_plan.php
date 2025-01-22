<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_plan extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'worked_dates', 'paued_number'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
