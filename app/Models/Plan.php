<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['title', 'description', 'duration', 'type', 'count', 'tranner_id'];
    public function tranner()
    {
        return $this->belongsTo(Tranner::class);
    }
}
