@extends('layouts.app')

@section('content')
<div class="mb-3 pb-2 border-bottom borda-custom text-center">
    <header>
        <h1 class="display-6 fw-bold text-escuro mb-1">Publicações</h1>
    </header>
</div>

@foreach($postagens as $postagem)
<div class="card mb-3">
    <h2 class="h6 pl-1 pt-1 fw-semibold">{{ $postagem->titulo_prato }}</h2>
    <img src="{{ asset($postagem->foto) }}" class="img-fluid my-2" alt="{{ $postagem->titulo_prato }}">
    <div class="card-body">


        <div x-data="{ abrir: false}" class="mt-2">
            <div class="row">
                <div class="col-6">
                    <p class="mb-0 fw-semibold text-start">{{ $postagem->local }}</p>
                </div>
                <div class="col-6">
                    <p class="mb-0 fw-semibold text-end">{{ $postagem->cidade }}</p>
                </div>
            </div>

            <div class="d-flex align-items-center mt-2">
                <form action="{{ route('postagens.like', $postagem) }}" method="POST" class="me-2">
                    @csrf
                    <button type="button" class="btn p-0 border-0 bg-transparent" 
                        @auth onclick="this.form.submit()" @endauth>
                        @php
                            $curtido = $postagem->likes->where('user_id', auth()->id())->count() > 0;
                        @endphp
                        <img src="{{ asset('imagens/icones/' . ($curtido ? 'flecha_cima_cheia.svg' : 'flecha_cima_vazia.svg')) }}" style="width:24px;height:24px;">
                    </button>
                </form>
                <span class="me-3">{{ $postagem->likes->count() }}</span>

                <form action="{{ route('postagens.deslike', $postagem) }}" method="POST" class="me-2">
                    @csrf
                    <button type="button" class="btn p-0 border-0 bg-transparent" 
                        @auth onclick="this.form.submit()" @endauth>
                        @php
                            $naoCurtido = $postagem->deslikes->where('user_id', auth()->id())->count() > 0;
                        @endphp
                        <img src="{{ asset('imagens/icones/' . ($naoCurtido ? 'flecha_baixo_cheia.svg' : 'flecha_baixo_vazia.svg')) }}" style="width:24px;height:24px;">
                    </button>
                </form>
                <span class="me-3">{{ $postagem->deslikes->count() }}</span>

                <div class="ms-auto d-flex align-items-center">
                    <button class="btn p-0 border-0 bg-transparent me-2" @click="abrir = !abrir">
                        <img src="{{ asset('imagens/icones/chat.svg') }}" style="width:24px;height:24px;">
                    </button>
                    <span>{{ $postagem->comentarios->count() }}</span>
                </div>
            </div>

            <div x-show="abrir" x-transition class="mt-3">
                @auth
                    <div class="mb-2">
                        <p class="fw-semibold mb-1 d-block">{{ Auth::user()->nome }}:</p>
                        <form action="{{ route('postagens.comentar', $postagem) }}" method="POST" class="d-flex gap-2">
                            @csrf
                            <input type="text" name="comentario" class="form-control me-2" required>
                            <button type="submit" class="btn btn-primary" style="background-color:#D97014; border-color:#D97014;">Comentar</button>
                        </form>
                    </div>
                @endauth

                <div class="d-flex flex-column gap-2">
                    @foreach($postagem->comentarios as $comentario)
                        <div x-data="{ editando: false }" class="border p-2 rounded bg-gray-100 grid grid-cols-3">
                            <div class="col-span-2 flex gap-2">
                                <strong class="py-1">{{ $comentario->user->nome }}:</strong> 

                                <span x-show="!editando" class="py-1">{{ $comentario->comentario }}</span>

                                <form x-show="editando" method="POST" action="{{ route('comentarios.update', $comentario) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="comentario" value="{{ $comentario->comentario }}" class="border rounded p-1 flex-1 h-full">
                                    <button type="submit" class="bg-blue-500 text-white px-3 rounded">Comentar</button>
                                </form>
                            </div>


                            <div class="justify-items-end py-1">
                                @if(auth()->id() === $comentario->user_id)
                                <div class="flex gap-2 text-sm">
                                    <button @click="editando = !editando" class="text-blue-600 hover:underline">
                                        <img class="h-4 w-4" src="imagens/icones/lapis_editar.svg">
                                    </button>
                                    
                                    <form method="POST" action="{{ route('comentarios.destroy', $comentario) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class=" hover:underline">
                                            <img class="pt-1 h-5 w-5" src="imagens/icones/lixeira_deletar.svg">
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>


                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
