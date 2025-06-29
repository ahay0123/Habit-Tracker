<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    /**
     * Tampilkan semua habit milik user (sementara user #1).
     */
    public function index()
    {
        $userId = 1;                                         // TODO: ganti auth()->id() setelah login siap
        $habits = Habit::where('user_id', $userId)
            ->latest()
            ->get();

        return view('habits.index', compact('habits'));
    }

    /**
     * Form tambah habit.
     */
    public function create()
    {
        return view('habits.form');              // mode tambah
    }

    /**
     * Simpan habit baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:habit,task',
            'days'        => 'required|array|min:1',
            'days.*'      => 'in:monday,tuesday.wednesday.thursday,friday,saturday,sunday',
        ]);

        $validated['user_id'] = 1;                            // hard-code sementara
        // Habit::create($validated);
        $habit = Habit::create([
            'user_id' => 1,
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
        ]);

        foreach ($request->days as $day) {
            $habit->schedules()->create(['days' => $day]);
        }

        return redirect()
            ->route('habits.index')
            ->with('success', 'Habit berhasil ditambahkan!');
    }

    public function show(Habit $habit)
    {
        $trackings = $habit->trackings()->orderByDesc('date')->get();

        return view('habits.show', compact('habit', 'trackings'));
    }


    /**
     * Form edit habit.
     */
    public function edit(Habit $habit)
    {
        $habit->load('schedules');
        return view('habits.form', compact('habit')); // mode edit
    }

    /**
     * Update habit.
     */
    public function update(Request $request, Habit $habit)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:habit,task',
            'days'        => 'required|array|min:1',
            'days.*'      => 'in:monday,tuesday.wednesday.thursday,friday,saturday,sunday',
        ]);

        $habit->update($validated);

        $habit->schedules()->delete();
        foreach($request->days as $day) {
            $habit->schedules()->create(['day' => $day]);
        }

        return redirect()
            ->route('habits.index')
            ->with('success', 'Habit berhasil diperbarui!');
    }

    /**
     * Hapus habit.
     */
    public function destroy(Habit $habit)
    {
        $habit->delete();

        return redirect()
            ->route('habits.index')
            ->with('success', 'Habit berhasil dihapus!');
    }
}
