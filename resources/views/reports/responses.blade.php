@extends('layouts.app')

@section('title', 'Respuestas Individuales')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Respuestas Individuales</h1>
            <p class="text-gray-600 mt-1">Encuesta: {{ $survey->title }}</p>
        </div>
        <a href="{{ route('reports.show', $survey->id) }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
            Volver al Reporte
        </a>
    </div>

    @if($responses->count() == 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
            <p class="text-yellow-800">Aún no hay respuestas para esta encuesta.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($responses as $email => $userResponses)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $userResponses->first()->respondent_name }}
                        </h3>
                        <p class="text-sm text-gray-600">{{ $email }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            Fecha: {{ $userResponses->first()->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <div class="space-y-4">
                        @php
                            $groupedByQuestion = $userResponses->groupBy('question_id');
                        @endphp

                        @foreach($groupedByQuestion as $questionId => $answers)
                            @php
                                $question = $answers->first()->question;
                            @endphp
                            <div class="bg-gray-50 p-4 rounded">
                                <p class="font-medium text-gray-800 mb-2">{{ $question->question }}</p>

                                @if($question->type === 'text')
                                    <p class="text-gray-700">{{ $answers->first()->answer_text }}</p>
                                @elseif($question->type === 'select')
                                    <p class="text-gray-700">" {{ $answers->first()->option->option_text }}</p>
                                @elseif($question->type === 'checkbox')
                                    <ul class="list-disc list-inside text-gray-700">
                                        @foreach($answers as $answer)
                                            <li>{{ $answer->option->option_text }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-blue-800">
                <strong>Total de Participantes:</strong> {{ $responses->count() }}
            </p>
        </div>
    @endif
</div>
@endsection
