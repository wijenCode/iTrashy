<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I-Trashy - Register</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white">

    <!-- Full-Screen Layout -->
    <div class="h-screen flex">
        <!-- Left Side: Image -->
        <div class="w-1/2 h-screen bg-cover bg-center" style="background-image: url('{{ asset('image/orang buang sampah.jpg') }}');">
            <div class="absolute bottom-10 left-10 lg:bottom-20 lg:left-14">
                <div class="flex items-center mb-2">
                    <img src="{{ asset('image/logo itrashy.png') }}" alt="I-Trashy Logo" class="w-6 lg:w-12">
                </div>
                <h1 class="md:text-2xl font-bold text-white/80 mb-2">I-Trashy.</h1>
                <p class="text-sm text-white/80 pr-20 lg:pr-0">Solusi pengelolaan sampah untuk rumah tangga dan bisnis</p>
            </div>
        </div>

        <!-- Right Side: Register Form -->
        <div class="w-1/2 p-8 flex items-center justify-center bg-white">
            <div class="w-full max-w-sm">
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="mb-8 text-center">
                    <h1 class="text-2xl font-bold pb-2">Welcome!</h1>
                    <p class="text-gray-400">Yuk daftar! Wujudkan lingkungan hijau dan bersih</p>
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register.store', ['role' => $role]) }}" class="space-y-4">
                    @csrf

                    <!-- Username -->
                    <div>
                        <label for="username" class="text-gray-600">Username</label>
                        <input type="text" id="username" name="username" placeholder="Masukkan Username" required 
                            class="w-full px-4 py-2 rounded-xl bg-[#f5f7fa] mt-2"
                            value="{{ old('username') }}">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="text-gray-600">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan Email" required
                            class="w-full px-4 py-2 rounded-xl bg-[#f5f7fa] mt-2"
                            value="{{ old('email') }}">
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label for="no_telepon" class="text-gray-600">Nomor Telepon</label>
                        <input type="text" id="no_telepon" name="no_telepon" placeholder="Masukkan Nomor Telepon" required
                            class="w-full px-4 py-2 rounded-xl bg-[#f5f7fa] mt-2"
                            value="{{ old('no_telepon') }}">
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <label for="password" class="text-gray-600">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan Password" required
                            class="w-full px-4 py-2 rounded-xl bg-[#f5f7fa] mt-2">
                        <button type="button" id="togglePassword" class="absolute right-6 pt-4 opacity-50">
                            <img src="{{ asset('image/eye icon.png') }}" alt="show/hide" class="w-6">
                        </button>
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative">
                        <label for="password_confirmation" class="text-gray-600">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password" required
                            class="w-full px-4 py-2 rounded-xl bg-[#f5f7fa] mt-2">
                        <button type="button" id="toggleConfirmPassword" class="absolute right-6 pt-4 opacity-50">
                            <img src="{{ asset('image/eye icon.png') }}" alt="show/hide" class="w-6">
                        </button>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="terms" name="terms" class="rounded border-gray-300" required>
                        <label for="terms" class="text-gray-600 text-sm">Saya setuju dengan <a href="#" class="text-blue-500">Ketentuan Penggunaan</a></label>
                    </div>

                    <!-- Register Button -->
                    <div class="text-center">
                        <button type="submit" class="w-full bg-[#1f6feb] text-white py-2 rounded-xl">
                            Daftar
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center text-sm mt-4">
                        <p>Sudah punya akun? <a href="{{ route('login') }}" class="text-[#1f6feb]">Masuk di sini</a></p>
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
            input.type = input.type === 'password' ? 'text' : 'password';
            toggleIcon.src = input.type === 'password' ? '{{ asset('image/eye icon.png') }}' : '{{ asset('image/eye-slash.png') }}';
        }

        document.getElementById('togglePassword').addEventListener('click', togglePassword);

        function toggleConfirmPassword() {
            const input = document.getElementById('confirmPassword');
            const toggleIcon = document.getElementById('toggleConfirmPassword').querySelector('img');
            input.type = input.type === 'password' ? 'text' : 'password';
            toggleIcon.src = input.type === 'password' ? '{{ asset('image/eye icon.png') }}' : '{{ asset('image/eye-slash.png') }}';
        }

        document.getElementById('toggleConfirmPassword').addEventListener('click', toggleConfirmPassword);
    </script>
</body>
</html>
