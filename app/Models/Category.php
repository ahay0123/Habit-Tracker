<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name'];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function habits()
    {
        return $this->belongsToMany(Habit::class, 'habit_category');
    }
}
