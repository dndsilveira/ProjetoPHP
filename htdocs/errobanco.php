<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Solução Sistemas | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <script src="plugins/sweetalert2/sweetalert2.min.js"></script>

  <link rel="icon" type="image/png" href="dist/img/AdminLTELogo.png"/>
</head>
<body style="background-color: #212529;" class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img src="dist/img/SolucaoLogo.png" class="solucao-logo-login">
      <h1>Solução Sistemas</h1>
    </div>
    <div class="card-body">
      	<?php
	    if (isset($_SESSION['openErrorModal'])) {

        echo "
        <script>
        var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
        });
        Toast.fire({
        icon: 'error',
        title: '".$_SESSION['openErrorModal']."'
        })
        </script>
        ";

        unset($_SESSION['openErrorModal']);

	    }

      ?>
      <!-- /.social-auth-links -->
        <div class='text-center'>
          Erro ao acessar o banco de dados.
          <a class='btn btn-success btn-sm' style="margin-top: 15px;" href="http://solucaosistemasctdv.ddns.net:8081"><i class='fas fa-undo-alt'></i> Voltar</a>
        </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- Page specific script -->

</body>
</html>

<?php

echo "Ocorreu um erro ao conectar-se ao banco de dados.";

?>