@extends('layouts.admin')

@section('title', 'Créer un produit')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Créer un nouveau produit</h1>
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-300">
        <i class="fas fa-arrow-left mr-2"></i>
        Retour à la liste
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
    <div class="p-6">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom du produit -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom du produit</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 @error('name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Prix -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Prix (€)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">€</span>
                        </div>
                        <input type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price') }}" required
                               class="pl-7 w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 @error('price') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    </div>
                    @error('price')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Quantité en stock</label>
                    <input type="number" min="0" id="stock" name="stock" value="{{ old('stock') }}" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 @error('stock') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('stock')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Catégorie -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                    <select id="category_id" name="category_id" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 @error('category_id') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->getId() }}" {{ old('category_id') == $category->getId() ? 'selected' : '' }}>
                                {{ $category->getName() }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="4" required
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 @error('description') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Image -->
            <div x-data="{ fileName: '' }">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image du produit</label>
                <div class="mt-1 flex items-center">
                    <div class="w-full">
                        <label class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 cursor-pointer transition duration-300">
                            <span x-text="fileName || 'Choisir un fichier'"></span>
                            <input type="file" id="image" name="image" accept="image/*" class="sr-only"
                                   x-on:change="fileName = $event.target.files[0].name">
                        </label>
                    </div>
                </div>
                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">Formats recommandés : JPG, PNG. Taille maximale : 2 MB</p>
            </div>
            
            <!-- Options avancées -->
            <div x-data="{ open: false }">
                <button type="button" @click="open = !open" class="flex items-center text-gray-600 text-sm font-medium">
                    <i class="fas" :class="open ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                    <span class="ml-1">Options avancées</span>
                </button>
                
                <div x-show="open" class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Champs supplémentaires à ajouter si nécessaire -->
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU (Référence)</label>
                        <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    </div>
                    
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Poids (kg)</label>
                        <input type="number" step="0.01" min="0" id="weight" name="weight" value="{{ old('weight') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    </div>
                </div>
            </div>
            
            <!-- Boutons de soumission -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.products.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-300">
                    Annuler
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition duration-300">
                    Créer le produit
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Aide et conseils -->
<div class="bg-blue-50 rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-blue-100">
        <h3 class="text-lg font-medium text-blue-900">Conseils pour un bon référencement</h3>
    </div>
    <div class="p-6 text-blue-700">
        <ul class="list-disc pl-5 space-y-2 text-sm">
            <li>Choisissez un nom de produit concis et descriptif</li>
            <li>Incluez des mots-clés pertinents dans la description</li>
            <li>Ajoutez des images de haute qualité pour une meilleure présentation</li>
            <li>Catégorisez correctement votre produit pour une meilleure navigation</li>
        </ul>
    </div>
</div>
@endsection