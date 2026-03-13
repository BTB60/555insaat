<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <div class="text-center mb-4 px-3">
            <h5 class="text-white mb-0">555 İnşaat</h5>
            <small class="text-white-50">İşçi İdarəetmə Sistemi</small>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </li>
            
            <li class="nav-item mt-3">
                <small class="text-white-50 px-3 text-uppercase" style="font-size: 0.7rem;">İdarəetmə</small>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}" href="{{ route('admin.employees.index') }}">
                    <i class="bi bi-people"></i>
                    İşçilər
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">
                    <i class="bi bi-building"></i>
                    Obyektlər
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.attendances.*') ? 'active' : '' }}" href="{{ route('admin.attendances.index') }}">
                    <i class="bi bi-calendar-check"></i>
                    Davamiyyət
                </a>
            </li>
            
            <li class="nav-item mt-3">
                <small class="text-white-50 px-3 text-uppercase" style="font-size: 0.7rem;">Maliyyə</small>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.salaries.*') ? 'active' : '' }}" href="{{ route('admin.salaries.index') }}">
                    <i class="bi bi-cash-stack"></i>
                    Maaşlar
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.advances.*') ? 'active' : '' }}" href="{{ route('admin.advances.index') }}">
                    <i class="bi bi-cash"></i>
                    Avanslar
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.fines.*') ? 'active' : '' }}" href="{{ route('admin.fines.index') }}">
                    <i class="bi bi-exclamation-triangle"></i>
                    Cərimələr
                </a>
            </li>
            
            <li class="nav-item mt-3">
                <small class="text-white-50 px-3 text-uppercase" style="font-size: 0.7rem;">Digər</small>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}" href="{{ route('admin.tasks.index') }}">
                    <i class="bi bi-list-task"></i>
                    Tapşırıqlar
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}" href="{{ route('admin.documents.index') }}">
                    <i class="bi bi-files"></i>
                    Fayllar
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                    <i class="bi bi-graph-up"></i>
                    Hesabatlar
                </a>
            </li>
            
            @if(auth()->user()->hasRole('super-admin'))
                <li class="nav-item mt-3">
                    <small class="text-white-50 px-3 text-uppercase" style="font-size: 0.7rem;">Ayarlar</small>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="#">
                        <i class="bi bi-person-gear"></i>
                        İstifadəçilər
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="#">
                        <i class="bi bi-gear"></i>
                        Ayarlar
                    </a>
                </li>
            @endif
        </ul>
        
        <div class="mt-auto pt-3 px-3">
            <div class="d-flex align-items-center text-white">
                <div class="flex-shrink-0">
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <small class="d-block">{{ auth()->user()->name ?? 'Admin' }}</small>
                    <small class="text-white-50">{{ auth()->user()->role ?? 'Admin' }}</small>
                </div>
            </div>
        </div>
    </div>
</nav>
