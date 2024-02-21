<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>

        <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="sidebar-item {{ request()->routeIs('loan.*') ? 'active' : '' }}">
            <a href="{{ route('loan.index') }}" class='sidebar-link'>
                <i class="bi bi-collection-fill"></i>
                <span>Peminjaman</span>
            </a>
        </li>

        @if (Auth::user()->role_id == 1)
            <li class="sidebar-item {{ request()->routeIs('vehicle.*') ? 'active' : '' }}">
                <a href="{{ route('vehicle.index') }}" class='sidebar-link'>
                    <i class="bi bi-collection-fill"></i>
                    <span>Kendaraan</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('vehicle-origin.*') ? 'active' : '' }}">
                <a href="{{ route('vehicle-origin.index') }}" class='sidebar-link'>
                    <i class="bi bi-collection-fill"></i>
                    <span>Jenis Kendaraan</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('vehicle-type.*') ? 'active' : '' }}">
                <a href="{{ route('vehicle-type.index') }}" class='sidebar-link'>
                    <i class="bi bi-collection-fill"></i>
                    <span>Tipe Kendaraan</span>
                </a>
            </li>

            <li class="sidebar-title">Pengaturan</li>

            <li class="sidebar-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class='sidebar-link'>
                    <i class="bi bi-journal-check"></i>
                    <span>Pengguna</span>
                </a>
            </li>
        @endif
    </ul>
</div>
