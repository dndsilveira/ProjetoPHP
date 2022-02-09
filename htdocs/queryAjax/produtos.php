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
  case 'buscarProduto':

$nome = $_POST['nome'];

$sql = $pdo->prepare("SELECT Codigo, Nome, Estoque, Reserva FROM material WHERE nome LIKE CONCAT ('%', :nome , '%') AND Ativo = 'S'");
$sql->bindValue(":nome", $nome);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

  foreach ($sql->fetchAll() as $linha) {
    echo "<tr class='text-center' style='line-height: 35px;'>";
      echo "<td scope='row'>".$linha['Codigo']."</td>";
      echo "<td>".$linha['Nome']."</td>";
      echo "<td>".$linha['Estoque']."</td>";
      echo "<td>".$linha['Reserva']."</td>";

      echo "
      <td class='project-actions text-center' style='width: 15%;'>
        <a class='btn btn-info btn-sm desktop' href='produtos/edit/".$linha['Codigo']."'><i class='fas fa-pencil-alt'></i> Editar</a>
        <a class='btn btn-danger btn-sm desktop' href='produtos/delete/".$linha['Codigo']."'><i class='fas fa-trash'></i> Excluir</a>

        <a class='btn btn-info btn-sm mobile' href='produtos/edit/".$linha['Codigo']."'><i class='fas fa-pencil-alt'></i></a>
        <a class='btn btn-danger btn-sm mobile' href='produtos/delete/".$linha['Codigo']."'><i class='fas fa-trash'></i></a>
      </td>";

    echo "</tr>";
  }

}

else {

  echo "<tr><td colspan='5' class='text-center'>Produto não encontrado!</td></tr>";

}
  
  break;
  
  default:
  

  break;
}