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
   case 'tabModalEmpresa':

$codigoTab = $_POST['codigoTab'];

$sql = $pdo->prepare("SELECT codigo FROM empresa WHERE codigo = :codigo");
$sql->bindValue(":codigo", $codigoTab);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

   $sql = $pdo->prepare("SELECT codigo, nomefantasia FROM empresa WHERE codigo = :codigo");
   $sql->bindValue(":codigo", $codigoTab);
   $sql->execute();

   $linha = $sql->fetch();

   ?>

   <script>
      
   document.getElementById('nomeModalEmpresa').value = "<?php echo $linha['nomefantasia']; ?>";

   </script>

   <?php

}

elseif ($codigoTab == '') {

?>

<script>

document.getElementById('nomeModalEmpresa').value = "";

</script>

<?php

}

else {

?>

<script>

document.getElementById('filtroModalEmpresa').value = "";
document.getElementById('nomeModalEmpresa').value = "";
document.getElementById('filtroModalEmpresa').focus();

var Toast = Swal.mixin({
   toast: true,
   position: 'top-end',
   showConfirma: false,
   timer: 3000
});

Toast.fire({
   icon: 'error',
   title: 'A empresa não foi encontrada ou está inativa.'
});

</script>

<?php

}

   break;

   case 'buscarVendedoresEmpresa':

$empresa = $_POST['empresa'];

if ($_SESSION['parametros']['verSomenteSuasVendas'] == 'S') {
   $sql = $pdo->prepare("SELECT Codigo, Nome FROM vendedores WHERE Usuario = :usuario");
   $sql->bindValue(":usuario", $info['Id']);
   $sql->execute();
}

else {

   if (TrataInt($empresa) > 0) {
      $sql = $pdo->prepare("SELECT Codigo, Nome FROM vendedores WHERE Empresa = :empresa");
      $sql->bindValue(":empresa", $empresa);
      $sql->execute();
   }
   
   else {
      $sql = $pdo->prepare("SELECT Codigo, Nome FROM vendedores");
      $sql->execute();
   }

}

$qtd = $sql->rowCount();

if($qtd>0) {

   if (isset($_SESSION['buscaRelatorioVendasPorVendedor']['vendedores']) && !empty($_SESSION['buscaRelatorioVendasPorVendedor']['vendedores'])) {
      $arrayVendedores = explode(", ", $_SESSION['buscaRelatorioVendasPorVendedor']['vendedores']);
   
      foreach ($sql->fetchAll() as $linha) {
         echo "<tr class='text-center' style='line-height: 35px;'>";

            if (in_array($linha['Codigo'], $arrayVendedores)) {
               echo "<td><input type='checkbox' checked id=".$linha['Codigo']."></td>";
            }
            else {
               echo "<td><input type='checkbox' id=".$linha['Codigo']."></td>";
            }

            echo "<td scope='row'>".$linha['Codigo']."</td>";
            echo "<td>".$linha['Nome']."</td>";
   
         echo "</tr>";
      }

   }
   
   else {
    
      foreach ($sql->fetchAll() as $linha) {
         echo "<tr class='text-center' style='line-height: 35px;'>";
   
            echo "<td><input type='checkbox' id=".$linha['Codigo']."></td>";
            echo "<td scope='row'>".$linha['Codigo']."</td>";
            echo "<td>".$linha['Nome']."</td>";
   
         echo "</tr>";
      }

   }

}

else {

   echo "<tr><td colspan='4' class='text-center'>Vendedores não encontrados!</td></tr>";

}
   
   break;
    
   default:

   break;

}