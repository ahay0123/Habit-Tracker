@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">Daftar Kategori</h4>

    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">
        + Tambah Kategori
    </a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Nama Kategori</th>
                    <th style="width: 20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>
                            <form action="{{ route('categories.delete', $category->id) }}"
                                method="POST"
                                onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada kategori.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection