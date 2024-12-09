@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Gestion des utilisateurs</h1>
    <div class="flex space-x-3">
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-300">
                <i class="fas fa-filter mr-2"></i>
                Filtrer
                <i class="fas fa-chevron-down ml-2"></i>
            </button>
            <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                <div class="py-1" role="menu" aria-orientation="vertical">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-300" role="menuitem">Tous les utilisateurs</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-300" role="menuitem">Administrateurs</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-300" role="menuitem">Clients</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-300" role="menuitem">Nouveaux utilisateurs</a>
                </div>
            </div>
        </div>
        
        <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 transition duration-300">
            <i class="fas fa-download mr-2"></i>
            Exporter
        </a>
    </div>
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

<!-- Statistiques des utilisateurs -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 rounded-md bg-rose-100 flex items-center justify-center text-rose-600">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total utilisateurs</h3>
                <span class="text-xl font-semibold text-gray-900">{{ count($users) }}</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 rounded-md bg-purple-100 flex items-center justify-center text-purple-600">
                <i class="fas fa-user-shield text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Administrateurs</h3>
                <span class="text-xl font-semibold text-gray-900">{{ count(array_filter($users, function($u) { return $u->isAdmin(); })) }}</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 rounded-md bg-blue-100 flex items-center justify-center text-blue-600">
                <i class="fas fa-user text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Clients</h3>
                <span class="text-xl font-semibold text-gray-900">{{ count(array_filter($users, function($u) { return !$u->isAdmin(); })) }}</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 rounded-md bg-green-100 flex items-center justify-center text-green-600">
                <i class="fas fa-user-plus text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Nouveaux (30j)</h3>
                <span class="text-xl font-semibold text-gray-900">{{ count(array_filter($users, function($u) { 
                    return $u->getCreatedAt() >= now()->subDays(30); 
                })) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Recherche et tri -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
    <div class="p-4 border-b border-gray-200 bg-gray-50">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="relative flex-grow max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="searchInput" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-rose-500 focus:border-rose-500 sm:text-sm" placeholder="Rechercher un utilisateur...">
            </div>
        </div>
    </div>
    
    <!-- Tableau des utilisateurs -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer">
                            ID <i class="fas fa-sort ml-1"></i>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer">
                            Utilisateur <i class="fas fa-sort ml-1"></i>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer">
                            Email <i class="fas fa-sort ml-1"></i>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer">
                            Date d'inscription <i class="fas fa-sort ml-1"></i>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Rôle
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition duration-300">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->getId() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold">
                                        {{ substr($user->getName(), 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->getName() }}</div>
                                    <div class="text-xs text-gray-500">Utilisateur #{{ $user->getId() }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->getEmail() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->getCreatedAt()->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.users.toggle-admin', $user->getId()) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="{{ $user->isAdmin() ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }} px-2 inline-flex text-xs leading-5 font-semibold rounded-full hover:bg-opacity-75 transition duration-300">
                                    {{ $user->isAdmin() ? 'Administrateur' : 'Client' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.users.show', $user->getId()) }}" class="text-blue-600 hover:text-blue-900 transition duration-300" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="text-green-600 hover:text-green-900 transition duration-300" title="Envoyer un email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                @if(auth()->id() != $user->getId())
                                    <form action="#" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')" class="text-red-600 hover:text-red-900 transition duration-300" title="Supprimer">
                                            <i class="fas fa-user-slash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach

                @if(count($users) == 0)
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-users-slash text-gray-300 text-4xl mb-3"></i>
                                <p>Aucun utilisateur trouvé</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if(isset($users) && is_object($users) && method_exists($users, 'links'))
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- Aide et information -->
<div class="bg-blue-50 rounded-xl shadow-sm overflow-hidden">
    <div class="p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-blue-900">Gestion des rôles et permissions</h3>
                <p class="mt-1 text-sm text-blue-700">
                    Les administrateurs ont accès à toutes les fonctionnalités du back-office, y compris la gestion des produits, catégories, commandes et utilisateurs. 
                    Soyez prudent lorsque vous accordez le statut d'administrateur à un utilisateur.
                </p>
                <div class="mt-3 text-sm">
                    <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">
                        Consulter la politique de sécurité <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Code JavaScript pour filtrer et trier les utilisateurs
        // (Placeholder - le vrai code serait ajouté dans un fichier JS séparé)
    });
</script>
@endpush
@endsection