<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="'https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500'" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sprint.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div id="viewport">
        <!-- Sidebar -->

        <div id="sidebar" >
            <header>
                <a class="navbar-brand" href="{{ url('/') }}">
                    Scrumapp
                </a>
            </header>
            <ul class="nav">
                <li id="li-bottom-line">
                    <a href=" {{ url('/') }}">
                        <i class="fas fa-columns i-sidebar"></i> Dashboard
                    </a>
                </li>
                <li id="li-bottom-line">
                    <a href="{{ url('/project') }}">
                        <i class="fas fa-file-powerpoint i-sidebar"></i> Projecten
                    </a>
                </li>
                @if (\Request::is('project/*'))
                    <li id="li-bottom-line-project">
                        <a href="{{ route('project.dashboard', request()->route('project')) }}">
                            <i class="fas fa-columns i-sidebar sidebar-icon"></i> Project dashboard
                        </a>
                    </li>
                    <li id="li-bottom-line-project">
                        <a href="{{ route('project.backlog', request()->route('project')) }}">
                            <i class="fas fa-clipboard-list i-sidebar sidebar-icon"></i> Backlog
                        </a>
                    </li>
                    <li id="li-bottom-line-project">
                        <a href="{{ route('sprint.dashboard', request()->route('project')) }}">
                            <i class="fas fa-redo i-sidebar sidebar-icon"></i> Sprints
                        </a>
                    </li>
                    <li id="li-bottom-line-project">
                        <a href="{{ route('project.team', request()->route('project')) }}">
                            <i class="fas fa-users i-sidebar sidebar-icon"></i> Leden
                        </a>
                    </li>
                @endif
                @if (\Request::is('sprint'))
                    <li id="li-bottom-line-project">
                        <a href="/project">
                            <i class="fas fa-clipboard-list i-sidebar sidebar-icon"></i> Backlog
                        </a>
                    </li>
                    <li id="li-bottom-line-project">
                        <a href="/project">
                            <i class="fas fa-bug i-sidebar sidebar-icon"></i> Bugs
                        </a>
                    </li>
                    <li id="li-bottom-line-project">
                        <a href="/sprint">
                            <i class="fas fa-redo i-sidebar sidebar-icon"></i> Sprints
                        </a>
                    </li>
                    <li id="li-bottom-line-project">
                        <a href="/project">
                            <i class="fas fa-users i-sidebar sidebar-icon"></i> Leden
                        </a>
                    </li>
                @endif
                @if (auth()->check())
                    @if ( Auth::user()->user_role_id  === 1)
                <li id="li-bottom-line">
                    <a href="/admin">
                        <i class="fas fa-cog i-sidebar"></i> Admin pagina
                    </a>
                </li>
                @else
                    @endif
                @endif
            </ul>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" >
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if (\Request::is('project/*'))
                            <a href="{{ url()->previous() }}">
                                <i style="float: right" class="fas fa-long-arrow-alt-left big-arrow-left"></i>
                            </a>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile.show', auth::id()) }}">
                                    Profile
                                </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
