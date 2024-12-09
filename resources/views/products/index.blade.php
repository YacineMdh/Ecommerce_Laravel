@extends('layouts.app')

@section('title', 'Produits')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                    <i class="fas fa-home mr-2"></i>
                    Accueil
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <span class="text-sm font-medium text-gray-500">Produits</span>
                </div>
            </li>
            @if($category)
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <span class="text-sm font-medium text-gray-500">{{ $category->getName() }}</span>
                </div>
            </li>
            @endif
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar with filters -->
        <div class="lg:col-span-1" x-data="{ mobileFiltersOpen: false }">
            <!-- Mobile filters toggle -->
            <div class="lg:hidden mb-6 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Filtres</h2>
                <button @click="mobileFiltersOpen = !mobileFiltersOpen" class="text-gray-600 hover:text-gray-900">
                    <span x-show="!mobileFiltersOpen"><i class="fas fa-filter mr-2"></i> Afficher les filtres</span>
                    <span x-show="mobileFiltersOpen"><i class="fas fa-times mr-2"></i> Masquer les filtres</span>
                </button>
            </div>
            
            <!-- Filters content -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6 hidden lg:block" :class="{'block': mobileFiltersOpen, 'hidden': !mobileFiltersOpen}">
                <!-- Categories filter -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Catégories</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('products.index') }}" class="flex items-center text-gray-700 hover:text-rose-600 {{ is_null($category) ? 'text-rose-600 font-medium' : '' }}">
                                <span class="ml-2">Toutes les catégories</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('products.index', ['category' => $cat->getId()]) }}" class="flex items-center text-gray-700 hover:text-rose-600 {{ $category && $category->getId() == $cat->getId() ? 'text-rose-600 font-medium' : '' }}">
                                    <span class="ml-2">{{ $cat->getName() }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price range filter -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Prix</h3>
                    <form action="{{ route('products.index') }}" method="GET" class="space-y-4">
                        @if($category)
                            <input type="hidden" name="category" value="{{ $category->getId() }}">
                        @endif
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="min_price" class="block text-sm text-gray-600 mb-1">Min</label>
                                <input type="number" name="min_price" id="min_price" min="0" 
                                       value="{{ request('min_price') }}" 
                                       class="w-full border border-gray-300 rounded-md p-2 focus:ring-rose-500 focus:border-rose-500">
                            </div>
                            <div>
                                <label for="max_price" class="block text-sm text-gray-600 mb-1">Max</label>
                                <input type="number" name="max_price" id="max_price" min="0" 
                                       value="{{ request('max_price') }}" 
                                       class="w-full border border-gray-300 rounded-md p-2 focus:ring-rose-500 focus:border-rose-500">
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 rounded-md transition duration-300">
                            Appliquer
                        </button>
                    </form>
                </div>

                <!-- Availability filter -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Disponibilité</h3>
                    <form action="{{ route('products.index') }}" method="GET">
                        @if($category)
                            <input type="hidden" name="category" value="{{ $category->getId() }}">
                        @endif
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request()->has('min_price'))
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        @endif
                        @if(request()->has('max_price'))
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                        @endif
                        
                        <div class="space-y-2">
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio text-rose-600" name="in_stock" value="1" {{ request('in_stock') == '1' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">En stock uniquement</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio text-rose-600" name="in_stock" value="0" {{ request('in_stock') == '0' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tous les produits</span>
                            </label>
                        </div>
                        
                        <button type="submit" class="mt-4 w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 rounded-md transition duration-300">
                            Appliquer
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Promotions banner -->
            <div class="hidden lg:block bg-gradient-to-r from-rose-500 to-rose-600 rounded-xl overflow-hidden shadow-sm text-white p-6">
                <h3 class="text-xl font-bold mb-2">Offres spéciales</h3>
                <p class="mb-4">Jusqu'à 30% de réduction sur une sélection de produits.</p>
                <a href="#" class="inline-block bg-white text-rose-600 px-4 py-2 rounded-full font-medium hover:bg-gray-100 transition duration-300">
                    Voir les offres
                </a>
            </div>
        </div>

        <!-- Products grid -->
        <div class="lg:col-span-3">
            <!-- Top controls: search, sort, view options -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        @if($category)
                            {{ $category->getName() }}
                        @elseif(request()->has('search'))
                            Résultats pour "{{ request('search') }}"
                        @else
                            Tous nos produits
                        @endif
                    </h1>
                    <p class="text-gray-600 mt-1">{{ $products->total() }} produits trouvés</p>
                </div>
                
                <div class="flex items-center gap-4 self-stretch sm:self-auto">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-gray-700 hover:text-gray-900">
                            <span>Trier par</span>
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                            <a href="{{ route('products.index', array_merge(request()->all(), ['sort' => 'name_asc'])) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Nom (A-Z)
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->all(), ['sort' => 'name_desc'])) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Nom (Z-A)
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->all(), ['sort' => 'price_asc'])) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Prix (croissant)
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->all(), ['sort' => 'price_desc'])) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Prix (décroissant)
                            </a>
                        </div>
                    </div>
                    
                    <div class="flex border divide-x rounded">
                        <a href="{{ route('products.index', array_merge(request()->all(), ['view' => 'grid'])) }}" class="py-2 px-3 {{ request('view', 'grid') == 'grid' ? 'bg-gray-100 text-gray-800' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                            <i class="fas fa-th-large"></i>
                        </a>
                        <a href="{{ route('products.index', array_merge(request()->all(), ['view' => 'list'])) }}" class="py-2 px-3 {{ request('view') == 'list' ? 'bg-gray-100 text-gray-800' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                            <i class="fas fa-list"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Search bar -->
            <div class="mb-8">
                <form action="{{ route('products.index') }}" method="GET" class="flex">
                    @if($category)
                        <input type="hidden" name="category" value="{{ $category->getId() }}">
                    @endif
                    <input type="text" name="search" placeholder="Rechercher un produit..." value="{{ request('search') }}" 
                           class="flex-grow border border-gray-300 rounded-l-md p-3 focus:ring-rose-500 focus:border-rose-500">
                    <button type="submit" class="bg-rose-600 text-white p-3 rounded-r-md hover:bg-rose-700 transition duration-300">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <!-- Products display -->
            @if(count($products) > 0)
                @if(request('view') == 'list')
                    <!-- List view -->
                    <div class="space-y-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition duration-300">
                                <div class="flex flex-col md:flex-row">
                                    <div class="md:w-1/3 h-64 md:h-auto">
                                        <a href="{{ route('products.show', $product->getId()) }}">
                                            <img src="https://source.unsplash.com/random/400x400/?product,{{ $loop->index }}" 
                                                alt="{{ $product->getName() }}" 
                                                class="w-full h-full object-cover">
                                        </a>
                                    </div>
                                    <div class="p-6 md:w-2/3 flex flex-col justify-between">
                                        <div>
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <span class="text-rose-600 text-sm">{{ $product->getCategory()->getName() }}</span>
                                                    <h3 class="text-lg font-semibold text-gray-900 mt-1">
                                                        <a href="{{ route('products.show', $product->getId()) }}" class="hover:text-rose-600 transition duration-300">
                                                            {{ $product->getName() }}
                                                        </a>
                                                    </h3>
                                                </div>
                                                <div class="flex items-center">
                                                    <div class="flex text-amber-400 text-xs">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star-half-alt"></i>
                                                    </div>
                                                    <span class="text-xs text-gray-600 ml-1">4.8</span>
                                                </div>
                                            </div>
                                            
                                            <p class="text-gray-600 mt-4 line-clamp-3">{{ $product->getDescription() }}</p>
                                        </div>
                                        
                                        <div class="flex items-end justify-between mt-4">
                                            <div>
                                                <span class="text-xl font-bold text-gray-900">{{ number_format($product->getPrice(), 2) }} €</span>
                                                @if($product->getStock() > 0)
                                                    <p class="text-green-600 text-sm flex items-center mt-1">
                                                        <i class="fas fa-check-circle mr-1"></i> En stock
                                                    </p>
                                                @else
                                                    <p class="text-red-600 text-sm flex items-center mt-1">
                                                        <i class="fas fa-times-circle mr-1"></i> Rupture de stock
                                                    </p>
                                                @endif
                                            </div>
                                            
                                            <div class="flex space-x-2">
                                                <a href="{{ route('products.show', $product->getId()) }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-300">
                                                    Détails
                                                </a>
                                                @if($product->getStock() > 0)
                                                    <form action="{{ route('cart.add', $product->getId()) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="px-4 py-2 bg-rose-600 rounded-md text-white hover:bg-rose-700 transition duration-300">
                                                            <i class="fas fa-shopping-bag mr-1"></i> Ajouter
                                                        </button>
                                                    </form>
                                                @else
                                                    <button disabled class="px-4 py-2 bg-gray-300 rounded-md text-gray-500 cursor-not-allowed">
                                                        <i class="fas fa-shopping-bag mr-1"></i> Indisponible
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Grid view (default) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition duration-300 flex flex-col">
                                <a href="{{ route('products.show', $product->getId()) }}" class="group">
                                    <div class="relative h-64 overflow-hidden">
                                        <img src="https://source.unsplash.com/random/400x400/?product,{{ $loop->index }}" 
                                             alt="{{ $product->getName() }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            
                                        @if($product->getStock() <= 5 && $product->getStock() > 0)
                                            <div class="absolute top-2 left-2 bg-amber-500 text-white text-xs font-bold px-2 py-1 rounded">
                                                Stock limité
                                            </div>
                                        @elseif($product->getStock() == 0)
                                            <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                                Rupture de stock
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                
                                <div class="p-4 flex-grow flex flex-col">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs text-gray-500">{{ $product->getCategory()->getName() }}</span>
                                        <div class="flex items-center">
                                            <div class="flex text-amber-400 text-xs">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                            <span class="text-xs text-gray-600 ml-1">4.8</span>
                                        </div>
                                    </div>
                                    
                                    <h3 class="text-gray-900 font-medium mb-2">
                                        <a href="{{ route('products.show', $product->getId()) }}" class="hover:text-rose-600 transition duration-300">
                                            {{ $product->getName() }}
                                        </a>
                                    </h3>
                                    
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2 flex-grow">{{ $product->getDescription() }}</p>
                                    
                                    <div class="flex justify-between items-center mt-auto">
                                        <span class="text-lg font-bold text-rose-600">{{ number_format($product->getPrice(), 2) }} €</span>
                                        
                                        @if($product->getStock() > 0)
                                            <form action="{{ route('cart.add', $product->getId()) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="text-rose-600 hover:text-rose-700 hover:bg-rose-50 p-2 rounded-full transition duration-300">
                                                    <i class="fas fa-shopping-bag"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="text-gray-400 p-2 cursor-not-allowed">
                                                <i class="fas fa-shopping-bag"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->appends(request()->all())->links() }}
                </div>
            @else
                <!-- No products found -->
                <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mt-4">Aucun produit trouvé</h3>
                    <p class="text-gray-600 mt-2">Nous n'avons pas trouvé de produit correspondant à votre recherche.</p>
                    <div class="mt-6">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-rose-600 text-white rounded-md hover:bg-rose-700 transition duration-300">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Voir tous les produits
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection