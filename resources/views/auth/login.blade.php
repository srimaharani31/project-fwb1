<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div
    class="absolute inset-0 bg-cover bg-center opacity-30"
    style="background-image: url('/images/bedround.jpeg');">
</div>

    <div class="w-full max-w-sm bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                Masuk
            </button>
        </form>

        <div class="mt-4 text-center text-sm text-gray-500">
            Belum punya akun? <a href="#" class="text-blue-600 hover:underline">Daftar di sini</a>
        </div>
    </div>
</body>
</html>
