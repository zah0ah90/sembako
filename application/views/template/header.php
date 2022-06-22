<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IKA STORE</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('asset/') ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('asset/') ?>dist/css/adminlte.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('asset/') ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">


    <!-- jQuery -->
    <script src="<?= base_url('asset/') ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('asset/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('asset/') ?>dist/js/adminlte.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="<?= base_url('asset/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>

    <script src="<?= base_url('asset/') ?>dist/js/jquery.validate.min.js"></script>
    <style>
    .error {
        color: red;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <!-- <i class="far fa-profile"></i> -->
                        <i class="fa fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                        <a href="<?= base_url('auth/logout') ?>" class="dropdown-item">
                            <i class="fa fa-sign-out"></i> Log out

                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url() ?>" class="brand-link text-center">
                <!-- <img src="<?= base_url('asset/') ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8"> -->
                <i class="fas fa-info"></i>
                <span class="brand-text font-weight-light">IKA STORE</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="<?= base_url('dashboard') ?>" class="nav-link">
                                <!-- <i class="nav-icon fas fa-th"> </i> -->
                                <!-- <i class="fa fa-tachometer nav-icon"></i> -->
                                <i class="fa fa-file nav-icon"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <?php if ($this->session->userdata('nama') == 'admin') {  ?>
                        <li class="nav-item">
                            <a href="<?= base_url('transaksi') ?>" class="nav-link">
                                <!-- <i class="nav-icon fas fa-th"></i> -->
                                <i class="fa fa-shopping-cart nav-icon"></i>
                                <p>
                                    Penjualan
                                </p>
                            </a>
                        </li>
                        <?php } ?>

                        <li class="nav-item">
                            <a href="<?= base_url('transaksi/history') ?>" class="nav-link">
                                <!-- <i class="nav-icon fas fa-th"></i> -->
                                <!-- <i class="fa fa-sticky-note nav-icon"></i> -->
                                <i class="fa fa-book nav-icon"></i>
                                <p>
                                    History Penjualan
                                </p>
                            </a>
                        </li>

                        <?php if ($this->session->userdata('nama') == 'admin') {  ?>
                        <li class="nav-item">
                            <a href="<?= base_url('sembako') ?>" class="nav-link">
                                <!-- <i class="nav-icon fas fa-th"></i> -->
                                <i class="fa fa-archive nav-icon"></i>
                                <p>
                                    Sembako
                                </p>
                            </a>
                        </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a href="<?= base_url('sembako/history') ?>" class="nav-link">
                                <!-- <i class="nav-icon fas fa-th"></i> -->
                                <i class="fa fa-sticky-note nav-icon"></i>
                                <p>
                                    History Sembako
                                </p>
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