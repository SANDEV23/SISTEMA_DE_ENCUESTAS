<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReportController;

// Página de inicio
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas de autenticación (solo para invitados)
Route::middleware('guest')->group(function () {
    // Formulario de registro de usuarios
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

    // Formulario de login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    // Formulario de registro de empresas
    Route::get('/companies/register', [CompanyController::class, 'showRegisterForm'])->name('companies.register');
});

// Procesamiento de registro y login (sin middleware guest para permitir autenticación)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/companies/register', [CompanyController::class, 'register']);

// Rutas públicas para responder encuestas
Route::get('/surveys/{id}/view', [SurveyController::class, 'show'])->name('surveys.show');
Route::post('/surveys/{id}/submit', [SurveyController::class, 'submit'])->name('surveys.submit');
Route::get('/surveys/thank-you', [SurveyController::class, 'thankYou'])->name('surveys.thank-you');

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Empresas (para usuarios autenticados)
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('companies.show');
    Route::post('/companies/{id}/associate-user', [CompanyController::class, 'associateUser'])->name('companies.associate-user');

    // Encuestas
    Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
    Route::post('/surveys', [SurveyController::class, 'store'])->name('surveys.store');
    Route::get('/surveys/{id}/edit', [SurveyController::class, 'edit'])->name('surveys.edit');
    Route::put('/surveys/{id}', [SurveyController::class, 'update'])->name('surveys.update');
    Route::delete('/surveys/{id}', [SurveyController::class, 'destroy'])->name('surveys.destroy');

    // Preguntas
    Route::get('/surveys/{surveyId}/questions/create', [QuestionController::class, 'create'])->name('surveys.questions.create');
    Route::post('/surveys/{surveyId}/questions', [QuestionController::class, 'store'])->name('surveys.questions.store');
    Route::delete('/surveys/{surveyId}/questions/{questionId}', [QuestionController::class, 'destroy'])->name('surveys.questions.destroy');
    Route::get('/surveys/{surveyId}/questions/finish', [QuestionController::class, 'finish'])->name('surveys.questions.finish');

    // Reportes
    Route::get('/surveys/{surveyId}/report', [ReportController::class, 'show'])->name('reports.show');
    Route::get('/surveys/{surveyId}/responses', [ReportController::class, 'responses'])->name('reports.responses');
});

// Éxito de registro de empresa (público)
Route::get('/companies/success/{id}', [CompanyController::class, 'success'])->name('companies.success');
