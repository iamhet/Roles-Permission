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
    <script src="{{ asset('js/sidebars.js') }}" defer></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src='//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js'></script>
    <link rel='stylesheet' href='//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css'>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebars.css') }}" rel="stylesheet">

</head>

<body id="body-pd">
    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @if (Auth::user())
                    <button class="btn btn-primary toggle" id="menu-toggle"><i class="fas fa-bars"></i></button>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                @endif

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                                                             document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div>
        </div>
        @yield('content')
        @if (Auth::user())

            <div class="d-flex" id="wrapper">
                <!-- Sidebar -->
                @if (Auth::check())
                    <div class="bg-light border-right" id="sidebar-wrapper">
                        <div class="sidebar-heading">Laravel </div>
                        <div class="list-group list-group-flush">
                            @can('dashboard')
                                <a href="{{ route('home') }}"
                                    class="list-group-item list-group-item-action bg-light">Dashboard</a>
                            @endcan
                            @can('module1-view')
                                <a href="{{ route('module1.index') }}"
                                    class="list-group-item list-group-item-action bg-light">Module-1</a>
                            @endcan
                            @can('module2-view')
                                <a href="{{ route('module2.index') }}"
                                    class="list-group-item list-group-item-action bg-light">Module-2</a>
                            @endcan
                            @can('module3-view')
                                <a href="#" class="list-group-item list-group-item-action bg-light">Module-3</a>
                            @endcan

                            @canany(['user-delete', 'user-delete', 'role-delete', 'role-edit'])
                                <a href="#submenu1" data-bs-toggle="collapse"
                                    class="list-group-item list-group-item-action bg-light">
                                    <i class="fs-4 bi-speedometer2"></i> <span
                                        class="ms-1 d-none d-sm-inline">Setting</span> </a>
                                <ul class="collapse  nav flex-column list-group-item list-group-item-action bg-light"
                                    id="submenu1" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="{{ route('user.index') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline">User
                                                Management</span></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('role.index') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline">Role
                                                Management</span></a>
                                    </li>
                                </ul>
                            @endcanany
                        </div>
                    </div>
                @endif
                <div id="page-content-wrapper">
                    @yield('maincontent')
                    @yield('js')
                </div>
            </div>
    </div>
    @endif
</body>

</html>
