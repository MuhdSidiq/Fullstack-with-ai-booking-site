<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Evergreen Peaks' }}</title>
    
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Nunito:wght@400;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance

    <style>
        :root {
            --primary: #1e3a2f;
            --secondary: #2d4a3e;
            --accent: #d4a373;
            --bg: #fdfdfb;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: #1a1a1a;
            scroll-behavior: smooth;
        }

        h1, h2, h3, .nav-logo {
            font-family: 'Nunito', sans-serif;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--secondary);
            transform: scale(1.02);
            box-shadow: 0 10px 15px -3px rgba(30, 58, 47, 0.3);
        }
    </style>
</head>
<body class="overflow-x-hidden flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-nav border-b border-zinc-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center gap-3">
                        <div class="bg-emerald-900 p-2 rounded-lg">
                            <i class="fas fa-campground text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-extrabold tracking-tight text-emerald-950 nav-logo">Evergreen Peaks</span>
                    </a>
                </div>
                
                <!-- Desktop Links -->  
                <div class="hidden md:flex items-center space-x-8 font-medium">
                    <a href="/#home" class="text-gray-700 hover:text-emerald-800 transition">Home</a>
                    <a href="/#sites" class="text-gray-700 hover:text-emerald-800 transition">Campsites</a>
                    <a href="/#testimonials" class="text-gray-700 hover:text-emerald-800 transition">Reviews</a>
                    <a href="/#contact" class="text-gray-700 hover:text-emerald-800 transition">Support</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary text-white px-6 py-2.5 rounded-full text-sm font-bold">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-emerald-800 transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary text-white px-6 py-2.5 rounded-full text-sm font-bold">Sign Up</a>
                        @endif
                    @endauth
                </div>

                <!-- Mobile Toggle -->
                <button class="md:hidden text-emerald-950 p-2" id="mobile-menu-btn">
                    <i class="fas fa-bars-staggered text-2xl" id="menu-icon"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="absolute top-20 left-0 w-full bg-white border-b border-gray-100 shadow-xl md:hidden hidden z-40">
            <div class="flex flex-col p-6 space-y-4 font-semibold text-gray-800">
                <a href="/#home" class="mobile-link py-2 border-b border-gray-50">Home</a>
                <a href="/#sites" class="mobile-link py-2 border-b border-gray-50">Explore Sites</a>
                <a href="/#testimonials" class="mobile-link py-2 border-b border-gray-50">Testimonials</a>
                <a href="/#contact" class="mobile-link py-2 border-b border-gray-50">Contact Us</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-emerald-900 text-white text-center py-4 rounded-xl">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-emerald-900 text-white text-center py-4 rounded-xl">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-emerald-800 text-white text-center py-4 rounded-xl mt-2">Sign Up</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow pt-20">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 pt-20 pb-10 mt-auto">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-2 space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-emerald-900 p-2 rounded-lg">
                            <i class="fas fa-campground text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-extrabold tracking-tight text-emerald-950 nav-logo">Evergreen Peaks</span>
                    </div>
                    <p class="text-gray-500 max-w-sm">Preserving the wild for over 25 years. We provide sustainable, high-quality camping experiences.</p>
                </div>
                <div>
                    <h4 class="font-bold text-emerald-950 mb-6">Quick Links</h4>
                    <ul class="space-y-4 text-gray-600">
                        <li><a href="#" class="hover:text-emerald-800 transition">About Us</a></li>
                        <li><a href="#" class="hover:text-emerald-800 transition">Park Rules</a></li>
                        <li><a href="#" class="hover:text-emerald-800 transition">Carrers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-emerald-950 mb-6">Legal</h4>
                    <ul class="space-y-4 text-gray-600">
                        <li><a href="#" class="hover:text-emerald-800 transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-emerald-800 transition">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Evergreen Peaks. All rights reserved.</p>
                <p>Designed for the Great Outdoors.</p>
            </div>
        </div>
    </footer>

    <script>
        // Simple Mobile Menu Logic
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');

        if(mobileMenuBtn) {
            mobileMenuBtn.onclick = () => {
                mobileMenu.classList.toggle('hidden');
                menuIcon.classList.toggle('fa-bars-staggered');
                menuIcon.classList.toggle('fa-xmark');
            };
        }
    </script>
    @fluxScripts
</body>
</html>
