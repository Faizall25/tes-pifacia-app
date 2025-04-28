<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Management System') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Management
    </div>

    <!-- Nav Item - Projects -->
    <li class="nav-item {{ Route::is('projects.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('projects.index') }}">
            <i class="fas fa-fw fa-project-diagram"></i>
            <span>Projects</span>
        </a>
    </li>

    <!-- Nav Item - Tasks -->
    <li class="nav-item {{ Route::is('tasks.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('tasks.index') }}">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Tasks</span>
        </a>
    </li>

    <!-- Nav Item - Comments -->
    <li class="nav-item {{ Route::is('comments.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('comments.index') }}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Comments</span>
        </a>
    </li>

    @if (auth()->check() && auth()->user()->role && auth()->user()->role->name === 'Administrator')
        <!-- Nav Item - Roles -->
        <li class="nav-item {{ Route::is('roles.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('roles.index') }}">
                <i class="fas fa-fw fa-user-tag"></i>
                <span>Role Management</span>
            </a>
        </li>

        <!-- Nav Item - Users -->
        <li class="nav-item {{ Route::is('users.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>User Management</span>
            </a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->