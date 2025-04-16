<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Aplikasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 transform transition-all duration-300 hover:scale-105">
        <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Login</h1>
        
        @if(session('error'))
            <div class="bg-red-500 text-white text-sm rounded p-2 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="Masukkan email Anda" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900 transition duration-200" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2" for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Masukkan password Anda" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900 transition duration-200" required>
            </div>
            <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold py-3 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                Masuk
            </button>
        </form>

        <p class="mt-6 text-center text-gray-600 text-sm">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-900 hover:underline font-semibold">Daftar di sini</a>
        </p>
    </div>
</body>
</html>
