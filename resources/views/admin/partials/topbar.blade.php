
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <button id="sidebarToggleTop"
            class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <h6 class="font-weight-bold text-primary mb-0">
        Admin Minimarket
    </h6>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown no-arrow">

            <a class="nav-link dropdown-toggle"
               href="#"
               id="userDropdown"
               role="button"
               data-toggle="dropdown">

                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->name }}
                </span>

                <i class="fas fa-user-circle fa-lg text-primary"></i>

            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">

                <a class="dropdown-item" href="{{ route('frontend') }}">
                    <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400"></i>
                    Halaman Frontend
                </a>

                <div class="dropdown-divider"></div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="dropdown-item">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </button>
                </form>

            </div>

        </li>

    </ul>

</nav>
