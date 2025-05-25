<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script> <!-- Add Alpine.js -->
</head>
<body class="font-sans bg-gray-50">

    <!-- Wrapper for Sidebar, Content, and Footer -->
    <div class="flex h-screen">

        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-blue-900 to-blue-700 text-white flex flex-col">
            <div class="flex items-center justify-center h-20 bg-blue-800">
                <h1 class="text-2xl font-semibold">Dashboard</h1>
            </div>
            <nav class="flex-1 p-4">
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out">Home</a></li>
                    <!-- Dropdown Menu for Katalog -->
                    <li class="relative group">
                        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out">
                            Management Katalog
                            <svg class="w-4 h-4 inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </a>
                        <div class="absolute left-0 w-48 bg-white shadow-md rounded-lg hidden group-hover:block transition duration-300 ease-in-out">
                            <ul>
                                <li><a href="{{ route('admin.jenis-sampah.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Jenis Sampah</a></li>
                            </ul>
                            <ul>
                                <li><a href="{{ route('admin.edukasi.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Edukasi</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">

            <!-- Header -->
            <header class="bg-white p-4 shadow-lg flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="text-xl font-semibold text-gray-700">Welcome back, {{ auth()->user()->name }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg transition duration-300 ease-in-out hover:bg-blue-600">New Notification</button>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg transition duration-300 ease-in-out hover:bg-blue-600">Profile</button>
                    <div x-data="{ open: false }" class="relative">
                        <!-- Settings Button -->
                        <button @click="open = !open" class="bg-gray-800 text-white px-4 py-2 rounded-lg focus:outline-none">
                            <span class="text-sm">Settings</span>
                            <svg class="w-4 h-4 inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white shadow-md rounded-lg hidden">
                            <ul>
                                <!-- Profile Settings Link -->
                                <li><a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Profile Settings</a></li>
                                <!-- Logout Link -->
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-200">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content: This is where the page content will be injected -->
            <main class="flex-1 p-6 bg-gray-100 space-y-6">
                @yield('content') <!-- Dynamic content for each admin page will go here -->
            </main>

            <!-- Footer -->
            <footer class="bg-blue-800 text-white p-4 text-center">
                <p>© 2025 Your Company. All Rights Reserved.</p>
            </footer>
        </div>
    </div>

</body>
</html>
