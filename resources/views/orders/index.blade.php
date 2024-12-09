@extends('layouts.app')

@section('title', 'Mes Commandes')

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
                    <span class="text-sm font-medium text-gray-500">Mes Commandes</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Mes Commandes</h1>
    </div>

    @if(count($orders) > 0)
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Commande</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition duration-300">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $order->getId() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $order->getCreatedAt()->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $order->getCreatedAt()->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ number_format($order->getTotal(), 2) }} €</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ $order->getStatus() }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('orders.show', $order->getId()) }}" class="text-rose-600 hover:text-rose-900 transition duration-300">
                                        Voir détails <i class="fas fa-chevron-right ml-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm p-12 text-center max-w-2xl mx-auto">
            <div class="h-24 w-24 mx-auto mb-6 flex items-center justify-center rounded-full bg-rose-100">
                <i class="fas fa-shopping-bag text-rose-600 text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Aucune commande</h2>
            <p class="text-gray-600 mb-8">Vous n'avez pas encore passé de commande.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-rose-600 hover:bg-rose-700 transition duration-300">
                <i class="fas fa-shopping-bag mr-2"></i>
                Découvrir nos produits
            </a>
        </div>
    @endif
    
    <!-- FAQ Section -->
    @if(count($orders) > 0)
        <div class="mt-12 bg-white rounded-xl shadow-sm overflow-hidden" x-data="{activeTab: null}">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Questions fréquentes</h2>
            </div>
            
            <div class="divide-y divide-gray-200">
                <div class="py-4 px-6">
                    <button @click="activeTab = activeTab === 1 ? null : 1" class="flex justify-between items-center w-full text-left focus:outline-none">
                        <h3 class="text-base font-medium text-gray-900">Comment suivre ma commande ?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i class="fas" :class="activeTab === 1 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </span>
                    </button>
                    <div x-show="activeTab === 1" class="mt-3 text-gray-600 text-sm">
                        <p>Vous recevrez un email avec les informations de suivi dès que votre commande sera expédiée. Vous pourrez également consulter le statut de votre commande à tout moment dans votre espace client.</p>
                    </div>
                </div>
                
                <div class="py-4 px-6">
                    <button @click="activeTab = activeTab === 2 ? null : 2" class="flex justify-between items-center w-full text-left focus:outline-none">
                        <h3 class="text-base font-medium text-gray-900">Comment annuler une commande ?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i class="fas" :class="activeTab === 2 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </span>
                    </button>
                    <div x-show="activeTab === 2" class="mt-3 text-gray-600 text-sm">
                        <p>Vous pouvez annuler votre commande uniquement si elle n'a pas encore été expédiée. Pour ce faire, contactez notre service client par téléphone ou par email en précisant le numéro de votre commande.</p>
                    </div>
                </div>
                
                <div class="py-4 px-6">
                    <button @click="activeTab = activeTab === 3 ? null : 3" class="flex justify-between items-center w-full text-left focus:outline-none">
                        <h3 class="text-base font-medium text-gray-900">Comment effectuer un retour ?</h3>
                        <span class="ml-6 flex-shrink-0">
                            <i class="fas" :class="activeTab === 3 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </span>
                    </button>
                    <div x-show="activeTab === 3" class="mt-3 text-gray-600 text-sm">
                        <p>Vous disposez de 30 jours après réception de votre commande pour effectuer un retour. Rendez-vous dans la page détail de votre commande et cliquez sur "Demander un retour". Suivez ensuite les instructions pour imprimer votre étiquette de retour.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection