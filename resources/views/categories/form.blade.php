@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">{{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori' }}</h4>

    <form action="{{ isset($category)
        ? route('categories.update', $category->id)
        : route('categories.store') }}"
        method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $category->name ?? '') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary">
            {{ isset($category) ? 'Update' : 'Simpan' }}
        </button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
