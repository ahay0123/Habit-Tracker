<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Habit;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class HabitController extends Controller
{
    /**
     * Tampilkan semua habit milik user (sementara user #1).
     */
    public function index(Request $request)
    {
        $userId = 1;
        $day = $request->query('day');
        $type = $request->query('type');
        $habits = Habit::where('user_id', $userId)
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->when($day !== null && $day !== '', function ($query) use ($day) {
                $query->whereHas('schedules', function ($q) use ($day) {
                    $q->where('day', strtolower($day));
                });
            })
                ->with('schedules')
                ->latest()
                ->get();

        return view('habits.index', compact('habits', 'day', 'type'));
    }

    /**
     * Form tambah habit.
     */
    public function create()
    {
        $allCategories = Category::where('user_id', 1)->get();
        return view('habits.form', compact('allCategories'));              // mode tambah
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
            'days.*'      => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
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
            $habit->schedules()->create(['day' => $day]);
        }

        $habit->categories()->sync($request->categories ?? []);

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
        $allCategories = Category::where('user_id', 1)->get();
        return view('habits.form', compact('habit', compact('allCategories'))); // mode edit

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
            'days.*'      => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        ]);

        $habit->update($validated);

        $habit->schedules()->delete();
        foreach ($request->days as $day) {
            $habit->schedules()->create(['day' => $day]);
        }

        $habit->categories()->sync($request->categories ?? []);

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
