@extends('layouts.app')

@section('title', 'Registro Exitoso')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <div class="mb-6">
            <svg class="w-20 h-20 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <h2 class="text-3xl font-bold text-gray-800 mb-4">Empresa Registrada Exitosamente</h2>
        <p class="text-gray-600 mb-8">La empresa <strong>{{ $company->name }}</strong> ha sido registrada correctamente.</p>

        <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
            <h3 class="font-semibold text-gray-800 mb-4">Informacion de la Empresa:</h3>
            <div class="space-y-2">
                <p class="text-gray-700"><strong>Nombre:</strong> {{ $company->name }}</p>
                <p class="text-gray-700"><strong>Email:</strong> {{ $company->contact_email }}</p>
                @if($company->phone)
                    <p class="text-gray-700"><strong>Telefono:</strong> {{ $company->phone }}</p>
                @endif
                @if($company->address)
                    <p class="text-gray-700"><strong>Direccion:</strong> {{ $company->address }}</p>
                @endif
                @if($company->website)
                    <p class="text-gray-700">
                        <strong>Sitio Web:</strong>
                        <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ $company->website }}
                        </a>
                    </p>
                @endif
            </div>
        </div>

        <div class="space-y-3">
            <a
                href="{{ route('register') }}"
                class="block w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-medium"
            >
                Crear Usuario para esta Empresa
            </a>
            <a
                href="{{ route('home') }}"
                class="block w-full bg-gray-200 text-gray-700 py-3 rounded-lg hover:bg-gray-300 transition duration-200 font-medium"
            >
                Volver al Inicio
            </a>
        </div>
    </div>
</div>
@endsection
