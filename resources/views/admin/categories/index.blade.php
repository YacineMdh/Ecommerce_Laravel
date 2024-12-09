@extends('layouts.admin')

@section('title', 'Gestion des catégories')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Gestion des catégories</h1>
    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 transition duration-300">
        <i class="fas fa-plus mr-2"></i>
        Ajouter une catégorie
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

<!-- Grid des catégories -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    @foreach($categories as $category)
        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition duration-300">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ $category->getName() }}</h2>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $category->getDescription() }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        {{ count($category->getProducts()) }} produits
                    </span>
                </div>
                
                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('admin.categories.edit', $category->getId()) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-300">
                        <i class="fas fa-edit mr-1"></i>
                        Modifier
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category->getId()) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Tous les produits associés seront affectés.')" class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 hover:border-red-300 transition duration-300">
                            <i class="fas fa-trash mr-1"></i>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    
    <!-- Carte "Ajouter une catégorie" -->
    <div class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 hover:border-rose-500 transition duration-300">
        <a href="{{ route('admin.categories.create') }}" class="block h-full p-6">
            <div class="flex flex-col items-center justify-center h-full text-center">
                <div class="h-12 w-12 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 mb-3">
                    <i class="fas fa-plus"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Ajouter une catégorie</h3>
                <p class="text-sm text-gray-500">Créer une nouvelle catégorie pour vos produits</p>
            </div>
        </a>
    </div>
</div>

<!-- Tableau des catégories -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h2 class="text-lg font-medium text-gray-900">Liste des catégories</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produits</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($categories as $category)
                    <tr class="hover:bg-gray-50 transition duration-300">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->getId() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $category->getName() }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($category->getDescription(), 60) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ count($category->getProducts()) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.categories.edit', $category->getId()) }}" class="text-blue-600 hover:text-blue-900 transition duration-300" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->getId()) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')" class="text-red-600 hover:text-red-900 transition duration-300" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @if(empty($categories))
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-folder-open text-gray-300 text-4xl mb-3"></i>
                                <p>Aucune catégorie trouvée</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Aide et information -->
<div class="mt-6 bg-blue-50 rounded-xl shadow-sm overflow-hidden">
    <div class="p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-blue-900">Gestion des catégories</h3>
                <p class="mt-1 text-sm text-blue-700">
                    Les catégories vous permettent d'organiser vos produits pour une meilleure navigation et expérience utilisateur. 
                    Une structure de catégories bien pensée améliore le référencement et facilite les achats pour vos clients.
                </p>
                <div class="mt-3 text-sm">
                    <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">
                        En savoir plus sur l'organisation des catégories <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection