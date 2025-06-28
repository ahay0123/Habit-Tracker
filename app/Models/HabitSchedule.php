<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HabitSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['habit_id', 'day'];
    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }
}
