@extends('layouts.app')

@section('title', 'Reporte de Encuesta')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Reporte: {{ $survey->title }}</h1>
            <p class="text-gray-600 mt-1">Total de Respuestas: {{ $totalResponses }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('surveys.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                Volver
            </a>
            <a href="{{ route('reports.responses', $survey->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Ver Respuestas Individuales
            </a>
        </div>
    </div>

    @if($totalResponses == 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
            <p class="text-yellow-800">Aún no hay respuestas para esta encuesta.</p>
            <a href="{{ route('surveys.show', $survey->id) }}" class="text-blue-600 hover:underline mt-2 inline-block">
                Ver encuesta
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($reportData as $index => $data)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        {{ $index + 1 }}. {{ $data['question'] }}
                    </h3>

                    @if($data['type'] === 'text')
                        <div class="space-y-3">
                            <p class="text-sm text-gray-600 mb-3">Total de respuestas: {{ $data['total_answers'] }}</p>
                            @foreach($data['data'] as $answer)
                                <div class="bg-gray-50 p-4 rounded border border-gray-200">
                                    <p class="text-gray-700">{{ $answer['text'] }}</p>
                                    <p class="text-xs text-gray-500 mt-2">- {{ $answer['respondent'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($data['data'] as $option)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-800 font-medium">{{ $option['option'] }}</span>
                                        <span class="text-gray-600">
                                            {{ $option['count'] }} respuestas ({{ $option['percentage'] }}%)
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-4">
                                        <div
                                            class="bg-blue-600 h-4 rounded-full transition-all duration-300"
                                            style="width: {{ $option['percentage'] }}%"
                                        ></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-800 mb-2">Resumen General</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-blue-700">Total de Respuestas</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $totalResponses }}</p>
                </div>
                <div>
                    <p class="text-sm text-blue-700">Total de Preguntas</p>
                    <p class="text-2xl font-bold text-blue-900">{{ count($reportData) }}</p>
                </div>
                <div>
                    <p class="text-sm text-blue-700">Fecha de Creación</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $survey->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
