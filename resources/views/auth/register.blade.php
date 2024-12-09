@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Créer un compte</h1>
            <p class="text-gray-600">Rejoignez-nous pour une expérience shopping exceptionnelle</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 @error('name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 @error('email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <input id="password" type="password" name="password" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 @error('password') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Le mot de passe doit contenir au moins 8 caractères</p>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                        <input id="password-confirm" type="password" name="password_confirmation" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    </div>
                    
                    <div class="flex items-center">
                        <input type="hidden" name="isAdmin" value="0">
                        <input id="isAdmin" type="checkbox" name="isAdmin" value="1" class="h-4 w-4 rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                        <label for="isAdmin" class="ml-2 block text-sm text-gray-700">S'inscrire en tant qu'administrateur</label>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 rounded border-gray-300 text-rose-600 focus:ring-rose-500">
                        </div>
                        <div class="ml-2 text-sm">
                            <label for="terms" class="text-gray-700">
                                J'accepte les <a href="#" class="text-rose-600 hover:underline">conditions générales</a> et la <a href="#" class="text-rose-600 hover:underline">politique de confidentialité</a>
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition duration-300">
                            Créer mon compte
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Ou s'inscrire avec</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-300">
                            <i class="fab fa-google text-red-600 mr-2"></i>
                            Google
                        </a>
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-300">
                            <i class="fab fa-facebook text-blue-600 mr-2"></i>
                            Facebook
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}" class="font-medium text-rose-600 hover:text-rose-500">Se connecter</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection