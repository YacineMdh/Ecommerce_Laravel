<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin LuxeMarket - @yield('title', 'Dashboard')</title>
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
        
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 500;
            color: rgb(209 213 219);
            border-radius: 0.5rem;
            transition: all 300ms;
        }
        
        .sidebar-item:hover {
            background-color: rgb(55 65 81);
        }
        
        .sidebar-item.active {
            background-color: rgb(55 65 81);
            color: white;
        }
        
        .sidebar-icon {
            width: 1.5rem;
            height: 1.5rem;
            transition: all 300ms;
            margin-right: 0.75rem;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-800 shadow-xl transform transition-transform duration-300 md:translate-x-0" 
               x-data="{ sidebarOpen: true }" 
               :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            <!-- Logo -->
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-700">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white">
                    LUXE<span class="text-rose-500">MARKET</span>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-300 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Navigation -->
            <nav class="p-4 space-y-2 overflow-y-auto h-[calc(100vh-70px)]">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt sidebar-icon"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="sidebar-item {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                    <i class="fas fa-box sidebar-icon"></i>
                    <span>Produits</span>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="sidebar-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                    <i class="fas fa-tags sidebar-icon"></i>
                    <span>Catégories</span>
                </a>
                
                <a href="{{ route('admin.coupons.index') }}" class="sidebar-item {{ request()->routeIs('admin.coupons*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt sidebar-icon"></i>
                    <span>Coupons</span>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="sidebar-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart sidebar-icon"></i>
                    <span>Commandes</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="sidebar-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="fas fa-users sidebar-icon"></i>
                    <span>Utilisateurs</span>
                </a>
                
                <hr class="border-gray-700 my-4">
                
                <a href="{{ route('home') }}" class="sidebar-item">
                    <i class="fas fa-store sidebar-icon"></i>
                    <span>Voir la boutique</span>
                </a>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-item w-full text-left">
                        <i class="fas fa-sign-out-alt sidebar-icon"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex-1 md:ml-64 flex flex-col min-h-screen">
            <!-- Header -->
            <header class="bg-white shadow-sm p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="mr-4 text-gray-600 md:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                </div>
                
                <div class="flex items-center">
                    <!-- Notifications -->
                    <div class="relative mr-4" x-data="{ open: false }">
                        <button @click="open = !open" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                            <i class="fas fa-bell"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-20">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <h3 class="text-sm font-semibold text-gray-800">Notifications</h3>
                            </div>
                            <div class="max-h-60 overflow-y-auto">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm text-gray-600">Pas de nouvelles notifications</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center focus:outline-none">
                            <div class="h-8 w-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 font-semibold">
                                {{ substr(auth()->user()->getName(), 0, 1) }}
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-700 hidden sm:block">{{ auth()->user()->getName() }}</span>
                            <i class="fas fa-chevron-down ml-1 text-xs text-gray-500"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Paramètres</a>
                            <div class="border-t border-gray-100"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main content -->
            <main class="flex-1 p-6 overflow-x-hidden">
                <!-- Messages flash -->
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-500"></i>
                            <span>{{ session('success') }}</span>
                            <button @click="show = false" class="ml-auto text-green-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                            <span>{{ session('error') }}</span>
                            <button @click="show = false" class="ml-auto text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
                
                <!-- Content -->
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 p-4 text-center text-gray-600 text-sm">
                &copy; 2025 LuxeMarket Admin. Tous droits réservés.
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>