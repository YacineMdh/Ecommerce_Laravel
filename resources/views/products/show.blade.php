@extends('layouts.app')

@section('title', $product->getName())

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
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Produits</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <a href="{{ route('products.index', ['category' => $product->getCategory()->getId()]) }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                        {{ $product->getCategory()->getName() }}
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <span class="text-sm font-medium text-gray-500 truncate max-w-[150px] md:max-w-xs">{{ $product->getName() }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Images -->
        <div>
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 mb-4">
                <div class="relative pt-[100%]"> <!-- 1:1 Aspect Ratio -->
                    <img src="https://source.unsplash.com/random/800x800/?product" 
                         class="absolute top-0 left-0 w-full h-full object-cover" 
                         alt="{{ $product->getName() }}">
                </div>
            </div>
            <div class="grid grid-cols-4 gap-2">
                <div class="bg-white rounded-lg overflow-hidden border-2 border-rose-500">
                    <img src="https://source.unsplash.com/random/200x200/?product" class="w-full h-24 object-cover" alt="Thumbnail 1">
                </div>
                <div class="bg-white rounded-lg overflow-hidden border hover:border-rose-500 transition duration-300">
                    <img src="https://source.unsplash.com/random/201x201/?product" class="w-full h-24 object-cover" alt="Thumbnail 2">
                </div>
                <div class="bg-white rounded-lg overflow-hidden border hover:border-rose-500 transition duration-300">
                    <img src="https://source.unsplash.com/random/202x202/?product" class="w-full h-24 object-cover" alt="Thumbnail 3">
                </div>
                <div class="bg-white rounded-lg overflow-hidden border hover:border-rose-500 transition duration-300">
                    <img src="https://source.unsplash.com/random/203x203/?product" class="w-full h-24 object-cover" alt="Thumbnail 4">
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div>
            <div class="mb-6">
                <span class="text-rose-600 font-medium">{{ $product->getCategory()->getName() }}</span>
                <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $product->getName() }}</h1>
                <div class="flex items-center mt-4">
                    <div class="flex text-amber-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="ml-2 text-gray-600 text-sm">4.8 (24 avis)</span>
                </div>
            </div>

            <div class="border-t border-b py-6 my-6">
                <div class="flex items-baseline mb-4">
                    <span class="text-3xl font-bold text-gray-900">{{ number_format($product->getPrice(), 2) }} €</span>
                    @if(rand(0, 1) == 1) <!-- Simulate a discount price -->
                    <span class="ml-3 text-lg text-gray-500 line-through">{{ number_format($product->getPrice() * 1.2, 2) }} €</span>
                    <span class="ml-3 px-2 py-1 text-xs font-semibold text-white bg-rose-600 rounded-full">-20%</span>
                    @endif
                </div>

                <div class="mb-6">
                    <div class="flex items-center">
                        <span class="mr-2 text-gray-700">Disponibilité:</span>
                        @if($product->getStock() > 10)
                            <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">En stock</span>
                        @elseif($product->getStock() > 0)
                            <span class="px-2 py-1 text-xs font-semibold text-amber-800 bg-amber-100 rounded-full">Stock limité ({{ $product->getStock() }} restants)</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Rupture de stock</span>
                        @endif
                    </div>
                </div>

                @if($product->getStock() > 0)
                    <form action="{{ route('cart.add', $product->getId()) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="quantity" class="block text-gray-700 font-medium mb-2">Quantité</label>
                            <div class="flex">
                                <select name="quantity" id="quantity" class="w-full md:w-1/3 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                                    @for($i = 1; $i <= min($product->getStock(), 10); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit" class="flex-1 bg-rose-600 text-white py-3 px-6 rounded-full font-medium hover:bg-rose-700 transition duration-300 flex items-center justify-center">
                                <i class="fas fa-shopping-bag mr-2"></i>
                                Ajouter au panier
                            </button>
                            <button type="button" class="flex-1 bg-black text-white py-3 px-6 rounded-full font-medium hover:bg-gray-800 transition duration-300 flex items-center justify-center">
                                <i class="fas fa-bolt mr-2"></i>
                                Acheter maintenant
                            </button>
                        </div>
                    </form>
                @else
                    <div class="mb-6">
                        <button disabled class="w-full bg-gray-300 text-gray-500 py-3 px-6 rounded-full font-medium cursor-not-allowed">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            Temporairement indisponible
                        </button>
                        <p class="text-gray-600 text-sm mt-2">Ce produit est actuellement en rupture de stock. Veuillez revenir ultérieurement.</p>
                    </div>
                @endif
            </div>

            <!-- Features -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center">
                        <i class="fas fa-shipping-fast text-rose-600"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900">Livraison gratuite</h3>
                        <p class="text-xs text-gray-500">Pour les commandes > 50€</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center">
                        <i class="fas fa-undo text-rose-600"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900">Retours faciles</h3>
                        <p class="text-xs text-gray-500">30 jours pour changer d'avis</p>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Description</h2>
                <div class="prose prose-rose text-gray-600">
                    <p>{{ $product->getDescription() }}</p>
                    
                    <!-- Extended description placeholder if the real one is too short -->
                    @if(strlen($product->getDescription()) < 100)
                    <div class="mt-4">
                        <p>Ce produit premium a été sélectionné avec soin pour répondre aux attentes de notre clientèle exigeante. Fabriqué avec des matériaux de haute qualité, il vous garantit une durabilité optimale et une expérience utilisateur incomparable.</p>
                        <p class="mt-2">Nos experts ont travaillé en collaboration avec les meilleurs artisans pour vous proposer un produit alliant esthétique raffinée et fonctionnalité avancée. Chaque détail a été pensé pour votre satisfaction.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Accordion for additional information -->
            <div class="border-t pt-6" x-data="{ activeTab: 'details' }">
                <div class="border-b">
                    <button @click="activeTab = 'details'" class="flex justify-between items-center w-full py-3 text-left" :class="{'text-rose-600 font-medium': activeTab === 'details', 'text-gray-700': activeTab !== 'details'}">
                        <span>Détails du produit</span>
                        <i class="fas" :class="activeTab === 'details' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                    <div x-show="activeTab === 'details'" class="py-3 text-gray-600">
                        <ul class="space-y-2">
                            <li class="flex">
                                <span class="w-1/3 font-medium">Référence:</span>
                                <span>PRD-{{ $product->getId() }}</span>
                            </li>
                            <li class="flex">
                                <span class="w-1/3 font-medium">Catégorie:</span>
                                <span>{{ $product->getCategory()->getName() }}</span>
                            </li>
                            <li class="flex">
                                <span class="w-1/3 font-medium">Disponibilité:</span>
                                <span>{{ $product->getStock() > 0 ? 'En stock' : 'Rupture de stock' }}</span>
                            </li>
                            <li class="flex">
                                <span class="w-1/3 font-medium">Livraison:</span>
                                <span>2-4 jours ouvrés</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-b">
                    <button @click="activeTab = 'shipping'" class="flex justify-between items-center w-full py-3 text-left" :class="{'text-rose-600 font-medium': activeTab === 'shipping', 'text-gray-700': activeTab !== 'shipping'}">
                        <span>Livraison et retours</span>
                        <i class="fas" :class="activeTab === 'shipping' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                    <div x-show="activeTab === 'shipping'" class="py-3 text-gray-600">
                        <p>Livraison standard : 2-4 jours ouvrés (gratuite à partir de 50€)</p>
                        <p class="mt-2">Livraison express : 24h (supplément de 9,90€)</p>
                        <p class="mt-2">Retours : gratuits sous 30 jours dans l'emballage d'origine</p>
                    </div>
                </div>
                
                <div>
                    <button @click="activeTab = 'reviews'" class="flex justify-between items-center w-full py-3 text-left" :class="{'text-rose-600 font-medium': activeTab === 'reviews', 'text-gray-700': activeTab !== 'reviews'}">
                        <span>Avis clients</span>
                        <i class="fas" :class="activeTab === 'reviews' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                    <div x-show="activeTab === 'reviews'" class="py-3 text-gray-600">
                        <div class="flex items-center mb-4">
                            <div class="flex text-amber-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="ml-2 text-gray-600">4.8 sur 5 (24 avis)</span>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between mb-2">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 font-semibold">M</div>
                                        <span class="ml-2 font-medium">Marie D.</span>
                                    </div>
                                    <div class="flex text-amber-400 text-sm">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <p class="text-sm">Excellent produit, très satisfaite de mon achat. La qualité est au rendez-vous et la livraison a été rapide.</p>
                                <p class="text-xs text-gray-500 mt-1">Publié le 12 mars 2025</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between mb-2">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 font-semibold">T</div>
                                        <span class="ml-2 font-medium">Thomas L.</span>
                                    </div>
                                    <div class="flex text-amber-400 text-sm">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                                <p class="text-sm">Bon rapport qualité/prix. Répond parfaitement à mes attentes. Je recommande ce produit !</p>
                                <p class="text-xs text-gray-500 mt-1">Publié le 5 février 2025</p>
                            </div>
                        </div>
                        
                        <button class="mt-4 text-rose-600 font-medium flex items-center">
                            Voir tous les avis
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Similar Products -->
    @if(isset($similarProducts) && count($similarProducts) > 0)
        <section class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Vous aimerez aussi</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($similarProducts as $similarProduct)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition duration-300">
                        <a href="{{ route('products.show', $similarProduct->getId()) }}" class="block overflow-hidden">
                            <div class="relative h-64">
                                <img src="https://source.unsplash.com/random/400x400/?product,{{ $loop->index }}" 
                                    alt="{{ $similarProduct->getName() }}" 
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            </div>
                        </a>
                        
                        <div class="p-4">
                            <a href="{{ route('products.show', $similarProduct->getId()) }}" class="hover:text-rose-600 transition duration-300">
                                <h3 class="text-gray-900 font-medium mb-2">{{ $similarProduct->getName() }}</h3>
                            </a>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-rose-600">{{ number_format($similarProduct->getPrice(), 2) }} €</span>
                                <form action="{{ route('cart.add', $similarProduct->getId()) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="text-rose-600 hover:text-rose-700 transition duration-300" {{ $similarProduct->getStock() == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-bag"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Product image gallery functionality could be added here
</script>
@endpush