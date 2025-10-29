<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .accent-laranja { background-color: #D97014 !important; }
        .text-escuro { color: #000000 !important; }
        .borda-custom { border: 1px solid #C2BEBE !important; }
    </style>
</head>
<body class="bg-white">
<div class="container-fluid px-4 py-4">
    <div class="row gx-4">
        <!-- Perfil (col-3) -->
        <aside class="col-md-3 mb-4">
            <div class="p-3 h-100">
                <div class="d-flex flex-column align-items-center">
                    @auth
                        <img src="{{ Auth::user()->foto }}" class="rounded-circle mb-3" style="width:96px;height:96px;object-fit:cover;">
                        <h2 class="h5 fw-bold text-escuro">{{ Auth::user()->nome }}</h2>
                    @endauth

                    @guest
                        <img src="{{ asset('imagens/logo/logo_sabor_do_brasil.png') }}" class="rounded-circle mb-3" style="width:96px;height:96px;object-fit:cover;">
                        <h2 class="h5 fw-bold text-escuro">Sabor do Brasil</h2>
                    @endguest

                    <hr class="my-3" style="border-top:3px solid #D97014; width:75%">

                    <div class="grid grid-col-2 w-full text-center">
                        <div class="">
                            @guest
                                <p class="fw-bold text-escuro mb-0">{{$like}}</p>
                            @endguest
                            @auth
                                <p class="fw-bold text-escuro mb-0">{{$likeusuario}}</p>
                            @endauth
                            <p class="fw-bold text-escuro small">Quantidade<br>Likes</p>
                        </div>
                        <div class="">
                            @guest
                                <p class="fw-bold text-escuro mb-0">{{$deslike}}</p>
                            @endguest
                            @auth
                                <p class="fw-bold text-escuro mb-0">{{$deslikeusuario}}</p>
                            @endauth
                            <p class="fw-bold text-escuro small">Quantidade<br>Deslikes</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Principal (col-6) -->
        <main class="col-md-6 mb-4">
            <div class="card shadow-sm borda-custom">
                <div class="card-body">
                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Login / Ações (col-3) -->
        <aside class="col-md-3 mb-4 d-flex flex-column justify-content-between">
            <!-- Container Alpine.js envolvendo botão e modal -->
            <div x-data="{ abrirLogin: false }">
                <div class="mb-3 d-flex justify-content-center">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn" style="background-color:#D97014; color:#FFFFFF; font-weight:700; padding-left:3.5rem; padding-right:3.5rem;">
                                Sair
                            </button>
                        </form>
                    @endauth

                    @guest
                    <button command="show-modal" commandfor="dialog" class="rounded-md bg-[#D97014] font-bold text-[#FFFFFF] px-20 py-2 text-sm inset-ring inset-ring-white/5">Entrar</button>
                    @endguest
                    

                    <el-dialog>
                        <dialog id="dialog" aria-labelledby="dialog-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
                        <el-dialog-backdrop class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

                        <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                        <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-white text-center shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                            <div class="bg-white px-2 pt-3 pb-4">
                            <div class="">
                                
                                <div class="mt-3 text-center">
                                    <h1 id="dialog-title" class="text-base font-semibold text-black">Login</h1>
                                    <div class="mt-2 px-4">
                                        <x-auth-session-status class="mb-4" :status="session('status')" />
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            
                                            <!-- Email Address -->
                                            <div>
                                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Digite seu email" />
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            </div>

                                            <!-- Password -->
                                            <div class="mt-4">
                                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Digite sua senha" />

                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            </div>
                                            
                                            <div class="py-3 sm:flex sm:flex-row-reverse">
                                            <button type="submit" class="inline-flex w-full justify-center rounded-md border bg-[#d97014] px-3 py-2 text-sm font-semibold text-white hover:bg-red-400 sm:ml-3 sm:w-auto">Entrar</button>
                                            
                                            <button type="button" command="close" commandfor="dialog" class="mt-3 inline-flex w-full justify-center rounded-md border border-[#d97014] px-3 py-2 text-sm font-semibold text-black inset-ring inset-ring-white/5 hover:bg-white/20 sm:mt-0 sm:w-auto">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </el-dialog-panel>
                    </div>
                        </dialog>
                    </el-dialog>
            </div>

            <!-- Footer dentro da coluna direita (opcional) -->
            <div class="mt-3 text-center small">
                <!-- Espaço reservado para informações rápidas / anúncios -->
            </div>
        </aside>
    </div>
</div>

<!-- Footer full-width -->
<footer class="py-4" style="background-color:#D97014; color:#FFFFFF;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 text-start">
                <p class="h5 fw-bold mb-0">Sabor do Brasil</p>
            </div>
            <div class="col-md-4 d-flex justify-content-center gap-8">
                <a href="#">
                    <img src="{{ asset('imagens/icones/Instagram.svg') }}" alt="Instagram" style="height:28px;width:28px;">
                </a>
                <a href="#">
                    <img src="{{ asset('imagens/icones/Twitter.svg') }}" alt="Twitter" style="height:28px;width:28px;">
                </a>
                <a href="#">
                    <img src="{{ asset('imagens/icones/Whatsapp.svg') }}" alt="Whatsapp" style="height:28px;width:28px;">
                </a>
                <a href="#">
                    <img src="{{ asset('imagens/icones/Globe.svg') }}" alt="Site" style="height:28px;width:28px;">
                </a>
            </div>
            <div class="col-md-4 text-end">
                <p class="h6 fw-bold mb-0">Copyright - 2024</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
