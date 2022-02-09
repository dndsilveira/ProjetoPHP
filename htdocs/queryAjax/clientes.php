<?php

session_start();

require '../../app/config.php';

// VERIFICAÇÕES INICIAIS 

require '../../app/verif.php';

// FORMULÁRIOS

require '../../app/forms.php';

// FUNCTIONS

include_once '../../app/functions.php';

$paginaOperacao = $_POST['paginaOperacao'];

switch ($paginaOperacao) {
   case 'buscarCidade':

$nome = $_POST['nome'];

$sql = $pdo->prepare("SELECT Id, NomeCidade, Estado FROM cidade WHERE nomecidade LIKE CONCAT ('%', :nome , '%')");
$sql->bindValue(":nome", $nome);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

   foreach ($sql->fetchAll() as $linha) {
      echo "<tr class='text-center' style='line-height: 35px;'>";
      echo "<td scope='row'>".$linha['Id']."</td>";
      echo "<td>".$linha['NomeCidade']."</td>";
      echo "<td>".$linha['Estado']."</td>";

      echo "
      <td class='project-actions' style='width: 15%;'>
         <a class='btn btn-success btn-sm' onclick='incluirCidade(".$linha['Id'].")'><i class='fas fa-plus'></i> Selecionar</a>
      </td>";

      echo "</tr>";
   }

}

else {

   echo "<tr><td colspan='4' class='text-center'>Cidade não encontrada!</td></tr>";

}
   
   break;

   case 'tabCidade':

$codigoTab = $_POST['codigoTab'];

$sql = $pdo->prepare("SELECT id FROM cidade WHERE id = :codigo");
$sql->bindValue(":codigo", $codigoTab);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

   $sql = $pdo->prepare("SELECT id, nomecidade, estado FROM cidade WHERE id = :codigo");
   $sql->bindValue(":codigo", $codigoTab);
   $sql->execute();

   $linha = $sql->fetch();

   ?>

   <script>

   document.getElementById('nomeCidade').value = "<?php echo $linha['nomecidade']; ?>";
   document.getElementById('estado').value = "<?php echo $linha['estado']; ?>";

   </script>

   <?php

}

elseif ($codigoTab == '') {

}

else {

?>

<script>

document.getElementById('codigoCidade').value = "";
document.getElementById('nomeCidade').value = "";
document.getElementById('estado').value = "";
document.getElementById('codigoCidade').focus();

var Toast = Swal.mixin({
   toast: true,
   position: 'top-end',
   showConfirma: false,
   timer: 3000
});
Toast.fire({
   icon: 'error',
   title: 'Esta cidade não foi encontrada ou está inativa.'
})

</script>

<?php

}

   break;
  
   default:
   
   break;
   
}