@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Judul Tampilan Berdasarkan Hari --}}
    <h5 class="text-muted mb-3">
        Menampilkan
        @if(request('type') === 'habit')
        habit
        @elseif(request('type') === 'task')
        task
        @else
        semua habit dan task
        @endif
        {{ $day ? 'untuk hari: ' . ucfirst($day) : '' }}
    </h5>

    {{-- Tombol Tambah + Dropdown Filter Hari --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <a href="{{ route('habits.create') }}" class="btn btn-primary">
            + Tambah Habit
        </a>

        <form method="GET" action="{{ route('habits.index') }}" class="d-flex align-items-center gap-2">
            <label for="day" class="fw-semibold mb-0">Filter Hari:</label>
            <select name="day" id="day" onchange="this.form.submit()" class="form-select form-select-sm w-auto">
                <option value="">Semua Hari</option>
                @foreach (['monday','tuesday','wednesday','thursday','friday','saturday','sunday'] as $d)
                <option value="{{ $d }}" {{ request('day') === $d ? 'selected' : '' }}>
                    {{ ucfirst($d) }}
                </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Daftar Habit --}}
    <div class="row g-3">
        <ul class="nav nav-pills mb-3">
            @foreach (['' => 'Semua', 'habit' => 'Habit', 'task' => 'Task'] as $value => $label)
            <li class="nav-item">
                <a class="nav-link {{ request('type') === $value ? 'active' : '' }}"
                    href="{{ route('habits.index', array_merge(request()->except('page'), ['type' => $value])) }}">
                    {{ $label }}
                </a>
            </li>
            @endforeach
        </ul>
        @forelse($habits as $habit)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-1">{{ $habit->name }}</h6>
                    <p class="text-muted mb-2" style="min-height: 3em;">
                        {{ $habit->description ?? '-' }}
                    </p>
                    <small class="text-muted d-block mb-2">
                        <span class="badge bg-primary text-capitalize">
                            Jenis: {{ ucfirst($habit->type) }}
                        </span><br>
                        Jadwal: {{ implode(', ', $habit->schedules->pluck('day')->map(fn($d) => ucfirst($d))->toArray()) }}
                    </small>
                    <p class="card-text">
                        <small class="text-muted">
                            Kategori:
                            @if($habit->categories->isEmpty())
                            <em>Tidak ada</em>
                            @else
                            {{ implode(', ', $habit->categories->pluck('name')->toArray()) }}
                            @endif
                        </small>
                    </p>
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
                Tidak ada
                @if(request('type') === 'habit')
                habit
                @elseif(request('type') === 'task')
                task
                @else
                habit atau tak
                @endif
                ditemukan
                @if($day)
                untuk hari ini
                @endif
            </div>
        </div>
        @endforelse
    </div>

</div>
@endsection