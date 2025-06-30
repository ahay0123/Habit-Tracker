@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="h4 fw-bold mb-4">
        {{ isset($habit) ? 'Edit Habit' : 'Tambah Habit' }}
    </h2>

    <form action="{{ isset($habit)
        ? route('habits.update', $habit->id)
        : route('habits.store') }}" method="POST">

        @csrf
        {{-- Gunakan @method jika update --}}
        {{-- Tidak pakai PUT karena kamu pakai POST juga di route update --}}

        <div class="mb-3">
            <label class="form-label">Nama Habit</label>
            <input type="text"
                name="name"
                value="{{ old('name', $habit->name ?? '') }}"
                class="form-control @error('name') is-invalid @enderror"
                required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description"
                class="form-control @error('description') is-invalid @enderror"
                rows="3">{{ old('description', $habit->description ?? '') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis</label>
            <select name="type"
                class="form-select @error('type') is-invalid @enderror">
                <option value="habit" {{ old('type', $habit->type ?? 'habit') == 'habit' ? 'selected' : '' }}>
                    Habit
                </option>
                <option value="task" {{ old('type', $habit->type ?? '') == 'task' ? 'selected' : '' }}>
                    Task
                </option>
            </select>
            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            @php
            $selectedCategories = isset($habit)
            ? $habit->categories->pluck('id')->toArray()
            : [];
            @endphp
            @foreach ($allCategories as $category)
            <div class="form-check">
                <input class="form-check-input"
                    type="checkbox"
                    name="categories[]"
                    value="{{ $category->id }}"
                    {{ in_array($category->id, old('categories', $selectedCategories)) ? 'checked' : '' }}>
                <label class="form-check-label">
                    {{ $category->name }}
                </label>
            </div>
            @endforeach
            @error('categories') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>


        <div class="mb-3">
            <label class="form-label">Jadwal Hari</label><br>
            @php
            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            $selectedDays = isset($habit)
            ? $habit->schedules->pluck('day')->toArray()
            : [];
            @endphp
            @foreach ($days as $day)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox"
                    name="days[]"
                    value="{{ $day }}"
                    {{ in_array($day, old('days', $selectedDays)) ? 'checked' : '' }}>
                <label class="form-check-label text-capitalize">{{ $day }}</label>
            </div>
            @endforeach
            @error('days') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>


        <button class="btn btn-primary">
            {{ isset($habit) ? 'Update Habit' : 'Simpan Habit' }}
        </button>
        <a href="{{ route('habits.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection