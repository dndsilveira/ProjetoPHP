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
   case 'tabProduto':

$codigoTab = $_POST['codigoTab'];

$sql = $pdo->prepare("SELECT codigo FROM material WHERE codigo = :codigo AND Ativo = 'S'");
$sql->bindValue(":codigo", $codigoTab);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

   // $sql = $pdo->prepare("SELECT codigo, nome, vendav, estoque, unidade FROM material WHERE codigo = :codigo AND Ativo = 'S'");
   $sql = $pdo->prepare("SELECT codigo, nome, vendav, unidade FROM material WHERE codigo = :codigo AND Ativo = 'S'");
   $sql->bindValue(":codigo", $codigoTab);
   $sql->execute();

   $linha = $sql->fetch();

   ?>

   <script>

   document.getElementById('nomeProduto').value = '<?php echo ValidaString($linha['nome']).' ('.$linha['unidade'].')'; ?>';

   </script>

   <?php

}

elseif ($codigoTab == '') {

?>

<script>

document.getElementById('nomeProduto').value = "";

</script>

<?php

}

else {

?>

<script>

document.getElementById('filtroProduto').value = "";
document.getElementById('nomeProduto').value = "";
document.getElementById('filtroProduto').focus();

var Toast = Swal.mixin({
   toast: true,
   position: 'top-end',
   showConfirma: false,
   timer: 3000
});
Toast.fire({
   icon: 'error',
   title: 'O produto não foi encontrado ou está inativo.'
})

</script>

<?php

}

   break;

   case 'buscarProduto':

$nome = $_POST['nome'];

$sql = $pdo->prepare("SELECT Codigo, Nome, Estoque FROM material WHERE nome LIKE CONCAT ('%', :nome , '%') AND Ativo = 'S'");
$sql->bindValue(":nome", $nome);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

   foreach ($sql->fetchAll() as $linha) {
      echo "<tr class='text-center' style='line-height: 35px;'>";
      echo "<td scope='row'>".$linha['Codigo']."</td>";
      echo "<td>".$linha['Nome']."</td>";
      echo "<td>".$linha['Estoque']."</td>";

      echo "
      <td class='project-actions' style='width: 15%;'>
         <a class='btn btn-success btn-sm' onclick='incluirProduto(".$linha['Codigo'].")'><i class='fas fa-plus'></i> Selecionar</a>
      </td>";

      echo "</tr>";
   }

}

else {

   echo "<tr><td colspan='4' class='text-center'>Produto não encontrado!</td></tr>";

}
   
   break;
    
   default:

   break;

}