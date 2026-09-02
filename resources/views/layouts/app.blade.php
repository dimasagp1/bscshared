<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Super Apps BSC' }} - PT Herbatech Innopharma</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Theme style (AdminLTE v3) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    @livewireStyles
    <style>
        .brand-text-custom {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .badge-tercapai { background-color: #28a745; color: white; }
        .badge-waspada { background-color: #ffc107; color: #1f2d3d; }
        .badge-dibawah { background-color: #dc3545; color: white; }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-teal">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('dashboard') }}" class="nav-link active">Super Apps BSC Hop 4</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-calendar-alt mr-1"></i> Periode Aktif: <strong>2026-08</strong>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" title="User Profile">
                    <i class="fas fa-user-circle"></i> Super Admin
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-teal elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link bg-teal">
            <i class="fas fa-chart-line brand-image img-circle elevation-3 p-2 bg-white text-teal"></i>
            <span class="brand-text brand-text-custom">SuperApps BSC</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <div class="img-circle elevation-2 bg-info text-center text-white" style="width: 34px; height: 34px; line-height: 34px; font-weight: bold;">
                        SA
                    </div>
                </div>
                <div class="info">
                    <a href="#" class="d-block">Administrator BSC</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-header">KONSOLIDASI KINERJA</li>
                    
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Piramida BSC</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('financial-ratios') }}" class="nav-link {{ request()->routeIs('financial-ratios') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-coins"></i>
                            <p>Rasio Keuangan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('department-objectives') }}" class="nav-link {{ request()->routeIs('department-objectives') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bullseye"></i>
                            <p>Objective Departemen</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('action-plans') }}" class="nav-link {{ request()->routeIs('action-plans') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Program Kerja (Action)</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('bsc-wiring') }}" class="nav-link {{ request()->routeIs('bsc-wiring') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-project-diagram"></i>
                            <p>Wiring / Peta Hubungan</p>
                        </a>
                    </li>

                    <li class="nav-header">INTEGRASI & AUDIT</li>

                    <li class="nav-item">
                        <a href="{{ route('system-integration') }}" class="nav-link {{ request()->routeIs('system-integration') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-plug"></i>
                            <p>Integrasi & Gateway</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('staging-logs') }}" class="nav-link {{ request()->routeIs('staging-logs') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-network-wired"></i>
                            <p>Staging & Audit Log</p>
                        </a>
                    </li>

                    <li class="nav-header">ADMINISTRASI</li>

                    <li class="nav-item">
                        <a href="{{ route('manage-users') }}" class="nav-link {{ request()->routeIs('manage-users') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Manage User</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('settings') }}" class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Setting</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{ $slot }}
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            Version 1.0 (Basic Livewire)
        </div>
        <strong>PT Herbatech Innopharma &copy; 2026 <a href="#">Super Apps BSC Hop 4</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@livewireScripts
</body>
</html>
