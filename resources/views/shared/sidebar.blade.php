<div class="sidebar" data-active-color="blue" data-background-color="black" data-image="{{ asset('img/sidebar-1.jpg') }}">
    <div class="logo">
        <a href="/" class="simple-text">
            NicTracking
        </a>
    </div>
    <div class="logo logo-mini">
        <a href="/" class="simple-text">
            NT
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img src="{{ asset(Auth::user()->avatar) }}" />
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    {{ Auth::user()->name }}
                    <b class="caret"></b>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li><a href="#">Mi perfil</a></li>
                        <li><a href="#">Ajustes</a></li>
                        <li><a href="#">Salir</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li class="{{ Request::is('tracking-panel/general') ? 'active' : '' }}">
                <a href="general">
                    <i class="material-icons">apps</i>
                    <p>Vista General</p>
                </a>
            </li>
            <li class="{{ Request::is('tracking-panel/map') ? 'active' : '' }}">
                <a href="map">
                    <i class="material-icons">map</i>
                    <p>Mapa</p>
                </a>
            </li>
            <li class="{{ Request::is('tracking-panel/charts') ? 'active' : '' }}">
                <a href="charts">
                    <i class="material-icons">timeline</i>
                    <p>Graficos</p>
                </a>
            </li>
            <li class="{{ Request::is('tracking-panel/vehicles') ? 'active' : '' }}">
                <a href="vehicles">
                    <i class="material-icons">directions_car</i>
                    <p>Vehiculos</p>
                </a>
            </li>
        </ul>
    </div>
</div>