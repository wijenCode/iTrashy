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
    <style>
        @media (max-width: 768px) {
            .mobile-menu-open {
                display: block;
            }

            .hero-bg {
                background-image: none !important;
                background-color: white; /* Optional: Tambahkan warna latar belakang alternatif */
            }
        }
    </style>
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

            <div class="hidden md:flex gap-5">
                <!-- Sign In Button -->
                <a href="{{ route('login') }}" class="hidden md:block">
                    <button class="bg-green-500 text-white py-1 px-6 rounded-full hover:bg-green-600">Login</button>
                </a>

                <a href="{{ route('register') }}" class="hidden md:block">
                    <button class="bg-blue-500 text-white py-1 px-6 rounded-full hover:bg-blue-600">Register</button>
                </a>
            </div>
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

    <!-- Hero Section -->
    <div id="slideContainer" class="relative w-full h-[600px] md:h-screen bg-cover bg-center -mt-24 hero-bg" style="background-image: url('{{ asset('storage/images/cover.png') }}');">
        <section>
            <div id="contentSlides" class="absolute top-1/2 -translate-y-1/2 left-0 px-6 md:px-14">
                <!-- Slide 1 -->
                <div class="slide active">
                    <h1 class="text-3xl md:text-5xl mb-5 font-bold">
                        Yuk, Kelola Sampahmu <br>
                        <span class="block text-3xl md:text-5xl pt-2 text-green-500">Bersama Itrashy</span>
                    </h1>        
                    <p class="text-base md:text-lg mb-16">Ubah sampah menjadi sumber daya bernilai.</p>
                    <a href="login.php" class="bg-green-500 text-white py-2 md:py-3 px-4 md:px-6 rounded-full hover:bg-green-600 text-base md:text-lg inline-block">
                        Coba Sekarang
                    </a>
                </div>
                <!-- Slide 2 -->
                <div class="slide hidden">
                    <h1 class="text-3xl md:text-5xl mb-5 font-bold text-blue-600">
                        Jangan khawatir, <br>
                        <span class="block pt-2 text-black">kami siap jemput</span>
                        <span class="block pt-2 text-black">sampahmu!</span>
                    </h1>        
                    <p class="text-base md:text-lg mb-16">Langkah kecilmu, dampak besar bagi lingkungan.</p>
                    <a href="login.php" class="bg-green-500 text-white py-2 md:py-3 px-4 md:px-6 rounded-full hover:bg-green-600 text-base md:text-lg inline-block">
                        Mulai Sekarang
                    </a>
                </div>
                <!-- Slide 3 -->
                <div class="slide hidden">
                    <h1 class="text-3xl md:text-5xl mb-5 font-bold">
                        Lingkungan Bersih <br>
                        <span class="block text-3xl md:text-5xl pt-2 text-yellow-500">Masa Depan Cerah</span>
                    </h1>        
                    <p class="text-base md:text-lg mb-16">Bersama, kita bisa menuju zero waste!</p>
                    <a href="login.php" class="bg-green-500 text-white py-2 md:py-3 px-4 md:px-6 rounded-full hover:bg-green-600 text-base md:text-lg inline-block">
                        Mulai Sekarang
                    </a>
                </div>
            </div>

            <!-- Slide Controls -->
            <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 flex space-x-3">
                <button onclick="changeSlide(0)" class="w-3 h-3 rounded-full bg-gray-300 slide-control"></button>
                <button onclick="changeSlide(1)" class="w-3 h-3 rounded-full bg-gray-300 slide-control"></button>
                <button onclick="changeSlide(2)" class="w-3 h-3 rounded-full bg-gray-300 slide-control"></button>
            </div>
        </section>
    </div>

    <!-- About Us Section -->
    <section id="about-us" class="mt-16 md:mt-32">
        <div class="flex flex-col md:flex-row items-center justify-center gap-8 px-6 md:px-24">
            <video autoplay loop muted class="w-full md:w-[500px] h-auto md:h-[500px] rounded-3xl md:rounded-[50px] md:mr-16">
                <source src="{{ asset('storage/images/2024121910502..mp4') }}" type="video/mp4">
                Browser Anda tidak mendukung video tag.
            </video>
            <div class="flex flex-col mt-8 md:mt-0">
                <h1 class="font-bold text-3xl md:text-5xl mb-2 text-[#313131]">iTrashy Adalah Startup Climate-Tech</h1>
                <div class="w-full border-t-2 border-gray-300 mt-2 mb-8 md:mb-16"></div>
                <p class="text-base md:text-lg text-gray-600 leading-relaxed text-justify">
                    iTrashy merupakan platform pengelolaan sampah yang didesain untuk 
                    memudahkan individu dan bisnis dalam mengelola sampah secara efisien, 
                    bertanggung jawab, dan berdampak positif bagi lingkungan. 
                    <span class="block mt-4 md:mt-6">Kami hadir untuk 
                    memberikan solusi bagi permasalahan pengelolaan sampah dengan menghadirkan 
                    sistem digital yang terintegrasi untuk mendukung proses pengumpulan, pemilahan, 
                    dan daur ulang sampah.</span>
                </p>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="mt-16 md:mt-32">
        <div class="flex flex-col px-6 md:px-24">
            <h1 class="font-bold text-3xl md:text-5xl mb-2">Layanan</h1>
            <div class="w-full border-t-2 border-gray-300 mt-2 mb-8 md:mb-16"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16">
                <!-- Layanan Perusahaan -->
                <div class="flex flex-col md:flex-row items-center">
                    <div class="flex flex-col text-center md:text-start md:pr-10 mb-6 md:mb-0">
                        <h2 class="font-semibold text-xl md:text-2xl pb-3 md:pb-5">Perusahaan</h2>
                        <p class="text-gray-700 text-base md:text-lg">
                            Solusi pengelolaan sampah terpadu untuk perusahaan yang mendukung keberlanjutan lingkungan.
                        </p>
                    </div>
                    <div>
                        <div class="flex bg-green-200 rounded-3xl overflow-hidden w-48 h-48 md:w-64 md:h-64 items-center justify-center">
                            <img src="{{ asset('storage/images/role bisnis.png') }}" alt="role bisnis" class="h-40 md:h-56 object-cover">
                        </div>
                    </div>
                </div>
                <!-- Layanan Individu -->
                <div class="flex flex-col-reverse md:flex-row-reverse items-center">
                    <div class="flex flex-col text-center md:text-end md:pl-10 mt-6 md:mt-0">
                        <h2 class="font-semibold text-xl md:text-2xl pb-3 md:pb-5">Individu</h2>
                        <p class="text-gray-700 text-base md:text-lg">
                            Layanan pengelolaan sampah untuk individu yang mempermudah penjemputan sampah dan daur ulang.
                        </p>
                    </div>
                    <div>
                        <div class="flex bg-green-200 rounded-3xl overflow-hidden w-48 h-48 md:w-64 md:h-64 items-center justify-center">
                            <img src="{{ asset('storage/images/role individu.png') }}" alt="role individu" class="h-40 md:h-56 object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-[#0a519f] mt-16 md:mt-32"> 
        <div class="flex flex-col w-full py-16 md:py-32">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-14 px-6 md:px-20">
                <!-- Fitur Pick Up -->
                <div class="flex flex-col items-center text-center">
                    <div class="bg-white shadow-xl rounded-3xl p-4">
                        <img src="{{ asset('storage/images/pickup.png') }}" alt="pickup" class="w-32 md:w-44 object-contain">
                    </div>
                    <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Pick Up</h2>
                    <div class="w-5/6 mx-auto border-t border-black-300 mt-2 mb-2"></div>
                    <p class="text-base md:text-lg text-white mt-2">Jadwalkan pejemputan sampah, kami siap menjemput ke lokasi anda.</p>
                </div>
                <!-- Fitur Reward Poin -->
                <div class="flex flex-col items-center text-center">
                    <div class="bg-white shadow-xl rounded-3xl p-4">
                        <img src="{{ asset('storage/images/reward.png') }}" alt="reward" class="w-32 md:w-44 object-contain">
                    </div>
                    <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Reward Poin</h2>
                    <div class="w-5/6 mx-auto border-t border-black-300 mt-2 mb-2"></div>
                    <p class="text-base md:text-lg text-white mt-2">Kumpulkan poin untuk setiap pick up dan tukarkan dengan hadiah menarik.</p>
                </div>
                <!-- Fitur Laporan -->
                <div class="flex flex-col items-center text-center">
                    <div class="bg-white shadow-xl rounded-3xl p-4">
                        <img src="{{ asset('storage/images/report.png') }}" alt="laporan" class="w-32 md:w-44 object-contain">
                    </div>
                    <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Laporan</h2>
                    <div class="w-5/6 mx-auto border-t border-black-300 mt-2 mb-2"></div>
                    <p class="text-base md:text-lg text-white mt-2">Akses laporan lengkap tentang aktivitas pengelolaan sampah Anda.</p>
                </div>
                <!-- Fitur Edukasi -->
                <div class="flex flex-col items-center text-center">
                    <div class="bg-white shadow-xl rounded-3xl p-4">
                        <img src="{{ asset('storage/images/education.png') }}" alt="edukasi" class="w-32 md:w-44 object-contain">
                    </div>
                    <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Edukasi</h2>
                    <div class="w-5/6 mx-auto border-t border-black-300 mt-2 mb-2"></div>
                    <p class="text-base md:text-lg text-white mt-2">Pelajari cara memilah dan mengelola sampah dengan baik dan benar.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SDGs Section -->
    <section class="mt-16 md:mt-32">
        <div class="flex flex-col px-6 md:px-24">
            <h1 class="font-bold text-3xl md:text-5xl mb-2 text-[#313131]">Kontribusi Kami Untuk SDGs</h1>
            <div class="w-full border-t-2 border-gray-300 mt-2 mb-8 md:mb-16"></div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6 md:gap-10">
                <div class="text-center">
                    <img src="{{ asset('storage/images/sdgs 8.png') }}" alt="sdgs 8" class="w-28 md:w-40 rounded-3xl mx-auto">
                    <p class="mt-2 text-sm md:text-base font-medium text-gray-600">Pekerjaan Layak dan Pertumbuhan Ekonomi (SDG 8)</p>
                </div>
                <div class="text-center">
                    <img src="{{ asset('storage/images/sdgs 11.png') }}" alt="sdgs 11" class="w-28 md:w-40 rounded-3xl mx-auto">
                    <p class="mt-2 text-sm md:text-base font-medium text-gray-600">Kota dan Komunitas yang Berkelanjutan (SDG 11)</p>
                </div>
                <div class="text-center">
                    <img src="{{ asset('storage/images/sdgs 12.png') }}" alt="sdgs 12" class="w-28 md:w-40 rounded-3xl mx-auto">
                    <p class="mt-2 text-sm md:text-base font-medium text-gray-600">Konsumsi dan Produksi yang Bertanggung Jawab (SDG 12)</p>
                </div>
                <div class="text-center">
                    <img src="{{ asset('storage/images/sdgs 13.png') }}" alt="sdgs 13" class="w-28 md:w-40 rounded-3xl mx-auto">
                    <p class="mt-2 text-sm md:text-base font-medium text-gray-600">Penanganan Perubahan Iklim (SDG 13)</p>
                </div>
                <div class="text-center">
                    <img src="{{ asset('storage/images/sdgs 14.png') }}" alt="sdgs 14" class="w-28 md:w-40 rounded-3xl mx-auto">
                    <p class="mt-2 text-sm md:text-base font-medium text-gray-600">Ekosistem Lautan yang Sehat (SDG 14)</p>
                </div>
                <div class="text-center">
                    <img src="{{ asset('storage/images/sdgs 15.png') }}" alt="sdgs 15" class="w-28 md:w-40 rounded-3xl mx-auto">
                    <p class="mt-2 text-sm md:text-base font-medium text-gray-600">Melestarikan Ekosistem Daratan (SDG 15)</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="relative bg-fixed bg-cover bg-center bg-no-repeat text-white py-20 md:py-40 mt-16 md:mt-32" style="background-image: url('{{ asset('storage/images/together.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>
        <div class="relative z-8 container mx-auto text-center px-6 md:px-0">
            <p class="text-2xl md:text-4xl max-w-4xl font-bold mx-auto">
                Jadilah bagian dari generasi yang peduli lingkungan bersama iTrashy. Yuk, mulai dari hal kecil dengan memilah sampahmu. 
                Bersama-sama kita bisa menciptakan lingkungan yang bersih dan sehat!
            </p>
        </div>
    </section>

    <!-- Our Team Section -->
    {{-- <section id="our-team" class="mt-16 md:mt-32">
        <div class="container mx-auto text-center px-6 md:px-24">
            <h1 class="font-bold text-3xl md:text-5xl mb-2 text-[#313131]">Our Team</h1>
            <div class="w-4/5 mx-auto border-t-2 border-gray-300 mt-2 mb-8 md:mb-16"></div>
            <div class="flex flex-wrap justify-center gap-8 md:gap-12">
                <!-- Card Member 1 -->
                <div class="text-center">
                    <img src="{{ asset('storage/images/zed.png') }}" alt="founder itrashy" class="w-40 h-40 md:w-52 md:h-52 object-cover rounded-3xl mx-auto mb-4">
                    <h2 class="text-base md:text-lg font-semibold">Izzedine Elfatih</h2>
                    <p class="text-sm text-gray-600">Founder</p>
                </div>
                <!-- Card Member 2 -->
                <div class="text-center">
                    <img src="{{ asset('storage/images/kev.png') }}" alt="founder itrashy" class="w-40 h-40 md:w-52 md:h-52 object-cover rounded-3xl mx-auto mb-4">
                    <h2 class="text-base md:text-lg font-semibold">Kevin Tri Putra</h2>
                    <p class="text-sm text-gray-600">Founder</p>
                </div>
                <!-- Card Member 3 -->
                <div class="text-center">
                    <img src="{{ asset('storage/images/han.png') }}" alt="founder itrashy" class="w-40 h-40 md:w-52 md:h-52 object-cover rounded-3xl mx-auto mb-4">
                    <h2 class="text-base md:text-lg font-semibold">Andi Farhan A.</h2>
                    <p class="text-sm text-gray-600">Co Founder</p>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Footer -->
    <footer class="py-8 bg-[#f5f6fb] mt-16 md:mt-24">
        <div class="container mx-auto px-6 md:px-24 pt-8">
            <!-- Main content grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Brand and Social Section -->
                <div class="space-y-6">
                    <a href="#" class="flex items-center space-x-3">
                        <img src="{{ asset('storage/images/Logo Itrashy.png') }}" class="h-12 md:h-16" alt="iTrashy Logo" />
                        <span class="text-xl md:text-2xl font-semibold text-gray-600">iTrashy</span>
                    </a>

                    <div>
                        <p class="text-base md:text-lg font-bold text-gray-600 mb-4">Follow us:</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 md:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 md:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 md:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.441 16.892c-2.102.144-6.784.144-8.883 0-2.276-.156-2.541-1.27-2.558-4.892.017-3.629.285-4.736 2.558-4.892 2.099-.144 6.782-.144 8.883 0 2.277.156 2.541 1.27 2.559 4.892-.018 3.629-.285 4.736-2.559 4.892zm-6.441-7.892l4.917 2.917-4.917 2.917v-5.834z"/></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 md:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2.917 16.083c-2.258 0-4.083-1.825-4.083-4.083s1.825-4.083 4.083-4.083c1.103 0 2.024.402 2.735 1.067l-1.107 1.068c-.304-.292-.834-.63-1.628-.63-1.394 0-2.531 1.155-2.531 2.579 0 1.424 1.138 2.579 2.531 2.579 1.616 0 2.224-1.162 2.316-1.762h-2.316v-1.4h3.855c.036.204.064.408.064.677.001 2.332-1.563 3.988-3.919 3.988zm9.917-3.083h-1.75v1.75h-1.167v-1.75h-1.75v-1.166h1.75v-1.75h1.167v1.75h1.75v1.166z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Us Section -->
                <div class="space-y-4">
                    <h2 class="text-lg md:text-xl font-bold text-gray-600 mb-6">OUR LOCATION</h2>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <img src="{{ asset('storage/images/location.png') }}" alt="location" class="w-5 flex-shrink-0">
                            <span class="text-sm md:text-base text-gray-500">Jl. Telekomunikasi No. 1, Terusan Buahbatu - Bojongsoang, Sukapura, Kec. Dayeuhkolot, Kabupaten Bandung, Jawa Barat 40257.</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-sm md:text-base text-gray-500">(+62) 3456 7890</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm md:text-base text-gray-500">itrashycompany@gmail.com</span>
                        </div>
                    </div>
                </div>

                <!-- Information Section -->
                <div class="lg:pl-24 pl-0">
                    <h2 class="text-lg md:text-xl font-bold text-gray-600 mb-6">INFORMATION</h2>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm md:text-base text-gray-500 hover:text-gray-800">Our Blog</a></li>
                        <li><a href="#" class="text-sm md:text-base text-gray-500 hover:text-gray-800">About Our Shop</a></li>
                        <li><a href="#" class="text-sm md:text-base text-gray-500 hover:text-gray-800">Privacy policy</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Copyright Section -->
            <div class="w-full mx-auto border-t-2 border-black-300 mt-12 md:mt-16 mb-6 md:mb-8"></div>
            <div class="text-center">
                <p class="text-sm md:text-base text-gray-600">Copyright 2024 by <span class="text-green-600">iTrashy</span> - All right reserved</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        function toggleMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        }

        // Slider Functionality
        const slides = document.querySelectorAll('.slide');
        const slideContainer = document.getElementById('slideContainer');
        const slideControls = document.querySelectorAll('.slide-control');
        const backgrounds = [
            '{{ asset('storage/images/cover.png') }}',
            '{{ asset('storage/images/cover2.png') }}', 
            '{{ asset('storage/images/cover3.png') }}'
        ];
        let currentSlide = 0;

        function changeSlide(index) {
            // Cek apakah layar lebih besar dari 768px
            if (window.innerWidth > 768) {
                // Remove active class dari slide saat ini
                slides[currentSlide].classList.add('hidden');
                slideControls[currentSlide].classList.remove('bg-green-500');
                slideControls[currentSlide].classList.add('bg-gray-300');

                // Set slide baru
                currentSlide = index;
                slides[currentSlide].classList.remove('hidden');
                slideControls[currentSlide].classList.remove('bg-gray-300');
                slideControls[currentSlide].classList.add('bg-green-500');

                // Ganti background
                slideContainer.style.backgroundImage = `url('${backgrounds[currentSlide]}')`;
            } else {
                // Pada mobile, jangan ganti background image
                slides.forEach((slide, idx) => {
                    if (idx === index) {
                        slide.classList.remove('hidden');
                    } else {
                        slide.classList.add('hidden');
                    }
                });
                slideControls.forEach((control, idx) => {
                    if (idx === index) {
                        control.classList.remove('bg-gray-300');
                        control.classList.add('bg-green-500');
                    } else {
                        control.classList.remove('bg-green-500');
                        control.classList.add('bg-gray-300');
                    }
                });
            }
        }

        // Auto slide every 10 seconds
        function autoSlide() {
            let nextSlide = (currentSlide + 1) % slides.length;
            changeSlide(nextSlide);
        }

        // Initial setup of slide controls
        slideControls[0].classList.remove('bg-gray-300');
        slideControls[0].classList.add('bg-green-500');

        // Start auto sliding
        setInterval(autoSlide, 10000);
    </script>
</body>
</html>