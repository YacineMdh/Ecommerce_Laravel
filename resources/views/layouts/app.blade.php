<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeMarket - @yield('title')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-50">
    <!-- Topbar -->
    <div class="bg-black text-white text-xs py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="hidden md:flex space-x-4">
                <a href="#" class="hover:text-gray-300">Support 24/7</a>
                <span>|</span>
                <a href="#" class="hover:text-gray-300">Livraison Gratuite dès 50€</a>
                <span>|</span>
                <a href="#" class="hover:text-gray-300">Retours sous 30 jours</a>
            </div>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-gray-300"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-gray-300"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-gray-300"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-gray-300"><i class="fab fa-pinterest"></i></a>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-black">LUXE<span class="text-rose-600">MARKET</span></span>
                    </a>
                </div>

                <!-- Main navigation - Desktop -->
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <a href="{{ route('home') }}" class="font-medium text-gray-800 hover:text-rose-600 transition duration-300 {{ request()->routeIs('home') ? 'text-rose-600' : '' }}">
                        Accueil
                    </a>
                    <a href="{{ route('products.index') }}" class="font-medium text-gray-800 hover:text-rose-600 transition duration-300 {{ request()->routeIs('products*') ? 'text-rose-600' : '' }}">
                        Boutique
                    </a>
                    <a href="#" class="font-medium text-gray-800 hover:text-rose-600 transition duration-300">
                        Catégories
                    </a>
                    <a href="#" class="font-medium text-gray-800 hover:text-rose-600 transition duration-300">
                        À Propos
                    </a>
                    <a href="#" class="font-medium text-gray-800 hover:text-rose-600 transition duration-300">
                        Contact
                    </a>
                </div>

                <!-- Right side items -->
                <div class="flex items-center space-x-6">
                    <!-- Search -->
                    <div class="hidden md:block relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-gray-600 hover:text-rose-600 transition duration-300">
                            <i class="fas fa-search text-xl"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-md p-2 z-50">
                            <form action="{{ route('products.index') }}" method="GET" class="flex items-center">
                                <input type="text" name="search" placeholder="Rechercher..." class="w-full px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-1 focus:ring-rose-500 focus:border-rose-500">
                                <button type="submit" class="bg-rose-600 text-white p-2 border border-rose-600 rounded-r-md hover:bg-rose-700 transition duration-300">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- User Menu -->
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-gray-600 hover:text-rose-600 transition duration-300">
                                <i class="fas fa-user text-xl"></i>
                            </button>
                            <div x-show="open" 
                                @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" 
                                role="menu">
                                <div class="px-4 py-2 text-sm text-gray-500 border-b border-gray-100">
                                    Bonjour, {{ substr(auth()->user()->getName(), 0, 12) }}
                                </div>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mes commandes</a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Panel</a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST" class="block border-t border-gray-100">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-rose-600 transition duration-300">
                            <i class="fas fa-user text-xl"></i>
                        </a>
                    @endauth

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-rose-600 transition duration-300 relative">
                        <i class="fas fa-shopping-bag text-xl"></i>
                        @if(isset($cartCount) && $cartCount > 0)
                            <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform bg-rose-600 rounded-full">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button" class="text-gray-600 hover:text-rose-600 transition duration-300" x-data="{ mobileMenuOpen: false }" @click="mobileMenuOpen = !mobileMenuOpen; $dispatch('mobile-menu-toggled', mobileMenuOpen)">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div 
            class="md:hidden bg-white shadow-lg transform transition-transform duration-300 ease-in-out hidden absolute w-full z-40"
            x-data="{ open: false }"
            x-show="open"
            @mobile-menu-toggled.window="open = $event.detail"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-10">
            <div class="px-4 pt-2 pb-5 space-y-4">
                <form action="{{ route('products.index') }}" method="GET" class="flex items-center mt-4">
                    <input type="text" name="search" placeholder="Rechercher..." class="w-full px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-1 focus:ring-rose-500 focus:border-rose-500">
                    <button type="submit" class="bg-rose-600 text-white p-2 border border-rose-600 rounded-r-md hover:bg-rose-700 transition duration-300">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <a href="{{ route('home') }}" class="block py-2 px-3 rounded-md font-medium text-gray-900 hover:bg-gray-100 {{ request()->routeIs('home') ? 'bg-rose-50 text-rose-600' : '' }}">Accueil</a>
                <a href="{{ route('products.index') }}" class="block py-2 px-3 rounded-md font-medium text-gray-900 hover:bg-gray-100 {{ request()->routeIs('products*') ? 'bg-rose-50 text-rose-600' : '' }}">Boutique</a>
                <a href="#" class="block py-2 px-3 rounded-md font-medium text-gray-900 hover:bg-gray-100">Catégories</a>
                <a href="#" class="block py-2 px-3 rounded-md font-medium text-gray-900 hover:bg-gray-100">À Propos</a>
                <a href="#" class="block py-2 px-3 rounded-md font-medium text-gray-900 hover:bg-gray-100">Contact</a>
                
                @guest
                <div class="mt-6 grid grid-cols-2 gap-4">
                    <a href="{{ route('login') }}" class="text-center py-2 px-4 border border-rose-600 rounded-md text-rose-600 font-medium hover:bg-rose-50 transition duration-300">Connexion</a>
                    <a href="{{ route('register') }}" class="text-center py-2 px-4 bg-rose-600 rounded-md text-white font-medium hover:bg-rose-700 transition duration-300">Inscription</a>
                </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Notifications -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-md shadow-sm">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button @click="show = false" class="text-green-500 hover:text-green-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md shadow-sm">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                    <button @click="show = false" class="text-red-500 hover:text-red-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Content -->
    <main class="flex-grow w-full mx-auto">
        @yield('content')
    </main>

    <!-- Newsletter -->
    <section class="bg-black text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-4">Rejoignez notre newsletter</h2>
                    <p class="text-gray-300 mb-3">Inscrivez-vous pour recevoir nos dernières offres et nouveautés.</p>
                    <p class="text-gray-400">Aucun spam, nous promettons.</p>
                </div>
                <div>
                    <form class="flex flex-col sm:flex-row gap-2">
                        <input type="email" placeholder="Votre adresse email" required class="px-4 py-3 rounded-md flex-grow bg-gray-800 text-white border border-gray-700 focus:outline-none focus:border-rose-500">
                        <button type="submit" class="px-6 py-3 bg-rose-600 text-white rounded-md font-medium hover:bg-rose-700 transition duration-300">
                            S'abonner
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main footer content -->
            <div class="py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <div class="mb-4">
                        <span class="text-2xl font-bold text-white">LUXE<span class="text-rose-500">MARKET</span></span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Votre destination pour des produits exclusifs et de qualité supérieure. Nous sélectionnons les meilleures marques pour vous offrir une expérience shopping inégalée.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-rose-500 transition duration-300">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-rose-500 transition duration-300">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-rose-500 transition duration-300">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-rose-500 transition duration-300">
                            <i class="fab fa-pinterest text-lg"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-100">Boutique</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-rose-500 transition duration-300">Tous les produits</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-rose-500 transition duration-300">Nouveautés</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-rose-500 transition duration-300">Meilleures ventes</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-rose-500 transition duration-300">Offres spéciales</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-100">Informations</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-rose-500 transition duration-300">À propos de nous</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-rose-500 transition duration-300">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-rose-500 transition duration-300">Livraison & Retours</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-rose-500 transition duration-300">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-rose-500 transition duration-300">Conditions générales</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-100">Contact</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-rose-500"></i>
                            <span class="text-gray-400">123 Avenue des Champs-Élysées, 75008 Paris, France</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone mt-1 mr-3 text-rose-500"></i>
                            <span class="text-gray-400">+33 1 23 45 67 89</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3 text-rose-500"></i>
                            <span class="text-gray-400">contact@luxemarket.com</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-clock mt-1 mr-3 text-rose-500"></i>
                            <span class="text-gray-400">Lun-Ven: 9h-18h | Sam: 10h-16h</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Payment methods and copyright -->
            <div class="py-6 border-t border-gray-800">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="text-gray-400 text-sm">
                        &copy; 2025 LuxeMarket. Tous droits réservés.
                    </div>
                    <div class="flex space-x-4">
                        <img src="https://cdn.shopify.com/s/files/1/0597/1151/0305/files/visa-icon.svg" alt="Visa" class="h-6">
                        <img src="https://cdn.shopify.com/s/files/1/0597/1151/0305/files/mastercard-icon.svg" alt="Mastercard" class="h-6">
                        <img src="https://cdn.shopify.com/s/files/1/0597/1151/0305/files/amex-icon.svg" alt="American Express" class="h-6">
                        <img src="https://cdn.shopify.com/s/files/1/0597/1151/0305/files/paypal-icon.svg" alt="PayPal" class="h-6">
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>