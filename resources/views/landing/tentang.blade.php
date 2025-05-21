<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itrashy - Slide Content</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['THICCCBOI'],
                    },
                },
            },
        };
    </script>
</head>
<body>
       <!-- Navbar -->
       <nav class="sticky top-0 bg-white bg-opacity-70 backdrop-blur-lg w-full z-10">
        <div class="flex justify-between items-center pt-8 pb-6 px-4 md:px-14">
            <!-- Logo -->
            <div class="flex items-center gap-5">
                <img src="{{ asset('storage/images/Logo Itrashy.png') }}" alt="I-Trashy" class="w-9">
                <span class="text-xl">Itrashy</span>
            </div>

            <!-- Mobile Menu Button -->
            <button id="menuButton" class="md:hidden text-gray-700" onclick="toggleMenu()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Desktop Menu -->
            <div class="hidden md:flex gap-5">
                <a href="{{ url('/') }}" class="text-lg text-gray-700 mx-3 hover:font-semibold hover:text-blue-600">Beranda</a>
                <a href="{{ url('/tentang') }}" class="text-lg text-gray-700 mx-3 hover:font-semibold hover:text-blue-600">Tentang Kami</a>
                <a href="{{ url('/fitur') }}" class="text-lg text-gray-700 mx-3 hover:font-semibold hover:text-blue-600">fitur</a>
                <a href="{{ url('/solusi') }}" class="text-lg text-gray-700 mx-3 hover:font-semibold hover:text-blue-600">Solusi Kami</a>
            </div>

            <!-- Sign In Button -->
            <a href="login.php" class="hidden md:block">
                <button class="bg-green-500 text-white py-1 px-6 rounded-full hover:bg-green-600">Sign in</button>
            </a>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden px-4 pb-4 bg-white">
            <div class="flex flex-col space-y-4">
                <a href="{{ url('/') }}" class="text-lg text-gray-700 mx-3 hover:font-semibold hover:text-blue-600">Beranda</a>
                <a href="{{ url('/tentang') }}" class="text-lg text-gray-700 mx-3 hover:font-semibold hover:text-blue-600">Tentang Kami</a>
                <a href="{{ url('/fitur') }}" class="text-lg text-gray-700 mx-3 hover:font-semibold hover:text-blue-600">fitur</a>
                <a href="{{ url('/solusi') }}" class="text-lg text-gray-700 mx-3 hover:font-semibold hover:text-blue-600">Solusi Kami</a>
                <a href="login.php">
                    <button class="w-full bg-green-500 text-white py-2 px-6 rounded-full hover:bg-green-600">Sign in</button>
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section (Hidden on Mobile) -->
    <div class="relative w-full h-screen bg-cover hidden md:block" style="background-image: url('{{ asset('storage/images/bg_aboutus.png') }}');">
        <div class="absolute top-0 left-0 w-full h-full bg-black opacity-20"></div>
        <div class="absolute flex-col top-1/2 pl-24 -translate-y-1/2 text-5xl md:text-6xl font-bold text-white">
            <p>Ubah Limbah</p> 
            <p class="mt-4">Jadi Kebaikan</p>
        </div>
    </div>    
    
    <section class="mt-16 md:mt-32 px-6 md:px-32">
        <div class="flex flex-col items-center justify-center">
            <p class="text-base md:text-lg text-justify text-gray-600">
                Tahukah kamu, Indonesia menghasilkan sekitar 69,7 juta ton sampah setiap tahun, dengan 18,2% atau sekitar 12,5 juta ton di antaranya adalah sampah plastik. Sayangnya, hanya sekitar 15% dari sampah tersebut yang diolah, dan hanya 13% yang didaur ulang. 
            </p>
            <p class="text-base md:text-lg text-justify text-gray-600 mt-4">
                Sisa sampah yang tidak terkelola dengan baik ini sering kali berakhir di lautan, mengancam ekosistem laut dan kesehatan manusia. Mikroplastik dari sampah plastik dapat masuk ke rantai makanan melalui ikan dan makanan laut lainnya, yang kemudian dikonsumsi oleh manusia. Paparan mikroplastik ini dapat menyebabkan berbagai masalah kesehatan, termasuk gangguan hormonal dan risiko kanker.
            </p>
            <p class="text-base md:text-lg text-justify text-gray-600 mt-4">
                Oleh karena itu, penting bagi kita untuk mengurangi penggunaan plastik sekali pakai, mendaur ulang sampah, dan mendukung kebijakan pengelolaan sampah yang lebih baik untuk melindungi kesehatan kita dan lingkungan.
            </p>
        </div>
    </section>

    <section class="bg-green-300 mt-16 md:mt-32 px-6 md:px-32">
        <div class="flex flex-col md:flex-row gap-8 md:gap-16 pt-16 pb-16 items-center">
            <div class="flex flex-col text-justify">
                <h1 class="text-2xl md:text-4xl font-bold mb-6 md:mb-8">Mulai aksi hijau bersama iTrashy!</h1>
                <p class="text-base md:text-lg">
                    Saatnya kita ambil langkah nyata untuk lingkungan yang lebih bersih dan sehat. Bersama iTrashy, kamu bisa memulai aksi perubahan dengan cara sederhana namun berdampak besar, seperti memilah sampah di rumah dan memanfaatkan layanan kami untuk pengelolaan sampah daur ulang.
                    <span class="block mt-3 md:mt-5">
                        Dengan setiap aksi kecil yang kamu lakukan, kamu tidak hanya membantu mengurangi tumpukan sampah, tapi juga berkontribusi dalam mendukung ekonomi sirkular. Bersama iTrashy, kita bisa menciptakan masa depan yang lebih hijau dan bumi yang lebih baik untuk generasi mendatang. Yuk, mulai sekarang!
                    </span>
                </p>
            </div>
            <img src="{{ asset('storage/images/kids.png') }}" alt="Itrashy" class="w-72 md:w-96 rounded-[50px] shadow-xl">
        </div>
    </section>

    <section class="mt-16 md:mt-32 px-6 md:px-32">
        <div class="flex flex-col md:flex-row gap-8 md:gap-16 items-center">
            <img src="{{ asset('storage/images/daur ulang.jpg') }}" alt="Itrashy" class="w-72 md:w-96 rounded-[50px] shadow-xl">
            <div class="flex flex-col text-justify">
                <p class="text-base md:text-lg">
                    Sampah yang terkumpul akan diolah oleh iTrashy dengan membersihkan dan memilah berdasarkan jenis, warna, dan bahan, lalu dikirim ke pusat daur ulang. Di sana, sampah akan dihancurkan dan diolah menjadi produk baru seperti karung, botol plastik, atau bahan baku untuk biji plastik, benang, dan kain. Produk daur ulang ini juga bisa diekspor, membuka peluang ekonomi baru, dan mendukung upaya keberlanjutan. Proses ini tidak hanya mengurangi sampah, tetapi juga memberikan nilai tambah bagi lingkungan dan masyarakat.
                </p>
            </div>
        </div>
    </section>

    <footer class="py-8 bg-[#f5f6fb] mt-16 md:mt-24 px-6 md:px-24">
        <div class="container mx-auto">
            <!-- Main content grid - 1 column on mobile, 2 on tablet, 3 on desktop -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Brand and Social Section -->
                <div class="space-y-6">
                    <a href="https://flowbite.com/" class="flex items-center space-x-3">
                        <img src="{{ asset('storage/images/Logo Itrashy.png') }}" class="h-12 md:h-16" alt="iTrashy Logo" />
                        <span class="text-xl md:text-2xl font-semibold text-gray-600">iTrashy</span>
                    </a>

                    <div>
                        <p class="text-base md:text-lg font-bold text-gray-600 mb-4">Follow us:</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-gray-600">
                                <!-- Facebook Icon -->
                                <svg class="h-6 md:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-600">
                                <!-- Twitter Icon -->
                                <svg class="h-6 md:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-600">
                                <!-- Instagram Icon -->
                                <svg class="h-6 md:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.441 16.892c-2.102.144-6.784.144-8.883 0-2.276-.156-2.541-1.27-2.558-4.892.017-3.629.285-4.736 2.558-4.892 2.099-.144 6.782-.144 8.883 0 2.277.156 2.541 1.27 2.559 4.892-.018 3.629-.285 4.736-2.559 4.892zm-6.441-7.892l4.917 2.917-4.917 2.917v-5.834z"/></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-600">
                                <!-- LinkedIn Icon -->
                                <svg class="h-6 md:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2.917 16.083c-2.258 0-4.083-1.825-4.083-4.083s1.825-4.083 4.083-4.083c1.103 0 2.024.402 2.735 1.067l-1.107 1.068c-.304-.292-.834-.63-1.628-.63-1.394 0-2.531 1.155-2.531 2.579 0 1.424 1.138 2.579 2.531 2.579 1.616 0 2.224-1.162 2.316-1.762h-2.316v-1.4h3.855c.036.204.064.408.064.677.001 2.332-1.563 3.988-3.919 3.988zm9.917-3.083h-1.75v1.75h-1.167v-1.75h-1.75v-1.166h1.75v-1.75h1.167v1.75h1.75v1.166z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Us Section -->
                <div class="space-y-4">
                    <h2 class="text-base md:text-lg font-bold text-gray-600 mb-4">OUR LOCATION</h2>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <img src="{{ asset('storage/images/location.png') }}" alt="location" class="w-4 md:w-5 flex-shrink-0">
                            <span class="text-sm md:text-base text-gray-500">Jl. Telekomunikasi No. 1, Terusan Buahbatu - Bojongsoang, Sukapura, Kec. Dayeuhkolot, Kabupaten Bandung, Jawa Barat 40257.</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 md:h-5 w-4 md:w-5 text-gray-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-sm md:text-base text-gray-500">(+62) 3456 7890</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 md:h-5 w-4 md:w-5 text-gray-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm md:text-base text-gray-500">itrashycompany@gmail.com</span>
                        </div>
                    </div>
                </div>

                <!-- Information Section -->
                <div class="lg:pl-6 xl:pl-24 pl-0">
                    <h2 class="text-base md:text-lg font-bold text-gray-600 mb-4">INFORMATION</h2>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm md:text-base text-gray-500 hover:text-gray-800">Our Blog</a></li>
                        <li><a href="#" class="text-sm md:text-base text-gray-500 hover:text-gray-800">About Our Shop</a></li>
                        <li><a href="#" class="text-sm md:text-base text-gray-500 hover:text-gray-800">Privacy policy</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Divider -->
            <div class="w-full mx-auto border-t border-gray-300 mt-8 md:mt-16"></div>
            <div class="text-center mt-4 md:mt-8">
                <p class="text-sm md:text-base text-gray-600">Copyright 2024 by <span class="text-green-600">iTrashy</span> - All rights reserved</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        function toggleMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
