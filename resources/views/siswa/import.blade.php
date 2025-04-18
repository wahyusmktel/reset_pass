@extends('layouts.app')

@section('title', 'Import Siswa')

@section('content')
    <h1 class="mb-4">Import Data Siswa dari Excel</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('siswa.import.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Pilih File Excel</label>
            <input type="file" name="file" id="file" class="form-control" required>
            <small class="text-muted">Format: xlsx | <a href="{{ asset('template/template_import_siswa.xlsx') }}">Download
                    Template</a></small>
        </div>
        <button class="btn btn-primary">Import</button>
    </form>
@endsection
