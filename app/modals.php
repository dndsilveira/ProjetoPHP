<?php

// LOTE E LOCAL CADASTRO PRODUTO
if (!empty($_GET['id_produto_lotelocal']) && $_GET['func'] == 'lotelocal') {

	$sql = $pdo->prepare("SELECT Codigo FROM material WHERE Codigo = :codigo");
	$sql->bindValue(":codigo", $_GET['id_produto_lotelocal']);
	$sql->execute();

	if ($sql->rowCount() > 0) {
	?>
	
	<script>
		$(function(){
			$('#lotelocalModal').modal();
		});
	</script>

	<?php
	}
}

// EDIT ACERTO ESTOQUE
if (!empty($_GET['id_acerto_estoque']) && $_GET['func'] == 'edit') {

	$_SESSION['get_id_acerto_estoque'] = $_GET['id_acerto_estoque'];

	$sql = $pdo->prepare("SELECT Id FROM acertoestoque WHERE Id = :id");
	$sql->bindValue(":id", $_GET['id_acerto_estoque']);
	$sql->execute();

	if ($sql->rowCount() > 0) {
	?>
	
	<script>
		$(function(){
			$('#editModal').modal();
		});

		$(document).ready(function() {
			var paginaOperacao = 'carregarProdutos';

			var idAcertoEstoque = <?php echo $_SESSION['get_id_acerto_estoque']; ?>;

			$.ajax
				({
				//Configurações
				type: 'POST',//Método que está sendo utilizado.
				dataType: 'html',//É o tipo de dado que a página vai retornar.
				url: 'queryAjax/acertosDeEstoque.php',//Indica a página que está sendo solicitada.
				//função que vai ser executada assim que a requisição for enviada
				data: {idAcertoEstoque: idAcertoEstoque,
				paginaOperacao: paginaOperacao,},//Dados para consulta
				//função que será executada quando a solicitação for finalizada.
				success: function (msg)
				{
					$("#tableEdit").html(msg);
				}
			});
		});

	</script>

	<?php
	}
}

// DELETE ACERTO ESTOQUE
if (!empty($_GET['id_acerto_estoque']) && $_GET['func'] == 'del') {

	$sql = $pdo->prepare("SELECT Id FROM acertoestoque WHERE Id = :id");
	$sql->bindValue(":id", $_GET['id_acerto_estoque']);
	$sql->execute();

	if ($sql->rowCount() > 0) {
	?>
	
	<script>
		$(function(){
			$('#deleteModal').modal();
		});
	</script>

	<?php
	}
}

if (isset($_SESSION['openSuccessModal'])) {
  echo "
  <script>
  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
  Toast.fire({
    icon: 'success',
    title: '".$_SESSION['openSuccessModal']."'
  })
  </script>
  ";

unset($_SESSION['openSuccessModal']);
}

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

if (isset($_SESSION['openSuccessModal2'])) {
   echo "
   <script>
   $(function() {

      var Toast = Swal.mixin({
         toast: true,
         position: 'top-end',
         showConfirmButton: false,
         timer: 3000
      });

      $(document).Toasts('create', {
         class: 'bg-success',
         title: 'Sucesso!',
         subtitle: '',
         body: '".$_SESSION['openSuccessModal2']."'
      });

   });
   </script>
   ";
 
 unset($_SESSION['openSuccessModal2']);
 }

?>