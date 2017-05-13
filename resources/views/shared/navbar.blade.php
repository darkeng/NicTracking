<nav class="navbar {{ Request::is('tracking-panel/*') ? 'navbar-transparent' : 'navbar-inverse' }}  navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-minimize {{ Request::is('tracking-panel/*') ? '' : 'hidden'  }}">
            <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons visible-on-sidebar-mini">view_list</i>
            </button>
        </div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse">
                <span class="sr-only">Menu</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"> NicTracking </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                @if(!Request::is('tracking-panel/*'))
                    @if(!Auth::check())
                        <li>
                            <a href="/auth/login">
                                <i class="material-icons">fingerprint</i> Iniciar sesion
                            </a>
                        </li>
                        <li>
                            <a href="/auth/register">
                                <i class="material-icons">person_add</i> Registrate
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="/tracking-panel/general">
                                <i class="material-icons">navigation</i> GPS Tracking
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img class="img-profile img-circle" src="{{ asset(Auth::user()->avatar) }}" alt="">
                                {{ Auth::user()->name }} <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-user"></i> Mi perfil</a></li>
                                <li><a href="#"><i class="fa fa-cog"></i> Ajustes</a></li>
                                <li><a href="auth/logout"><i class="fa fa-sign-out"></i> Salir</a></li>
                            </ul>
                        </li>
                    @endif
                    <li class="separator hidden-lg hidden-md"></li>
                @endif
            </ul>
        </div>
    </div>
</nav>