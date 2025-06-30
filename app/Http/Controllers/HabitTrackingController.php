<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitTracking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HabitTrackingController extends Controller
{
    //
    public function store(Request $request, Habit $habit)
    {
        $userId = 1;
        $request->validate([
            'habit_id' => 'required|exists:habits,id',
        ]);

        $habit = Habit::with('schedules')->findOrFail($request->habit_id);

        $today = strtolower(Carbon::now()->englishDayOfWeek);

        // cek apakah hari ini termasuk jadwal habit
        $isScheduledToday = $habit->schedules->contains('day', $today);

        if (!$isScheduledToday) {
            return back()->with('info', 'Habit ini tidak dijadwalkan untuk hari ini ' . ucfirst($today));
        }

        // Cek apakah sudah ada tracking hari ini
        $existing = HabitTracking::where('habit_id', $habit->id)
            ->where('user_id', $userId)
            ->where('date', Carbon::today())
            ->first();

        if ($existing) {
            return redirect()->route('habits.show', $habit->id)
                ->with('error', 'Habit sudah ditandai selesai hari ini');
        }

        HabitTracking::create([
            'habit_id' => $habit->id,
            'user_id' => $userId,
            'date' => Carbon::today(),
            'is_done' => true,
        ]);

        return redirect()->route('habits.show', $habit->id)
            ->with('success', 'Habit ditandai selesai untuk hari ini!');
    }
}
