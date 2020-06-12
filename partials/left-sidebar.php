<!-- Sidebar -->
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-text mx-3">Alianza</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Inicio</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Perfil
</div>

<!-- Nav Item -->
<li class="nav-item">
    <a class="nav-link" href="<?php url();?>">
        <i class="fas fa-fw fa-user"></i>
        <span>Mi Perfil</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

            <!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="<?php wp_login_url();?>">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Cerrar Sesión</span></a>
</li>

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->