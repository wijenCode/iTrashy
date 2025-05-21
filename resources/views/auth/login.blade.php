<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I-Trashy - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white">

    <div class="flex flex-col md:flex-row min-h-screen">
        <div class="relative w-full md:w-1/2">
            <div class="relative w-full h-64 md:h-full p-4">
                <a href="{{ url('/') }}" class="absolute top-8 left-10 h-4 lg:top-12 lg:left-14">
                    <img src="{{ asset('storage/images/back icon.png') }}" alt="Back" class="w-6 h-6">
                </a>
                <img src="{{ asset('storage/images/orang buang sampah.jpg') }}" alt="Background" class="w-full h-full object-cover rounded-xl">
                
                <div class="absolute bottom-10 left-10 lg:bottom-20 lg:left-14">
                    <div class="flex items-center mb-2">
                        <img src="{{ asset('storage/images/logo itrashy.png') }}" alt="I-Trashy Logo" class="w-8 lg:w-12">
                    </div>
                    <h1 class="md:text-2xl font-bold text-white/80 mb-2">I-Trashy.</h1>
                    <p class="text-sm text-white/80 pr-20 lg:pr-0">Solusi pengelolaan sampah untuk rumah tangga dan bisnis</p>
                </div>
            </div>
        </div>

        <div class="flex-1 p-6 md:p-12 flex flex-col items-center justify-center">
            <div class="max-w-md mx-auto w-full">
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="mb-8 text-center">
                    <h1 class="text-2xl font-bold pb-2">Welcome Back!</h1>
                    <p class="text-gray-400">Yuk, Masukkan email dan password untuk akses akunmu</p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="text-gray-600">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan Email" required
                            class="w-full px-4 py-2 rounded-xl bg-[#f5f7fa] mt-2"
                            value="{{ old('email') }}">
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <label for="password" class="text-gray-600">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan Password" required
                            class="w-full px-4 py-2 rounded-xl bg-[#f5f7fa] mt-2">
                        <button type="button" id="togglePassword" class="absolute right-6 pt-4 opacity-50">
                            <img src="{{ asset('storage/images/eye icon.png') }}" alt="show/hide" class="w-6">
                        </button>
                    </div>

                    <div class="text-blue-500 text-end">
                        <a href="{{ route('password.request') }}">Lupa password?</a>
                    </div>

                    <div class="pt-8">
                        <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            Login
                        </button>
                    </div>

                    
                </form>
            </div>
        </div>
    </div>

    <script>
        // Show/Hide password functionality
        function togglePassword() {
            const input = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePassword').querySelector('img');

            if (input.type === 'password') {
                input.type = 'text';
                toggleIcon.src = '{{ asset('storage/images/eye-slash.png') }}';  // Icon mata terbuka
            } else {
                input.type = 'password';
                toggleIcon.src = '{{ asset('storage/images/eye icon.png') }}';  // Icon mata tertutup
            }
        }

        document.getElementById('togglePassword').addEventListener('click', togglePassword);
    </script>
</body>
</html>
