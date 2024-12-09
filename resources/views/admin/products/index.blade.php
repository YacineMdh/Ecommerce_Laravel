@extends('layouts.admin')

@section('title', 'Gestion des produits')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Gestion des produits</h1>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 transition duration-300">
        <i class="fas fa-plus mr-2"></i>
        Ajouter un produit
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

<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
    <!-- Filtres et recherche -->
    <div class="p-4 border-b border-gray-200 bg-gray-50">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="relative flex-grow max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="searchInput" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-rose-500 focus:border-rose-500 sm:text-sm" placeholder="Rechercher un produit...">
            </div>
            
            <div class="flex flex-wrap gap-2">
                <select id="stockFilter" class="rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 text-sm">
                    <option value="">Tous les stocks</option>
                    <option value="in_stock">En stock</option>
                    <option value="low_stock">Stock faible</option>
                    <option value="out_of_stock">Rupture de stock</option>
                </select>
                
                <button type="button" id="resetFilters" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition duration-300">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Réinitialiser
                </button>
            </div>
        </div>
    </div>
    
    <!-- Tableau des produits -->
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
                            Produit <i class="fas fa-sort ml-1"></i>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer">
                            Prix <i class="fas fa-sort ml-1"></i>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer">
                            Stock <i class="fas fa-sort ml-1"></i>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Catégorie
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                    <tr class="hover:bg-gray-50 transition duration-300">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $product->getId() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0 rounded-md bg-gray-100 overflow-hidden">
                                    <img src="https://source.unsplash.com/random/400x400/?product,{{ $loop->index }}" class="h-full w-full object-cover" alt="{{ $product->getName() }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->getName() }}</div>
                                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($product->getDescription(), 60) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ number_format($product->getPrice(), 2) }} €</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->getStock() > 10)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $product->getStock() }} unités
                                </span>
                            @elseif($product->getStock() > 0)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ $product->getStock() }} unités
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Rupture de stock
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                {{ $product->getCategory()->getName() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('products.show', $product->getId()) }}" target="_blank" class="text-gray-500 hover:text-gray-700 transition duration-300" title="Voir sur le site">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product->getId()) }}" class="text-blue-600 hover:text-blue-900 transition duration-300" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->getId()) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')" class="text-red-600 hover:text-red-900 transition duration-300" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @if(count($products) == 0)
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-box-open text-gray-300 text-4xl mb-3"></i>
                                <p>Aucun produit trouvé</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if(isset($products) && is_object($products) && method_exists($products, 'links'))
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $products->links() }}
        </div>
    @endif
</div>

<!-- Statistiques des produits -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 rounded-md bg-rose-100 flex items-center justify-center text-rose-600">
                <i class="fas fa-box-open text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total des produits</h3>
                <span class="text-xl font-semibold text-gray-900">{{ count($products) }}</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 rounded-md bg-green-100 flex items-center justify-center text-green-600">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">En stock</h3>
                <span class="text-xl font-semibold text-gray-900">{{ count(array_filter($products, function($p) { return $p->getStock() > 0; })) }}</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 rounded-md bg-yellow-100 flex items-center justify-center text-yellow-600">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Stock faible</h3>
                <span class="text-xl font-semibold text-gray-900">{{ count(array_filter($products, function($p) { return $p->getStock() > 0 && $p->getStock() <= 5; })) }}</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12 rounded-md bg-red-100 flex items-center justify-center text-red-600">
                <i class="fas fa-times-circle text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Rupture de stock</h3>
                <span class="text-xl font-semibold text-gray-900">{{ count(array_filter($products, function($p) { return $p->getStock() == 0; })) }}</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Code JavaScript pour filtrer et trier les produits
        // (Placeholder - le vrai code serait ajouté dans un fichier JS séparé)
    });
</script>
@endpush
@endsection