<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 py-3" href="{{ route('admin.dashboard') }}">
        <i class="bi bi-building me-2"></i>555 İnşaat
    </a>
    
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="w-100"></div>
    
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle px-3 text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2"></i>{{ auth()->user()->name ?? 'Admin' }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-person me-2"></i>Profil
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-gear me-2"></i>Ayarlar
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Çıxış
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
