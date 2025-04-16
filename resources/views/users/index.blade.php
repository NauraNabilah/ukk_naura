@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 fw-bold text-black">Kelola Pengguna</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
            <i class="ti ti-plus me-1"></i> Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0 align-middle">
                    <thead class="table-light text-center small">
                        <tr>
                            <th>No</th>
                            <th class="text-start">Nama</th>
                            <th class="text-start">Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td class="text-start">{{ $user->name }}</td>
                            <td class="text-start">{{ $user->email }}</td>
                            <td class="text-center">{{ $user->role }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1 flex-wrap">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pengguna?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>
@endsection
