@extends('layouts.app')

@section('title', 'Bienvenue')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-black h-[600px] overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2574&q=80" 
                 class="w-full h-full object-cover opacity-60" alt="Hero Background">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-black to-transparent opacity-70"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="max-w-xl">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 leading-tight">Découvrez l'excellence</h1>
                <p class="text-xl text-gray-200 mb-8">Des produits exceptionnels pour une clientèle exigeante. Qualité, élégance et exclusivité.</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('products.index') }}" class="px-8 py-3 bg-rose-600 text-white font-medium rounded-full hover:bg-rose-700 transition duration-300 text-center">
                        Découvrir la collection
                    </a>
                    <a href="#" class="px-8 py-3 bg-transparent border border-white text-white font-medium rounded-full hover:bg-white hover:text-black transition duration-300 text-center">
                        En savoir plus
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Nos catégories populaires</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Explorez notre sélection de produits premium classés par catégories pour trouver exactement ce que vous recherchez.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->getId()]) }}" class="group">
                        <div class="relative overflow-hidden rounded-lg shadow-lg h-80">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-60 z-10"></div>
                            <img src="https://source.unsplash.com/random/600x800/?{{ urlencode($category->getName()) }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="{{ $category->getName() }}">
                            <div class="absolute bottom-0 left-0 right-0 p-6 z-20">
                                <h3 class="text-xl font-bold text-white mb-2">{{ $category->getName() }}</h3>
                                <p class="text-gray-200 mb-4 line-clamp-2">{{ $category->getDescription() }}</p>
                                <span class="inline-flex items-center text-white text-sm font-medium">
                                    Explorer
                                    <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Produits à la une</h2>
                    <p class="text-gray-600">Découvrez nos produits les plus populaires et tendances</p>
                </div>
                <a href="{{ route('products.index') }}" class="mt-4 md:mt-0 px-6 py-2 border border-gray-300 rounded-full text-gray-700 hover:bg-gray-100 transition duration-300 flex items-center">
                    Voir tous les produits
                    <svg class="ml-2 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts as $product)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden group hover:shadow-md transition duration-300">
                        <div class="relative overflow-hidden h-64">
                            <img src="https://source.unsplash.com/random/600x600/?product" 
                                alt="{{ $product->getName() }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <a href="{{ route('products.show', $product->getId()) }}" class="bg-white text-gray-900 px-4 py-2 rounded-full font-medium transform -translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                    Voir détails
                                </a>
                            </div>
                            
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
                        
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs text-gray-500">{{ $product->getCategory()->getName() }}</span>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span class="text-xs text-gray-600 ml-1">4.8</span>
                                </div>
                            </div>
                            
                            <h3 class="text-gray-900 font-medium text-lg mb-2">{{ $product->getName() }}</h3>
                            
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-lg font-bold text-rose-600">{{ number_format($product->getPrice(), 2) }} €</span>
                                </div>
                                <form action="{{ route('cart.add', $product->getId()) }}" method="POST" class="flex-shrink-0">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="text-rose-600 hover:text-rose-700 transition duration-300" {{ $product->getStock() == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-bag"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Pourquoi nous choisir ?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Nous nous engageons à offrir un service d'excellence avec des produits de qualité supérieure.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-8 rounded-xl hover:shadow-lg transition duration-300">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-rose-100 text-rose-600 rounded-full mb-6">
                        <i class="fas fa-shipping-fast text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Livraison rapide</h3>
                    <p class="text-gray-600">Livraison offerte à partir de 50€ d'achat et expédition sous 24h pour une satisfaction garantie.</p>
                </div>

                <div class="text-center p-8 rounded-xl hover:shadow-lg transition duration-300">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-rose-100 text-rose-600 rounded-full mb-6">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Paiement sécurisé</h3>
                    <p class="text-gray-600">Transactions 100% sécurisées avec cryptage SSL pour protéger vos données personnelles.</p>
                </div>

                <div class="text-center p-8 rounded-xl hover:shadow-lg transition duration-300">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-rose-100 text-rose-600 rounded-full mb-6">
                        <i class="fas fa-undo text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Retours faciles</h3>
                    <p class="text-gray-600">Satisfait ou remboursé sous 30 jours avec une politique de retour sans tracas.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Ce que disent nos clients</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Découvrez les témoignages de nos clients satisfaits qui ont fait confiance à LuxeMarket.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-800 p-6 rounded-xl relative">
                    <div class="absolute -top-5 left-6 text-5xl text-rose-500 opacity-50">"</div>
                    <div class="pt-4">
                        <p class="text-gray-300 mb-4">Je suis extrêmement satisfaite de la qualité des produits et du service client. La livraison a été très rapide et l'emballage soigné.</p>
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 font-semibold">S</div>
                            <div class="ml-3">
                                <h4 class="font-semibold">Sophie Marceau</h4>
                                <div class="flex text-amber-400 mt-1">
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-800 p-6 rounded-xl relative">
                    <div class="absolute -top-5 left-6 text-5xl text-rose-500 opacity-50">"</div>
                    <div class="pt-4">
                        <p class="text-gray-300 mb-4">Je recommande vivement LuxeMarket pour l'authenticité des produits et le professionnalisme de l'équipe. Un achat en toute confiance.</p>
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 font-semibold">T</div>
                            <div class="ml-3">
                                <h4 class="font-semibold">Thomas Laurent</h4>
                                <div class="flex text-amber-400 mt-1">
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star-half-alt text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-800 p-6 rounded-xl relative">
                    <div class="absolute -top-5 left-6 text-5xl text-rose-500 opacity-50">"</div>
                    <div class="pt-4">
                        <p class="text-gray-300 mb-4">Service impeccable et produits de très haute qualité. Le site est facile à utiliser et le suivi de commande parfait. Je reviendrai !</p>
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 font-semibold">M</div>
                            <div class="ml-3">
                                <h4 class="font-semibold">Marie Dupont</h4>
                                <div class="flex text-amber-400 mt-1">
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                    <i class="fas fa-star text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Newsletter -->
    <section class="py-16 bg-rose-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="grid md:grid-cols-2">
                    <div class="p-8 md:p-12 lg:p-16">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Restez connecté avec nous</h2>
                        <p class="text-gray-600 mb-8">Inscrivez-vous à notre newsletter pour recevoir nos offres exclusives, nos nouveautés et nos conseils personnalisés.</p>
                        
                        <form class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                <input type="text" id="name" placeholder="Votre nom" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-rose-500 focus:border-rose-500">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" placeholder="Votre adresse email" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-rose-500 focus:border-rose-500">
                            </div>
                            <button type="submit" class="w-full bg-rose-600 text-white py-3 px-4 rounded-md font-medium hover:bg-rose-700 transition duration-300">
                                S'abonner
                            </button>
                            <p class="text-xs text-gray-500 mt-2">
                                En vous inscrivant, vous acceptez notre politique de confidentialité. Nous promettons de ne pas spammer votre boîte mail.
                            </p>
                        </form>
                    </div>
                    <div class="hidden md:block relative">
                        <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80" 
                             class="absolute inset-0 h-full w-full object-cover" alt="Newsletter Image">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection