@extends('layouts.app')

@section('title', 'Registro de Empresa')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Registrar Empresa</h2>
        <p class="text-gray-600 text-center mb-6">Complete los datos de su empresa</p>

        <form method="POST" action="{{ route('companies.register') }}">
            @csrf

            <!-- Nombre de la Empresa -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre de la Empresa *
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email de Contacto -->
            <div class="mb-4">
                <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email de Contacto *
                </label>
                <input
                    type="email"
                    id="contact_email"
                    name="contact_email"
                    value="{{ old('contact_email') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('contact_email') border-red-500 @enderror"
                    required
                >
                @error('contact_email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Telefono -->
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    Telefono
                </label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Direccion -->
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                    Direccion
                </label>
                <textarea
                    id="address"
                    name="address"
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sitio Web -->
            <div class="mb-6">
                <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                    Sitio Web
                </label>
                <input
                    type="url"
                    id="website"
                    name="website"
                    value="{{ old('website') }}"
                    placeholder="https://ejemplo.com"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('website')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex gap-4">
                <button
                    type="submit"
                    class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200 font-medium"
                >
                    Registrar Empresa
                </button>
                <a
                    href="{{ route('home') }}"
                    class="flex-1 text-center bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition duration-200 font-medium"
                >
                    Cancelar
                </a>
            </div>
        </form>

        <p class="text-center text-gray-600 text-sm mt-6">
            Eres un usuario individual?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">
                Registrate como usuario
            </a>
        </p>
    </div>
</div>
@endsection
