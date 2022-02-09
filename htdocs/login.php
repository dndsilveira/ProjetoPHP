<?php

session_start();

require '../app/config.php';

if (!isset($_SESSION['usuario'])) {

	if (isset($_POST['usuario']) && !empty($_POST['usuario'])) {

		$usuario = addslashes(strtoupper($_POST['usuario']));
		$senha = strtoupper($_POST['senha']);
      $sNova = '';

      for ($i=0; $i < strlen($senha); $i++) { 
         $iResp = ord($senha[$i]);
         $iResp = $iResp * 4;
         $iResp = $iResp * 10;
         $iResp = str_pad($iResp , 10 , 0 , STR_PAD_LEFT);
         $sNova = $sNova.$iResp;
      }

		$sql = $pdo->prepare("SELECT Id, Ativo FROM usuarios WHERE Usuario = :usuario AND Senha = :senha");
		$sql->bindValue(":usuario", $usuario);
		$sql->bindValue(":senha", $sNova);
		$sql->execute();
      $dadosLogin = $sql->fetch();

		if ($sql->rowCount() > 0) {

         if ($dadosLogin['Ativo'] == 'S') {
            $_SESSION['usuario'] = $dadosLogin['Id'];
            $_SESSION['tema'] = "branco";
            header("Location: http://solucaosistemasctdv.ddns.net:8081");
         }

         else {
            $_SESSION['usuario_inativo'] = true;
            header("Location: login");
            exit;
         }

         }

         else {

         if (empty($_POST['senha'])) {
            $_SESSION['nao_autenticado'] = true;
            header("Location: login");
            exit;
         }

         else {
            $_SESSION['nao_autenticado'] = true;
            header("Location: login");
            exit;
         }
		}

	}

}

else {

	header("Location: home");

}

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

  <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

  <link rel="icon" type="image/png" href="dist/img/AdminLTELogo.png"/>
</head>

<script>

$(document).ready(function(){

document.getElementById('usuario').focus();

});

</script>

<body style="background-color: #212529;" class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
        <?php

        if ($_SESSION['database'] == 'MZ') {
            ?>
            <img src="dist/img/LogoMZ.png" class="solucao-logo-login">
            <h1>M&Z</h1>
            <?php
        }

        elseif ($_SESSION['database'] == 'CONSTRUMONTE') {
            ?>
            <img src="dist/img/LogoConstrumonte.png" class="solucao-logo-login">
            <h1>Construmonte</h1>
            <?php
        }

        else {
            ?>
            <img src="dist/img/SolucaoLogo.png" class="solucao-logo-login">
            <h1>Solução Sistemas</h1>
            <?php
        }

        ?>
    </div>
    <div class="card-body">
    <form method="POST">
      	<?php
			if (isset($_SESSION['nao_autenticado'])) {
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
          title: 'Falha ao acessar, preencha seus dados corretamente.'
        })
        </script>
				";

      unset($_SESSION['nao_autenticado']);
			}

      if (isset($_SESSION['usuario_inativo'])) {
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
          title: 'Falha ao acessar, o usuário encontra-se inativo.'
        })
        </script>
        ";

      unset($_SESSION['usuario_inativo']);

      }
        ?>
				<div class="input-group mb-3">
	        <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuário" required>
	        <div class="input-group-append">
	          <div class="input-group-text">
	            <span class="fas fa-user"></span>
	          </div>
	        </div>
	      </div>
	      <div class="input-group mb-3">
	        <input type="password" class="form-control" name="senha" placeholder="Senha" required>
	        <div class="input-group-append">
	          <div class="input-group-text">
	            <span class="fas fa-lock"></span>
	          </div>
	        </div>
	      </div>
	      <div class="row">
	        <!-- /.col -->
	        <div class="col-12">
	          <button type="submit" class="btn btn-dark btn-block">Entrar</button>
	        </div>
	        <!-- /.col -->
	      </div>
	</form>

      <!-- <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->
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