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

   </script>

   <?php

}

elseif ($codigoTab == '') {

   ?>

   <script>

   document.getElementById('nomeCliente').value = "";

   </script>

   <?php

}

elseif ($codigoTab == 0) {

   ?>

   <script>
   
   document.getElementById('nomeCliente').value = "CONSUMIDOR";

   </script>

   <?php

}

else {

?>

<script>

document.getElementById('filtroCliente').value = "";
document.getElementById('nomeCliente').value = "";
document.getElementById('filtroCliente').focus();

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

   case 'tabUsuario':

$codigoTab = $_POST['codigoTab'];

$sql = $pdo->prepare("SELECT Id FROM Usuarios WHERE Id = :id AND Ativo = 'S'");
$sql->bindValue(":id", $codigoTab);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

   // $sql = $pdo->prepare("SELECT codigo, nome, vendav, estoque, unidade FROM material WHERE codigo = :codigo AND Ativo = 'S'");
   $sql = $pdo->prepare("SELECT Id, Usuario FROM Usuarios WHERE Id = :id AND Ativo = 'S'");
   $sql->bindValue(":id", $codigoTab);
   $sql->execute();

   $linha = $sql->fetch();

   ?>

   <script>

   document.getElementById('nomeUsuario').value = '<?php echo ValidaString($linha['Usuario']); ?>';

   </script>

   <?php

}

elseif ($codigoTab == '') {

?>

<script>

document.getElementById('nomeUsuario').value = "";

</script>

<?php

}

else {

?>

<script>

document.getElementById('filtroUsuario').value = "";
document.getElementById('nomeUsuario').value = "";
document.getElementById('filtroUsuario').focus();

var Toast = Swal.mixin({
   toast: true,
   position: 'top-end',
   showConfirma: false,
   timer: 3000
});
Toast.fire({
   icon: 'error',
   title: 'O usuário não foi encontrado ou está inativo.'
})

</script>

<?php

}

   break;

   case 'buscarUsuario':

$nome = $_POST['nome'];

$sql = $pdo->prepare("SELECT Id, Usuario FROM Usuarios WHERE Usuario LIKE CONCAT ('%', :nome , '%') AND Ativo = 'S'");
$sql->bindValue(":nome", $nome);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

   foreach ($sql->fetchAll() as $linha) {
      echo "<tr class='text-center' style='line-height: 35px;'>";
      echo "<td scope='row'>".$linha['Id']."</td>";
      echo "<td>".$linha['Usuario']."</td>";

      echo "
      <td class='project-actions' style='width: 15%;'>
         <a class='btn btn-success btn-sm' onclick='incluirUsuario(".$linha['Id'].")'><i class='fas fa-plus'></i> Selecionar</a>
      </td>";

      echo "</tr>";
   }

}

else {

   echo "<tr><td colspan='4' class='text-center'>Usuário não encontrado!</td></tr>";

}
   
   break;

   default:

   break;

}