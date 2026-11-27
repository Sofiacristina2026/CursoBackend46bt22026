<?php

declare(strict_types=1);

use App\Http\Controllers\CatalogoController;
use Illuminate\Support\Facades\Route;

// Redireciona a raiz para o catalogo da loja de informatica
Route::redirect('/', '/catalogo');

// Rotas do catalogo da loja
Route::prefix('catalogo')->name('catalogo.')->group(function (): void {
    Route::get('/', [CatalogoController::class, 'index'])->name('index');
});
