@extends('layouts.app')

@section('title', 'Edit Pengajuan Google')

@section('content')
    <h1 class="mb-3">
        Edit Pengajuan Reset Google</h1>

    <a href="{{ route('admin.pengajuan-google.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('pengajuan_google.form', [
        'action' => route('pengajuan-google.update', $data->id),
        'method' => 'PUT',
        'button' => 'Update',
        'siswas' => $siswas,
        'data' => $data,
    ])
@endsection
