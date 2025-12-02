@extends('layouts.app')

@section('title', 'Mis Encuestas')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mis Encuestas</h1>
        <a href="{{ route('surveys.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Crear Nueva Encuesta
        </a>
    </div>

    @if($surveys->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Titulo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Preguntas
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Creada
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($surveys as $survey)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $survey->title }}
                            </div>
                            @if($survey->description)
                                <div class="text-sm text-gray-500">
                                    {{ Str::limit($survey->description, 50) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $survey->questions_count }} preguntas
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $survey->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('surveys.show', $survey->id) }}" class="text-blue-600 hover:text-blue-900">
                                Ver
                            </a>
                            <a href="{{ route('surveys.questions.create', $survey->id) }}" class="text-green-600 hover:text-green-900">
                                Preguntas
                            </a>
                            <a href="{{ route('reports.show', $survey->id) }}" class="text-purple-600 hover:text-purple-900">
                                Reportes
                            </a>
                            <form action="{{ route('surveys.destroy', $survey->id) }}" method="POST" class="inline" onsubmit="return confirm('Estas seguro de eliminar esta encuesta?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $surveys->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <p class="text-gray-600 mb-4">No tienes encuestas creadas aun.</p>
            <a href="{{ route('surveys.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-block">
                Crear tu primera encuesta
            </a>
        </div>
    @endif
</div>
@endsection
