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
    <div id="slideContainer" class="relative w-full h-[600px] md:h-screen bg-cover bg-center -mt-24" style="background-image: url('{{ asset('storage/images/individu.png') }}');">
        <section>
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-transparent to-black opacity-70"></div>

            <div id="contentSlides" class="absolute top-1/2 -translate-y-1/2 right-0 px-6 md:px-14 flex flex-col items-end text-right">
                <div class="slide active">
                    <h1 class="text-3xl md:text-5xl mb-5 font-bold text-white">
                        Langkah Kecil untuk Masa<br>
                        <span class="block text-3xl md:text-5xl pt-2 text-white">Depan yang Lebih Cerah</span>
                    </h1>        
                </div>
                <div class="slide hidden">
                    <h1 class="text-3xl md:text-5xl mb-5 font-bold text-white">
                        Ciptakan Bisnis yang<br>
                        <span class="block pt-2 text-white">Ramah Lingkungan</span>
                    </h1>
                </div>
            </div>            

            <!-- Slide Controls -->
            <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 flex space-x-3">
                <button onclick="changeSlide(0)" class="w-3 h-3 rounded-full bg-gray-300 slide-control"></button>
                <button onclick="changeSlide(1)" class="w-3 h-3 rounded-full bg-gray-300 slide-control"></button>
            </div>
        </section>
    </div>    

    <section class="mt-32">
        <div class="px-32 ">
            <h1 class="font-bold text-3xl md:text-5xl mb-4 text-[#313131]">Perusahaan</h1>
            <div class="w-full mx-auto border-t-2 border-gray-300 mt-2 mb-8 md:mb-16"></div>
            <div class="flex gap-16 items-center">
                <img src="{{ asset('storage/images/individusolusi.png') }}" alt="Itrashy" class="w-96 rounded-[50px] shadow-xl">
                <div class="flex flex-col">
                    <h1 class="font-bold text-3xl md:text-3xl mb-8 text-blue-600 text-justify">Ciptakan lingkungan kerja yang bersih dan berkelanjutan.</h1>
                    <div class=" text-justify">
                        <p class="text-lg">Kelola limbah bisnis Anda secara profesional dengan layanan pengelolaan sampah terpercaya. Kami hadir untuk membantu perusahaan Anda menciptakan lingkungan kerja yang bersih dan berkelanjutan. Dengan sistem pemilahan yang cermat dan pengelolaan limbah yang efisien, kami mendukung upaya Anda untuk memenuhi standar lingkungan sekaligus mengurangi jejak karbon.
                            <span class="block mt-5">
                                Tak hanya sekadar pengangkutan sampah, kami menawarkan solusi terpadu mulai dari pengumpulan, pemilahan, hingga daur ulang, sesuai kebutuhan bisnis Anda. Bergabunglah bersama kami dalam membangun masa depan hijau, di mana tanggung jawab lingkungan menjadi bagian dari kesuksesan perusahaan Anda.
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-32">
        <div class="px-32 ">
            <h1 class="font-bold text-3xl md:text-5xl mb-4 text-end text-[#313131]">Individu</h1>
            <div class="w-full mx-auto border-t-2 border-gray-300 mt-2 mb-8 md:mb-16"></div>
            <div class="flex gap-16 items-center">
                <div class="flex flex-col">
                    <h1 class="font-bold text-3xl md:text-3xl mb-8 text-blue-600 text-justify">Ciptakan lingkungan kerja yang bersih dan berkelanjutan.</h1>
                    <div class=" text-justify">
                        <p class="text-lg">Kelola limbah bisnis Anda secara profesional dengan layanan pengelolaan sampah terpercaya. Kami hadir untuk membantu perusahaan Anda menciptakan lingkungan kerja yang bersih dan berkelanjutan. Dengan sistem pemilahan yang cermat dan pengelolaan limbah yang efisien, kami mendukung upaya Anda untuk memenuhi standar lingkungan sekaligus mengurangi jejak karbon.
                            <span class="block mt-5">
                                Tak hanya sekadar pengangkutan sampah, kami menawarkan solusi terpadu mulai dari pengumpulan, pemilahan, hingga daur ulang, sesuai kebutuhan bisnis Anda. Bergabunglah bersama kami dalam membangun masa depan hijau, di mana tanggung jawab lingkungan menjadi bagian dari kesuksesan perusahaan Anda.
                            </span>
                        </p>
                    </div>
                </div>
                <img src="{{ asset('storage/images/companysolusi.jpg') }}" alt="Itrashy" class="w-96 rounded-[50px] shadow-xl">
            </div>
        </div>
    </section>

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
                            <img src="{{ asset('storage/images/location.png') }}" alt="location" class="w-5 flex-shrink-0">
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
            <div class="w-full mx-auto border-t-2 border-black-300 mt-16 mb-8"></div>
            <div class="text-center">
                <p class="text-gray-600">Copyright 2024 by <span class="text-green-600">iTrashy</span> - All right reserved</p>
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
            '{{ asset('storage/images/individu.png') }}',
            '{{ asset('storage/images/company.jpg') }}'
        ];
        let currentSlide = 0;

        function changeSlide(index) {
            // Remove active class from current slide
            slides[currentSlide].classList.add('hidden');
            slideControls[currentSlide].classList.remove('bg-green-500');
            slideControls[currentSlide].classList.add('bg-gray-300');

            // Set new slide
            currentSlide = index;
            slides[currentSlide].classList.remove('hidden');
            slideControls[currentSlide].classList.remove('bg-gray-300');
            slideControls[currentSlide].classList.add('bg-green-500');

            // Change background
            slideContainer.style.backgroundImage = `url('${backgrounds[currentSlide]}')`;
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
