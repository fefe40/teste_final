<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicacaoController;
Route::get('/', [PublicacaoController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/postagens/{postagem}/like', [PublicacaoController::class, 'like'])->name('postagens.like');
    Route::post('/postagens/{postagem}/deslike', [PublicacaoController::class, 'deslike'])->name('postagens.deslike');
    Route::post('/postagens/{postagem}/comentario', [PublicacaoController::class, 'comentar'])->name('postagens.comentar');
    Route::patch('/comentarios/{comentario}', [PublicacaoController::class, 'atualizarComentario'])->name('comentarios.update');
    Route::delete('/comentarios/{comentario}', [PublicacaoController::class, 'excluirComentario'])->name('comentarios.destroy');
});
Route::get('/postagens', [PublicacaoController::class, 'index'])->name('postagens.index');


require __DIR__.'/auth.php';
