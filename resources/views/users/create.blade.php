@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold text-dark">Nama</label>
                    <input type="text" name="name" id="name" 
                        value="{{ old('name') }}" 
                        class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold text-dark">Email</label>
                    <input type="email" name="email" id="email" 
                        value="{{ old('email') }}" 
                        class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label fw-semibold text-dark">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="">--Pilih Role--</option>
                        <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ old('role')=='petugas' ? 'selected' : '' }}>Petugas</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold text-dark">Password</label>
                    <input type="password" name="password" id="password" 
                        class="form-control" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold text-dark">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                        class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary btn-sm px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
