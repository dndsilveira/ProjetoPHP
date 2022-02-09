<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="content-type" content="application/vnd.ms-Excel; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Solução Sistemas | <?php echo $titulo; ?></title>

  <base href="http://solucaosistemasctdv.ddns.net:8081/" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

  <link rel="stylesheet" href="dist/css/pages/allModals.css">

  <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <link rel="icon" type="image/png" href="dist/img/AdminLTELogo.png"/>

  <!-- CSS PARA A PÁGINA DESTINADA -->
  <?php

  if (!empty($arquivo)) {
    echo '<link rel="stylesheet" href="dist/css/pages/'.$arquivo.'.css">';
  }

  unset($arquivo);

  ?>
  
</head>

<?php

if ($_SESSION['tema'] == 'branco') {
  ?>

<style>
  input:-webkit-autofill,
  input:-webkit-autofill:hover, 
  input:-webkit-autofill:focus, 
  input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px rgba(0, 0, 0, 0) inset !important;
    transition: background-color 5000s ease-in-out 0s;
    font-size: 1rem !important;
    font-weight: 400 !important;
    font-family: inherit !important;
  }
</style>

<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="font-family: Roboto !important;">

  <?php
}

else {
  ?>

<style>
  input:-webkit-autofill,
  input:-webkit-autofill:hover, 
  input:-webkit-autofill:focus, 
  input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px rgba(0, 0, 0, 0) inset !important;
    -webkit-text-fill-color: #fff !important;
    border-color: #6c757d !important;
    transition: background-color 5000s ease-in-out 0s;
    font-size: 1rem !important;
    font-weight: 400 !important;
    font-family: inherit !important;
  }
</style>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="font-family: Roboto !important;">

  <?php
}

?>
<div class="wrapper">

  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="Solução Sistemas" height="60" width="60">
  </div>

  <?php

  if ($_SESSION['tema'] == 'branco') {
    ?>
  <nav class="main-header navbar navbar-expand navbar-light">
    <?php
  }

  else {
    ?>
  <nav class="main-header navbar navbar-expand navbar-dark">
    <?php
  }

  ?>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="http://solucaosistemasctdv.ddns.net:8081" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="ajuda" class="nav-link">Ajuda</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" role="button" onclick="trocarTema()">
        <form method="POST">
          <input type="submit" id="trocarTema" name="trocarTema" hidden />
          <i class="fas fa-adjust"></i>
        </form>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php" role="button">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>

  <?php

  if ($_SESSION['tema'] == 'branco') {
    ?>
  <aside class="main-sidebar sidebar-light-primary elevation-4" id="navbar-left-id">
    <?php
  }

  else {
    ?>
  <aside class="main-sidebar sidebar-dark-primary elevation-4" id="navbar-left-id">
    <?php
  }

  ?>
    <a href="http://solucaosistemasctdv.ddns.net:8081" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light" style="font-size: 18px;">Solução Sistemas</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/default-profile.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block" style="font-size: 18px;"><?php echo $primeironome; ?></a>
        </div>
      </div>

      <div class="form-inline nav-responsive1">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
               <a href="pedidos" class="nav-link">
               <i class="nav-icon fas fa-clipboard-check"></i>
               <p>
                  Pedidos
               </p>
               </a>
            </li>
            <!--
            <li class="nav-item">
               <ul class="nav nav-treeview">
               <li class="nav-item">
                  <a href="promocoes" class="nav-link">
                     <i class="far fa-circle nav-icon"></i>
                     <p>Produtos em promoção</p>
                  </a>
               </li>
               </ul>
            </li>
            -->
            <li class="nav-item">
               <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-shopping-basket"></i>
                  <p>
                  Produtos
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="produtos" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cadastros</p>
                     </a>
                  </li>
               </ul>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="saidasprodutos" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Saídas</p>
                     </a>
                  </li>
               </ul>
            </li>
            <!--<li class="nav-item">
               <a href="clientes" class="nav-link">
               <i class="nav-icon fas fa-users"></i>
               <p>
                  Clientes
               </p>
               </a>
            </li>-->
            <li class="nav-item">
               <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                     Clientes
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="clientes" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cadastros</p>
                     </a>
                  </li>
               </ul>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="saidascliente" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Saídas</p>
                     </a>
                  </li>
               </ul>
               <!--
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="debitoscliente" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Débitos</p>
                     </a>
                  </li>
               </ul>
               -->
            </li>
            <!--
            <li class="nav-item">
               <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-file-invoice-dollar"></i>
                  <p>
                     Relatórios
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="vendasvendedor" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Vendas e comissões</p>
                     </a>
                  </li>
               </ul>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="saidascliente" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Vendas ABC geral</p>
                     </a>
                  </li>
               </ul>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="recebimentos" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Recebimentos</p>
                     </a>
                  </li>
               </ul>
            </li>
            -->
            <li class="nav-item">
               <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-chart-line"></i>
                  <p>
                     Gráficos
                     <i class="right fas fa-angle-left"></i>
                  </p>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="grafico-ticketmedio" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Ticket médio mês a mês</p>
                     </a>
                  </li>
               </ul>

         <!--<li class="nav-item">
            <a href="saidascliente" class="nav-link">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>
               Saídas por cliente
              </p>
            </a>
         </li>-->
        </ul>
      </nav>
    </div>
  </aside>