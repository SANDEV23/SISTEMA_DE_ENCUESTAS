@extends('layouts.app')

@section('title', 'Detalles de la Empresa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">{{ $company->name }}</h1>
        <a href="{{ route('companies.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
            Volver
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informacion de la Empresa -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informacion de la Empresa</h2>

                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-700">Nombre:</span>
                        <span class="text-gray-600">{{ $company->name }}</span>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Email de Contacto:</span>
                        <span class="text-gray-600">{{ $company->contact_email }}</span>
                    </div>

                    @if($company->phone)
                    <div>
                        <span class="font-medium text-gray-700">Telefono:</span>
                        <span class="text-gray-600">{{ $company->phone }}</span>
                    </div>
                    @endif

                    @if($company->address)
                    <div>
                        <span class="font-medium text-gray-700">Direccion:</span>
                        <span class="text-gray-600">{{ $company->address }}</span>
                    </div>
                    @endif

                    @if($company->website)
                    <div>
                        <span class="font-medium text-gray-700">Sitio Web:</span>
                        <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ $company->website }}
                        </a>
                    </div>
                    @endif

                    <div>
                        <span class="font-medium text-gray-700">Estado:</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $company->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $company->is_active ? 'Activa' : 'Inactiva' }}
                        </span>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Registrada:</span>
                        <span class="text-gray-600">{{ $company->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Lista de Usuarios -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Usuarios de la Empresa ({{ $company->users->count() }})</h2>

                @if($company->users->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rol
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($company->users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No hay usuarios asociados aun.</p>
                @endif
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="lg:col-span-1">
            <!-- Asociar Usuario -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Asociar Usuario</h3>

                <form action="{{ route('companies.associate-user', $company->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="user_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email del Usuario
                        </label>
                        <input
                            type="email"
                            id="user_email"
                            name="user_email"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_email') border-red-500 @enderror"
                            placeholder="usuario@ejemplo.com"
                            required
                        >
                        @error('user_email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">
                            El usuario debe estar registrado en el sistema
                        </p>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Asociar Usuario
                    </button>
                </form>
            </div>

            <!-- Estadisticas -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Estadisticas</h3>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Usuarios:</span>
                        <span class="text-2xl font-bold text-blue-600">{{ $company->users->count() }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Encuestas:</span>
                        <span class="text-2xl font-bold text-green-600">{{ $company->surveys->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
