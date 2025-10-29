<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacao;
use App\Models\Like;
use App\Models\Deslike;

class PublicacaoController extends Controller
{

    public function index()
    {
        $postagens = Publicacao::all();
        $like = Like::count();
        $deslike = Deslike::count();
        $likeusuario = Like::where('user_id', auth()->id())->count();
        $deslikeusuario = Deslike::where('user_id', auth()->id())->count();

        return view('index', compact('postagens','like','deslike','likeusuario','deslikeusuario'));
    }


    
    public function like(Publicacao $postagem)
    {
        $usuario = auth()->user();

        if ($postagem->likes()->where('user_id', $usuario->id)->exists()) {
            $postagem->likes()->where('user_id', $usuario->id)->delete();
        } else {
            $postagem->likes()->create(['user_id' => $usuario->id]);
        }

        return back();
    }

    public function deslike(Publicacao $postagem)
    {
        $usuario = auth()->user();

        if ($postagem->deslikes()->where('user_id', $usuario->id)->exists()) {
            $postagem->deslikes()->where('user_id', $usuario->id)->delete();
        } else {
            $postagem->deslikes()->create(['user_id' => $usuario->id]);
        }
        
        return back();
    }
    
    public function comentar(Request $request, Publicacao $postagem)
    {
        $postagem->comentarios()->create([
            'user_id' => auth()->id(),
            'comentario' => $request->comentario,
        ]);

        return back();
    }
    
    public function atualizarComentario(Request $request, Comentario $comentario)
    {
        if ($comentario->user_id !== auth()->id()) {
            abort(403, 'Acesso negado');
        }

        $request->validate([
            'comentario' => 'required|string|max:500',
        ]);

        $comentario->update([
            'comentario' => $request->comentario,
        ]);

        return back()->with('success', 'Comentário atualizado com sucesso!');
    }

    public function excluirComentario(Comentario $comentario)
    {
        if ($comentario->user_id !== auth()->id()) {
            abort(403, 'Acesso negado');
        }

        $comentario->delete();

        return back()->with('success', 'Comentário excluído com sucesso!');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
