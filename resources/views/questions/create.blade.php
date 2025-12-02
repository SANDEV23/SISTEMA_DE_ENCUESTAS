@extends('layouts.app')

@section('title', 'Agregar Preguntas')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulario para agregar pregunta -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Agregar Pregunta a: {{ $survey->title }}</h1>

                <form action="{{ route('surveys.questions.store', $survey->id) }}" method="POST" id="questionForm">
                    @csrf

                    <div class="mb-4">
                        <label for="question" class="block text-sm font-medium text-gray-700 mb-2">
                            Texto de la Pregunta *
                        </label>
                        <textarea
                            id="question"
                            name="question"
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('question') border-red-500 @enderror"
                            required
                            placeholder="Escribe tu pregunta aqui..."
                        >{{ old('question') }}</textarea>
                        @error('question')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de Pregunta *
                        </label>
                        <select
                            id="type"
                            name="type"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('type') border-red-500 @enderror"
                            required
                            onchange="toggleOptions()"
                        >
                            <option value="">Selecciona un tipo</option>
                            <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Respuesta de Texto Libre</option>
                            <option value="select" {{ old('type') == 'select' ? 'selected' : '' }}>Seleccion Unica</option>
                            <option value="checkbox" {{ old('type') == 'checkbox' ? 'selected' : '' }}>Seleccion Multiple</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="optionsContainer" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Opciones de Respuesta *
                        </label>
                        <div id="optionsList">
                            <div class="flex gap-2 mb-2">
                                <input
                                    type="text"
                                    name="options[]"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Opcion 1"
                                >
                            </div>
                            <div class="flex gap-2 mb-2">
                                <input
                                    type="text"
                                    name="options[]"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Opcion 2"
                                >
                            </div>
                        </div>
                        <button
                            type="button"
                            onclick="addOption()"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                        >
                            + Agregar otra opcion
                        </button>
                    </div>

                    <div class="flex gap-4 mt-6">
                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200"
                        >
                            Agregar Pregunta
                        </button>
                        <button
                            type="button"
                            onclick="window.location.href='{{ route('surveys.questions.finish', $survey->id) }}'"
                            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-200"
                        >
                            Finalizar Encuesta
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de preguntas agregadas -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Preguntas Agregadas ({{ $survey->questions->count() }})</h3>

                @if($survey->questions->count() > 0)
                    <div class="space-y-3">
                        @foreach($survey->questions as $index => $question)
                            <div class="border border-gray-200 rounded-lg p-3">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-sm font-medium text-gray-800">{{ $index + 1 }}. {{ Str::limit($question->question, 50) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">
                                        @if($question->type == 'text')
                                            Texto libre
                                        @elseif($question->type == 'select')
                                            Seleccion Unica ({{ $question->options->count() }} opciones)
                                        @else
                                            Multiple ({{ $question->options->count() }} opciones)
                                        @endif
                                    </span>
                                    <form action="{{ route('surveys.questions.destroy', [$survey->id, $question->id]) }}" method="POST" class="inline" onsubmit="return confirm('Eliminar esta pregunta?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Aun no has agregado preguntas.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function toggleOptions() {
        const type = document.getElementById('type').value;
        const optionsContainer = document.getElementById('optionsContainer');

        if (type === 'select' || type === 'checkbox') {
            optionsContainer.style.display = 'block';
        } else {
            optionsContainer.style.display = 'none';
        }
    }

    function addOption() {
        const optionsList = document.getElementById('optionsList');
        const optionCount = optionsList.children.length + 1;

        const div = document.createElement('div');
        div.className = 'flex gap-2 mb-2';
        div.innerHTML = `
            <input
                type="text"
                name="options[]"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Opcion ${optionCount}"
            >
            <button
                type="button"
                onclick="this.parentElement.remove()"
                class="text-red-600 hover:text-red-800 px-3"
            >
                
            </button>
        `;
        optionsList.appendChild(div);
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleOptions();
    });
</script>
@endsection
