@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Statistiques générales -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 flex items-start">
            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-rose-100 text-rose-600">
                <i class="fas fa-shopping-cart text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Commandes</h3>
                <div class="mt-1 flex items-baseline">
                    <span class="text-2xl font-semibold text-gray-900">{{ $stats['totalOrders'] }}</span>
                    <span class="ml-2 text-xs font-medium text-green-600 px-2 py-0.5 rounded-full bg-green-100">+12.5%</span>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.orders.index') }}" class="font-medium text-rose-600 hover:text-rose-500 transition duration-300">
                    Voir toutes les commandes <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 flex items-start">
            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-blue-100 text-blue-600">
                <i class="fas fa-box-open text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Produits</h3>
                <div class="mt-1 flex items-baseline">
                    <span class="text-2xl font-semibold text-gray-900">{{ $stats['totalProducts'] }}</span>
                    <span class="ml-2 text-xs font-medium text-green-600 px-2 py-0.5 rounded-full bg-green-100">+4.3%</span>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.products.index') }}" class="font-medium text-rose-600 hover:text-rose-500 transition duration-300">
                    Gérer les produits <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 flex items-start">
            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-purple-100 text-purple-600">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Utilisateurs</h3>
                <div class="mt-1 flex items-baseline">
                    <span class="text-2xl font-semibold text-gray-900">{{ $stats['totalUsers'] }}</span>
                    <span class="ml-2 text-xs font-medium text-green-600 px-2 py-0.5 rounded-full bg-green-100">+22.3%</span>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.users.index') }}" class="font-medium text-rose-600 hover:text-rose-500 transition duration-300">
                    Voir tous les utilisateurs <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 flex items-start">
            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-green-100 text-green-600">
                <i class="fas fa-euro-sign text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Chiffre d'affaires</h3>
                <div class="mt-1 flex items-baseline">
                    <span class="text-2xl font-semibold text-gray-900">12 450 €</span>
                    <span class="ml-2 text-xs font-medium text-green-600 px-2 py-0.5 rounded-full bg-green-100">+8.1%</span>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-3">
            <div class="text-sm">
                <a href="#" class="font-medium text-rose-600 hover:text-rose-500 transition duration-300">
                    Voir les statistiques <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Graphique de ventes et commandes en attente -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Graphique des ventes -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden lg:col-span-2">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-medium text-gray-900">Ventes récentes</h2>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 bg-rose-600 text-white text-xs rounded-full">Jour</button>
                    <button class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full hover:bg-gray-200 transition duration-300">Semaine</button>
                    <button class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full hover:bg-gray-200 transition duration-300">Mois</button>
                </div>
            </div>
        </div>
        <div class="px-6 py-6">
            <div class="h-64 relative">
                <!-- Graphique factice - à remplacer par un vrai graphique -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <img src="https://cdn.pixabay.com/photo/2018/05/07/10/48/infographic-3380276_960_720.png" alt="Sales Chart" class="h-full max-w-full object-contain opacity-60">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Commandes en attente -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Commandes en attente</h2>
        </div>
        <div class="overflow-y-auto max-h-80">
            @if(count($stats['recentOrders']) > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($stats['recentOrders'] as $order)
                        <li class="px-6 py-4 hover:bg-gray-50 transition duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Commande #{{ $order->getId() }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->getUser()->getName() }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ number_format($order->getTotal(), 2) }} €</p>
                                    @if($order->getStatus() == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            En attente
                                        </span>
                                    @elseif($order->getStatus() == 'processing')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            En traitement
                                        </span>
                                    @elseif($order->getStatus() == 'shipped')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            Expédiée
                                        </span>
                                    @elseif($order->getStatus() == 'delivered')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Livrée
                                        </span>
                                    @elseif($order->getStatus() == 'cancelled')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Annulée
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="px-6 py-4 text-center">
                    <p class="text-gray-500">Aucune commande récente</p>
                </div>
            @endif
        </div>
        <div class="bg-gray-50 px-6 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.orders.index') }}" class="font-medium text-rose-600 hover:text-rose-500 transition duration-300">
                    Voir toutes les commandes <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Produits populaires et derniers utilisateurs -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Produits populaires -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Produits populaires</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ventes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($stats['topProducts'] as $product)
                        <tr class="hover:bg-gray-50 transition duration-300">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 rounded-full bg-gray-200 overflow-hidden">
                                        <img src="https://source.unsplash.com/random/400x400/?product,{{ $loop->index }}" class="h-full w-full object-cover" alt="{{ $product->getName() }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->getName() }}</div>
                                        <div class="text-sm text-gray-500">{{ $product->getCategory()->getName() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($product->getPrice(), 2) }} €</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->getStock() > 10)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $product->getStock() }} en stock
                                    </span>
                                @elseif($product->getStock() > 0)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $product->getStock() }} en stock
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Rupture de stock
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ rand(10, 100) }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 px-6 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.products.index') }}" class="font-medium text-rose-600 hover:text-rose-500 transition duration-300">
                    Voir tous les produits <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Derniers utilisateurs -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Derniers utilisateurs inscrits</h2>
        </div>
        <div class="divide-y divide-gray-200">
            @for($i = 0; $i < 5; $i++)
                <div class="px-6 py-4 flex items-center hover:bg-gray-50 transition duration-300">
                    <div class="flex-shrink-0 h-10 w-10">
                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold">
                            {{ chr(65 + $i) }}
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Utilisateur {{ $i + 1 }}</p>
                                <p class="text-sm text-gray-500">utilisateur{{ $i + 1 }}@example.com</p>
                            </div>
                            <div class="text-sm text-gray-500">
                                Il y a {{ rand(1, 30) }} jours
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <div class="bg-gray-50 px-6 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.users.index') }}" class="font-medium text-rose-600 hover:text-rose-500 transition duration-300">
                    Voir tous les utilisateurs <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Actions rapides</h2>
    </div>
    <div class="px-6 py-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.products.create') }}" class="bg-rose-50 hover:bg-rose-100 p-4 rounded-lg transition duration-300 flex flex-col items-center justify-center text-center">
                <div class="bg-rose-100 rounded-full p-3 mb-3">
                    <i class="fas fa-plus text-rose-600"></i>
                </div>
                <h3 class="text-sm font-medium text-gray-900">Ajouter un produit</h3>
            </a>
            
            <a href="{{ route('admin.categories.create') }}" class="bg-blue-50 hover:bg-blue-100 p-4 rounded-lg transition duration-300 flex flex-col items-center justify-center text-center">
                <div class="bg-blue-100 rounded-full p-3 mb-3">
                    <i class="fas fa-folder-plus text-blue-600"></i>
                </div>
                <h3 class="text-sm font-medium text-gray-900">Ajouter une catégorie</h3>
            </a>
            
            <a href="{{ route('admin.coupons.create') }}" class="bg-amber-50 hover:bg-amber-100 p-4 rounded-lg transition duration-300 flex flex-col items-center justify-center text-center">
                <div class="bg-amber-100 rounded-full p-3 mb-3">
                    <i class="fas fa-percentage text-amber-600"></i>
                </div>
                <h3 class="text-sm font-medium text-gray-900">Créer un coupon</h3>
            </a>
            
            <a href="{{ route('admin.orders.index') }}" class="bg-green-50 hover:bg-green-100 p-4 rounded-lg transition duration-300 flex flex-col items-center justify-center text-center">
                <div class="bg-green-100 rounded-full p-3 mb-3">
                    <i class="fas fa-shipping-fast text-green-600"></i>
                </div>
                <h3 class="text-sm font-medium text-gray-900">Gérer les commandes</h3>
            </a>
        </div>
    </div>
</div>
@endsection