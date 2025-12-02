@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Bienvenido, {{ Auth::user()->name }}</h1>
        <p class="text-gray-600 mt-2">Panel de control del sistema de encuestas</p>
    </div>

    <!-- Informacion del Usuario -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Card de Usuario -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tu Perfil</h3>
            <div class="space-y-2">
                <p class="text-gray-700"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                @if(Auth::user()->phone)
                    <p class="text-gray-700"><strong>Telefono:</strong> {{ Auth::user()->phone }}</p>
                @endif
                <p class="text-gray-700"><strong>Rol:</strong>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ Auth::user()->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </p>
                <p class="text-gray-700"><strong>Estado:</strong>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ Auth::user()->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ Auth::user()->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Card de Empresa -->
        @if(Auth::user()->company)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tu Empresa</h3>
            <div class="space-y-2">
                <p class="text-gray-700"><strong>Nombre:</strong> {{ Auth::user()->company->name }}</p>
                <p class="text-gray-700"><strong>Email:</strong> {{ Auth::user()->company->contact_email }}</p>
                @if(Auth::user()->company->phone)
                    <p class="text-gray-700"><strong>Telefono:</strong> {{ Auth::user()->company->phone }}</p>
                @endif
                @if(Auth::user()->company->website)
                    <p class="text-gray-700">
                        <strong>Web:</strong>
                        <a href="{{ Auth::user()->company->website }}" target="_blank" class="text-blue-600 hover:underline">
                            Ver sitio
                        </a>
                    </p>
                @endif
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('companies.show', Auth::user()->company->id) }}" class="text-blue-600 hover:underline text-sm">
                    Ver detalles completos →
                </a>
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Empresa</h3>
            <p class="text-gray-600 mb-4">No estas asociado a ninguna empresa</p>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-yellow-800">
                    Para crear encuestas necesitas estar asociado a una empresa.
                    Puedes registrar una nueva empresa o pedir al administrador que te asocie a una existente.
                </p>
            </div>
            <a href="{{ route('companies.register') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Registrar mi empresa
            </a>
        </div>
        @endif

        <!-- Card de Acciones Rapidas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Acciones Rapidas</h3>
            <div class="space-y-2">
                <a href="{{ route('surveys.create') }}" class="block text-blue-600 hover:underline">
                    Crear encuesta
                </a>
                <a href="{{ route('surveys.index') }}" class="block text-blue-600 hover:underline">
                    Ver encuestas
                </a>
                <a href="{{ route('companies.index') }}" class="block text-blue-600 hover:underline">
                    Ver empresas
                </a>
            </div>
        </div>
    </div>

    <!-- Estadisticas Placeholder -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Estadisticas</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <p class="text-3xl font-bold text-blue-600">0</p>
                <p class="text-gray-600 text-sm">Encuestas Creadas</p>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <p class="text-3xl font-bold text-green-600">0</p>
                <p class="text-gray-600 text-sm">Respuestas Recibidas</p>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <p class="text-3xl font-bold text-purple-600">0</p>
                <p class="text-gray-600 text-sm">Preguntas Activas</p>
            </div>
            <div class="text-center p-4 bg-orange-50 rounded-lg">
                <p class="text-3xl font-bold text-orange-600">{{ Auth::user()->company ? Auth::user()->company->users->count() : 1 }}</p>
                <p class="text-gray-600 text-sm">Usuarios</p>
            </div>
        </div>
    </div>
</div>
@endsection
