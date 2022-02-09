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
   case 'tabCliente':

$codigoTab = $_POST['codigoTab'];

$sql = $pdo->prepare("SELECT codigo FROM cliente WHERE codigo = :codigo AND Inativo = 'N'");
$sql->bindValue(":codigo", $codigoTab);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

   $sql = $pdo->prepare("SELECT codigo, nome FROM cliente WHERE codigo = :codigo AND Inativo = 'N'");
   $sql->bindValue(":codigo", $codigoTab);
   $sql->execute();

   $linha = $sql->fetch();

   $complemento = "";

   ?>

   <script>

   document.getElementById('nomeCliente').value = "<?php echo $linha['nome']; ?>";

   if ($('#vendaDevolucao').is(':checked')) {
      <?php

      $complemento = " AND (Venda = 'S' OR Devolucao = 'S') ";

      ?>
   }

   </script>

   <?php

   $sql = $pdo->prepare("SELECT EnderecoCliente FROM Movimento WHERE CodigoCliente = :codigo".$complemento."GROUP BY EnderecoCliente , NomeCidadeCliente");
   $sql->bindValue(":codigo", $codigoTab);
   $sql->execute();

   $resultEndereco = $sql->fetchAll();

   if ($resultEndereco != false) {

      ?>

      <script>

      while (document.getElementById("enderecoObra").options.length > 0) {
         document.getElementById("enderecoObra").remove(0);
      }

      if (document.getElementById("enderecoObra").disabled == true) {
         document.getElementById("enderecoObra").disabled = false;
      }

      var opt = document.createElement('option');
      opt.value = '0';
      opt.innerHTML = '';

      document.getElementById("enderecoObra").appendChild(opt);

      </script>

      <?php

      foreach ($resultEndereco as $linhaEndereco) {
         
         ?>

         <script>

         var opt = document.createElement('option');
         opt.value = '<?php echo $linhaEndereco['EnderecoCliente']; ?>';
         opt.innerHTML = '<?php echo $linhaEndereco['EnderecoCliente']; ?>';

         document.getElementById("enderecoObra").appendChild(opt);

         </script>

         <?php

      }

   }

}

elseif ($codigoTab == '') {

   ?>

   <script>

   document.getElementById('nomeCliente').value = "";

   while (document.getElementById("enderecoObra").options.length > 0) {
      document.getElementById("enderecoObra").remove(0);
   }

   if (document.getElementById("enderecoObra").disabled == false) {
      document.getElementById("enderecoObra").disabled = true;
   }

   </script>

   <?php

}

elseif ($codigoTab == 0) {

   ?>

   <script>
   
   document.getElementById('nomeCliente').value = "CONSUMIDOR";

   while (document.getElementById("enderecoObra").options.length > 0) {
      document.getElementById("enderecoObra").remove(0);
   }

   if (document.getElementById("enderecoObra").disabled == false) {
      document.getElementById("enderecoObra").disabled = true;
   }

   </script>

   <?php

}

else {

?>

<script>

document.getElementById('filtroCliente').value = "";
document.getElementById('nomeCliente').value = "";
document.getElementById('filtroCliente').focus();

while (document.getElementById("enderecoObra").options.length > 0) {
   document.getElementById("enderecoObra").remove(0);
}

if (document.getElementById("enderecoObra").disabled == false) {
   document.getElementById("enderecoObra").disabled = true;
}

var Toast = Swal.mixin({
   toast: true,
   position: 'top-end',
   showConfirma: false,
   timer: 3000
});
Toast.fire({
   icon: 'error',
   title: 'Este cliente não foi encontrado ou está inativo.'
})

</script>

<?php

}

   break;

   case 'buscarCliente':

$nome = $_POST['nome'];

$sql = $pdo->prepare("SELECT Codigo, Nome, CNPJ, NomeCidade, Estado, Telefone, Apelido FROM cliente WHERE nome LIKE CONCAT ('%', :nome , '%') AND Inativo = 'N'");
$sql->bindValue(":nome", $nome);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

   foreach ($sql->fetchAll() as $linha) {
      echo "<tr class='text-center' style='line-height: 35px;'>";
      echo "<td scope='row'>".$linha['Codigo']."</td>";
      echo "<td>".$linha['Nome']."</td>";
      echo "<td>".$linha['CNPJ']."</td>";
      echo "<td>".$linha['NomeCidade']."</td>";
      echo "<td>".$linha['Estado']."</td>";
      echo "<td>".$linha['Telefone']."</td>";
      echo "<td>".$linha['Apelido']."</td>";

      echo "
      <td class='project-actions' style='width: 15%;'>
         <a class='btn btn-success btn-sm' onclick='incluirCliente(".$linha['Codigo'].")'><i class='fas fa-plus'></i> Selecionar</a>
      </td>";

      echo "</tr>";
   }

}

else {

   echo "<tr><td colspan='4' class='text-center'>Cliente não encontrado!</td></tr>";

}
   
   break;      

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