<!-- Logo -->
<div class="logo">
    <div class="logo-img">
        <a href="{{ route('home') }}">
            <img src="/images/mannylogo.png" alt="Logo" />
        </a>
    </div>
</div>

<!-- Título -->
<h1 class="titulo">
    <a href="{{ route('home') }}">
        <span class="marca">MANNY</span> <span class="subtitulo">Maquinarias</span>
    </a>
</h1>

<!-- Navegación dinámica -->
<div class="actions">
    @auth
        @if(Auth::user()->isAdmin())
            <div>
                <a class="btn btn-primary" href="{{ route('maquinarias.create') }}">
                    Cargar maquina
                </a>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('employees.index') }}">
                    Gestionar Empleados
                </a>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('estadisticas') }}">
                    Ver estadísticas
                </a>
            </div>

        @endif
        @if(Auth::user()->isEmployee())
            <div>
                <a class="btn btn-primary" href="{{ route('reservas.historial') }}">
                    Historial de reservas
                </a>
            </div>
        @endif
        <!-- Usuario AUTENTICADO - Dropdown -->
        <div class="user-dropdown" x-data="{ open: false }" x-on:click.outside="open = false">
            <button @click="open = !open" class="user-button" type="button">
                <div class="user-avatar">
                    <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Usuario" />
                </div>
                <span class="user-name">{{ Auth::user()->name }}</span>
                <svg class="dropdown-arrow" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Dropdown Menu - OCULTO por defecto -->
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="dropdown-menu"
                 style="display: none;"
                 x-cloak>

                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Mi perfil
                </a>

                <a href="{{ url('/profile#cambiar-clave') }}" class="dropdown-item">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Cambiar contraseña
                </a>

                <a href="{{ url('/profile#reservas') }}" class="dropdown-item">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Mis reservas
                </a>


                <hr class="dropdown-divider">

                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="button" class="dropdown-item logout-btn" onclick="confirmarCierreSesion()">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    @else
        <!-- Usuario NO AUTENTICADO -->
        <a href="{{ route('login') }}">Iniciar sesión</a>
        <a href="{{ route('register') }}">Registrarse</a>
    @endauth
</div>
</header>
<div id="modal-confirmacion" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Cerrar sesión</h4>
        </div>
        <div class="modal-body">
            <p>¿Está seguro que desea cerrar sesión?</p>
        </div>
        <div class="modal-footer">
            <button id="btn-cancelar" class="btn-secundario">Cancelar</button>
            <button id="btn-confirmar" class="btn-primario">Confirmar</button>
        </div>
    </div>
</div>


</style>

<script>
    function confirmarCierreSesion() {
        const modal = document.getElementById('modal-confirmacion');
        modal.style.display = 'flex';

        document.getElementById('btn-cancelar').addEventListener('click', function() {
            modal.style.display = 'none';
        });

        document.getElementById('btn-confirmar').addEventListener('click', function() {
            document.getElementById('logout-form').submit();
        });
    }
    // Verificar si Alpine detecta el click
    document.querySelector('.user-button').addEventListener('click', () => {
        console.log('Click detectado');
    });
</script>
