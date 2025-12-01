@extends('layouts.app')

@section('title', 'Responder Encuesta')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $survey->title }}</h1>
        @if($survey->description)
            <p class="text-gray-600 mb-6">{{ $survey->description }}</p>
        @endif

        @if($survey->questions->count() == 0)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <p class="text-yellow-800">Esta encuesta aun no tiene preguntas.</p>
                @auth
                    @if(Auth::user()->company_id == $survey->company_id)
                        <a href="{{ route('surveys.questions.create', $survey->id) }}" class="text-blue-600 hover:underline">
                            Agregar preguntas ahora
                        </a>
                    @endif
                @endauth
            </div>
        @else
            <form action="{{ route('surveys.submit', $survey->id) }}" method="POST">
                @csrf

                <div class="mb-6 border-t border-b border-gray-200 py-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informacion del Participante</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="respondent_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre Completo *
                            </label>
                            <input
                                type="text"
                                id="respondent_name"
                                name="respondent_name"
                                value="{{ old('respondent_name') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                        </div>

                        <div>
                            <label for="respondent_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Correo Electronico *
                            </label>
                            <input
                                type="email"
                                id="respondent_email"
                                name="respondent_email"
                                value="{{ old('respondent_email') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                        </div>
                    </div>
                </div>

                @foreach($survey->questions as $index => $question)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <label class="block text-sm font-medium text-gray-800 mb-3">
                            {{ $index + 1 }}. {{ $question->question }}
                            @if($question->type !== 'text')
                                <span class="text-red-500">*</span>
                            @endif
                        </label>

                        @if($question->type === 'text')
                            <textarea
                                name="answers[{{ $question->id }}]"
                                rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Escribe tu respuesta aqui..."
                            >{{ old('answers.' . $question->id) }}</textarea>

                        @elseif($question->type === 'select')
                            <div class="space-y-2">
                                @foreach($question->options as $option)
                                    <label class="flex items-center p-2 hover:bg-gray-100 rounded cursor-pointer">
                                        <input
                                            type="radio"
                                            name="answers[{{ $question->id }}]"
                                            value="{{ $option->id }}"
                                            class="mr-3 text-blue-600"
                                            {{ old('answers.' . $question->id) == $option->id ? 'checked' : '' }}
                                        >
                                        <span class="text-gray-700">{{ $option->option_text }}</span>
                                    </label>
                                @endforeach
                            </div>

                        @elseif($question->type === 'checkbox')
                            <div class="space-y-2">
                                @foreach($question->options as $option)
                                    <label class="flex items-center p-2 hover:bg-gray-100 rounded cursor-pointer">
                                        <input
                                            type="checkbox"
                                            name="answers[{{ $question->id }}][]"
                                            value="{{ $option->id }}"
                                            class="mr-3 text-blue-600"
                                            {{ is_array(old('answers.' . $question->id)) && in_array($option->id, old('answers.' . $question->id)) ? 'checked' : '' }}
                                        >
                                        <span class="text-gray-700">{{ $option->option_text }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        @error('answers.' . $question->id)
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

                <div class="flex gap-4 mt-8">
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-medium"
                    >
                        Enviar Respuestas
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
