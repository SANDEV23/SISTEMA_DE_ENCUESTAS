@extends('layouts.app')

@section('title', 'Inicio - Sistema de Encuestas')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="text-center py-16">
        <h1 class="text-5xl font-bold text-gray-900 mb-4">
            Sistema de Encuestas
        </h1>
        <p class="text-xl text-gray-600 mb-8">
            Crea, gestiona y analiza encuestas de manera facil y profesional
        </p>

        @guest
        <div class="flex justify-center gap-4">
            <a href="{{ route('register') }}"
               class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-medium text-lg">
                Comenzar Gratis
            </a>
            <a href="{{ route('login') }}"
               class="bg-white border-2 border-blue-600 text-blue-600 px-8 py-3 rounded-lg hover:bg-blue-50 transition duration-200 font-medium text-lg">
                Iniciar Sesion
            </a>
        </div>
        @else
        <div>
            <a href="{{ route('dashboard') }}"
               class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-medium text-lg inline-block">
                Ir al Dashboard
            </a>
        </div>
        @endguest
    </div>

    <!-- Features Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 py-16">
        <!-- Feature 1 -->
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Crea Encuestas</h3>
            <p class="text-gray-600">
                Disena encuestas personalizadas con multiples tipos de preguntas
            </p>
        </div>

        <!-- Feature 2 -->
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Gestion Multiempresa</h3>
            <p class="text-gray-600">
                Administra multiples empresas y usuarios desde una sola plataforma
            </p>
        </div>

        <!-- Feature 3 -->
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Analiza Resultados</h3>
            <p class="text-gray-600">
                Obten insights valiosos de las respuestas recolectadas
            </p>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-xl p-12 text-center text-white my-16">
        <h2 class="text-3xl font-bold mb-4">Listo para comenzar?</h2>
        <p class="text-xl mb-8 text-blue-100">
            Registra tu empresa y empieza a crear encuestas en minutos
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('companies.register') }}"
               class="bg-white text-blue-600 px-8 py-3 rounded-lg hover:bg-gray-100 transition duration-200 font-medium text-lg">
                Registrar Empresa
            </a>
            <a href="{{ route('register') }}"
               class="bg-blue-500 text-white px-8 py-3 rounded-lg hover:bg-blue-400 transition duration-200 font-medium text-lg">
                Crear Cuenta Personal
            </a>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 py-16">
        <div class="text-center">
            <p class="text-4xl font-bold text-blue-600 mb-2">Facil</p>
            <p class="text-gray-600">Interfaz intuitiva</p>
        </div>
        <div class="text-center">
            <p class="text-4xl font-bold text-green-600 mb-2">Rapido</p>
            <p class="text-gray-600">Resultados en tiempo real</p>
        </div>
        <div class="text-center">
            <p class="text-4xl font-bold text-purple-600 mb-2">Seguro</p>
            <p class="text-gray-600">Datos protegidos</p>
        </div>
        <div class="text-center">
            <p class="text-4xl font-bold text-orange-600 mb-2">Flexible</p>
            <p class="text-gray-600">Multiples formatos</p>
        </div>
    </div>
</div>
@endsection
