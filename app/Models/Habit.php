<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    //
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(HabitSchedule::class);
    }

    public function trackings()
    {
        return $this->hasMany(HabitTracking::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'habit_category');
    }
}
