@extends('layouts.admin')

@section('title', 'Détails de l\'utilisateur')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Détails de l'utilisateur</h1>
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-300">
        <i class="fas fa-arrow-left mr-2"></i>
        Retour à la liste
    </a>
</div>

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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informations utilisateur -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Profil utilisateur -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Profil</h2>
            </div>
            <div class="p-6">
                <div class="flex flex-col items-center">
                    <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-4xl font-semibold mb-4">
                        {{ substr($user->getName(), 0, 1) }}
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">{{ $user->getName() }}</h3>
                    <p class="text-gray-500 mt-1">{{ $user->getEmail() }}</p>
                    
                    <div class="mt-3">
                        <span class="{{ $user->isAdmin() ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }} px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full">
                            {{ $user->isAdmin() ? 'Administrateur' : 'Client' }}
                        </span>
                    </div>
                </div>
                
                <div class="mt-6 border-t border-gray-200 pt-4">
                    <dl class="divide-y divide-gray-200">
                        <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Compte créé le</dt>
                            <dd class="text-sm text-gray-900">{{ $user->getCreatedAt()->format('d/m/Y à H:i') }}</dd>
                        </div>
                        <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Dernière connexion</dt>
                            <dd class="text-sm text-gray-900">{{ now()->subDays(rand(0, 30))->format('d/m/Y à H:i') }}</dd>
                        </div>
                        <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Statut</dt>
                            <dd class="text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Actif
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Actions</h2>
            </div>
            <div class="p-6 space-y-3">
                <form action="{{ route('admin.users.toggle-admin', $user->getId()) }}" method="POST" class="w-full">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                        <i class="fas {{ $user->isAdmin() ? 'fa-user' : 'fa-user-shield' }} mr-2"></i>
                        {{ $user->isAdmin() ? 'Rétrograder au rôle Client' : 'Promouvoir au rôle Administrateur' }}
                    </button>
                </form>
                
                <a href="#" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    <i class="fas fa-envelope mr-2"></i>
                    Envoyer un email
                </a>
                
                <a href="#" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    <i class="fas fa-key mr-2"></i>
                    Réinitialiser le mot de passe
                </a>
                
                @if(auth()->id() != $user->getId())
                    <button type="button" onclick="return confirm('Êtes-vous sûr de vouloir bloquer cet utilisateur ?')" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 hover:border-red-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300">
                        <i class="fas fa-ban mr-2"></i>
                        Bloquer l'utilisateur
                    </button>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Commandes et activité -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Commandes récentes -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Commandes récentes</h2>
            </div>
            
            @if(count($user->getOrders()) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commande</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($user->getOrders() as $order)
                                <tr class="hover:bg-gray-50 transition duration-300">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#{{ $order->getId() }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $order->getCreatedAt()->format('d/m/Y') }}</div>
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
                                        <a href="{{ route('admin.orders.show', $order->getId()) }}" class="text-blue-600 hover:text-blue-900 transition duration-300">
                                            Voir
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="text-sm text-right">
                        <a href="{{ route('admin.orders.index') }}?user={{ $user->getId() }}" class="font-medium text-rose-600 hover:text-rose-500 transition duration-300">
                            Voir toutes les commandes <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @else
                <div class="p-6 text-center">
                    <div class="py-8">
                        <i class="fas fa-shopping-cart text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-500">Cet utilisateur n'a pas encore passé de commande.</p>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Statistiques d'activité -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Statistiques</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-gray-900 mb-2">{{ count($user->getOrders()) }}</div>
                        <p class="text-gray-500 text-sm">Total commandes</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-gray-900 mb-2">{{ number_format(array_sum(array_map(function($o) { return $o->getTotal(); }, $user->getOrders())), 2) }} €</div>
                        <p class="text-gray-500 text-sm">Montant total dépensé</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-gray-900 mb-2">{{ count($user->getOrders()) > 0 ? number_format(array_sum(array_map(function($o) { return $o->getTotal(); }, $user->getOrders())) / count($user->getOrders()), 2) : '0.00' }} €</div>
                        <p class="text-gray-500 text-sm">Panier moyen</p>
                    </div>
                </div>
                
                <!-- Graphique d'activité factice -->
                <div class="mt-6 h-64 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <img src="https://cdn.pixabay.com/photo/2018/05/07/10/48/infographic-3380276_960_720.png" alt="Activity Chart" class="h-full max-w-full object-contain opacity-40">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <p class="text-gray-500">Historique d'activité de l'utilisateur</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Notes et commentaires -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Notes administratives</h2>
            </div>
            <div class="p-6">
                <form>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Ajouter une note</label>
                        <textarea id="notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500" placeholder="Ajoutez des notes ou commentaires sur cet utilisateur..."></textarea>
                    </div>
                    <div class="mt-3 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition duration-300">
                            Enregistrer
                        </button>
                    </div>
                </form>
                
                <div class="mt-6">
                    <div class="border-t border-gray-200 pt-4">
                        <div class="text-sm text-gray-500 italic">
                            Aucune note disponible pour cet utilisateur.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection