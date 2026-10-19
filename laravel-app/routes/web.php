<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;

// Display the home page.
Route::get('/', function () {
    return view('home');
})->name('home');

// Guests can register or log in.
Route::middleware('guest')->group(function () {

    // Registration
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

// Only logged-in users can access these routes.
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [PortfolioController::class, 'dashboard'])
    ->name('dashboard');

    // Create portfolio
    Route::get('/portfolio/create', [PortfolioController::class, 'create'])
        ->name('portfolio.create');

    // Save portfolio
    Route::post('/portfolio/store', [PortfolioController::class, 'store'])
    ->name('portfolio.store');
    // Update the existing portfolio.
    Route::put('/portfolio/update', [PortfolioController::class, 'update'])
    ->name('portfolio.update');

    // Manage the user's portfolio.
    Route::get('/portfolio/manage', [PortfolioController::class, 'manage'])
    ->name('portfolio.manage');

    // Edit the saved portfolio.
    Route::get('/portfolio/edit', [PortfolioController::class, 'edit'])
    ->name('portfolio.edit');

    // Open the template selection page.
Route::get('/portfolio/template', [PortfolioController::class, 'changeTemplate'])
    ->name('portfolio.template');

// Save the selected template.
Route::post('/portfolio/template', [PortfolioController::class, 'updateTemplate'])
    ->name('portfolio.template.update');

    // Show the Creative palette selection page.
Route::get('/portfolio/palette', [PortfolioController::class, 'choosePalette'])
    ->name('portfolio.palette');

// Save the selected Creative palette.
Route::post('/portfolio/palette', [PortfolioController::class, 'updatePalette'])
    ->name('portfolio.palette.update');

    // Delete the logged-in user's portfolio.
Route::delete('/portfolio/delete', [PortfolioController::class, 'destroy'])
    ->name('portfolio.destroy');
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
