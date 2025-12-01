@extends('layouts.app')

@section('title', 'Crear Encuesta')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Crear Nueva Encuesta</h1>

        <form action="{{ route('surveys.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Titulo de la Encuesta *
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                    required
                    placeholder="Ej: Encuesta de Satisfaccion 2024"
                >
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Descripcion
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                    placeholder="Describe el proposito de esta encuesta..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Opcional: Breve descripcion de lo que deseas conocer</p>
            </div>

            <div class="flex gap-4">
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200"
                >
                    Crear y Agregar Preguntas
                </button>
                <a
                    href="{{ route('surveys.index') }}"
                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition duration-200"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h3 class="text-sm font-semibold text-blue-800 mb-2">Siguiente paso</h3>
        <p class="text-sm text-blue-700">
            Despues de crear la encuesta, podras agregar las preguntas con sus opciones de respuesta.
        </p>
    </div>
</div>
@endsection
