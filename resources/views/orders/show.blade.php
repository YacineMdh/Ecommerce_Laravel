@extends('layouts.app')

@section('title', 'Commande #' . $order->getId())

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
                    <a href="{{ route('orders.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                        Mes Commandes
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <span class="text-sm font-medium text-gray-500">Commande #{{ $order->getId() }}</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <div class="flex justify-between items-start mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Commande #{{ $order->getId() }}</h1>
        <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour aux commandes
        </a>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Détails de la commande et suivi -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Statut et suivi -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Statut de la commande</h2>
                </div>
                
                <div class="p-6">
                    <!-- Étapes de suivi -->
                    <div class="relative pb-8">
                        <div class="absolute top-0 bottom-0 left-4 w-0.5 bg-gray-200"></div>
                        
                        <!-- Date de la commande -->
                        <div class="relative flex items-start">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-green-500 text-white shrink-0">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-base font-medium text-gray-900">Commande confirmée</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $order->getCreatedAt()->format('d/m/Y à H:i') }}</p>
                                <p class="mt-1 text-sm text-gray-600">Votre commande a été reçue et confirmée.</p>
                            </div>
                        </div>
                        
                        <!-- Paiement -->
                        <div class="relative flex items-start mt-8">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full {{ in_array($order->getStatus(), ['pending', 'processing', 'shipped', 'delivered']) ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }} shrink-0">
                                @if(in_array($order->getStatus(), ['pending', 'processing', 'shipped', 'delivered']))
                                    <i class="fas fa-check text-sm"></i>
                                @else
                                    <i class="fas fa-credit-card text-sm"></i>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h3 class="text-base font-medium text-gray-900">Paiement {{ in_array($order->getStatus(), ['pending', 'processing', 'shipped', 'delivered']) ? 'accepté' : 'en attente' }}</h3>
                                @if(in_array($order->getStatus(), ['pending', 'processing', 'shipped', 'delivered']))
                                    <p class="mt-1 text-sm text-gray-500">{{ $order->getCreatedAt()->addMinutes(5)->format('d/m/Y à H:i') }}</p>
                                @endif
                                <p class="mt-1 text-sm text-gray-600">
                                    @if(in_array($order->getStatus(), ['pending', 'processing', 'shipped', 'delivered']))
                                        Votre paiement a été traité avec succès.
                                    @else
                                        Nous attendons la confirmation de votre paiement.
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Préparation -->
                        <div class="relative flex items-start mt-8">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full {{ in_array($order->getStatus(), ['processing', 'shipped', 'delivered']) ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }} shrink-0">
                                @if(in_array($order->getStatus(), ['processing', 'shipped', 'delivered']))
                                    <i class="fas fa-check text-sm"></i>
                                @else
                                    <i class="fas fa-box text-sm"></i>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h3 class="text-base font-medium text-gray-900">
                                    @if(in_array($order->getStatus(), ['processing', 'shipped', 'delivered']))
                                        Commande préparée
                                    @else
                                        En préparation
                                    @endif
                                </h3>
                                @if(in_array($order->getStatus(), ['processing', 'shipped', 'delivered']))
                                    <p class="mt-1 text-sm text-gray-500">{{ $order->getCreatedAt()->addHours(1)->format('d/m/Y à H:i') }}</p>
                                @endif
                                <p class="mt-1 text-sm text-gray-600">
                                    @if(in_array($order->getStatus(), ['processing', 'shipped', 'delivered']))
                                        Votre commande a été préparée avec soin.
                                    @else
                                        Votre commande est en cours de préparation.
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Expédition -->
                        <div class="relative flex items-start mt-8">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full {{ in_array($order->getStatus(), ['shipped', 'delivered']) ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }} shrink-0">
                                @if(in_array($order->getStatus(), ['shipped', 'delivered']))
                                    <i class="fas fa-check text-sm"></i>
                                @else
                                    <i class="fas fa-shipping-fast text-sm"></i>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h3 class="text-base font-medium text-gray-900">
                                    @if(in_array($order->getStatus(), ['shipped', 'delivered']))
                                        Commande expédiée
                                    @else
                                        En attente d'expédition
                                    @endif
                                </h3>
                                @if(in_array($order->getStatus(), ['shipped', 'delivered']))
                                    <p class="mt-1 text-sm text-gray-500">{{ $order->getCreatedAt()->addDays(1)->format('d/m/Y à H:i') }}</p>
                                @endif
                                <p class="mt-1 text-sm text-gray-600">
                                    @if(in_array($order->getStatus(), ['shipped', 'delivered']))
                                        Votre commande a été expédiée. Numéro de suivi: TRACK123456789
                                    @else
                                        Votre commande sera bientôt expédiée.
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Livraison -->
                        <div class="relative flex items-start mt-8">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full {{ $order->getStatus() == 'delivered' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }} shrink-0">
                                @if($order->getStatus() == 'delivered')
                                    <i class="fas fa-check text-sm"></i>
                                @else
                                    <i class="fas fa-home text-sm"></i>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h3 class="text-base font-medium text-gray-900">
                                    @if($order->getStatus() == 'delivered')
                                        Commande livrée
                                    @else
                                        Livraison prévue
                                    @endif
                                </h3>
                                @if($order->getStatus() == 'delivered')
                                    <p class="mt-1 text-sm text-gray-500">{{ $order->getCreatedAt()->addDays(3)->format('d/m/Y à H:i') }}</p>
                                @else
                                    <p class="mt-1 text-sm text-gray-500">Estimée pour le {{ $order->getCreatedAt()->addDays(3)->format('d/m/Y') }}</p>
                                @endif
                                <p class="mt-1 text-sm text-gray-600">
                                    @if($order->getStatus() == 'delivered')
                                        Votre commande a été livrée avec succès.
                                    @else
                                        Votre commande sera bientôt livrée à l'adresse indiquée.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Articles commandés -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Articles commandés</h2>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @foreach($order->getItems() as $item)
                        <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                            <div class="flex items-center">
                                <div class="h-16 w-16 flex-shrink-0 rounded-md overflow-hidden">
                                    <img src="https://source.unsplash.com/random/400x400/?product,{{ $loop->index }}" 
                                        alt="{{ $item->getProduct()->getName() }}" 
                                        class="h-full w-full object-cover">
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-base font-medium text-gray-900">{{ $item->getProduct()->getName() }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">Quantité: {{ $item->getQuantity() }}</p>
                                </div>
                            </div>
                            <div class="mt-4 sm:mt-0 text-right">
                                <p class="text-sm font-medium text-gray-500">Prix unitaire: {{ number_format($item->getPrice(), 2) }} €</p>
                                <p class="mt-1 text-base font-semibold text-gray-900">Total: {{ number_format($item->getTotal(), 2) }} €</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Récapitulatif et adresses -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Récapitulatif -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Récapitulatif</h2>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sous-total</span>
                        <span class="text-gray-900 font-medium">{{ number_format($order->getTotal() - 5.90, 2) }} €</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Livraison</span>
                        <span class="text-gray-900 font-medium">5,90 €</span>
                    </div>
                    @if($order->getDiscount() > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Réduction</span>
                            <span>-{{ number_format($order->getDiscount(), 2) }} €</span>
                        </div>
                    @endif
                    <div class="pt-3 border-t border-gray-200">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-gray-900">{{ number_format($order->getTotal(), 2) }} €</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Adresse de livraison -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Adresse de livraison</h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-900 font-medium">{{ auth()->user()->getName() }}</p>
                    <p class="mt-1 text-gray-600">{{ $order->getShippingAddress() }}</p>
                </div>
            </div>
            
            <!-- Adresse de facturation -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Adresse de facturation</h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-900 font-medium">{{ auth()->user()->getName() }}</p>
                    <p class="mt-1 text-gray-600">{{ $order->getBillingAddress() }}</p>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Actions</h2>
                </div>
                <div class="p-6 space-y-4">
                    <a href="#" class="block w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 text-center transition duration-300">
                        <i class="fas fa-download mr-2"></i> Télécharger la facture
                    </a>
                    
                    @if(!in_array($order->getStatus(), ['shipped', 'delivered', 'cancelled']))
                        <a href="#" class="block w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-center transition duration-300">
                            <i class="fas fa-times mr-2"></i> Annuler la commande
                        </a>
                    @endif
                    
                    <a href="#" class="block w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-center transition duration-300">
                        <i class="fas fa-question-circle mr-2"></i> Aide et support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection