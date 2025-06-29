<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitTracking;
use Illuminate\Http\Request;

class HabitTrackingController extends Controller
{
    //
    public function store(Habit $habit)
    {
        $userId = 1;

        // Cek apakah sudah ada tracking hari ini
        $existing = HabitTracking::where('habit_id', $habit->id)
            ->where('user_id', $userId)
            ->where('date', now()->toDateString())
            ->first();

        if ($existing) {
            return redirect()->route('habits.show', $habit->id)
                ->with('info', 'Habit sudah ditandai selesai hari ini');
        }

        HabitTracking::create([
            'habit_id' => $habit->id,
            'user_id' => $userId,
            'date' => now()->toDateString(),
            'is_done' => true,
        ]);

        return redirect()->route('habits.show', $habit->id)
            ->with('success', 'Habit ditandai selesai untuk hari ini!');
    }
}
