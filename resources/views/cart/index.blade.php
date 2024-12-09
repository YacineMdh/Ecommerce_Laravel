@extends('layouts.app')

@section('title', 'Mon Panier')

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
                    <span class="text-sm font-medium text-gray-500">Mon Panier</span>
                </div>
            </li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-gray-900 mb-8">Mon Panier</h1>

    @if($cart && count($cart->getItems()) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Liste des produits -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cart->getItems() as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-16 w-16 flex-shrink-0 rounded-md overflow-hidden">
                                                    <img src="https://source.unsplash.com/random/400x400/?product,{{ $loop->index }}" 
                                                        alt="{{ $item->getProduct()->getName() }}" 
                                                        class="h-full w-full object-cover">
                                                </div>
                                                <div class="ml-4">
                                                    <a href="{{ route('products.show', $item->getProduct()->getId()) }}" class="text-gray-900 font-medium hover:text-rose-600 transition duration-300">
                                                        {{ $item->getProduct()->getName() }}
                                                    </a>
                                                    <div class="text-gray-500 text-sm">
                                                        {{ $item->getProduct()->getCategory()->getName() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-medium">{{ number_format($item->getPrice(), 2) }} €</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('cart.update', $item->getId()) }}" method="POST" class="flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <select name="quantity" 
                                                        class="block w-20 rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 text-sm"
                                                        onchange="this.form.submit()">
                                                    @for($i = 1; $i <= min($item->getProduct()->getStock(), 10); $i++)
                                                        <option value="{{ $i }}" {{ $item->getQuantity() == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-medium">{{ number_format($item->getPrice() * $item->getQuantity(), 2) }} €</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <form action="{{ route('cart.remove', $item->getId()) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-800 transition duration-300">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-6 flex flex-col sm:flex-row justify-between">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 mb-3 sm:mb-0 transition duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Continuer mes achats
                    </a>
                    
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center px-5 py-3 border border-transparent rounded-md text-white bg-gray-600 hover:bg-gray-700 transition duration-300">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Vider le panier
                        </button>
                    </form>
                </div>
            </div>

            <!-- Récapitulatif -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Récapitulatif</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sous-total</span>
                                <span class="text-gray-900 font-medium">{{ number_format($cart->getTotal(), 2) }} €</span>
                            </div>
                            
                            <div class="pt-2">
                                <div class="text-gray-700 font-medium mb-2">Code promo</div>
                                <form action="{{ route('cart.apply-coupon') }}" method="POST">
                                    @csrf
                                    <div class="flex">
                                        <input type="text" name="code" placeholder="Entrer le code" 
                                               class="flex-grow rounded-l-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 text-sm">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-r-md text-white bg-rose-600 hover:bg-rose-700 transition duration-300">
                                            Appliquer
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            @if(session()->has('coupon'))
                                <div class="flex justify-between text-green-600">
                                    <span>Réduction ({{ session('coupon')->getCode() }})</span>
                                    <span>-{{ number_format(session('coupon')->getDiscount(), 2) }} €</span>
                                </div>
                                <form action="{{ route('cart.remove-coupon') }}" method="POST" class="text-right">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-500 hover:text-gray-700 text-sm">
                                        <i class="fas fa-times mr-1"></i> Retirer
                                    </button>
                                </form>
                            @endif
                            
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-900 font-semibold">Total</span>
                                    <span class="text-2xl font-bold text-gray-900">
                                        {{ session()->has('coupon') 
                                            ? number_format($cart->getTotal() - session('coupon')->getDiscount(), 2)
                                            : number_format($cart->getTotal(), 2) }} €
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('checkout.index') }}" class="block w-full px-5 py-3 text-center font-medium text-white bg-rose-600 rounded-md hover:bg-rose-700 transition duration-300">
                                Procéder au paiement
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Secure checkout info -->
                <div class="mt-8 bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-gray-900 font-medium mb-4">Paiements sécurisés</h3>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <img src="https://cdn.shopify.com/s/files/1/0597/1151/0305/files/visa-icon.svg" alt="Visa" class="h-6">
                        <img src="https://cdn.shopify.com/s/files/1/0597/1151/0305/files/mastercard-icon.svg" alt="Mastercard" class="h-6">
                        <img src="https://cdn.shopify.com/s/files/1/0597/1151/0305/files/amex-icon.svg" alt="American Express" class="h-6">
                        <img src="https://cdn.shopify.com/s/files/1/0597/1151/0305/files/paypal-icon.svg" alt="PayPal" class="h-6">
                    </div>
                    
                    <div class="text-gray-600 text-sm space-y-2">
                        <div class="flex items-start">
                            <i class="fas fa-lock text-green-500 mt-1 mr-2"></i>
                            <p>Vos informations de paiement sont sécurisées avec un cryptage SSL.</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-truck text-green-500 mt-1 mr-2"></i>
                            <p>Livraison gratuite pour les commandes supérieures à 50 €.</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-undo text-green-500 mt-1 mr-2"></i>
                            <p>Retours gratuits sous 30 jours.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm p-12 text-center max-w-2xl mx-auto">
            <div class="h-24 w-24 mx-auto mb-6 flex items-center justify-center rounded-full bg-rose-100">
                <i class="fas fa-shopping-cart text-rose-600 text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Votre panier est vide</h2>
            <p class="text-gray-600 mb-8">Vous n'avez pas encore ajouté de produits à votre panier.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-rose-600 hover:bg-rose-700 transition duration-300">
                <i class="fas fa-shopping-bag mr-2"></i>
                Découvrir nos produits
            </a>
        </div>
    @endif
</div>
@endsection