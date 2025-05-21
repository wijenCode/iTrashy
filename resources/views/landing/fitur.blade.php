<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itrashy - Slide Content</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <style>
        /* Pastikan slider tidak meluap */
        .swiper-container {
            width: 100%;
            box-sizing: border-box;
            overflow: hidden; /* Mencegah overflow */
            position: relative; /* Untuk penempatan tombol navigasi */
        }

        /* Swiper slides */
        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

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
    <nav class="sticky top-0 flex justify-between items-center pt-8 pb-6 pr-14 pl-14 bg-white bg-opacity-70 backdrop-blur-lg w-full h-26 z-10">
        <div class="flex items-center gap-5">
            <img src="{{ asset('storage/images/Logo Itrashy.png') }}" alt="I-Trashy" class="w-9">
            <span class="text-xl">Itrashy</span>
        </div>
        <div class="flex gap-5">
            <a href="{{ url('/') }}" class="text-lg text-gray-700 mx-3 hover:font-semibold hover:text-blue-600">Beranda</a>
            <a href="{{ url('/tentang') }}" class="text-lg text-gray-700 mx-3 hover:font-semibold hover:text-blue-600">Tentang Kami</a>
            <a href="{{ url('/fitur') }}" class="text-lg text-gray-700 mx-3 hover:font-semibold hover:text-blue-600">fitur</a>
            <a href="{{ url('/solusi') }}" class="text-lg text-gray-700 mx-3 hover:font-semibold hover:text-blue-600">Solusi Kami</a>
        </div>
        <a href="login.php">
            <button class="bg-green-500 text-white py-1 px-6 rounded-full hover:bg-green-600">Sign in</button>
        </a>
    </nav>

    <!-- Hero Section -->
    <div class="relative w-full h-screen bg-cover -mt-24" style="background-image: url('{{ asset('storage/images/mockup.png') }}');">
        <div class="absolute top-0 left-0 w-full h-full bg-black opacity-30"></div>
        <div class="relative flex-col top-80 -translate-y-1/2 text-5xl font-semibold text-white text-right pr-20">
            <p>Kemudahan dalam</p> 
            <p class="mt-4">Mengelola Sampah</p>
            <p class="mt-6 text-3xl font-medium">#Darirumahaja</p>
        </div>
    </div>    

    <!-- About Section -->
    <section class="mt-32">
        <div class="flex gap-16 px-32 items-center">
            <img src="{{ asset('storage/images/picker.jpg') }}" alt="Itrashy" class="w-96 rounded-[50px] shadow-xl">
            <div class="flex flex-col text-justify">
                <p class="text-lg">iTrashy berkomitmen mengurangi penumpukan sampah dengan menyediakan layanan penjemputan sampah yang efisien dan ramah lingkungan. Pengguna cukup memesan layanan melalui aplikasi atau situs web, dan petugas akan datang ke alamat yang ditentukan untuk mengumpulkan sampah. Setelah dijemput, sampah akan ditimbang dan dikonversi menjadi poin insentif bagi pengguna, yang dapat ditukar dengan diskon, hadiah ramah lingkungan, atau sumbangan untuk program keberlanjutan.
                    <span class="block mt-5">
                        Sampah yang terkumpul kemudian dibersihkan, dipilah berdasarkan jenis dan bahan, dan dikirim ke pusat daur ulang. Proses ini memudahkan pengelolaan sampah dan mendukung upaya keberlanjutan serta pelestarian lingkungan.
                    </span>
                </p>
            </div>
        </div>
    </section>

    <!-- Slider Section -->
    <section class="bg-[#0a519f] mt-16 md:mt-32">
        <div class="flex flex-col w-full py-16 md:py-32 px-6 md:px-24">
            <h1 class="font-bold text-3xl md:text-4xl mb-2 text-white">Jenis Sampah Daur Ulang</h1>
            <div class="w-full border-t-2 border-gray-300 mt-2 mb-8 md:mb-16"></div>

            <!-- Swiper Container -->
            <div class="swiper-container relative">
                <div class="swiper-wrapper">
                    <!-- Card 1 -->
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-white shadow-xl rounded-[40px] p-4">
                                <img src="{{ asset('storage/images/botol_plastik.png') }}" alt="pickup" class="w-32 md:w-44 object-contain">
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Botol Plastik</h2>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-white shadow-xl rounded-[40px] p-4">
                                <img src="{{ asset('storage/images/botol_kaca.png') }}" alt="pickup" class="w-32 md:w-44 object-contain">
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Botol Kaca</h2>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-white shadow-xl rounded-[40px] p-4">
                                <img src="{{ asset('storage/images/kertas.png') }}" alt="pickup" class="w-32 md:w-44 object-contain">
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Kertas</h2>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-white shadow-xl rounded-[40px] p-4">
                                <img src="{{ asset('storage/images/kardus.png') }}" alt="pickup" class="w-32 md:w-44 object-contain">
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Kardus</h2>
                        </div>
                    </div>
                    <!-- Card 5 -->
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-white shadow-xl rounded-[40px] p-4">
                                <img src="{{ asset('storage/images/kaleng.png') }}" alt="pickup" class="w-32 md:w-44 object-contain">
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Kaleng</h2>
                        </div>
                    </div>
                    <!-- Additional Cards -->
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-white shadow-xl rounded-[40px] p-4">
                                <img src="{{ asset('storage/images/kotak_multi_layer.png') }}" alt="pickup" class="w-32 md:w-44 object-contain">
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Kotak Multi-Layer</h2>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-white shadow-xl rounded-[40px] p-4">
                                <img src="{{ asset('storage/images/kain.png') }}" alt="pickup" class="w-32 md:w-44 object-contain">
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Kain</h2>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-white shadow-xl rounded-[40px] p-4">
                                <img src="{{ asset('storage/images/elektronik.png') }}" alt="pickup" class="w-32 md:w-44 object-contain">
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Elektronik</h2>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-white shadow-xl rounded-[40px] p-4">
                                <img src="{{ asset('storage/images/besi.png') }}" alt="pickup" class="w-32 md:w-44 object-contain">
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Besi</h2>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-white shadow-xl rounded-[40px] p-4">
                                <img src="{{ asset('storage/images/sampah_organik.png') }}" alt="pickup" class="w-32 md:w-44 object-contain">
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold mt-4 text-white">Sampah Organik</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    

    <section class="mt-16 md:mt-32">
        <div class="flex flex-col px-6 md:px-32">
            <h1 class="font-bold text-3xl md:text-5xl mb-2">Reward</h1>
            <div class="w-full border-t-2 border-gray-300 mt-2 mb-8 md:mb-16"></div>
            <div class="flex items-center gap-16"> 
                <p class="text-lg text-justify text-gray-600">Fitur reward poin ini memberikan insentif kepada pengguna yang melakukan penjemputan sampah. Setiap sampah yang dijemput akan ditimbang dan dikonversikan menjadi poin yang dapat ditukarkan dengan berbagai hadiah menarik, seperti saldo e-wallet, token listrik, pulsa, voucher diskon dan sembako selain itu anda juga bisa mendonasikannya untuk keberlanjutan program pengelolaan sampah. Program ini bertujuan untuk mendorong partisipasi aktif dalam menjaga kebersihan lingkungan.</p>
                <img src="{{ asset('storage/images/reward.png') }}" alt="reward" class="w-80 rounded-[50px] shadow-xl bg-green-200">
            </div>
        </div>
    </section>

    <section class="mt-16 md:mt-24">
        <div class="flex flex-col px-6 md:px-32">
            <h1 class="font-bold text-3xl md:text-5xl mb-2">Laporan</h1>
            <div class="w-full border-t-2 border-gray-300 mt-2 mb-8 md:mb-16"></div>
            <div class="flex items-center gap-16"> 
                <p class="text-lg text-justify text-gray-600">Fitur laporan ini memberikan akses lengkap dan terperinci mengenai seluruh aktivitas pengelolaan sampah Anda. Melalui fitur ini, Anda dapat memantau frekuensi penjemputan sampah, jenis sampah yang dihasilkan, volume sampah, dan status pengelolaan dari setiap titik pengumpulan. Laporan ini dirancang untuk memberikan wawasan yang jelas mengenai efisiensi pengelolaan sampah, memungkinkan Anda untuk melakukan evaluasi dan perencanaan yang lebih baik. Dengan data yang tersedia secara real-time, Anda dapat memastikan pengelolaan sampah berjalan sesuai harapan dan memudahkan perbaikan berkelanjutan.</p>
                <img src="{{ asset('storage/images/report.png') }}" alt="reward" class="w-80 rounded-[50px] shadow-xl bg-green-200">
            </div>
        </div>
    </section>

    <section class="mt-16 md:mt-24">
        <div class="flex flex-col px-6 md:px-32">
            <h1 class="font-bold text-3xl md:text-5xl mb-2">edukasi</h1>
            <div class="w-full border-t-2 border-gray-300 mt-2 mb-8 md:mb-16"></div>
            <div class="flex items-center gap-16"> 
                <p class="text-lg text-justify text-gray-600">Fitur edukasi ini memberikan akses ke berbagai sumber informasi, termasuk video, artikel, dan panduan, yang mengajarkan cara memilah dan mengelola sampah dengan benar. Anda akan mempelajari berbagai teknik pemilahan sampah, jenis-jenis sampah yang dapat didaur ulang, serta cara-cara pengelolaan sampah yang ramah lingkungan. Dengan informasi yang lengkap dan mudah dipahami, Anda dapat meningkatkan kesadaran dan keterampilan dalam mengelola sampah secara lebih efisien, berkelanjutan, dan bertanggung jawab.</p>
                <img src="{{ asset('storage/images/education.png') }}" alt="reward" class="w-80 rounded-[50px] shadow-xl bg-green-200">
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 bg-[#f5f6fb] mt-24">
        <div class="container mx-auto pt-8 pr-24 pl-24">
            <!-- Main content grid - 1 column on mobile, 2 on tablet, 3 on desktop -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Brand and Social Section -->
                <div class="space-y-6">
                    <a href="https://flowbite.com/" class="flex items-center space-x-3">
                        <img src="{{ asset('storage/images/Logo Itrashy.png') }}" class="h-16" alt="iTrashy Logo" />
                        <span class="text-2xl font-semibold text-gray-600">iTrashy</span>
                    </a>

                    <div>
                        <p class="text-lg font-bold text-gray-600 mb-4">Follow us:</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.441 16.892c-2.102.144-6.784.144-8.883 0-2.276-.156-2.541-1.27-2.558-4.892.017-3.629.285-4.736 2.558-4.892 2.099-.144 6.782-.144 8.883 0 2.277.156 2.541 1.27 2.559 4.892-.018 3.629-.285 4.736-2.559 4.892zm-6.441-7.892l4.917 2.917-4.917 2.917v-5.834z"/></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2.917 16.083c-2.258 0-4.083-1.825-4.083-4.083s1.825-4.083 4.083-4.083c1.103 0 2.024.402 2.735 1.067l-1.107 1.068c-.304-.292-.834-.63-1.628-.63-1.394 0-2.531 1.155-2.531 2.579 0 1.424 1.138 2.579 2.531 2.579 1.616 0 2.224-1.162 2.316-1.762h-2.316v-1.4h3.855c.036.204.064.408.064.677.001 2.332-1.563 3.988-3.919 3.988zm9.917-3.083h-1.75v1.75h-1.167v-1.75h-1.75v-1.166h1.75v-1.75h1.167v1.75h1.75v1.166z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Us Section -->
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-gray-600 mb-6">OUR LOCATION</h2>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <img  src="{{ asset('storage/images/location.png') }}" alt="location" class="w-5 flex-shrink-0">
                            <span class="text-gray-500">Jl. Telekomunikasi No. 1, Terusan Buahbatu - Bojongsoang, Sukapura, Kec. Dayeuhkolot, Kabupaten Bandung, Jawa Barat 40257.</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-gray-500">(+62) 3456 7890</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-500">itrashycompany@gmail.com</span>
                        </div>
                    </div>
                </div>

                <!-- Information Section -->
                <div class="lg:pl-24 pl-0">
                    <h2 class="text-lg font-bold text-gray-600 mb-6">INFORMATION</h2>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-500 hover:text-gray-800">Our Blog</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-800">About Our Shop</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-800">Privacy policy</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Copyright Section -->
            <div class="w-full mx-auto border-t-2 border-gray-300 mt-16 mb-8"></div>
            <div class="text-center">
                <p class="text-gray-600">Copyright 2024 by <span class="text-green-600">iTrashy</span> - All rights reserved</p>
            </div>
        </div>
    </footer>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        const swiper = new Swiper('.swiper-container', {
          slidesPerView: 5,            // Menampilkan 5 slide secara default
          slidesPerGroup: 5,           // Bergeser 5 slide setiap kali
          spaceBetween: 10,            // Jarak antar slide
          loop: true,                  // Agar slider mengulang
          autoplay: {
            delay: 5000,               // Slide otomatis setiap 5 detik
            disableOnInteraction: false
          },
          breakpoints: {
            0: {        // Untuk perangkat kecil, mulai dari 0px
              slidesPerView: 1, 
              slidesPerGroup: 1,
            },
            640: {
              slidesPerView: 2,
              slidesPerGroup: 2,
            },
            768: {
              slidesPerView: 3,
              slidesPerGroup: 3,
            },
            1024: {
              slidesPerView: 4,
              slidesPerGroup: 4,
            },
            1200: {
              slidesPerView: 5,
              slidesPerGroup: 5,
            },
          },
        });
      </script>       
</body>
</html>
