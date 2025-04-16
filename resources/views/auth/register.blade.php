<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white p-6 rounded shadow">
        @if($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <h1 class="text-xl font-bold mb-4">Registrasi</h1>
            <div class="mb-4">
                <label class="block text-gray-700">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Role</label>
                <select name="role" class="w-full p-2 border rounded" required>
                    <option value="">--Pilih Role--</option>
                    <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ old('role')=='petugas' ? 'selected' : '' }}>Petugas</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded">
                Daftar
            </button>
        </form>
    </div>
</body>
</html>
