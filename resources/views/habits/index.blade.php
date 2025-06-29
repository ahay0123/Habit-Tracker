@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="h4 fw-bold mb-4">Daftar Habits</h2>

    <a href="{{ route('habits.create') }}" class="btn btn-primary mb-4">
        + Tambah Habit
    </a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        @forelse($habits as $habit)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $habit->name }}</h5>
                    <p class="card-text text-muted mb-2" style="min-height: 3em;">
                        {{ $habit->description ?? '-' }}
                    </p>
                    <span class="badge bg-primary text-capitalize">{{ $habit->type }}</span>
                </div>
                <div class="card-footer bg-white border-0 d-flex justify-content-between">
                    <a href="{{ route('habits.show', $habit->id) }}"
                        class="btn btn-sm btn-info">Lihat</a>

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
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                Belum ada habit yang ditambahkan.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection