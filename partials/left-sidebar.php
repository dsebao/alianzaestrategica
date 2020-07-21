    <!-- Sidebar -->
    <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php url();?>/dashboard">
        <div class="sidebar-brand-text mx-3">Alianza</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?php url();?>/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Panel</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php

    //Obtengo las adhesiones de empresas del usuarios
    $empresas = UserData::inst()->empresas();
    $adhesion = UserData::inst()->adhesion();

    if($empresas || $adhesion) : ?>

    <!-- Heading -->
    <div class="sidebar-heading">
        ESQUEMAS
    </div>

    <!-- Nav Item -->
    <li class="nav-item">
        <a class="nav-link" href="<?php url();?>/dashboard/empresas/items">
            <i class="fas fa-fw fa-hand-paper"></i>
            <span>Items</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php url();?>/dashboard/presupuestos">
            <i class="fas fa-fw fa-scroll"></i>
            <span>Presupuestos</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php url();?>/dashboard/mensajes">
            <i class="fas fa-fw fa-inbox"></i>
            <span>Mensajes</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php url();?>/dashboard/empresas/usuarios">
            <i class="fas fa-fw fa-users"></i>
            <span>Usuarios</span>
        </a>
    </li>
        
    <?php endif;?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">


    <!-- Heading -->
    <div class="sidebar-heading">
        PERFIL
    </div>


    <!-- Nav Item -->
    <li class="nav-item">
        <a class="nav-link" href="<?php url();?>/dashboard/perfil">
            <i class="fas fa-fw fa-user"></i>
            <span>Mi Perfil</span>
        </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item">
        <a class="nav-link" href="<?php url();?>/dashboard/empresa">
            <i class="fas fa-fw fa-network-wired"></i>
            <span>Esquemas</span>
        </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item">
        <a class="nav-link" href="<?php url();?>/dashboard/perfil">
            <i class="fas fa-fw fa-wallet"></i>
            <span>Billetera</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

                <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo wp_logout_url(home_url());?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Cerrar Sesión</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    </ul>
    <!-- End of Sidebar -->