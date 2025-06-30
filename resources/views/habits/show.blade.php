@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="h4 fw-bold mb-3">{{ $habit->name }}</h2>

    <p><strong>Deskripsi:</strong> {{ $habit->description ?? '-' }}</p>
    <p><strong>Jenis:</strong> {{ ucfirst($habit->type) }}</p>

    <hr>

    <h5 class="mb-3">📅 Log Harian</h5>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <form method="POST" action="{{ route('habits.track', $habit->id) }}">
        @csrf
        <input type="hidden" name="habit_id" value="{{ $habit->id }}">
        <button class="btn btn-sm btn-primary mb-3">
            Tandai Selesai Hari Ini
        </button>
    </form>

    @if ($trackings->isEmpty())
    <p class="text-muted">Belum ada log untuk habit ini.</p>
    @else
    @php
    $trackings = $habit->trackings()->orderByDesc('date')->get();
    @endphp

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trackings as $track)
            <tr>
                <td>{{ \Carbon\Carbon::parse($track->date)->format('d M Y') }}</td>
                <td>
                    @if ($track->is_done)
                    <span class="badge bg-success">✅ Selesai</span>
                    @else
                    <span class="badge bg-secondary">❌ Belum</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @endif

    <a href="{{ route('habits.index') }}" class="btn btn-secondary mt-3">← Kembali</a>
</div>
@endsection