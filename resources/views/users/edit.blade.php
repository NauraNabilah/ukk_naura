@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="container mx-auto mt-6">
    <div class="bg-white rounded shadow-sm">
        <div class="bg-blue-600 text-white p-4 rounded-t">
            <h2 class="text-xl font-bold">Edit Pengguna</h2>
        </div>
        <div class="p-6">
            @if($errors->any())
                <div class="bg-red-500 text-white p-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-gray-700">Role</label>
                    <select name="role" id="role" class="w-full p-2 border rounded" required>
                        <option value="">--Pilih Role--</option>
                        <option value="admin" {{ old('role', $user->role)=='admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ old('role', $user->role)=='petugas' ? 'selected' : '' }}>Petugas</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" id="password" class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border rounded">
                </div>
                <div class="flex justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                        Update
                    </button>
                    <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
