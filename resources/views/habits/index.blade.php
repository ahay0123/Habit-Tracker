@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 fw-bold mb-0">Daftar Habit</h2>
        <a href="{{ route('habits.create') }}" class="btn btn-success">
            + Tambah Habit
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul class="list-group">
        @forelse ($habits as $habit)
        <li class="list-group-item d-flex justify-content-between align-items-start mt-2">
            <div class="ms-2 me-auto">
                <div class="fw-semibold">{{ $habit->name }}</div>
                <small class="text-muted">{{ $habit->description }}</small>
                <span class="badge bg-primary ms-2">{{ $habit->type }}</span>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('habits.edit', $habit->id) }}"
                    class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('habits.delete', $habit->id) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus habit ini?')">
                    @csrf
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </div>
        </li>
        @empty
        <li class="list-group-item text-center">Belum ada habit.</li>
        @endforelse
    </ul>

</div>
@endsection