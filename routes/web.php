<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    // Routes d'administration
    Route::middleware(['isAdmin'])->prefix('admin')->group(function () {
        Route::get('/themes', function () {
            return Inertia::render('Themes/Index');
        })->name('admin.themes');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
