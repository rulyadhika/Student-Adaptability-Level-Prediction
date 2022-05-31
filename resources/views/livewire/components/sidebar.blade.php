<ul class="navbar-nav bg-gray-900 sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-text mx-3">Data Mining</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Heading -->
    <div class="sidebar-heading">
        Data Management
    </div>

    <li class="nav-item {{ request()->is('data-training*') ? 'active' : '' }}">
        <a class="nav-link"
            href="{{ route('data-training') }}">
            <i class="fas fa-random"></i>
            <span>Data Training</span></a>
    </li>

    <div class="nav-item {{ request()->is('data-klasifikasi*') ? 'active' : '' }}">
        <a class="nav-link"
            href="{{ route('data-klasifikasi') }}">
            <i class="fab fa-hubspot"></i>
            <span>Klasifikasi Data</span></a>
    </div>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
