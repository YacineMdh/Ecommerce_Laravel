@extends('layouts.app')

@section('title', 'Paiement')

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
                    <a href="{{ route('cart.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                        Mon Panier
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <span class="text-sm font-medium text-gray-500">Paiement</span>
                </div>
            </li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-gray-900 mb-8">Finaliser la commande</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Formulaire de commande -->
        <div class="lg:col-span-2">
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                
                <!-- Étapes -->
                <div class="mb-8">
                    <div class="flex justify-between items-center text-sm">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-rose-600 flex items-center justify-center text-white font-bold">1</div>
                            <span class="mt-2 text-rose-600 font-medium">Adresses</span>
                        </div>
                        <div class="h-px bg-rose-600 flex-grow mx-2"></div>
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-bold">2</div>
                            <span class="mt-2 text-gray-500">Paiement</span>
                        </div>
                        <div class="h-px bg-gray-200 flex-grow mx-2"></div>
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-bold">3</div>
                            <span class="mt-2 text-gray-500">Confirmation</span>
                        </div>
                    </div>
                </div>

                <!-- Adresse de livraison -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Adresse de livraison</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                                <input type="text" name="shipping_name" id="shipping_name" 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                       value="{{ old('shipping_name') }}" required>
                                @error('shipping_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                <input type="tel" name="shipping_phone" id="shipping_phone" 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                       value="{{ old('shipping_phone') }}" required>
                                @error('shipping_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                                <textarea name="shipping_address" id="shipping_address" rows="3"
                                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                          required>{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                                <input type="text" name="shipping_city" id="shipping_city" 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                       value="{{ old('shipping_city') }}" required>
                                @error('shipping_city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Code postal</label>
                                <input type="text" name="shipping_postal_code" id="shipping_postal_code" 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                       value="{{ old('shipping_postal_code') }}" required>
                                @error('shipping_postal_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Adresse de facturation -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6" x-data="{ sameAddress: true }">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Adresse de facturation</h2>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" x-model="sameAddress" class="rounded border-gray-300 text-rose-600 shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-500 focus:ring-opacity-50">
                                <span class="ml-2 text-gray-700">Identique à l'adresse de livraison</span>
                            </label>
                        </div>
                        
                        <div x-show="!sameAddress" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="billing_name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                                <input type="text" name="billing_name" id="billing_name" 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                       value="{{ old('billing_name') }}">
                                @error('billing_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="billing_phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                <input type="tel" name="billing_phone" id="billing_phone" 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                       value="{{ old('billing_phone') }}">
                                @error('billing_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                                <textarea name="billing_address" id="billing_address" rows="3"
                                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">{{ old('billing_address') }}</textarea>
                                @error('billing_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                                <input type="text" name="billing_city" id="billing_city" 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                       value="{{ old('billing_city') }}">
                                @error('billing_city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="billing_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Code postal</label>
                                <input type="text" name="billing_postal_code" id="billing_postal_code" 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                       value="{{ old('billing_postal_code') }}">
                                @error('billing_postal_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Méthode de paiement -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Méthode de paiement</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <label class="block p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-rose-500 transition duration-300">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="card" class="h-4 w-4 text-rose-600 focus:ring-rose-500" checked>
                                    <span class="ml-3 flex items-center">
                                        <i class="fas fa-credit-card text-gray-400 mr-2"></i>
                                        <span class="font-medium text-gray-700">Carte bancaire</span>
                                    </span>
                                    <div class="ml-auto flex space-x-2">
                                        <img src="https://cdn.shopify.com/s/files/1/0597/1151/0305/files/visa-icon.svg" alt="Visa" class="h-6">
                                        <img src="https://cdn.shopify.com/s/files/1/0597/1151/0305/files/mastercard-icon.svg" alt="Mastercard" class="h-6">
                                        <img src="https://cdn.shopify.com/s/files/1/0597/1151/0305/files/amex-icon.svg" alt="American Express" class="h-6">
                                    </div>
                                </div>
                                
                                <div class="mt-4 ml-7 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Numéro de carte</label>
                                        <input type="text" placeholder="1234 5678 9012 3456" class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Titulaire de la carte</label>
                                        <input type="text" placeholder="John Doe" class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Date d'expiration</label>
                                        <input type="text" placeholder="MM/AA" class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                        <input type="text" placeholder="123" class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                                    </div>
                                </div>
                            </label>
                            
                            <label class="block p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-rose-500 transition duration-300">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="paypal" class="h-4 w-4 text-rose-600 focus:ring-rose-500">
                                    <span class="ml-3 flex items-center">
                                        <i class="fab fa-paypal text-blue-600 mr-2"></i>
                                        <span class="font-medium text-gray-700">PayPal</span>
                                    </span>
                                    <span class="ml-auto">
                                        <img src="https://cdn.shopify.com/s/files/1/0597/1151/0305/files/paypal-icon.svg" alt="PayPal" class="h-6">
                                    </span>
                                </div>
                                <div class="mt-2 ml-7 text-gray-500 text-sm">
                                    Vous serez redirigé vers PayPal pour effectuer le paiement sécurisé.
                                </div>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('cart.index') }}" class="inline-flex items-center text-gray-700 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour au panier
                    </a>
                    
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition duration-300">
                        Confirmer la commande
                        <i class="fas fa-check ml-2"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Récapitulatif -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Récapitulatif de commande</h2>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4 divide-y divide-gray-200">
                        @foreach($cart->getItems() as $item)
                            <div class="flex justify-between items-center pt-4 first:pt-0">
                                <div class="flex items-center">
                                    <div class="h-16 w-16 flex-shrink-0 rounded-md overflow-hidden bg-gray-100">
                                        <img src="https://source.unsplash.com/random/400x400/?product,{{ $loop->index }}" 
                                            alt="{{ $item->getProduct()->getName() }}" 
                                            class="h-full w-full object-cover">
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $item->getProduct()->getName() }}</p>
                                        <p class="text-xs text-gray-500">Quantité: {{ $item->getQuantity() }}</p>
                                    </div>
                                </div>
                                <p class="text-sm font-medium text-gray-900">{{ number_format($item->getPrice() * $item->getQuantity(), 2) }} €</p>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="border-t border-gray-200 mt-6 pt-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Sous-total</span>
                            <span class="text-gray-900 font-medium">{{ number_format($cart->getTotal(), 2) }} €</span>
                        </div>
                        
                        @if(session()->has('coupon'))
                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-green-600">Réduction ({{ session('coupon')->getCode() }})</span>
                                <span class="text-green-600">-{{ number_format(session('coupon')->getDiscount(), 2) }} €</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between text-sm mt-2">
                            <span class="text-gray-600">Frais de livraison</span>
                            <span class="text-gray-900 font-medium">
                                @if($cart->getTotal() >= 50)
                                    Gratuit
                                @else
                                    5,90 €
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
                            <span class="text-gray-900 font-semibold">Total</span>
                            <span class="text-2xl font-bold text-gray-900">
                                @php
                                    $total = $cart->getTotal();
                                    if(session()->has('coupon')) {
                                        $total -= session('coupon')->getDiscount();
                                    }
                                    if($total < 50) {
                                        $total += 5.90;
                                    }
                                    echo number_format($total, 2);
                                @endphp €
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Informations de sécurité et livraison -->
            <div class="mt-8 bg-white rounded-xl shadow-sm p-6 space-y-4">
                <div class="flex items-start">
                    <i class="fas fa-shield-alt text-green-500 mt-1 mr-3"></i>
                    <div>
                        <h3 class="text-gray-900 font-medium">Paiement sécurisé</h3>
                        <p class="text-gray-600 text-sm mt-1">Toutes vos données de paiement sont cryptées et sécurisées.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <i class="fas fa-truck text-green-500 mt-1 mr-3"></i>
                    <div>
                        <h3 class="text-gray-900 font-medium">Livraison rapide</h3>
                        <p class="text-gray-600 text-sm mt-1">Expédition sous 24h pour toutes les commandes passées avant 15h.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <i class="fas fa-headset text-green-500 mt-1 mr-3"></i>
                    <div>
                        <h3 class="text-gray-900 font-medium">Service client</h3>
                        <p class="text-gray-600 text-sm mt-1">Notre équipe est à votre disposition 7j/7 pour répondre à vos questions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection