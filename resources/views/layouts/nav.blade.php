<nav id="main-nav" v-on:click="toogleMobileNav">
    <div class="nav-header">
        <a class="logo-container" href="{{ url('/') }}">
            <span id="logo">🃏</span>
            <span class="text">Crash Card Club</span>
        </a>

        @if(Route::currentRouteName() != "home")
            <div class="page-name" id="{{ Route::currentRouteName() }}-nav-header">
                <span class="title">@yield('title')</span>
                <div class="card"></div>
            </div>
        @endif

    </div>

    <div class="nav-container">
        <ul>
            <li class="nav-elem" id="workshops-nav">
                <a href="{{ route('workshops-manager') }}">
                    <div class="card"></div>
                    <span class="title">Workshops</span>
                </a>
            </li>
            <li class="nav-elem" id="decks-nav">
                <a href="{{ route('decks-manager') }}">
                    <div class="card"></div>
                    <span class="title">Decks</span>
                </a>
            </li>
            <li class="nav-elem" id="cards-nav">
                <a href="{{ route('cards-manager') }}">
                    <div class="card"></div>
                    <span class="title">Cards</span>
                </a>
            </li>

            @guest
                <li class="nav-elem" id="login-nav">
                    <a href="{{ route('login') }}">
                        <div class="card"></div>
                        <span class="title">Connection</span>
                    </a>
                </li>
                <li class="nav-elem" id="register-nav">
                    <a href="{{ route('register') }}">
                        <div class="card"></div>
                        <span class="title">Inscription</span>
                    </a>
                </li>
            @else

                <li class="nav-elem" id="user-nav">
                    <a href="{{ route('user') }}">
                        <div class="card"></div>
                        <span class="title">Profile</span>
                    </a>
                </li>
                <li class="nav-elem" id="logout-nav">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        <div class="card"></div>
                        <span class="title">Déconnection</span>
                    </a>
                </li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>


            @endguest
        </ul>
    </div>

    <div class="mobile-nav invisible">
        <h2>Mobile nav</h2>
    </div>

</nav>