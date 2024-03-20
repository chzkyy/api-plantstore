<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.index') }}">
        <div class="sidebar-brand-text mx-3">Portfolio</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item ">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="{{ route('dashboard.project') }}">
            <i class="fas fas fa-folder-open"></i>
            <span>Project</=>
        </a>
    </li>

    {{--  <li class="nav-item {{ $title === 'Experience' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('experience.index') }}">
            <i class="fas fa-tasks"></i>
            <span>Experience</span>
        </a>
    </li>  --}}

    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
