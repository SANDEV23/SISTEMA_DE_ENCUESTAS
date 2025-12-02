@extends('layouts.app')

@section('title', 'Gracias por Participar')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <div class="mb-6">
            <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-4">Gracias por tu Participacion</h1>

        <p class="text-gray-600 mb-8">
            Tus respuestas han sido registradas exitosamente. Agradecemos tu tiempo y contribucion.
        </p>

        <div class="space-y-3">
            @auth
                <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                    Volver al Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                    Iniciar Sesion
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
