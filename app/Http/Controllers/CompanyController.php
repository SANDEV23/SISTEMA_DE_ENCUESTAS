<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Mostrar formulario de registro de empresa
     */
    public function showRegisterForm()
    {
        return view('companies.register');
    }

    /**
     * Procesar el registro de empresa
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_email' => 'required|email|unique:companies,contact_email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
        ]);

        $company = Company::create([
            'name' => $validated['name'],
            'contact_email' => $validated['contact_email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'website' => $validated['website'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('companies.success', $company->id)
                         ->with('success', 'Empresa registrada exitosamente!');
    }

    /**
     * Mostrar pagina de exito tras registro
     */
    public function success($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.success', compact('company'));
    }

    /**
     * Listar todas las empresas
     */
    public function index()
    {
        $companies = Company::withCount('users', 'surveys')
            ->where('is_active', true)
            ->paginate(15);
        return view('companies.index', compact('companies'));
    }

    /**
     * Mostrar detalle de empresa (solo la del usuario autenticado)
     */
    public function show($id)
    {
        $user = auth()->user();

        // Solo puede ver su propia empresa
        if ($user->company_id != $id) {
            return redirect()->route('companies.index')
                ->with('error', 'Solo puedes ver los detalles de tu propia empresa.');
        }

        $company = Company::with('users', 'surveys')->findOrFail($id);
        return view('companies.show', compact('company'));
    }

    /**
     * Asociar usuario a la empresa
     */
    public function associateUser(Request $request, $id)
    {
        $user = auth()->user();

        // Verificar que el usuario pertenece a esta empresa
        if ($user->company_id != $id) {
            return redirect()->route('companies.index')
                ->with('error', 'No tienes permisos para asociar usuarios a esta empresa.');
        }

        $validated = $request->validate([
            'user_email' => 'required|email|exists:users,email',
        ]);

        $userToAssociate = \App\Models\User::where('email', $validated['user_email'])->first();

        if ($userToAssociate->company_id) {
            return back()->with('error', 'Este usuario ya esta asociado a una empresa.');
        }

        $userToAssociate->update(['company_id' => $id]);

        return back()->with('success', 'Usuario asociado exitosamente a la empresa.');
    }
}
