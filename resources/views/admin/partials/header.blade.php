<header >
    <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center " href="{{ url('/') }}">
                <div class="logo_laravel">
                    <h3>MyPortfolio</h3>
                </div>
                {{-- config('app.name', 'Laravel') --}}
            </a>

            <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto ">
                    <!-- Authentication Links -->

                    @auth
                    <li>
                        <form  action="{{route('admin.projects.index')}}" method="GET">
                            @csrf
                            <input class="form-control d-inline-block w-75" name="search" type="text" placeholder="Cosa cerchi?" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </li>
                    @endauth

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
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

</header>
