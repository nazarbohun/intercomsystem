<nav class="sb-topnav navbar navbar-expand navbar-light">
    <a class="navbar-brand pl-0 ml-3" href="{{ route('dashboard') }}">Intercom System</a>
    <!-- Boorger button-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 " id="sidebarToggle" href="#"><i class="fas fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto ">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown"
               href="#" role="button"  data-bs-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <strong>Ви увійшли як: </strong>{{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <div class="sb-nav-link-icon"></div>
                    Вихід
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

