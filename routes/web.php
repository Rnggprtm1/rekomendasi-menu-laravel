<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// ──────────────────────────────────────────
// PUBLIC ROUTES
// ──────────────────────────────────────────

// Halaman utama
Route::get('/', [RecipeController::class, 'index'])->name('home');

// Form saran publik
Route::get('/saran',  [SuggestionController::class, 'show'])->name('saran');
Route::post('/saran', [SuggestionController::class, 'store'])->name('saran.store');

// API JSON
Route::prefix('api')->group(function () {
    Route::get('/recipes',      [RecipeController::class, 'apiIndex']);
    Route::get('/recipes/{id}', [RecipeController::class, 'apiShow']);
});

// ──────────────────────────────────────────
// ADMIN ROUTES
// ──────────────────────────────────────────

// Login (tidak perlu middleware)
Route::get('/admin/login',  [Admin\AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [Admin\AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout',[Admin\AuthController::class, 'logout'])->name('admin.logout');

// Semua route admin wajib login (dilindungi middleware)
Route::prefix('admin')->middleware('admin.auth')->group(function () {

    // Dashboard
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD Resep
    Route::get('/resep',              [Admin\RecipeController::class, 'index'])->name('admin.resep.index');
    Route::get('/resep/create',       [Admin\RecipeController::class, 'create'])->name('admin.resep.create');
    Route::post('/resep',             [Admin\RecipeController::class, 'store'])->name('admin.resep.store');
    Route::get('/resep/{id}/edit',    [Admin\RecipeController::class, 'edit'])->name('admin.resep.edit');
    Route::put('/resep/{id}',         [Admin\RecipeController::class, 'update'])->name('admin.resep.update');
    Route::delete('/resep/{id}',      [Admin\RecipeController::class, 'destroy'])->name('admin.resep.destroy');

    // Kelola Saran
    Route::get('/saran',                    [Admin\SuggestionController::class, 'index'])->name('admin.saran.index');
    Route::delete('/saran/{id}',            [Admin\SuggestionController::class, 'destroy'])->name('admin.saran.destroy');
    Route::get('/saran/{id}/convert',       [Admin\SuggestionController::class, 'convertToRecipe'])->name('admin.saran.convert');
    Route::post('/saran/{id}/approve',      [Admin\SuggestionController::class, 'approve'])->name('admin.saran.approve');
});
