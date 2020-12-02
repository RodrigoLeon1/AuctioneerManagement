<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-hammer"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Remates <sup>Ise</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Remates
    </div>

    <li class="nav-item {{ request()->routeIs('orden-ventas.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-cash-register"></i>
            <span>Orden de venta</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Seleccione su opción:</h6>
                <a class="collapse-item" href="{{ route('orden-ventas.create') }}">Crear orden de venta</a>
                <a class="collapse-item" href="{{ route('orden-ventas.index') }}">Listar ordenes</a>
                <a class="collapse-item" href="{{ route('orden-ventas.filter') }}">Filtrar ordenes</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ request()->routeIs('proformas.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Proformas</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Seleccione su opción:</h6>
                <a class="collapse-item" href="{{ route('proformas.pre-create') }}">Crear proforma</a>
                <a class="collapse-item" href="{{ route('proformas.index') }}">Listar proformas</a>
                <a class="collapse-item" href="{{ route('proformas.filter') }}">Filtrar proformas</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ request()->routeIs('liquidaciones.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInvoices" aria-expanded="true" aria-controls="collapseInvoices">
            <i class="far fa-money-bill-alt"></i>
            <span>Liquidaciones</span>
        </a>
        <div id="collapseInvoices" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Seleccione su opción:</h6>
                <a class="collapse-item" href="{{ route('liquidaciones.create') }}">Crear liquidación cliente</a>
                <a class="collapse-item" href="{{ route('liquidaciones.create') }}">Crear liquidacion remitente</a>
                <a class="collapse-item" href="{{ route('liquidaciones.index') }}">Listar liquidaciones</a>
                <a class="collapse-item" href="{{ route('liquidaciones.create') }}">Filtrar liquidaciones</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Control
    </div>

    <li class="nav-item {{ request()->routeIs('productos.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Mercadería</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Seleccione su opción:</h6>
                <a class="collapse-item" href="{{ route('productos.index') }}">Listar mercadería</a>
                <a class="collapse-item" href="{{ route('productos.filter') }}">Filtrar mercadería</a>

                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Categorías:</h6>
                <a class="collapse-item" href="{{ route('categorias.create') }}">Crear categoría</a>
                <a class="collapse-item" href="{{ route('categorias.index') }}">Listar categorías</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="true" aria-controls="collapsePages2">
            <i class="fas fa-fw fa-folder"></i>
            <span>Usuarios</span>
        </a>
        <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Seleccione su opción:</h6>
                <a class="collapse-item" href="{{ route('usuarios.create') }}">Crear usuario</a>
                <a class="collapse-item" href="{{ route('usuarios.index') }}">Listar usuarios</a>
                <a class="collapse-item" href="{{ route('usuarios.filter') }}">Filtrar usuarios</a>
            </div>
        </div>
    </li>

    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3" aria-expanded="true" aria-controls="collapsePages3">
            <i class="fas fa-fw fa-folder"></i>
            <span>Eventos virtuales</span>
        </a>
        <div id="collapsePages3" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Seleccione su opción:</h6>
                <a class="collapse-item" href="">Listar productos</a>
                <a class="collapse-item" href="">Filtrar productos</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages4" aria-expanded="true" aria-controls="collapsePages4">
            <i class="fas fa-fw fa-folder"></i>
            <span>Productos públicos</span>
        </a>
        <div id="collapsePages4" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Seleccione su opción:</h6>
                <a class="collapse-item" href="">Listar productos</a>
                <a class="collapse-item" href="">Filtrar productos</a>
            </div>
        </div>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>