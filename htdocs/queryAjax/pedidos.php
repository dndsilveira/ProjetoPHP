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
    case 'abrirExpedicao':

$_SESSION['expedicao'] = array();

for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 
    
    $_SESSION['expedicao'][$i]['codigo'] = $_SESSION['carrinho']['produtos'][$i]['codigo'];
    $_SESSION['expedicao'][$i]['nome'] = $_SESSION['carrinho']['produtos'][$i]['nome'];
    $_SESSION['expedicao'][$i]['quantidade'] = $_SESSION['carrinho']['produtos'][$i]['quantidade'];

}

?>

<script>

$(".expedicaoClass").load(location.href + " .expedicaoClass");

</script>

<?php

    break;

  case 'buscarOrcamentos':

$dataInicio = date('Y/m/d', strtotime($_POST['dataInicio']));
$dataFinal = date('Y/m/d', strtotime($_POST['dataFinal']));

$sSQL = "";
$sSQL1 = "";
$sSQL2 = "";
$sSQL3 = "";

if (isset($_POST['vendedor']) && !empty($_POST['vendedor'])) {
  $vendedor = $_POST['vendedor'];
}

else {
  $vendedor = null;
}

if (isset($_POST['pedido']) && !empty($_POST['pedido'])) {
  $pedido = $_POST['pedido'];
}

else {
  $pedido = null;
}

if (isset($_POST['cliente']) && !empty($_POST['cliente'])) {
  $cliente = $_POST['cliente'];
}

else {
  $cliente = null;
}

$sSQL1 = "SELECT Id, Data, Horas, NomeCliente, Numero, Usuario, Total FROM Orcamentos WHERE Data >= :datainicio AND Data <= :datafinal";

if ($vendedor != null) {
  $sSQL2 = $sSQL2." AND Usuario LIKE CONCAT ('%', :vendedor , '%') ";
}

if ($pedido != null) {
  $sSQL2 = $sSQL2." AND Numero = :numero ";
}

if ($cliente != null) {
  $sSQL2 = $sSQL2." AND NomeCliente LIKE CONCAT ('%', :cliente , '%') ";
}

$sSQL3 = " AND PedidoOrcamento <> 'E' AND PedidoOrcamento <> 'B'  AND PedidoOrcamento <> 'F' AND PedidoOrcamento <> 'X' AND PedidoOrcamento <> 'S' ORDER BY Data ASC";

$sSQL = $sSQL1.$sSQL2.$sSQL3;

$sql = $pdo->prepare($sSQL);
$sql->bindValue(":datainicio", $dataInicio);
$sql->bindValue(":datafinal", $dataFinal);
if ($vendedor != null) {
  $sql->bindValue(":vendedor", $vendedor);
}
if ($pedido != null) {
  $sql->bindValue(":numero", $pedido);
}
if ($cliente != null) {
  $sql->bindValue(":cliente", $cliente);
}
$sql->execute();

if ($sql->rowCount() > 0) {
  foreach ($sql->fetchAll() as $linha) {
    echo "
    <tr style='text-center'>
      <td>".$linha['Data']." ".$linha['Horas']."</td>
      <td>R$".ValidaValor($linha['Total'])."</td>
      <td>".ValidaString($linha['NomeCliente'])."</td>
      <td>".ValidaString($linha['Usuario'])."</td>
      <td>".$linha['Numero']."</td>
      <td>
        <a class='btn btn-success btn-sm desktop' onclick='confirmaIncluirOrcamento(".$linha['Id'].")'><i class='fas fa-pencil-alt'></i> Editar</a>
        <a class='btn btn-success btn-sm mobile' onclick='confirmaIncluirOrcamento(".$linha['Id'].")'><i class='fas fa-pencil-alt'></i></a>
      </td>
    </tr>
    ";
  }
}

else {
  echo "
  <tr style='text-center'>
    <td colspan='6'>Nenhum orçamento foi encontrado.</td>
  </tr>
  ";
}

  break;

  case 'trocarCarrinho':

unset($_SESSION['carrinho']);

$orcamentoIncluir = $_POST['orcamentoIncluir'];

$sql = $pdo->prepare("SELECT Numero, Data, CodigoCliente, NomeCliente, EnderecoCliente, BairroCliente, CidadeCliente, NomeCidadeCliente, EstadoCliente,
CepCliente, CNPJCliente, InscricaoCliente, Total, Vendedor, Vendedor2, Tabela, Usuario, CondicoesPagamento, Tipo, Banco, Horas, ObservacaoOrcamento FROM Orcamentos WHERE Id = :id");
$sql->bindValue(":id", $orcamentoIncluir);
$sql->execute();

foreach ($sql->fetchAll() as $linhaOrcamento) {

  $arrayDados = array (
    'cliente' => $linhaOrcamento['CodigoCliente'],
    'nomecliente' => ValidaString($linhaOrcamento['NomeCliente']),
    'endereco' => ValidaString($linhaOrcamento['EnderecoCliente']),
    'bairro' => ValidaString($linhaOrcamento['BairroCliente']),
    'cidade' => $linhaOrcamento['CidadeCliente'],
    'nomecidade' => $linhaOrcamento['NomeCidadeCliente'],
    'estado' => $linhaOrcamento['EstadoCliente'],
    'cep' => $linhaOrcamento['CepCliente'],
    'documento' => $linhaOrcamento['CNPJCliente'],
    'inscricao' => $linhaOrcamento['InscricaoCliente'],
    'vendedor' => $linhaOrcamento['Vendedor'],
    'interno' => $linhaOrcamento['Vendedor2'],
    'prazo' => TrataInt($linhaOrcamento['Tabela']),
    'tipo' => TrataInt($linhaOrcamento['Tipo']),
    'banco' => TrataInt($linhaOrcamento['Banco']),
    'total' => ValidaValorSql($linhaOrcamento['Total']),
    'observacoes' => $linhaOrcamento['ObservacaoOrcamento'],
    'numero' => $linhaOrcamento['Numero'],
  );

}

$_SESSION['carrinho']['dados'] = $arrayDados;

$sql = $pdo->prepare("SELECT Descricao FROM tipo WHERE id = :codigo");
$sql->bindValue(":codigo", $_SESSION['carrinho']['dados']['tipo']);
$sql->execute();

$nomeTipo = $sql->fetch();

if ($nomeTipo == null) {
   $nomeTipo['Descricao'] = "";
}

$sql = $pdo->prepare("SELECT Descricao FROM condicoespagamentos WHERE Id = :codigo");
$sql->bindValue(":codigo", $_SESSION['carrinho']['dados']['prazo']);
$sql->execute();

$nomePrazo = $sql->fetch();

if ($nomePrazo == null) {
   $nomePrazo['Descricao'] = "";
}

$sql = $pdo->prepare("SELECT Descricao FROM banco WHERE Id = :codigo AND MostrarVendas = 'S'");
$sql->bindValue(":codigo", $_SESSION['carrinho']['dados']['banco']);
$sql->execute();

$nomeBanco = $sql->fetch();

if ($nomeBanco == null) {
   $nomeBanco['Descricao'] = "";
}

?>

<script>

$("#cabecalho").load(location.href + " #cabecalho");

document.getElementById('nomePrazo').value = "";
document.getElementById('nomeTipo').value = "";
document.getElementById('codigoCliente').value = "<?php echo $_SESSION['carrinho']['dados']['cliente']; ?>";
document.getElementById('nomeCliente').value = "<?php echo $_SESSION['carrinho']['dados']['nomecliente']; ?>";
document.getElementById('enderecoCliente').value = "<?php echo $_SESSION['carrinho']['dados']['endereco']; ?>";
document.getElementById('bairroCliente').value = "<?php echo $_SESSION['carrinho']['dados']['bairro']; ?>";
document.getElementById('codigoCidadeCliente').value = "<?php echo $_SESSION['carrinho']['dados']['cidade']; ?>";
document.getElementById('nomeCidadeCliente').value = "<?php echo $_SESSION['carrinho']['dados']['nomecidade']; ?>";
document.getElementById('estadoCliente').value = "<?php echo $_SESSION['carrinho']['dados']['estado']; ?>";
document.getElementById('CEPCliente').value = "<?php echo $_SESSION['carrinho']['dados']['cep']; ?>";
document.getElementById('documentoCliente').value = "<?php echo $_SESSION['carrinho']['dados']['documento']; ?>";
document.getElementById('inscricaoCliente').value = "<?php echo $_SESSION['carrinho']['dados']['inscricao']; ?>";
document.getElementById('codigoVendedor').value = "<?php echo $_SESSION['carrinho']['dados']['vendedor']; ?>";
tabVendedor();
document.getElementById('codigoVendedorInterno').value = "<?php echo $_SESSION['carrinho']['dados']['interno']; ?>";
tabVendedorInterno();
document.getElementById('codigoCliente').focus();

document.getElementById('pills-profile-tab').click();

document.getElementById('prazoPagamento').value = "<?php echo TrataString($_SESSION['carrinho']['dados']['prazo']); ?>";
document.getElementById('nomePrazo').value = "<?php echo TrataString($nomePrazo['Descricao']); ?>";
document.getElementById('tipoPagamento').value = "<?php echo TrataString($_SESSION['carrinho']['dados']['tipo']); ?>";
document.getElementById('nomeTipo').value = "<?php echo TrataString($nomeTipo['Descricao']); ?>";
document.getElementById('bancoPagamento').value = "<?php echo $_SESSION['carrinho']['dados']['banco']; ?>";
document.getElementById('nomeBanco').value = "<?php echo TrataString($nomeBanco['Descricao']); ?>";
document.getElementById('total').value = "R$<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";
document.getElementById('observacoes').value = "<?php echo ValidaString($_SESSION['carrinho']['dados']['observacoes']); ?>";
document.getElementById('codigoMaterial').focus();

$("#lancamentos-produtos tbody").empty();

$('#buscarPedidoModal').modal('hide');

contador = 0;
arrayMaterial = [];

</script>

<?php

if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

    $sql = $pdo->prepare("SELECT CodigoProduto, Quantidade, Unitario, PrecoTabela, Total, Descricao, CustoUnitario, PrecoPromocao, UsouPromocao,
    Lote, Local FROM Orcamentositens WHERE Numero = :numero");
    $sql->bindValue(":numero", $_SESSION['carrinho']['dados']['numero']);
    $sql->execute();
    
    $linhaOrcamentoItens = $sql->fetchAll();
    
    $contadorOrcamentoItens = $sql->rowCount();
    
    $_SESSION['carrinho']['contador'] = $contadorOrcamentoItens;
      
    for ($i=0; $i < $contadorOrcamentoItens; $i++) { 
      
       $_SESSION['carrinho']['produtos'][$i]['codigo'] = $linhaOrcamentoItens[$i]['CodigoProduto'];
       $_SESSION['carrinho']['produtos'][$i]['quantidade'] = $linhaOrcamentoItens[$i]['Quantidade'];
       $_SESSION['carrinho']['produtos'][$i]['unitario'] = $linhaOrcamentoItens[$i]['Unitario'];
       $_SESSION['carrinho']['produtos'][$i]['tabela'] = $linhaOrcamentoItens[$i]['PrecoTabela'];
       $_SESSION['carrinho']['produtos'][$i]['total'] = $linhaOrcamentoItens[$i]['Total'];
       $_SESSION['carrinho']['produtos'][$i]['nome'] = $linhaOrcamentoItens[$i]['Descricao'];
       $_SESSION['carrinho']['produtos'][$i]['custo'] = $linhaOrcamentoItens[$i]['CustoUnitario'];
       $_SESSION['carrinho']['produtos'][$i]['lote'] = ValidaString($linhaOrcamentoItens[$i]['Lote']);
       $_SESSION['carrinho']['produtos'][$i]['local'] = ValidaString($linhaOrcamentoItens[$i]['Local']);
    
       $sql = $pdo->prepare("SELECT Descricao FROM loteestoque WHERE Codigo = :codigo");
       $sql->bindValue(":codigo", ValidaString($linhaOrcamentoItens[$i]['Lote']));
       $sql->execute();
    
       $nomeLote = $sql->fetch();
    
       if ($nomeLote == false) {
          if ($linhaOrcamentoItens[$i]['Lote'] == 999999) {
             $nomeLote['Descricao'] = "PRINCIPAL";
          }
    
          else {
             $nomeLote['Descricao'] = "";
          }
       }
    
       $sql = $pdo->prepare("SELECT Descricao FROM localestoque WHERE Codigo = :codigo");
       $sql->bindValue(":codigo", ValidaString($linhaOrcamentoItens[$i]['Local']));
       $sql->execute();
    
       $nomeLocal = $sql->fetch();
    
       if ($nomeLocal == false) {
             if ($linhaOrcamentoItens[$i]['Local'] == 999999) {
                $nomeLocal['Descricao'] = "PRINCIPAL";
             }
    
             else {
                $nomeLocal['Descricao'] = "";
             }
       }
    
      ?>
    
      <script>
    
      var tr = "<tr><td><?php echo $linhaOrcamentoItens[$i]['CodigoProduto']; ?></td>";
      tr = tr + '<td><?php echo ValidaString($linhaOrcamentoItens[$i]['Descricao']); ?></td>';
      tr = tr + "<td><?php echo ValidaValor($linhaOrcamentoItens[$i]['Quantidade']); ?></td>";
      tr = tr + "<td>R$<?php echo ValidaValor($linhaOrcamentoItens[$i]['Unitario']); ?></td>";
      tr = tr + "<td>R$<?php echo ValidaValor($linhaOrcamentoItens[$i]['Total']); ?></td>";
      tr = tr + "<td><?php echo ValidaString($nomeLote['Descricao']); ?></td>";
      tr = tr + "<td><?php echo ValidaString($nomeLocal['Descricao']); ?></td>";
      tr = tr + "<td class='project-actions' style='width: 10%;'>";
        tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
          tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
        tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
          tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
                
      arrayMaterial[contador] = ({
        codigo: parseInt(<?php echo $linhaOrcamentoItens[$i]['CodigoProduto']; ?>),
        nome: '<?php echo ValidaString($linhaOrcamentoItens[$i]['Descricao']); ?>',
        quantidade: <?php echo $linhaOrcamentoItens[$i]['Quantidade']; ?>,
        unitario: <?php echo $linhaOrcamentoItens[$i]['Unitario']; ?>,
        tabela: <?php echo $linhaOrcamentoItens[$i]['PrecoTabela']; ?>,
        custo: <?php echo $linhaOrcamentoItens[$i]['CustoUnitario']; ?>,
        total: <?php echo $linhaOrcamentoItens[$i]['Quantidade']*$linhaOrcamentoItens[$i]['Unitario']; ?>,
        lote: <?php echo ValidaString($linhaOrcamentoItens[$i]['Lote']); ?>,
        local: <?php echo ValidaString($linhaOrcamentoItens[$i]['Local']); ?>,
      });
    
      contador++;
    
      $("#lancamentos-produtos tbody").append(tr);
        
      </script>    
    
      <?php
    
    }

}

else {

    $sql = $pdo->prepare("SELECT CodigoProduto, Quantidade, Unitario, PrecoTabela, Total, Descricao, CustoUnitario, PrecoPromocao, UsouPromocao,
    FROM Orcamentositens WHERE Numero = :numero");
    $sql->bindValue(":numero", $_SESSION['carrinho']['dados']['numero']);
    $sql->execute();
    
    $linhaOrcamentoItens = $sql->fetchAll();
    
    $contadorOrcamentoItens = $sql->rowCount();
    
    $_SESSION['carrinho']['contador'] = $contadorOrcamentoItens;
      
    for ($i=0; $i < $contadorOrcamentoItens; $i++) { 
      
       $_SESSION['carrinho']['produtos'][$i]['codigo'] = $linhaOrcamentoItens[$i]['CodigoProduto'];
       $_SESSION['carrinho']['produtos'][$i]['quantidade'] = $linhaOrcamentoItens[$i]['Quantidade'];
       $_SESSION['carrinho']['produtos'][$i]['unitario'] = $linhaOrcamentoItens[$i]['Unitario'];
       $_SESSION['carrinho']['produtos'][$i]['tabela'] = $linhaOrcamentoItens[$i]['PrecoTabela'];
       $_SESSION['carrinho']['produtos'][$i]['total'] = $linhaOrcamentoItens[$i]['Total'];
       $_SESSION['carrinho']['produtos'][$i]['nome'] = $linhaOrcamentoItens[$i]['Descricao'];
       $_SESSION['carrinho']['produtos'][$i]['custo'] = $linhaOrcamentoItens[$i]['CustoUnitario'];
    
      ?>
    
      <script>
    
      var tr = "<tr><td><?php echo $linhaOrcamentoItens[$i]['CodigoProduto']; ?></td>";
      tr = tr + '<td><?php echo ValidaString($linhaOrcamentoItens[$i]['Descricao']); ?></td>';
      tr = tr + "<td><?php echo ValidaValor($linhaOrcamentoItens[$i]['Quantidade']); ?></td>";
      tr = tr + "<td>R$<?php echo ValidaValor($linhaOrcamentoItens[$i]['Unitario']); ?></td>";
      tr = tr + "<td>R$<?php echo ValidaValor($linhaOrcamentoItens[$i]['Total']); ?></td>";
      tr = tr + "<td class='project-actions' style='width: 10%;'>";
        tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
          tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
        tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
          tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
                
      arrayMaterial[contador] = ({
        codigo: parseInt(<?php echo $linhaOrcamentoItens[$i]['CodigoProduto']; ?>),
        nome: '<?php echo ValidaString($linhaOrcamentoItens[$i]['Descricao']); ?>',
        quantidade: <?php echo $linhaOrcamentoItens[$i]['Quantidade']; ?>,
        unitario: <?php echo $linhaOrcamentoItens[$i]['Unitario']; ?>,
        tabela: <?php echo $linhaOrcamentoItens[$i]['PrecoTabela']; ?>,
        custo: <?php echo $linhaOrcamentoItens[$i]['CustoUnitario']; ?>,
        total: <?php echo $linhaOrcamentoItens[$i]['Quantidade']*$linhaOrcamentoItens[$i]['Unitario']; ?>,
      });
    
      contador++;
    
      $("#lancamentos-produtos tbody").append(tr);
        
      </script>    
    
      <?php
    
    }

}

  break;

  case 'resetCarrinho':

unset($_SESSION['carrinho']);

  break;

  case 'salvarDadosCarrinho':

if (!isset($_SESSION['carrinho']['dados']['numero'])) {
   $_SESSION['carrinho']['dados']['numero'] = 0;
}

if (!isset($_SESSION['carrinho']['dados']['frete'])) {
   $_SESSION['carrinho']['dados']['frete'] = 0;
}

$arrayDados = array (
   'cliente' => $_POST['codigoCliente'],
   'nomecliente' => ValidaString($_POST['nomeCliente']),
   'endereco' => ValidaString($_POST['enderecoCliente']),
   'bairro' => ValidaString($_POST['bairroCliente']),
   'cidade' => $_POST['codigoCidadeCliente'],
   'nomecidade' => $_POST['nomeCidadeCliente'],
   'estado' => $_POST['estadoCliente'],
   'cep' => $_POST['CEPCliente'],
   'documento' => $_POST['documentoCliente'],
   'inscricao' => $_POST['inscricaoCliente'],
   'vendedor' => $_POST['codigoVendedor'],
   'comissao' => $_POST['comissao'],
   'interno' => $_POST['codigoVendedorInterno'],
   'comissaointerno' => $_POST['comissaoInterno'],
   'prazo' => $_POST['prazoPagamento'],
   'tipo' => $_POST['tipoPagamento'],
   'observacoes' => $_POST['observacoes'],
   'banco' => $_POST['bancoPagamento'],
   'numero' => $_SESSION['carrinho']['dados']['numero'],
   'total' => $_SESSION['carrinho']['dados']['total'],
   'frete' => $_SESSION['carrinho']['dados']['frete'],
   'observacoesExpedicao' => ValidaString($_POST['observacoesExpedicao']),
);

$_SESSION['carrinho']['dados'] = $arrayDados;

for ($i=0; $i < count($_POST['arrayExpedicao']); $i++) { 
    
    $_SESSION['carrinho']['produtos'][$i]['statusExpedicao'] = $_POST['arrayExpedicao'][$i]['statusExpedicao'];
    $_SESSION['carrinho']['produtos'][$i]['dataExpedicao'] = $_POST['arrayExpedicao'][$i]['dataExpedicao'];

}

?>

<script>

document.getElementById('submitForm').click();
   
</script>

<?php

  break;

   case 'carregarCarrinhoProdutos':

if (isset($_SESSION['carrinho']['dados']['numero'])) {
   if (TrataInt($_SESSION['carrinho']['dados']['numero']) != 0) {
      $sql = $pdo->prepare("SELECT Id FROM orcamentos where numero = :numero");
      $sql->bindValue(":numero", $_SESSION['carrinho']['dados']['numero']);
      $sql->execute();

      if ($sql->rowCount() == 0) {

      unset($_SESSION['carrinho']['dados']['numero']);

      }
   }
}

$_SESSION['carrinho']['dados']['total'] = 0;

if (isset($_SESSION['carrinho']['dados']['frete'])) {
$_SESSION['carrinho']['dados']['total'] += $_SESSION['carrinho']['dados']['frete'];
}

$contadorProdutos = count($_SESSION['carrinho']['produtos']);

if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

    for ($i=0; $i < $contadorProdutos; $i++) {

        // $sql = $pdo->prepare("SELECT codigo, nome, estoque, custov, vendav, unidade FROM material WHERE codigo = :codigo AND Ativo = 'S'");
        $sql = $pdo->prepare("SELECT codigo, nome, custov, vendav, unidade FROM material WHERE codigo = :codigo AND Ativo = 'S'");
        $sql->bindValue(":codigo", $_SESSION['carrinho']['produtos'][$i]['codigo']);
        $sql->execute();
     
        foreach ($sql->fetchAll() as $linha[$i]) {
           $linhaArray[$i] = array(
              'codigo' => $linha[$i]['codigo'],
              'nome' => ValidaString(ValidaString($linha[$i]['nome'])).' ('.ValidaString($linha[$i]['unidade']).')',
              'quantidade' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['quantidade']),
              'unitario' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['unitario']),
              'tabela' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['tabela']),
              'custo' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['custo']),
              'total' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['unitario']) * TrataFloat($_SESSION['carrinho']['produtos'][$i]['quantidade']),
              'lote' => TrataString($_SESSION['carrinho']['produtos'][$i]['lote']),
              'local' => TrataString($_SESSION['carrinho']['produtos'][$i]['local']),
           );
     
        }
     
        echo "<tr class='text-center' style='line-height: 35px;'>";
           echo "<td scope='row'>".$linhaArray[$i]['codigo']."</td>";
           echo '<td>'.ValidaString($linhaArray[$i]['nome']).'</td>';
           echo "<td>".ValidaValor($linhaArray[$i]['quantidade'])."</td>";
           echo "<td>R$".ValidaValor($linhaArray[$i]['unitario'])."</td>";
           echo "<td>R$".ValidaValor($linhaArray[$i]['total'])."</td>";
     
           $sql = $pdo->prepare("SELECT Descricao FROM loteestoque WHERE Codigo = :codigo");
           $sql->bindValue(":codigo", TrataString($linhaArray[$i]['lote']));
           $sql->execute();
        
           $nomeLote = $sql->fetch();
     
           if ($nomeLote == false) {
              if ($linhaArray[$i]['lote'] == 999999) {
                 $nomeLote['Descricao'] = "PRINCIPAL";
              }
     
              else {
                 $nomeLote['Descricao'] = "";
              }
           }
     
           echo "<td>".ValidaString($nomeLote['Descricao'])."</td>";
        
           $sql = $pdo->prepare("SELECT Descricao FROM localestoque WHERE Codigo = :codigo");
           $sql->bindValue(":codigo", TrataString($linhaArray[$i]['local']));
           $sql->execute();
        
           $nomeLocal = $sql->fetch();
     
           if ($nomeLocal == false) {
              if ($linhaArray[$i]['local'] == 999999) {
                 $nomeLocal['Descricao'] = "PRINCIPAL";
              }
     
              else {
                 $nomeLocal['Descricao'] = "";
              }
           }
     
           echo "<td>".ValidaString($nomeLocal['Descricao'])."</td>";
     
           echo "
           <td class='project-actions' style='width: 10%;'>
           <a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(".$i.")'><i class='fas fa-trash'></i> Excluir</a>
           <a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(".$i.")'><i class='fas fa-trash'></i></a>
           </td>";
     
        echo "</tr>";
     
        $_SESSION['carrinho']['dados']['total'] = TrataFloat($_SESSION['carrinho']['dados']['total']) + TrataFloat($_SESSION['carrinho']['produtos'][$i]['total']);
     
        $totalTabela += ($_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']);
     
        if ($_SESSION['carrinho']['produtos'][$i]['unitario'] > $_SESSION['carrinho']['produtos'][$i]['tabela']) {
           $diferencaTabela += (
              (
                 $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
              )
     
              -
     
              (
                 $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
              )
     
           );
        }
     
        else {
           if ($_SESSION['carrinho']['produtos'][$i]['unitario'] < $_SESSION['carrinho']['produtos'][$i]['tabela']) {
              $diferencaTabela -= (
                 (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                 )
     
                 -
     
                 (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                 )
     
              );
           }
        }
    }

}

else {

    for ($i=0; $i < $contadorProdutos; $i++) {

        // $sql = $pdo->prepare("SELECT codigo, nome, estoque, custov, vendav, unidade FROM material WHERE codigo = :codigo AND Ativo = 'S'");
        $sql = $pdo->prepare("SELECT codigo, nome, custov, vendav, unidade FROM material WHERE codigo = :codigo AND Ativo = 'S'");
        $sql->bindValue(":codigo", $_SESSION['carrinho']['produtos'][$i]['codigo']);
        $sql->execute();
     
        foreach ($sql->fetchAll() as $linha[$i]) {
           $linhaArray[$i] = array(
              'codigo' => $linha[$i]['codigo'],
              'nome' => ValidaString(ValidaString($linha[$i]['nome'])).' ('.ValidaString($linha[$i]['unidade']).')',
              'quantidade' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['quantidade']),
              'unitario' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['unitario']),
              'tabela' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['tabela']),
              'custo' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['custo']),
              'total' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['unitario']) * TrataFloat($_SESSION['carrinho']['produtos'][$i]['quantidade']),
           );
     
        }
     
        echo "<tr class='text-center' style='line-height: 35px;'>";
           echo "<td scope='row'>".$linhaArray[$i]['codigo']."</td>";
           echo '<td>'.ValidaString($linhaArray[$i]['nome']).'</td>';
           echo "<td>".ValidaValor($linhaArray[$i]['quantidade'])."</td>";
           echo "<td>R$".ValidaValor($linhaArray[$i]['unitario'])."</td>";
           echo "<td>R$".ValidaValor($linhaArray[$i]['total'])."</td>";
     
           echo "
           <td class='project-actions' style='width: 10%;'>
           <a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(".$i.")'><i class='fas fa-trash'></i> Excluir</a>
           <a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(".$i.")'><i class='fas fa-trash'></i></a>
           </td>";
     
        echo "</tr>";
     
        $_SESSION['carrinho']['dados']['total'] = TrataFloat($_SESSION['carrinho']['dados']['total']) + TrataFloat($_SESSION['carrinho']['produtos'][$i]['total']);
     
        $totalTabela += ($_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']);
     
        if ($_SESSION['carrinho']['produtos'][$i]['unitario'] > $_SESSION['carrinho']['produtos'][$i]['tabela']) {
           $diferencaTabela += (
              (
                 $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
              )
     
              -
     
              (
                 $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
              )
     
           );
        }
     
        else {
           if ($_SESSION['carrinho']['produtos'][$i]['unitario'] < $_SESSION['carrinho']['produtos'][$i]['tabela']) {
              $diferencaTabela -= (
                 (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                 )
     
                 -
     
                 (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                 )
     
              );
           }
        }
    }

}

if ($diferencaTabela > 0) {

   $porcentagem = round(($diferencaTabela/$totalTabela)*100, 2);

   ?>

   <script>

   if (document.getElementById('divDesconto').classList.contains('d-none')) {
      document.getElementById('divDesconto').classList.remove("d-none");
      document.getElementById('divDesconto').classList.add("d-block");
   }

   document.getElementById('descontoLabel').innerHTML = "Acréscimo";

   document.getElementById('descAcresc').value = "R$ " + "<?php echo ValidaValor($diferencaTabela); ?>" + " | " + "<?php echo ValidaValor($porcentagem); ?>" + "%";

   </script>

   <?php
}

else {
   if ($diferencaTabela < 0) {

      $porcentagem = round((($diferencaTabela*(-1))/$totalTabela)*100, 2);

      ?>

      <script>

      if (document.getElementById('divDesconto').classList.contains('d-none')) {
         document.getElementById('divDesconto').classList.remove("d-none");
         document.getElementById('divDesconto').classList.add("d-block");
      }

      document.getElementById('descontoLabel').innerHTML = "Desconto";

      document.getElementById('descAcresc').value = "R$ " + "<?php echo ValidaValor($diferencaTabela); ?>" + " | " + "<?php echo ValidaValor($porcentagem); ?>" + "%";

      </script>

      <?php
   }

   else {
      ?>

      <script>

      if (document.getElementById('divDesconto').classList.contains('d-block')) {
         document.getElementById('divDesconto').classList.remove("d-block");
         document.getElementById('divDesconto').classList.add("d-none");
      }

      document.getElementById('descontoLabel').innerHTML = "Desconto/Acréscimo";

      document.getElementById('descAcresc').value = "";

      </script>

      <?php
   }
}

if (isset($_SESSION['carrinho']['dados']['frete'])) {
   ?>

   <script>

   document.getElementById('freteOrcamento').value = "<?php echo ValidaValor($_SESSION['carrinho']['dados']['frete']); ?>";

   </script>

   <?php
}

?>

<script>

document.getElementById('total').value = "R$<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";
arrayMaterial = <?php echo json_encode($_SESSION['carrinho']['produtos']); ?>;
contador = <?php echo count($_SESSION['carrinho']['produtos']); ?>;

</script>

<?php

   break;

  case 'carregarCarrinhoDados':

if (isset($_SESSION['carrinho']['dados'])) {

   if (count($_SESSION['carrinho']['dados']) > 1) {

      $sql = $pdo->prepare("SELECT Descricao FROM tipo WHERE id = :codigo");
      $sql->bindValue(":codigo", $_SESSION['carrinho']['dados']['tipo']);
      $sql->execute();
   
      $nomeTipo = $sql->fetch();
   
      if ($nomeTipo == null) {
         $nomeTipo['Descricao'] = "";
      }
   
      $sql = $pdo->prepare("SELECT Descricao FROM condicoespagamentos WHERE Id = :codigo");
      $sql->bindValue(":codigo", $_SESSION['carrinho']['dados']['prazo']);
      $sql->execute();
   
      $nomePrazo = $sql->fetch();
   
      if ($nomePrazo == null) {
         $nomePrazo['Descricao'] = "";
      }
   
      $sql = $pdo->prepare("SELECT Descricao FROM banco WHERE Id = :codigo AND MostrarVendas = 'S'");
      $sql->bindValue(":codigo", $_SESSION['carrinho']['dados']['banco']);
      $sql->execute();
   
      $nomeBanco = $sql->fetch();
   
      if ($nomeBanco == null) {
         $nomeBanco['Descricao'] = "";
      }
      
   ?>
   
   <script>
   
   document.getElementById('codigoCliente').value = "<?php if (isset($_SESSION['carrinho']['dados']['cliente'])) { echo $_SESSION['carrinho']['dados']['cliente']; } else { echo ""; } ?>";
   document.getElementById('nomeCliente').value = "<?php if (isset($_SESSION['carrinho']['dados']['nomecliente'])) { echo $_SESSION['carrinho']['dados']['nomecliente']; } else { echo ""; } ?>";
   document.getElementById('bairroCliente').value = "<?php if (isset($_SESSION['carrinho']['dados']['bairro'])) { echo $_SESSION['carrinho']['dados']['bairro']; } else { echo ""; } ?>";
   document.getElementById('codigoCidadeCliente').value = "<?php if (isset($_SESSION['carrinho']['dados']['cidade'])) { echo $_SESSION['carrinho']['dados']['cidade']; } else { echo ""; } ?>";
   document.getElementById('nomeCidadeCliente').value = "<?php if (isset($_SESSION['carrinho']['dados']['nomecidade'])) { echo $_SESSION['carrinho']['dados']['nomecidade']; } else { echo ""; } ?>";
   document.getElementById('estadoCliente').value = "<?php if (isset($_SESSION['carrinho']['dados']['estado'])) { echo $_SESSION['carrinho']['dados']['estado']; } else { echo ""; } ?>";
   document.getElementById('CEPCliente').value = "<?php if (isset($_SESSION['carrinho']['dados']['cep'])) { echo $_SESSION['carrinho']['dados']['cep']; } else { echo ""; } ?>";
   document.getElementById('documentoCliente').value = "<?php if (isset($_SESSION['carrinho']['dados']['documento'])) { echo $_SESSION['carrinho']['dados']['documento']; } else { echo ""; } ?>";
   document.getElementById('inscricaoCliente').value = "<?php if (isset($_SESSION['carrinho']['dados']['inscricao'])) { echo $_SESSION['carrinho']['dados']['inscricao']; } else { echo ""; } ?>";
   document.getElementById('codigoVendedor').value = "<?php if (isset($_SESSION['carrinho']['dados']['vendedor'])) { echo $_SESSION['carrinho']['dados']['vendedor']; } else { echo ""; } ?>";
   tabVendedor();
   document.getElementById('codigoVendedorInterno').value = "<?php if (isset($_SESSION['carrinho']['dados']['interno'])) { echo $_SESSION['carrinho']['dados']['interno']; } else { echo ""; } ?>";
   tabVendedorInterno();
   document.getElementById('pills-profile-tab').click();
   document.getElementById('prazoPagamento').value = "<?php if (isset($_SESSION['carrinho']['dados']['prazo'])) { echo $_SESSION['carrinho']['dados']['prazo']; } else { echo ""; } ?>";
   document.getElementById('nomePrazo').value = "<?php echo TrataString($nomePrazo['Descricao']); ?>";
   document.getElementById('tipoPagamento').value = "<?php if (isset($_SESSION['carrinho']['dados']['tipo'])) { echo $_SESSION['carrinho']['dados']['tipo']; } else { echo ""; } ?>";
   document.getElementById('nomeTipo').value = "<?php echo TrataString($nomeTipo['Descricao']); ?>";
   document.getElementById('bancoPagamento').value = "<?php if (isset($_SESSION['carrinho']['dados']['banco'])) { echo $_SESSION['carrinho']['dados']['banco']; } else { echo ""; } ?>";
   document.getElementById('nomeBanco').value = "<?php echo TrataString($nomeBanco['Descricao']); ?>";
   document.getElementById('observacoes').value = "<?php if (isset($_SESSION['carrinho']['dados']['observacoes'])) { echo $_SESSION['carrinho']['dados']['observacoes']; } else { echo ""; } ?>";
   
   $("#cabecalho").load(location.href + " #cabecalho");
   
   </script>
   
   <?php
   
   }

   if (isset($_SESSION['carrinho']['produtos'])) {

      if (count($_SESSION['carrinho']['produtos']) >= 1) {
   
         ?>
      
         <script>
      
            document.getElementById('pills-profile-tab').click();
      
            var paginaOperacao = 'carregarCarrinhoProdutos';
         
            $.ajax
               ({
               //Configurações
               type: 'POST',//Método que está sendo utilizado.
               dataType: 'html',//É o tipo de dado que a página vai retornar.
               url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
               //função que vai ser executada assim que a requisição for enviada
               data: {paginaOperacao: paginaOperacao,},//Dados para consulta
               //função que será executada quando a solicitação for finalizada.
               success: function (msg)
               {
                  $("#table").html(msg);
               }
            });
      
         </script>
      
         <?php
      
      }

   }

}

  break;

  case 'tabCliente':

$codigoTab = $_POST['codigoTab'];

$sql = $pdo->prepare("SELECT codigo FROM cliente WHERE codigo = :codigo AND Inativo = 'N'");
$sql->bindValue(":codigo", $codigoTab);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

  $sql = $pdo->prepare("SELECT codigo, nome, endereco, bairro, codigocidade, nomecidade, estado, cep, cnpj, inscricaoestadual, vendedor FROM cliente WHERE codigo = :codigo AND Inativo = 'N'");
  $sql->bindValue(":codigo", $codigoTab);
  $sql->execute();

  $linha = $sql->fetch();

  ?>

  <script>

  document.getElementById('nomeCliente').value = "<?php echo $linha['nome']; ?>";
  document.getElementById('enderecoCliente').value = "<?php echo $linha['endereco']; ?>";
  document.getElementById('bairroCliente').value = "<?php echo $linha['bairro']; ?>";
  document.getElementById('codigoCidadeCliente').value = "<?php echo $linha['codigocidade']; ?>";
  document.getElementById('nomeCidadeCliente').value = "<?php echo $linha['nomecidade']; ?>";
  document.getElementById('estadoCliente').value = "<?php echo $linha['estado']; ?>";
  document.getElementById('CEPCliente').value = "<?php echo $linha['cep']; ?>";
  document.getElementById('documentoCliente').value = "<?php echo $linha['cnpj']; ?>";
  document.getElementById('inscricaoCliente').value = "<?php echo $linha['inscricaoestadual']; ?>";

  </script>

  <?php

  if ($_SESSION['parametros']['respeitarVendedorCadastro'] == 'S') {
      $sql = $pdo->prepare("SELECT codigo, nome FROM vendedores WHERE codigo = :codigo");
      $sql->bindValue(":codigo", $linha['vendedor']);
      $sql->execute();
    
      $linha = $sql->fetch();
  
      ?>
  
      <script>
        document.getElementById('codigoVendedor').value = "<?php echo $linha['codigo']; ?>";
        document.getElementById('nomeVendedor').value = "<?php echo $linha['nome']; ?>";
      </script>
  
      <?php
  }

  else {
    ?>
  
    <script>
      document.getElementById('codigoVendedor').value = "<?php echo $_SESSION['parametros']['vendedorLogado']['Codigo']; ?>";
      document.getElementById('nomeVendedor').value = "<?php echo $_SESSION['parametros']['vendedorLogado']['Nome']; ?>";
    </script>

    <?php
  }

}

elseif ($codigoTab == '') {

?>

<script>

if (!document.getElementById('codigoCidadeCliente').value) {
  document.getElementById('codigoCidadeCliente').value = "<?php echo $_SESSION['parametros']['codigoCidadeOrcamentos']; ?>";
  document.getElementById('nomeCidadeCliente').value = "<?php echo ValidaString($_SESSION['parametros']['nomeCidadeOrcamentos']); ?>";
}

if (!document.getElementById('codigoVendedor').value) {
  document.getElementById('codigoVendedor').value = "<?php echo $_SESSION['parametros']['vendedorLogado']['Codigo']; ?>";
  document.getElementById('nomeVendedor').value = "<?php echo ValidaString($_SESSION['parametros']['vendedorLogado']['Nome']); ?>";

}


</script>

<?php

}

elseif ($codigoTab == 0) {

?>

<script>

if (!document.getElementById('nomeCliente').value) {
  document.getElementById('nomeCliente').value = "CONSUMIDOR";
}

document.getElementById('enderecoCliente').value = "";
document.getElementById('bairroCliente').value = "";
document.getElementById('codigoCidadeCliente').value = "<?php echo $_SESSION['parametros']['codigoCidadeOrcamentos']; ?>";
document.getElementById('codigoCidadeCliente').focus();
document.getElementById('CEPCliente').value = "";
document.getElementById('documentoCliente').value = "";
document.getElementById('inscricaoCliente').value = "";
document.getElementById('codigoVendedor').value = "<?php echo $_SESSION['parametros']['vendedorLogado']['Codigo']; ?>";
document.getElementById('nomeVendedor').value = "<?php echo $_SESSION['parametros']['vendedorLogado']['Nome']; ?>";
document.getElementById('nomeCliente').focus();

</script>

<?php

}

else {

?>

<script>

document.getElementById('codigoCliente').value = "";
document.getElementById('nomeCliente').value = "";
document.getElementById('enderecoCliente').value = "";
document.getElementById('bairroCliente').value = "";
document.getElementById('codigoCidadeCliente').value = "";
document.getElementById('codigoCidadeCliente').focus();
document.getElementById('nomeCidadeCliente').value = "";
document.getElementById('estadoCliente').value = "";
document.getElementById('CEPCliente').value = "";
document.getElementById('documentoCliente').value = "";
document.getElementById('inscricaoCliente').value = "";
document.getElementById('codigoVendedor').value = "<?php echo $_SESSION['parametros']['vendedorLogado']['Codigo']; ?>";
document.getElementById('nomeVendedor').value = "<?php echo $_SESSION['parametros']['vendedorLogado']['Nome']; ?>";
document.getElementById('codigoCliente').focus();

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

  case 'tabQuantidade':

$operacao = $_POST['operacao'];
$codigoTab = $_POST['codigoTab'];
$quantidadeTab = $_POST['valorQuantidade'];

$sql = $pdo->prepare("SELECT codigo, embalagemmaterial FROM material WHERE codigo = :codigo AND Ativo = 'S'");
$sql->bindValue(":codigo", $codigoTab);
$sql->execute();

$linha = $sql->fetch();

if ($linha['embalagemmaterial'] != null || TrataInt($linha['embalagemmaterial']) != 0) {

  $embalagemMaterial = Trim($linha['embalagemmaterial']);
  $embalagemMaterial = str_replace(",", ".", $embalagemMaterial);

}

if (isset($embalagemMaterial)) {

   $quantidadeTab = floatval($quantidadeTab);
   $embalagemMaterial = floatval($embalagemMaterial);
   
   if ($embalagemMaterial != "") {
   
     if (!empty($quantidadeTab) && !empty($embalagemMaterial)) {
   
      if ((Round($quantidadeTab, 2)/Round($embalagemMaterial, 2)) != (intval(Round($quantidadeTab, 2)/Round($embalagemMaterial, 2)))) {
   
         $qtdSugestao = Round($quantidadeTab/$embalagemMaterial, 0);
         $qtdSugestao = $qtdSugestao * $embalagemMaterial;
   
         if ($qtdSugestao < $quantidadeTab) {
           $qtdSugestao = $qtdSugestao + $embalagemMaterial;
         }
   
         $_SESSION['sugestaoMaterial']['sugestao'] = $qtdSugestao;
         $_SESSION['sugestaoMaterial']['embalagem'] = $embalagemMaterial;
   
         if ($operacao > 0) {
   
           $sql = $pdo->prepare("SELECT * FROM Direitos_Dados WHERE IdUsuario = :id AND OpcoesPermitidas='300853'");
           $sql->bindValue(":id", $info['Id']);
           $sql->execute();
   
           if ($sql->fetch() == false) {
   
            $_SESSION['sugestaoMaterial2']['sugestao'] = $qtdSugestao;
            $_SESSION['sugestaoMaterial2']['embalagem'] = $embalagemMaterial;
   
            ?>
   
            <script>
   
            $(".confirmacao-embalagem").load(location.href + " .confirmacao-embalagem");
   
            $(function(){
               $('#validaEmbalagemMaterial').modal();
            });
   
            </script>
   
            <?php
   
           }
   
           else {
   
            ?>
   
            <script>
   
            adicionarProduto(true);
   
            </script>
   
            <?php
   
           }
   
         }
   
         else {
   
           ?>
   
           <script>
     
           $(".sugestao-material").load(location.href + " .sugestao-material");
     
           $(function(){
             $('#sugestaoModal').modal();
           });
     
           </script>
     
           <?php
   
         }
   
      }
   
      else {
         if ($operacao > 0) {
   
            ?>
   
            <script>
   
            adicionarProduto(true);
   
            </script>
   
            <?php
   
         }
      }
   
     }
   
     else {
         if ($operacao > 0) {
   
            ?>
   
            <script>
   
            adicionarProduto(true);
   
            </script>
   
            <?php
   
         }
     }
   
   }

}

else {
   if ($operacao > 0) {
   
      ?>

      <script>

      adicionarProduto(true);

      </script>

      <?php

   }
}

  break;

  case 'validaEmbalagemMaterial':

$usuario = addslashes(strtoupper($_POST['nome']));
$senha = $_POST['senha'];
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

  $sql = $pdo->prepare("SELECT * FROM Direitos_Dados WHERE IdUsuario = :id AND OpcoesPermitidas='300853'");
  $sql->bindValue(":id", $dadosLogin['Id']);
  $sql->execute();

  if ($sql->fetch() == false) {
    ?>

    <script>

    Toast.fire({
      icon: 'warning',
      title: 'Atenção, este usuário não possui esta permissão.'
    })

    </script>

    <?php
  }

  else {
    ?>

    <script>

    adicionarProduto(true);

    $('#validaEmbalagemMaterial').modal('hide');

    </script>

    <?php
  }

}

else {
  ?>

  <script>

  Toast.fire({
    icon: 'warning',
    title: 'Falha ao acessar, preencha seus dados corretamente.'
  })

  </script>

  <?php
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

  if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

    $_SESSION['loteLocalProduto']['codigo'] = $codigoTab;
    $_SESSION['loteLocalProduto']['nome'] = ValidaString($linha['nome']).' ('.$linha['unidade'].')';
  
    ?>
  
    <script>
  
    document.getElementById('nomeMaterial').value = '<?php echo ValidaString($linha['nome']).' ('.$linha['unidade'].')'; ?>';
    document.getElementById('unitarioMaterial').value = "<?php echo ValidaValor($linha['vendav']); ?>";
    document.getElementById('quantidadeMaterial').value = "1";
    var unitario = "<?php echo TrataFloat($linha['vendav']); ?>";
    // document.getElementById('estoqueMaterial').value = "<?php // echo $linha['estoque']; ?>";
    // var estoque = "<?php // echo $linha['estoque']; ?>";
    document.getElementById('totalMaterial').value = "<?php echo ValidaValor($linha['vendav']); ?>";
  
     $(".lotelocal-produto").load(location.href + " .lotelocal-produto");
  
     $(function(){
        $('#escolherLoteLocal').modal();
     });
  
    </script>
  
    <?php

  }

  else {
  
    ?>
  
    <script>
  
    document.getElementById('nomeMaterial').value = '<?php echo ValidaString($linha['nome']).' ('.$linha['unidade'].')'; ?>';
    document.getElementById('unitarioMaterial').value = "<?php echo ValidaValor($linha['vendav']); ?>";
    document.getElementById('quantidadeMaterial').value = "1";
    var unitario = "<?php echo TrataFloat($linha['vendav']); ?>";
    // document.getElementById('estoqueMaterial').value = "<?php // echo $linha['estoque']; ?>";
    // var estoque = "<?php // echo $linha['estoque']; ?>";
    document.getElementById('totalMaterial').value = "<?php echo ValidaValor($linha['vendav']); ?>";

  
    </script>
  
    <?php

  }

}

elseif ($codigoTab == '') {

    if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {
        ?>

        <script>
        
        document.getElementById('nomeMaterial').value = "";
        document.getElementById('unitarioMaterial').value = "";
        document.getElementById('quantidadeMaterial').value = "";
        document.getElementById('totalMaterial').value = "";
        document.getElementById('loteMaterial').value = "";
        document.getElementById('nomeLote').value = "";
        document.getElementById('localMaterial').value = "";
        document.getElementById('nomeLocal').value = "";
        
        </script>
        
        <?php
    }

    else {
        ?>

        <script>
        
        document.getElementById('nomeMaterial').value = "";
        document.getElementById('unitarioMaterial').value = "";
        document.getElementById('quantidadeMaterial').value = "";
        document.getElementById('totalMaterial').value = "";
        
        </script>
        
        <?php
    }

}

else {

    if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

        ?>

        <script>
        
        document.getElementById('codigoMaterial').value = "";
        document.getElementById('nomeMaterial').value = "";
        // document.getElementById('estoqueMaterial').value = "";
        document.getElementById('unitarioMaterial').value = "";
        document.getElementById('quantidadeMaterial').value = "";
        document.getElementById('totalMaterial').value = "";
        document.getElementById('loteMaterial').value = "";
        document.getElementById('nomeLote').value = "";
        document.getElementById('localMaterial').value = "";
        document.getElementById('nomeLocal').value = "";
        document.getElementById('codigoMaterial').focus();
        
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

    else {

        ?>

        <script>
        
        document.getElementById('codigoMaterial').value = "";
        document.getElementById('nomeMaterial').value = "";
        // document.getElementById('estoqueMaterial').value = "";
        document.getElementById('unitarioMaterial').value = "";
        document.getElementById('quantidadeMaterial').value = "";
        document.getElementById('totalMaterial').value = "";
        document.getElementById('codigoMaterial').focus();
        
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

}

  break;

  case 'tabVendedor':

$codigoTab = $_POST['codigoTab'];
$codigoCidade = $_POST['codigoCidade'];
$vendedorInterno =  $_POST['vendedorInterno'];

$sql = $pdo->prepare("SELECT codigo FROM vendedores WHERE codigo = :codigo");
$sql->bindValue(":codigo", $codigoTab);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

   $sql = $pdo->prepare("SELECT codigo, nome, Comissao1, InternoExterno, DentroCidade, ForaCidade, DentroCidadeInterno, ForaCidadeInterno, DentroCidadeExterno, ForaCidadeExterno FROM vendedores WHERE codigo = :codigo");
   $sql->bindValue(":codigo", $codigoTab);
   $sql->execute();

   $linha = $sql->fetch();

   $sInternoExterno = "I";

   if ($linha['InternoExterno'] != null && !empty($linha['InternoExterno'])) {
      $sInternoExterno = $linha['InternoExterno'];
   }

   $uC1 = $linha['DentroCidade'];
   $uC2 = $linha['ForaCidade'];
   $uC3 = $linha['DentroCidadeInterno'];
   $uC4 = $linha['ForaCidadeInterno'];
   $uC5 = $linha['DentroCidadeExterno'];
   $uC6 = $linha['ForaCidadeExterno'];

   $AchaComissaoCasa1 = 0;

   if ($codigoCidade != "" && $codigoCidade != 0) {
      if ($_SESSION['parametros']['codigoCidadeOrcamentos'] <> $codigoCidade) {
         // Fora da Cidade
         if ($vendedorInterno == 0) {
            // Sozinho
            $AchaComissaoCasa1 = $uC2;
         }
   
         else {
            // Tem 2 vendedores
            if ($sInternoExterno == "I") {
               $AchaComissaoCasa1 = $uC4;
            }
   
            else {
               $AchaComissaoCasa1 = $uC6;
            }
         }
      }
      
      else {
         // Dentro da Cidade
         if ($vendedorInterno == 0) {
            // Sozinho
            $AchaComissaoCasa1 = $uC1;
         }
   
         else {
            // Tem 2 vendedores
            if ($sInternoExterno == "I") {
               $AchaComissaoCasa1 = $uC3;
            }
   
            else {
               $AchaComissaoCasa1 = $uC4;
            }
         }
      }
   }

   ?>

   <script>

   document.getElementById('nomeVendedor').value = "<?php echo $linha['nome']; ?>";

   document.getElementById('comissaoVendedor').value = "<?php echo ValidaValor($AchaComissaoCasa1)."%"; ?>";

   </script>

   <?php

   if ($vendedorInterno != 0 && !empty($vendedorInterno)) {
      
      $sql = $pdo->prepare("SELECT codigo, nome, Comissao1, InternoExterno, DentroCidade, ForaCidade, DentroCidadeInterno, ForaCidadeInterno, DentroCidadeExterno, ForaCidadeExterno FROM vendedores WHERE codigo = :codigo");
      $sql->bindValue(":codigo", $vendedorInterno);
      $sql->execute();
   
      $linha = $sql->fetch();

      if ($linha != false) {

         $sInternoExterno = "I";
   
         if ($linha['InternoExterno'] != null && !empty($linha['InternoExterno'])) {
            $sInternoExterno = $linha['InternoExterno'];
         }
      
         $uC1 = $linha['DentroCidade'];
         $uC2 = $linha['ForaCidade'];
         $uC3 = $linha['DentroCidadeInterno'];
         $uC4 = $linha['ForaCidadeInterno'];
         $uC5 = $linha['DentroCidadeExterno'];
         $uC6 = $linha['ForaCidadeExterno'];
      
         $AchaComissaoCasa2 = 0;
      
         if ($codigoCidade != "" && $codigoCidade != 0) {
            if ($_SESSION['parametros']['codigoCidadeOrcamentos'] <> $codigoCidade) {
               // Fora da Cidade
               if ($vendedorInterno == 0) {
                  // Sozinho
                  $AchaComissaoCasa2 = $uC2;
               }
         
               else {
                  // Tem 2 vendedores
                  if ($sInternoExterno == "I") {
                     $AchaComissaoCasa2 = $uC4;
                  }
         
                  else {
                     $AchaComissaoCasa2 = $uC6;
                  }
               }
            }
            
            else {
               // Dentro da Cidade
               if ($vendedorInterno == 0) {
                  // Sozinho
                  $AchaComissaoCasa2 = $uC1;
               }
         
               else {
                  // Tem 2 vendedores
                  if ($sInternoExterno == "I") {
                     $AchaComissaoCasa2 = $uC3;
                  }
         
                  else {
                     $AchaComissaoCasa2 = $uC4;
                  }
               }
            }
         }
      
         ?>
      
         <script>
      
         document.getElementById('nomeVendedorInterno').value = "<?php echo $linha['nome']; ?>";

         document.getElementById('comissaoVendedor').value = "<?php echo ValidaValor($AchaComissaoCasa1)."%"; ?>";
         document.getElementById('comissaoVendedorInterno').value = "<?php echo ValidaValor($AchaComissaoCasa2)."%"; ?>";
      
         </script>
      
         <?php

      }

   }

}

elseif ($codigoTab == '') {

?>

<script>

document.getElementById('codigoVendedor').value = "";
document.getElementById('nomeVendedor').value = "";
document.getElementById('comissaoVendedor').value = "";

</script>

<?php   

}

else {

?>

<script>

document.getElementById('codigoVendedor').value = "";
document.getElementById('nomeVendedor').value = "";
document.getElementById('comissaoVendedor').value = "";
document.getElementById('codigoVendedor').focus();

var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirma: false,
  timer: 3000
});
Toast.fire({
  icon: 'error',
  title: 'O vendedor não foi encontrado ou está inativo.'
})

</script>

<?php

}

  break;

  case 'tabVendedorInterno':

$codigoTab = $_POST['codigoTab'];
$codigoCidade = $_POST['codigoCidade'];
$vendedorInterno =  $_POST['vendedorInterno'];

$sql = $pdo->prepare("SELECT codigo FROM vendedores WHERE codigo = :codigo");
$sql->bindValue(":codigo", $vendedorInterno);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

   $sql = $pdo->prepare("SELECT codigo, nome, Comissao1, InternoExterno, DentroCidade, ForaCidade, DentroCidadeInterno, ForaCidadeInterno, DentroCidadeExterno, ForaCidadeExterno FROM vendedores WHERE codigo = :codigo");
   $sql->bindValue(":codigo", $codigoTab);
   $sql->execute();

   $linha = $sql->fetch();

   if ($linha != false) {

      $sInternoExterno = "I";

      if ($linha['InternoExterno'] != null && !empty($linha['InternoExterno'])) {
         $sInternoExterno = $linha['InternoExterno'];
      }

      $uC1 = $linha['DentroCidade'];
      $uC2 = $linha['ForaCidade'];
      $uC3 = $linha['DentroCidadeInterno'];
      $uC4 = $linha['ForaCidadeInterno'];
      $uC5 = $linha['DentroCidadeExterno'];
      $uC6 = $linha['ForaCidadeExterno'];

      $AchaComissaoCasa1 = 0;

      if ($codigoCidade != "" && $codigoCidade != 0) {
         if ($_SESSION['parametros']['codigoCidadeOrcamentos'] <> $codigoCidade) {
            // Fora da Cidade
            if ($vendedorInterno == 0) {
               // Sozinho
               $AchaComissaoCasa1 = $uC2;
            }
      
            else {
               // Tem 2 vendedores
               if ($sInternoExterno == "I") {
                  $AchaComissaoCasa1 = $uC4;
               }
      
               else {
                  $AchaComissaoCasa1 = $uC6;
               }
            }
         }
         
         else {
            // Dentro da Cidade
            if ($vendedorInterno == 0) {
               // Sozinho
               $AchaComissaoCasa1 = $uC1;
            }
      
            else {
               // Tem 2 vendedores
               if ($sInternoExterno == "I") {
                  $AchaComissaoCasa1 = $uC3;
               }
      
               else {
                  $AchaComissaoCasa1 = $uC4;
               }
            }
         }
      }

      ?>

      <script>

      document.getElementById('nomeVendedor').value = "<?php echo $linha['nome']; ?>";

      document.getElementById('comissaoVendedor').value = "<?php echo ValidaValor($AchaComissaoCasa1)."%"; ?>";

      </script>

      <?php

   }

   if ($vendedorInterno != 0 && !empty($vendedorInterno)) {
      
      $sql = $pdo->prepare("SELECT codigo, nome, Comissao1, InternoExterno, DentroCidade, ForaCidade, DentroCidadeInterno, ForaCidadeInterno, DentroCidadeExterno, ForaCidadeExterno FROM vendedores WHERE codigo = :codigo");
      $sql->bindValue(":codigo", $vendedorInterno);
      $sql->execute();
   
      $linha = $sql->fetch();

      if ($linha != false) {

         $sInternoExterno = "I";
   
         if ($linha['InternoExterno'] != null && !empty($linha['InternoExterno'])) {
            $sInternoExterno = $linha['InternoExterno'];
         }
      
         $uC1 = $linha['DentroCidade'];
         $uC2 = $linha['ForaCidade'];
         $uC3 = $linha['DentroCidadeInterno'];
         $uC4 = $linha['ForaCidadeInterno'];
         $uC5 = $linha['DentroCidadeExterno'];
         $uC6 = $linha['ForaCidadeExterno'];
      
         $AchaComissaoCasa2 = 0;
      
         if ($codigoCidade != "" && $codigoCidade != 0) {
            if ($_SESSION['parametros']['codigoCidadeOrcamentos'] <> $codigoCidade) {
               // Fora da Cidade
               if ($vendedorInterno == 0) {
                  // Sozinho
                  $AchaComissaoCasa2 = $uC2;
               }
         
               else {
                  // Tem 2 vendedores
                  if ($sInternoExterno == "I") {
                     $AchaComissaoCasa2 = $uC4;
                  }
         
                  else {
                     $AchaComissaoCasa2 = $uC6;
                  }
               }
            }
            
            else {
               // Dentro da Cidade
               if ($vendedorInterno == 0) {
                  // Sozinho
                  $AchaComissaoCasa2 = $uC1;
               }
         
               else {
                  // Tem 2 vendedores
                  if ($sInternoExterno == "I") {
                     $AchaComissaoCasa2 = $uC3;
                  }
         
                  else {
                     $AchaComissaoCasa2 = $uC4;
                  }
               }
            }
         }
      
         ?>
      
         <script>
      
         document.getElementById('nomeVendedorInterno').value = "<?php echo $linha['nome']; ?>";

         document.getElementById('comissaoVendedor').value = "<?php echo ValidaValor($AchaComissaoCasa1)."%"; ?>";
         document.getElementById('comissaoVendedorInterno').value = "<?php echo ValidaValor($AchaComissaoCasa2)."%"; ?>";
      
         </script>
      
         <?php

      }

   }

}

elseif ($codigoTab == '') {

?>

<script>

document.getElementById('codigoVendedorInterno').value = "";
document.getElementById('nomeVendedorInterno').value = "";
document.getElementById('comissaoVendedorInterno').value = "";

</script>

<?php

}

else {

?>

<script>

document.getElementById('codigoVendedorInterno').value = "";
document.getElementById('nomeVendedorInterno').value = "";
document.getElementById('comissaoVendedorInterno').value = "";
document.getElementById('codigoVendedorInterno').focus();

var Toast = Swal.mixin({
   toast: true,
   position: 'top-end',
   showConfirma: false,
   timer: 3000
});
Toast.fire({
   icon: 'error',
   title: 'O vendedor não foi encontrado ou está inativo.'
})

</script>

<?php

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

  document.getElementById('nomeCidadeCliente').value = "<?php echo $linha['nomecidade']; ?>";
  document.getElementById('estadoCliente').value = "<?php echo $linha['estado']; ?>";

  </script>

  <?php

}

elseif ($codigoTab == '') {

}

else {

?>

<script>

document.getElementById('codigoCidadeCliente').value = "";
document.getElementById('nomeCidadeCliente').value = "";
document.getElementById('estadoCliente').value = "";
document.getElementById('codigoCidadeCliente').focus();

var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirma: false,
  timer: 3000
});
Toast.fire({
  icon: 'error',
  title: 'Esta cidade não foi encontrado ou está inativa.'
})

</script>

<?php

}

  break;

  case 'tabPrazoPagamento':

$codigoTab = $_POST['codigoTab'];

$sql = $pdo->prepare("SELECT Id FROM condicoespagamentos WHERE Id = :codigo AND Ativo = 'S' ORDER BY Descricao");
$sql->bindValue(":codigo", $codigoTab);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

  $sql = $pdo->prepare("SELECT Id, Descricao FROM condicoespagamentos WHERE Id = :codigo AND Ativo = 'S' ORDER BY Descricao");
  $sql->bindValue(":codigo", $codigoTab);
  $sql->execute();

  $linha = $sql->fetch();
    ?>

    <script>
  
    document.getElementById('nomePrazo').value = "<?php echo $linha['Descricao']; ?>";
  
    </script>
  
    <?php

}

elseif ($codigoTab == '') {

}

else {

?>

<script>

document.getElementById('prazoPagamento').value = "";
document.getElementById('nomePrazo').value = "";
document.getElementById('prazoPagamento').focus();

var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirma: false,
  timer: 3000
});
Toast.fire({
  icon: 'error',
  title: 'Este prazo de pagamento não foi encontrado ou está inativo.'
})

</script>

<?php

}

  break;

  case 'tabTipoPagamento':

$codigoTab = $_POST['codigoTab'];

$sql = $pdo->prepare("SELECT Id FROM tipo WHERE id = :codigo AND MostrarVendas = 'S' ");
$sql->bindValue(":codigo", $codigoTab);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

   $sql = $pdo->prepare("SELECT Id, Descricao FROM tipo WHERE id = :codigo AND MostrarVendas = 'S' ");
   $sql->bindValue(":codigo", $codigoTab);
   $sql->execute();

  $linha = $sql->fetch();

    ?>

    <script>
  
    document.getElementById('nomeTipo').value = "<?php echo $linha['Descricao']; ?>";
  
    </script>
  
    <?php

}

elseif ($codigoTab == '') {
  
}

else {

?>

<script>

document.getElementById('tipoPagamento').value = "";
document.getElementById('nomeTipo').value = "";
document.getElementById('tipoPagamento').focus();

var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirma: false,
  timer: 3000
});
Toast.fire({
  icon: 'error',
  title: 'Este tipo de pagamento não foi encontrado ou está inativo.'
})

</script>

<?php

}

  break;

   case 'tabBanco':

$codigoTab = $_POST['codigoTab'];

$sql = $pdo->prepare("SELECT Id FROM banco WHERE id = :codigo");
$sql->bindValue(":codigo", $codigoTab);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

  $sql = $pdo->prepare("SELECT Id, Descricao FROM banco WHERE id = :codigo");
  $sql->bindValue(":codigo", $codigoTab);
  $sql->execute();

  $linha = $sql->fetch();

    ?>

    <script>
  
    document.getElementById('nomeBanco').value = "<?php echo $linha['Descricao']; ?>";
  
    </script>
  
    <?php

}

elseif ($codigoTab == '') {
  
}

else {

?>

<script>

document.getElementById('bancoPagamento').value = "";
document.getElementById('nomeBanco').value = "";
document.getElementById('bancoPagamento').focus();

var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirma: false,
  timer: 3000
});
Toast.fire({
  icon: 'error',
  title: 'Este banco não foi encontrado ou está inativo.'
})

</script>

<?php

}

  break;

  case 'tabLote':

$codigoTab = $_POST['codigoTab'];

$sql = $pdo->prepare("SELECT Codigo FROM loteestoque WHERE Codigo = :codigo");
$sql->bindValue(":codigo", $codigoTab);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

  $sql = $pdo->prepare("SELECT Codigo, Descricao FROM loteestoque WHERE Codigo = :codigo");
  $sql->bindValue(":codigo", $codigoTab);
  $sql->execute();

  $linha = $sql->fetch();

  if ($linha['Codigo'] == 999999) {

   ?>

   <script>

   document.getElementById('nomeLote').value = "PRINCIPAL";

   </script>

   <?php

  }

  else {

   ?>

   <script>

   document.getElementById('nomeLote').value = "<?php echo $linha['Descricao']; ?>";

   </script>

   <?php

  }

}

elseif ($codigoTab == '') {

}

elseif ($codigoTab == 999999) {
  
   ?>

   <script>

   document.getElementById('nomeLote').value = "PRINCIPAL";

   </script>

   <?php

}

else {

?>

<script>

document.getElementById('loteMaterial').value = "";
document.getElementById('nomeLote').value = "";

var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirma: false,
  timer: 3000
});
Toast.fire({
  icon: 'error',
  title: 'Este lote não foi encontrado ou está inativo.'
})

</script>

<?php

}

  break;

  case 'tabLocal':

$codigoTab = $_POST['codigoTab'];

$sql = $pdo->prepare("SELECT Codigo FROM localestoque WHERE Codigo = :codigo");
$sql->bindValue(":codigo", $codigoTab);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

  $sql = $pdo->prepare("SELECT Codigo, Descricao FROM localestoque WHERE Codigo = :codigo");
  $sql->bindValue(":codigo", $codigoTab);
  $sql->execute();

  $linha = $sql->fetch();

  if ($linha['Codigo'] == 999999) {

   ?>

   <script>

   document.getElementById('nomeLocal').value = "PRINCIPAL";

   </script>

   <?php

  }

  else {

   ?>

   <script>

   document.getElementById('nomeLocal').value = "<?php echo $linha['Descricao']; ?>";

   </script>

   <?php

  }

}

elseif ($codigoTab == '') {
  
}

elseif ($codigoTab == 999999) {

   ?>

   <script>

   document.getElementById('nomeLocal').value = "PRINCIPAL";

   </script>

   <?php

}

else {

?>

<script>

document.getElementById('localMaterial').value = "";
document.getElementById('nomeLocal').value = "";

var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirma: false,
  timer: 3000
});
Toast.fire({
  icon: 'error',
  title: 'Este local não foi encontrado ou está inativo.'
})

</script>

<?php

}

  break;

  case 'buscarLote':

$nome = $_POST['nome'];

$sql = $pdo->prepare("SELECT Codigo, Descricao FROM loteestoque WHERE descricao LIKE CONCAT ('%', :descricao , '%')");
$sql->bindValue(":descricao", $nome);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

  foreach ($sql->fetchAll() as $linha) {
    echo "<tr class='text-center' style='line-height: 35px;'>";
      echo "<td scope='row'>".$linha['Codigo']."</td>";
      echo "<td>".$linha['Descricao']."</td>";

      echo "
      <td class='project-actions' style='width: 15%;'>
        <a class='btn btn-success btn-sm' onclick='incluirLote(".$linha['Codigo'].")'><i class='fas fa-plus'></i> Selecionar</a>
      </td>";

    echo "</tr>";
  }

}

else {

  echo "<tr><td colspan='4' class='text-center'>Lote não encontrado!</td></tr>";

}
  
  break;

  case 'buscarLocal':

$nome = $_POST['nome'];

$sql = $pdo->prepare("SELECT Codigo, Descricao FROM localestoque WHERE descricao LIKE CONCAT ('%', :descricao , '%')");
$sql->bindValue(":descricao", $nome);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

  foreach ($sql->fetchAll() as $linha) {
    echo "<tr class='text-center' style='line-height: 35px;'>";
      echo "<td scope='row'>".$linha['Codigo']."</td>";
      echo "<td>".$linha['Descricao']."</td>";

      echo "
      <td class='project-actions' style='width: 15%;'>
        <a class='btn btn-success btn-sm' onclick='incluirLocal(".$linha['Codigo'].")'><i class='fas fa-plus'></i> Selecionar</a>
      </td>";

    echo "</tr>";
  }

}

else {

  echo "<tr><td colspan='4' class='text-center'>Local não encontrado!</td></tr>";

}
  
  break;

  case 'lancarProduto':
  
$codigo = $_POST['codigoMaterial'];
$arrayMaterial = $_POST['arrayMaterial'];
$contadorMaterial = $_POST['contador']-1;

$sql = $pdo->prepare("SELECT codigo, nome, unidade, custov, vendav FROM material WHERE codigo = :codigo AND Ativo = 'S'");
$sql->bindValue(":codigo", $codigo);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

    if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

        $_SESSION['carrinho']['dados']['total'] = 0;

        foreach ($sql->fetchAll() as $linhaProdutoIncluir) {
           $linhaArrayIncluir = array(
              'codigo' => $linhaProdutoIncluir['codigo'],
              'nome' => ValidaString($linhaProdutoIncluir['nome']).' ('.ValidaString($linhaProdutoIncluir['unidade']).')',
              'quantidade' => TrataFloat($arrayMaterial[$contadorMaterial]['quantidade']),
              'unitario' => TrataFloat($arrayMaterial[$contadorMaterial]['unitario']),
              'tabela' => TrataFloat($linhaProdutoIncluir['vendav']),
              'custo' => TrataFloat($linhaProdutoIncluir['custov']),
              'total' => (TrataFloat($arrayMaterial[$contadorMaterial]['unitario'])) * (TrataFloat($arrayMaterial[$contadorMaterial]['quantidade'])),
              'lote' => $arrayMaterial[$contadorMaterial]['lote'],
              'local' => $arrayMaterial[$contadorMaterial]['local'],
           );
        }
     
        if (isset($_SESSION['carrinho']['produtos'])) {
           array_push($_SESSION['carrinho']['produtos'], $linhaArrayIncluir);
        }
     
        else {
           $_SESSION['carrinho']['produtos'][0] = $linhaArrayIncluir;
        }
     
        $_SESSION['carrinho']['contador'] = count($_SESSION['carrinho']['produtos']);
       
        for ($i=0; $i < $_SESSION['carrinho']['contador']; $i++) { 
     
        $sql = $pdo->prepare("SELECT codigo, nome, unidade, custov FROM material WHERE codigo = :codigo AND Ativo = 'S'");
        $sql->bindValue(":codigo", $_SESSION['carrinho']['produtos'][$i]['codigo']);
        $sql->execute();
     
        foreach ($sql->fetchAll() as $linha[$i]) {
           $linhaArray[$i] = array(
              'codigo' => $linha[$i]['codigo'],
              'nome' => ValidaString($linha[$i]['nome']).' ('.ValidaString($linha[$i]['unidade']).')',
              'quantidade' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['quantidade']),
              'unitario' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['unitario']),
              'tabela' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['tabela']),
              'custo' => TrataFloat($linha[$i]['custov']),
              'total' => (TrataFloat($_SESSION['carrinho']['produtos'][$i]['unitario'])) * (TrataFloat($_SESSION['carrinho']['produtos'][$i]['quantidade'])),
              'lote' => $_SESSION['carrinho']['produtos'][$i]['lote'],
              'local' => $_SESSION['carrinho']['produtos'][$i]['local'],
           );
     
        }
     
        echo "<tr class='text-center' style='line-height: 35px;'>";
        echo "<td scope='row'>".$_SESSION['carrinho']['produtos'][$i]['codigo']."</td>";
        echo '<td>'.ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']).'</td>';
        echo "<td>".ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade'])."</td>";
        echo "<td>R$".ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario'])."</td>";
        echo "<td>R$".ValidaValor($_SESSION['carrinho']['produtos'][$i]['total'])."</td>";
     
        $sql = $pdo->prepare("SELECT Descricao FROM loteestoque WHERE Codigo = :codigo");
        $sql->bindValue(":codigo", $_SESSION['carrinho']['produtos'][$i]['lote']);
        $sql->execute();
        $nomeLote = $sql->fetch();
     
        if ($nomeLote == false) {
           $nomeLote['Descricao'] = "";
        }
     
        echo "<td>".ValidaString($nomeLote['Descricao'])."</td>";
     
        $sql = $pdo->prepare("SELECT Descricao FROM localestoque WHERE Codigo = :codigo");
        $sql->bindValue(":codigo", $_SESSION['carrinho']['produtos'][$i]['local']);
        $sql->execute();
        $nomeLocal = $sql->fetch();
     
        if ($nomeLocal == false) {
           $nomeLocal['Descricao'] = "";
        }
     
        echo "<td>".ValidaString($nomeLocal['Descricao'])."</td>";
     
        echo "
        <td class='project-actions' style='width: 10%;'>
           <a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(".$i.")'><i class='fas fa-trash'></i> Excluir</a>
           <a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(".$i.")'><i class='fas fa-trash'></i></a>
        </td>";
     
        echo "</tr>";
     
        ?>
     
        <script>
     
        arrayMaterial[<?php echo $i; ?>]['custo'] = "<?php echo $_SESSION['carrinho']['produtos'][$i]['custo']; ?>";
     
        </script>
     
        <?php
     
       $_SESSION['carrinho']['dados']['total'] = TrataFloat($_SESSION['carrinho']['dados']['total']) + TrataFloat($_SESSION['carrinho']['produtos'][$i]['total']);
     
       }
     
       ?>
     
       <?php

    }
    
    else {

        $_SESSION['carrinho']['dados']['total'] = 0;

        foreach ($sql->fetchAll() as $linhaProdutoIncluir) {
           $linhaArrayIncluir = array(
              'codigo' => $linhaProdutoIncluir['codigo'],
              'nome' => ValidaString($linhaProdutoIncluir['nome']).' ('.ValidaString($linhaProdutoIncluir['unidade']).')',
              'quantidade' => TrataFloat($arrayMaterial[$contadorMaterial]['quantidade']),
              'unitario' => TrataFloat($arrayMaterial[$contadorMaterial]['unitario']),
              'tabela' => TrataFloat($linhaProdutoIncluir['vendav']),
              'custo' => TrataFloat($linhaProdutoIncluir['custov']),
              'total' => (TrataFloat($arrayMaterial[$contadorMaterial]['unitario'])) * (TrataFloat($arrayMaterial[$contadorMaterial]['quantidade'])),
           );
        }
     
        if (isset($_SESSION['carrinho']['produtos'])) {
           array_push($_SESSION['carrinho']['produtos'], $linhaArrayIncluir);
        }
     
        else {
           $_SESSION['carrinho']['produtos'][0] = $linhaArrayIncluir;
        }
     
        $_SESSION['carrinho']['contador'] = count($_SESSION['carrinho']['produtos']);
       
        for ($i=0; $i < $_SESSION['carrinho']['contador']; $i++) { 
     
        $sql = $pdo->prepare("SELECT codigo, nome, unidade, custov FROM material WHERE codigo = :codigo AND Ativo = 'S'");
        $sql->bindValue(":codigo", $_SESSION['carrinho']['produtos'][$i]['codigo']);
        $sql->execute();
     
        foreach ($sql->fetchAll() as $linha[$i]) {
           $linhaArray[$i] = array(
              'codigo' => $linha[$i]['codigo'],
              'nome' => ValidaString($linha[$i]['nome']).' ('.ValidaString($linha[$i]['unidade']).')',
              'quantidade' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['quantidade']),
              'unitario' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['unitario']),
              'tabela' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['tabela']),
              'custo' => TrataFloat($linha[$i]['custov']),
              'total' => (TrataFloat($_SESSION['carrinho']['produtos'][$i]['unitario'])) * (TrataFloat($_SESSION['carrinho']['produtos'][$i]['quantidade'])),
           );
     
        }
     
        echo "<tr class='text-center' style='line-height: 35px;'>";
        echo "<td scope='row'>".$_SESSION['carrinho']['produtos'][$i]['codigo']."</td>";
        echo '<td>'.ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']).'</td>';
        echo "<td>".ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade'])."</td>";
        echo "<td>R$".ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario'])."</td>";
        echo "<td>R$".ValidaValor($_SESSION['carrinho']['produtos'][$i]['total'])."</td>";
     
        echo "
        <td class='project-actions' style='width: 10%;'>
           <a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(".$i.")'><i class='fas fa-trash'></i> Excluir</a>
           <a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(".$i.")'><i class='fas fa-trash'></i></a>
        </td>";
     
        echo "</tr>";
     
        ?>
     
        <script>
     
        arrayMaterial[<?php echo $i; ?>]['custo'] = "<?php echo $_SESSION['carrinho']['produtos'][$i]['custo']; ?>";
     
        </script>
     
        <?php
     
       $_SESSION['carrinho']['dados']['total'] = TrataFloat($_SESSION['carrinho']['dados']['total']) + TrataFloat($_SESSION['carrinho']['produtos'][$i]['total']);
     
       }
     
       ?>
     
       <?php

    }

}

else {

  $_SESSION['carrinho']['dados']['total'] = 0;

  if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

    foreach ($sql->fetchAll() as $linhaProdutoIncluir) {
        $linhaArrayIncluir = array(
          'codigo' => $linhaProdutoIncluir['codigo'],
          'nome' => ValidaString($linhaProdutoIncluir['nome']).' ('.ValidaString($linhaProdutoIncluir['unidade']).')',
          'quantidade' => TrataFloat($arrayMaterial[$contadorMaterial]['quantidade']),
          'unitario' => TrataFloat($arrayMaterial[$contadorMaterial]['unitario']),
          'tabela' => TrataFloat($linhaProdutoIncluir['vendav']),
          'custo' => TrataFloat($linhaProdutoIncluir['custov']),
          'total' => (TrataFloat($arrayMaterial[$contadorMaterial]['unitario'])) * (TrataFloat($arrayMaterial[$contadorMaterial]['quantidade'])),
          'lote' => $arrayMaterial[$contadorMaterial]['lote'],
          'local' => $arrayMaterial[$contadorMaterial]['local'],
        );
      }
    
      if (isset($_SESSION['carrinho']['produtos'])) {
        array_push($_SESSION['carrinho']['produtos'], $linhaArrayIncluir);
      }
    
      else {
        $_SESSION['carrinho']['produtos'][0] = $linhaArrayIncluir;
      }
    
      $_SESSION['carrinho']['contador'] = count($_SESSION['carrinho']['produtos']);
      
      for ($i=0; $i < $_SESSION['carrinho']['contador']; $i++) { 
    
        $sql = $pdo->prepare("SELECT codigo, nome, unidade, custov FROM material WHERE codigo = :codigo AND Ativo = 'S'");
        $sql->bindValue(":codigo", $_SESSION['carrinho']['produtos'][$i]['codigo']);
        $sql->execute();
    
        foreach ($sql->fetchAll() as $linha[$i]) {
            $linhaArray[$i] = array(
              'codigo' => $linha[$i]['codigo'],
              'nome' => ValidaString($linha[$i]['nome']).' ('.ValidaString($linha[$i]['unidade']).')',
              'quantidade' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['quantidade']),
              'unitario' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['unitario']),
              'tabela' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['tabela']),
              'custo' => TrataFloat($linha[$i]['custov']),
              'total' => (TrataFloat($_SESSION['carrinho']['produtos'][$i]['unitario'])) * (TrataFloat($_SESSION['carrinho']['produtos'][$i]['quantidade'])),
              'lote' => $_SESSION['carrinho']['produtos'][$i]['lote'],
              'local' => $_SESSION['carrinho']['produtos'][$i]['local'],
            );
    
        }
    
        echo "<tr class='text-center' style='line-height: 35px;'>";
          echo "<td scope='row'>".$_SESSION['carrinho']['produtos'][$i]['codigo']."</td>";
          echo '<td>'.ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']).'</td>';
          echo "<td>".ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade'])."</td>";
          echo "<td>R$".ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario'])."</td>";
          echo "<td>R$".ValidaValor($_SESSION['carrinho']['produtos'][$i]['total'])."</td>";
    
          $sql = $pdo->prepare("SELECT Descricao FROM loteestoque WHERE Codigo = :codigo");
          $sql->bindValue(":codigo", $_SESSION['carrinho']['produtos'][$i]['lote']);
          $sql->execute();
          $nomeLote = $sql->fetch();
    
          if ($nomeLote == false) {
            $nomeLote['Descricao'] = "";
          }
    
          echo "<td>".ValidaString($nomeLote['Descricao'])."</td>";
    
          $sql = $pdo->prepare("SELECT Descricao FROM localestoque WHERE Codigo = :codigo");
          $sql->bindValue(":codigo", $_SESSION['carrinho']['produtos'][$i]['local']);
          $sql->execute();
          $nomeLocal = $sql->fetch();
    
          if ($nomeLocal == false) {
            $nomeLocal['Descricao'] = "";
          }
    
          echo "<td>".ValidaString($nomeLocal['Descricao'])."</td>";
    
          echo "
          <td class='project-actions' style='width: 10%;'>
          <a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(".$i.")'><i class='fas fa-trash'></i> Excluir</a>
          <a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(".$i.")'><i class='fas fa-trash'></i></a>
          </td>";
    
        echo "</tr>";
    
      $_SESSION['carrinho']['dados']['total'] = TrataFloat($_SESSION['carrinho']['dados']['total']) + TrataFloat($_SESSION['carrinho']['produtos'][$i]['total']);
    
      }
    
      ?>
    
    <script>
    
    document.getElementById('total').value = "R$<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";
    arrayMaterial = <?php echo json_encode($_SESSION['carrinho']['produtos']); ?>;
    
    contador--;
    
    document.getElementById('loteMaterial').value = "";
    document.getElementById('nomeLote').value = "";
    document.getElementById('localMaterial').value = "";
    document.getElementById('nomeLocal').value = "";
    
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirma: false,
      timer: 3000
    });
    
    Toast.fire({
      icon: 'error',
      title: 'O produto não foi encontrado ou está inativo.'
    });
    
    </script>
    
    <?php

  }

  else {

    foreach ($sql->fetchAll() as $linhaProdutoIncluir) {
        $linhaArrayIncluir = array(
          'codigo' => $linhaProdutoIncluir['codigo'],
          'nome' => ValidaString($linhaProdutoIncluir['nome']).' ('.ValidaString($linhaProdutoIncluir['unidade']).')',
          'quantidade' => TrataFloat($arrayMaterial[$contadorMaterial]['quantidade']),
          'unitario' => TrataFloat($arrayMaterial[$contadorMaterial]['unitario']),
          'tabela' => TrataFloat($linhaProdutoIncluir['vendav']),
          'custo' => TrataFloat($linhaProdutoIncluir['custov']),
          'total' => (TrataFloat($arrayMaterial[$contadorMaterial]['unitario'])) * (TrataFloat($arrayMaterial[$contadorMaterial]['quantidade'])),
        );
      }
    
      if (isset($_SESSION['carrinho']['produtos'])) {
        array_push($_SESSION['carrinho']['produtos'], $linhaArrayIncluir);
      }
    
      else {
        $_SESSION['carrinho']['produtos'][0] = $linhaArrayIncluir;
      }
    
      $_SESSION['carrinho']['contador'] = count($_SESSION['carrinho']['produtos']);
      
      for ($i=0; $i < $_SESSION['carrinho']['contador']; $i++) { 
    
        $sql = $pdo->prepare("SELECT codigo, nome, unidade, custov FROM material WHERE codigo = :codigo AND Ativo = 'S'");
        $sql->bindValue(":codigo", $_SESSION['carrinho']['produtos'][$i]['codigo']);
        $sql->execute();
    
        foreach ($sql->fetchAll() as $linha[$i]) {
            $linhaArray[$i] = array(
              'codigo' => $linha[$i]['codigo'],
              'nome' => ValidaString($linha[$i]['nome']).' ('.ValidaString($linha[$i]['unidade']).')',
              'quantidade' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['quantidade']),
              'unitario' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['unitario']),
              'tabela' => TrataFloat($_SESSION['carrinho']['produtos'][$i]['tabela']),
              'custo' => TrataFloat($linha[$i]['custov']),
              'total' => (TrataFloat($_SESSION['carrinho']['produtos'][$i]['unitario'])) * (TrataFloat($_SESSION['carrinho']['produtos'][$i]['quantidade'])),
            );
    
        }
    
        echo "<tr class='text-center' style='line-height: 35px;'>";
          echo "<td scope='row'>".$_SESSION['carrinho']['produtos'][$i]['codigo']."</td>";
          echo '<td>'.ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']).'</td>';
          echo "<td>".ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade'])."</td>";
          echo "<td>R$".ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario'])."</td>";
          echo "<td>R$".ValidaValor($_SESSION['carrinho']['produtos'][$i]['total'])."</td>";
    
          echo "
          <td class='project-actions' style='width: 10%;'>
          <a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(".$i.")'><i class='fas fa-trash'></i> Excluir</a>
          <a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(".$i.")'><i class='fas fa-trash'></i></a>
          </td>";
    
        echo "</tr>";
    
      $_SESSION['carrinho']['dados']['total'] = TrataFloat($_SESSION['carrinho']['dados']['total']) + TrataFloat($_SESSION['carrinho']['produtos'][$i]['total']);
    
      }
    
      ?>
    
    <script>
    
    document.getElementById('total').value = "R$<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";
    arrayMaterial = <?php echo json_encode($_SESSION['carrinho']['produtos']); ?>;
    
    contador--;
    
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirma: false,
      timer: 3000
    });
    
    Toast.fire({
      icon: 'error',
      title: 'O produto não foi encontrado ou está inativo.'
    });
    
    </script>
    
    <?php

  }

}

if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

    ?>

    <script>

        document.getElementById('total').value = "R$<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";
        document.getElementById('codigoMaterial').focus();
        document.getElementById('codigoMaterial').value = "";
        document.getElementById('nomeMaterial').value = "";
        document.getElementById('quantidadeMaterial').value = "";
        // document.getElementById('estoqueMaterial').value = "";
        document.getElementById('unitarioMaterial').value = "";
        document.getElementById('totalMaterial').value = "";
        document.getElementById('loteMaterial').value = "";
        document.getElementById('nomeLote').value = "";
        document.getElementById('localMaterial').value = "";
        document.getElementById('nomeLocal').value = "";

    </script>
    
    <?php

}

else {

    ?>

    <script>

        document.getElementById('total').value = "R$<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";
        document.getElementById('codigoMaterial').focus();
        document.getElementById('codigoMaterial').value = "";
        document.getElementById('nomeMaterial').value = "";
        document.getElementById('quantidadeMaterial').value = "";
        // document.getElementById('estoqueMaterial').value = "";
        document.getElementById('unitarioMaterial').value = "";
        document.getElementById('totalMaterial').value = "";

    </script>
    
    <?php

}

  break;

  case 'excluirProduto':

$indiceArray = $_POST['indiceArray'];
$total = $_POST['total'];

if (isset($_POST['arrayMaterial'])) {
  $arrayMaterial = $_POST['arrayMaterial'];

   if (isset($_SESSION['carrinho']['dados']['frete'])) {
      $_SESSION['carrinho']['dados']['total'] = $total + $_SESSION['carrinho']['dados']['frete'];
   }

   else {
      $_SESSION['carrinho']['dados']['total'] = $total;      
   }

  $_SESSION['carrinho']['produtos'] = $arrayMaterial;
  $_SESSION['carrinho']['contador'] = count($_SESSION['carrinho']['produtos']);

   ?>

   <script>

   document.getElementById('total').value = "R$" + "<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";

   </script>

   <?php

}

else {

   if (isset($_SESSION['carrinho']['dados']['frete'])) {
      $_SESSION['carrinho']['dados']['total'] = 0;
      unset($_SESSION['carrinho']['dados']['frete']);
   }

   else {
      $_SESSION['carrinho']['dados']['total'] = 0;
   }

  unset($_SESSION['carrinho']['produtos']);
  $_SESSION['carrinho']['contador'] = 0;

   ?>

   <script>

   document.getElementById('total').value = "";

   </script>

   <?php

}

if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

    for ($i=0; $i < $_SESSION['carrinho']['contador']; $i++) { 

        $sql = $pdo->prepare("SELECT Descricao FROM loteestoque WHERE Codigo = :codigo");
        $sql->bindValue(":codigo", ValidaString($_SESSION['carrinho']['produtos'][$i]['lote']));
        $sql->execute();
      
        $nomeLote = $sql->fetch();
      
        if ($nomeLote == false) {
          $nomeLote['Descricao'] = "";
        }
      
        $sql = $pdo->prepare("SELECT Descricao FROM localestoque WHERE Codigo = :codigo");
        $sql->bindValue(":codigo", ValidaString($_SESSION['carrinho']['produtos'][$i]['local']));
        $sql->execute();
      
        $nomeLocal = $sql->fetch();
      
        if ($nomeLocal == false) {
          $nomeLocal['Descricao'] = "";
        }
      
        ?>
      
        <script>
      
        var tr = "<tr><td><?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?></td>";
        tr = tr + '<td><?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?></td>';
        tr = tr + "<td><?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['total']); ?></td>";
        tr = tr + "<td><?php echo ValidaString($nomeLote['Descricao']); ?></td>";
        tr = tr + "<td><?php echo ValidaString($nomeLocal['Descricao']); ?></td>";
        tr = tr + "<td class='project-actions' style='width: 10%;'>";
          tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
          tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
      
        $("#lancamentos-produtos tbody").append(tr);
          
        </script>    
      
        <?php
      
      }

}
  
else {

    for ($i=0; $i < $_SESSION['carrinho']['contador']; $i++) {
      
        ?>
      
        <script>
      
        var tr = "<tr><td><?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?></td>";
        tr = tr + '<td><?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?></td>';
        tr = tr + "<td><?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['total']); ?></td>";
        tr = tr + "<td class='project-actions' style='width: 10%;'>";
          tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
          tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
      
        $("#lancamentos-produtos tbody").append(tr);
          
        </script>    
      
        <?php
      
      }

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

  case 'buscarVendedor':

$nome = $_POST['nome'];

$sql = $pdo->prepare("SELECT Codigo, Nome FROM vendedores WHERE Nome LIKE CONCAT ('%', :nome , '%')");
$sql->bindValue(":nome", $nome);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

  foreach ($sql->fetchAll() as $linha) {
    echo "<tr class='text-center' style='line-height: 35px;'>";
      echo "<td scope='row'>".$linha['Codigo']."</td>";
      echo "<td>".$linha['Nome']."</td>";

      echo "
      <td class='project-actions' style='width: 15%;'>
        <a class='btn btn-success btn-sm' onclick='incluirVendedor(".$linha['Codigo'].")'><i class='fas fa-plus'></i> Selecionar</a>
      </td>";

    echo "</tr>";
  }

}

else {

  echo "<tr><td colspan='4' class='text-center'>Vendedor não encontrado!</td></tr>";

}
  
  break;

  case 'buscarVendedorInterno':

$nome = $_POST['nome'];

$sql = $pdo->prepare("SELECT Codigo, Nome FROM vendedores WHERE Nome LIKE CONCAT ('%', :nome , '%')");
$sql->bindValue(":nome", $nome);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

   foreach ($sql->fetchAll() as $linha) {
      echo "<tr class='text-center' style='line-height: 35px;'>";
      echo "<td scope='row'>".$linha['Codigo']."</td>";
      echo "<td>".$linha['Nome']."</td>";

      echo "
      <td class='project-actions' style='width: 15%;'>
         <a class='btn btn-success btn-sm' onclick='incluirVendedorInterno(".$linha['Codigo'].")'><i class='fas fa-plus'></i> Selecionar</a>
      </td>";

      echo "</tr>";
   }

}

else {

   echo "<tr><td colspan='4' class='text-center'>Vendedor não encontrado!</td></tr>";

}
   
   break;

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

  case 'buscarPrazoPagamento':

$nome = $_POST['nome'];

$sql = $pdo->prepare("SELECT Id, Descricao FROM condicoespagamentos WHERE Descricao LIKE CONCAT ('%', :nome , '%') AND Ativo = 'S' ORDER BY Descricao");
$sql->bindValue(":nome", $nome);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

  foreach ($sql->fetchAll() as $linha) {

    echo "<tr class='text-center' style='line-height: 35px;'>";
      echo "<td scope='row'>".$linha['Id']."</td>";
      echo "<td>".$linha['Descricao']."</td>";

      echo "
      <td class='project-actions' style='width: 15%;'>
        <a class='btn btn-success btn-sm' onclick='incluirPrazoPagamento(".$linha['Id'].")'><i class='fas fa-plus'></i> Selecionar</a>
      </td>";

    echo "</tr>";
  }

}

else {

  echo "<tr><td colspan='4' class='text-center'>Prazo de pagamento não encontrado!</td></tr>";

}
  
  break;

  case 'buscarTipoPagamento':

$nome = $_POST['nome'];

$sql = $pdo->prepare("SELECT Id, Descricao FROM tipo WHERE Descricao LIKE CONCAT ('%', :nome , '%') AND MostrarVendas = 'S' ORDER BY Descricao");
$sql->bindValue(":nome", $nome);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

  foreach ($sql->fetchAll() as $linha) {
    echo "<tr class='text-center' style='line-height: 35px;'>";
      echo "<td scope='row'>".$linha['Id']."</td>";
      echo "<td>".$linha['Descricao']."</td>";

      echo "
      <td class='project-actions' style='width: 15%;'>
        <a class='btn btn-success btn-sm' onclick='incluirTipoPagamento(".$linha['Id'].")'><i class='fas fa-plus'></i> Selecionar</a>
      </td>";

    echo "</tr>";
  }

}

else {

  echo "<tr><td colspan='4' class='text-center'>Tipo de pagamento não encontrado!</td></tr>";

}
  
  break;

  case 'buscarBanco':

$nome = $_POST['nome'];

$sql = $pdo->prepare("SELECT Id, Descricao FROM banco WHERE Descricao LIKE CONCAT ('%', :nome , '%')");
$sql->bindValue(":nome", $nome);
$sql->execute();

$qtd = $sql->rowCount();

if($qtd>0) {

  foreach ($sql->fetchAll() as $linha) {
    echo "<tr class='text-center' style='line-height: 35px;'>";
      echo "<td scope='row'>".$linha['Id']."</td>";
      echo "<td>".$linha['Descricao']."</td>";

      echo "
      <td class='project-actions' style='width: 15%;'>
        <a class='btn btn-success btn-sm' onclick='incluirBanco(".$linha['Id'].")'><i class='fas fa-plus'></i> Selecionar</a>
      </td>";

    echo "</tr>";
  }

}

else {

  echo "<tr><td colspan='4' class='text-center'>Banco não encontrado!</td></tr>";

}
  
  break;

  case 'validaDescontoOrcamentoPorcentagem':

$desconto = floatval($_POST['desconto']);

?>
<script>
document.getElementById('descontoOrcamento').value = "<?php echo ValidaValor($desconto); ?>";
</script>
<?php

$sql = $pdo->prepare("SELECT Desconto FROM Parametros");
$sql->execute();
$descontoPermitido = $sql->fetch();

if ($descontoPermitido != false && $descontoPermitido != null) {
   if ($descontoPermitido['Desconto'] != null) {
      $descontoPermitido = floatval($descontoPermitido['Desconto']);
   }
}

$sql = $pdo->prepare("SELECT Descontos FROM Usuarios WHERE Id = :id");
$sql->bindValue(":id", $info['Id']);
$sql->execute();
$descontoPermitidoUsuario = $sql->fetch();

if ($descontoPermitidoUsuario != false && $descontoPermitidoUsuario != null) {
   if ($descontoPermitidoUsuario['Descontos'] != null && $descontoPermitidoUsuario['Descontos'] > 0) {
      $descontoPermitido = floatval($descontoPermitidoUsuario['Descontos']);
   }
}

$sql = $pdo->prepare("SELECT IdUsuario FROM Direitos_Dados WHERE IdUsuario = :idusuario AND OpcoesPermitidas='300855'");
$sql->bindValue(":idusuario", $info['Id']);
$sql->execute();

if ($sql->fetch() != false) {

   $sql = $pdo->prepare("SELECT IdUsuario FROM Direitos_Dados WHERE IdUsuario = :idusuario AND OpcoesPermitidas='300908'");
   $sql->bindValue(":idusuario", $info['Id']);
   $sql->execute();
   
   if ($sql->fetch() != false) {
      if ($desconto > $descontoPermitido) {
         ?>
   
         <script>
   
            Toast.fire({
               icon: 'warning',
               title: 'Atenção! Desconto acima do permitido nos parâmetros.'
            });
   
         </script>
   
         <?php
      }
   }
   
   else {
      if ($desconto > $descontoPermitido) {
         ?>
   
         <script>
   
            Toast.fire({
               icon: 'error',
               title: 'Atenção! Desconto acima do permitido nos parâmetros.'
            });
   
            document.getElementById('descontoOrcamento').value = "";
   
         </script>
   
         <?php
   
         exit;
      }
   }
   
   ?>
   
   <script>

   document.getElementById("codigoMaterial").focus();
   
   $('#confirmacaoDescontoPorcentagemModal').modal();
   
   document.getElementById('descontoModalPorcentagem').innerHTML = "<?php echo $desconto; ?>%";
   
   </script>
   
   <?php

}

else {
   ?>
   
   <script>

      Toast.fire({
         icon: 'error',
         title: 'Você não possui permissão para dar descontos em orçamentos.'
      });

      document.getElementById('descontoOrcamento').value = "";

   </script>

   <?php
}

  break;

  case 'validaDescontoOrcamentoReais':

$desconto = floatval($_POST['desconto']);

?>
<script>
document.getElementById('descontoOrcamento').value = "<?php echo ValidaValor($desconto); ?>";
</script>
<?php

$sql = $pdo->prepare("SELECT Desconto FROM Parametros");
$sql->execute();
$descontoPermitido = $sql->fetch();

if ($descontoPermitido != false && $descontoPermitido != null) {
   if ($descontoPermitido['Desconto'] != null) {
      $descontoPermitido = floatval($descontoPermitido['Desconto']);
   }
}

$sql = $pdo->prepare("SELECT Descontos FROM Usuarios WHERE Id = :id");
$sql->bindValue(":id", $info['Id']);
$sql->execute();
$descontoPermitidoUsuario = $sql->fetch();

if ($descontoPermitidoUsuario != false && $descontoPermitidoUsuario != null) {
   if ($descontoPermitidoUsuario['Descontos'] != null && $descontoPermitidoUsuario['Descontos'] > 0) {
      $descontoPermitido = floatval($descontoPermitidoUsuario['Descontos']);
   }
}

$sql = $pdo->prepare("SELECT IdUsuario FROM Direitos_Dados WHERE IdUsuario = :idusuario AND OpcoesPermitidas='300855'");
$sql->bindValue(":idusuario", $info['Id']);
$sql->execute();

if ($sql->fetch() != false) {

   $totalOrcamento = 0;

   for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 

      if (round($_SESSION['carrinho']['produtos'][$i]['unitario'], 3) >= round($_SESSION['carrinho']['produtos'][$i]['tabela'], 3)) {

         $totalOrcamento += $_SESSION['carrinho']['produtos'][$i]['unitario'];
         
      }

      else {

         // JÁ APLICADO O DESCONTO

         exit;

      }

   }

   $desconto = Round($desconto / $totalOrcamento * 100, 6);

   $sql = $pdo->prepare("SELECT IdUsuario FROM Direitos_Dados WHERE IdUsuario = :idusuario AND OpcoesPermitidas='300908'");
   $sql->bindValue(":idusuario", $info['Id']);
   $sql->execute();

   if ($sql->fetch() != false) {
      if ($desconto > $descontoPermitido) {
         ?>

         <script>

            Toast.fire({
               icon: 'warning',
               title: 'Atenção! Desconto acima do permitido nos parâmetros.'
            });

         </script>

         <?php
      }
   }

   else {
      if ($desconto > $descontoPermitido) {
         ?>

         <script>

            Toast.fire({
               icon: 'error',
               title: 'Atenção! Desconto acima do permitido nos parâmetros.'
            });

            document.getElementById('descontoOrcamento').value = "";

         </script>

         <?php

         exit;
      }
   }

   ?>

   <script>

   document.getElementById("codigoMaterial").focus();

   $('#confirmacaoDescontoReaisModal').modal();

   document.getElementById('descontoModalReais').innerHTML = "R$ <?php echo ValidaValor($_POST['desconto']); ?>";

   </script>

   <?php

}

else {
   ?>
   
   <script>

      Toast.fire({
         icon: 'error',
         title: 'Você não possui permissão para dar descontos em orçamentos.'
      });

      document.getElementById('descontoOrcamento').value = "";

   </script>

   <?php
}

   break;

  case 'aplicarDescontoPorcentagem':

$desconto = floatval($_POST['desconto']);

$sql = $pdo->prepare("SELECT Desconto FROM Parametros");
$sql->execute();
$descontoPermitido = $sql->fetch();

if ($descontoPermitido != false && $descontoPermitido != null) {
   if ($descontoPermitido['Desconto'] != null) {
      $descontoPermitido = floatval($descontoPermitido['Desconto']);
   }
}

$sql = $pdo->prepare("SELECT Descontos FROM Usuarios WHERE Id = :id");
$sql->bindValue(":id", $info['Id']);
$sql->execute();
$descontoPermitidoUsuario = $sql->fetch();

if ($descontoPermitidoUsuario != false && $descontoPermitidoUsuario != null) {
   if ($descontoPermitidoUsuario['Descontos'] != null && $descontoPermitidoUsuario['Descontos'] > 0) {
      $descontoPermitido = floatval($descontoPermitidoUsuario['Descontos']);
   }
}

$sql = $pdo->prepare("SELECT IdUsuario FROM Direitos_Dados WHERE IdUsuario = :idusuario AND OpcoesPermitidas='300855'");
$sql->bindValue(":idusuario", $info['Id']);
$sql->execute();

if ($sql->fetch() != false) {

   $sql = $pdo->prepare("SELECT IdUsuario FROM Direitos_Dados WHERE IdUsuario = :idusuario AND OpcoesPermitidas='300908'");
   $sql->bindValue(":idusuario", $info['Id']);
   $sql->execute();

   if ($sql->fetch() != false) {
      if ($desconto > $descontoPermitido) {
         ?>

         <script>

            Toast.fire({
               icon: 'warning',
               title: 'Atenção! Desconto acima do permitido nos parâmetros.'
            });

         </script>

         <?php
      }
   }

   else {
      if ($desconto > $descontoPermitido) {
         ?>

         <script>

            Toast.fire({
               icon: 'error',
               title: 'Atenção! Desconto acima do permitido nos parâmetros.'
            });

            document.getElementById('descontoOrcamento').value = "";

         </script>

         <?php

         exit;
      }
   }

   $_SESSION['carrinho']['dados']['total'] = 0;

   if (isset($_SESSION['carrinho']['dados']['frete'])) {
      $_SESSION['carrinho']['dados']['total'] += $_SESSION['carrinho']['dados']['frete'];
   }

   for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 
      
      $sql = $pdo->prepare("SELECT VendaV, CustoV, MargemMinimaV FROM material WHERE Codigo = :codigo");
      $sql->bindValue(":codigo", $_SESSION['carrinho']['produtos'][$i]['codigo']);
      $sql->execute();

      $resultMaterial = $sql->fetch();

      $precoTabela = $_SESSION['carrinho']['produtos'][$i]['tabela'];
      $custoTabela = $resultMaterial['CustoV'];
      $margemTabela = $resultMaterial['MargemMinimaV'];

      if ($margemTabela > 0) {
         $precoMinimo = $custoTabela + round(($custoTabela * $margemTabela) / 100, 2);
      }

      else {
         $precoMinimo = 0;
      }

      if (round($_SESSION['carrinho']['produtos'][$i]['unitario'], 3) >= round($_SESSION['carrinho']['produtos'][$i]['tabela'], 3)) {
      
         $sql = $pdo->prepare("SELECT * FROM Direitos_Dados WHERE IdUsuario = :idusuario AND OpcoesPermitidas='300905'");
         $sql->bindValue(":idusuario", $info['Id']);
         $sql->execute();

         if ($sql->fetch() != false) {
            $sPermissaoDesconto = "S";
         }

         else {
            $sPermissaoDesconto = "N";
         }

         $precoAtual = Round($_SESSION['carrinho']['produtos'][$i]['unitario'] - Round(($_SESSION['carrinho']['produtos'][$i]['unitario'] * $desconto) / 100, 3), 2);

         if ((round($precoAtual, 3) < round($precoMinimo, 3)) && $sPermissaoDesconto != "S") {
            
            ?>

            <script>

            Toast.fire({
               icon: 'error',
               title: 'O preço mínimo do produto <?php echo $_SESSION["carrinho"]["produtos"][$i]["codigo"]; ?> é de R$<?php echo ValidaValor($precoMinimo); ?>'
            });

            </script>

            <?php

         }

         else {
            $_SESSION['carrinho']['produtos'][$i]['unitario'] =
            Round($_SESSION['carrinho']['produtos'][$i]['unitario'] - Round(($_SESSION['carrinho']['produtos'][$i]['unitario'] * $desconto) / 100, 3), 2);

            $_SESSION['carrinho']['produtos'][$i]['total'] =
            Round($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade'], 2);

         }

      }

      else {
         ?>

         <script>

            Toast.fire({
               icon: 'error',
               title: 'Já existe um desconto neste orçamento, volte o preço de tabela e tente novamente.'
            });

         </script>

         <?php
      }

      $_SESSION['carrinho']['dados']['total'] += TrataFloat($_SESSION['carrinho']['produtos'][$i]['total']);

   }

   ?>

   <script>

   $("#lancamentos-produtos tbody").empty();

   $('#confirmacaoDescontoPorcentagemModal').modal('hide');
   
   contador = 0;
   arrayMaterial = [];
   
   </script>
   
   <?php

   $diferencaTabela = 0;
   $totalTabela = 0;

    if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

        for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 
            
            $sql = $pdo->prepare("SELECT Descricao FROM loteestoque WHERE Codigo = :codigo");
            $sql->bindValue(":codigo", ValidaString($_SESSION['carrinho']['produtos'][$i]['lote']));
            $sql->execute();

            $nomeLote = $sql->fetch();

            if ($nomeLote == false) {
                if ($_SESSION['carrinho']['produtos'][$i]['lote'] == 999999) {
                    $nomeLote['Descricao'] = "PRINCIPAL";
                }

                else {
                    $nomeLote['Descricao'] = "";
                }
            }

            $sql = $pdo->prepare("SELECT Descricao FROM localestoque WHERE Codigo = :codigo");
            $sql->bindValue(":codigo", ValidaString($_SESSION['carrinho']['produtos'][$i]['local']));
            $sql->execute();

            $nomeLocal = $sql->fetch();

            if ($nomeLocal == false) {
                    if ($_SESSION['carrinho']['produtos'][$i]['local'] == 999999) {
                    $nomeLocal['Descricao'] = "PRINCIPAL";
                    }

                    else {
                    $nomeLocal['Descricao'] = "";
                    }
            }
            
            ?>
            
            <script>
            
            var tr = "<tr><td><?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?></td>";
            tr = tr + '<td><?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?></td>';
            tr = tr + "<td><?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade']); ?></td>";
            tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario']); ?></td>";
            tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['total']); ?></td>";
            tr = tr + "<td><?php echo ValidaString($nomeLote['Descricao']); ?></td>";
            tr = tr + "<td><?php echo ValidaString($nomeLocal['Descricao']); ?></td>";
            tr = tr + "<td class='project-actions' style='width: 10%;'>";
                tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
                    tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
                tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
                    tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
                        
            arrayMaterial[contador] = ({
                codigo: parseInt(<?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?>),
                nome: '<?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?>',
                quantidade: <?php echo $_SESSION['carrinho']['produtos'][$i]['quantidade']; ?>,
                unitario: <?php echo $_SESSION['carrinho']['produtos'][$i]['unitario']; ?>,
                tabela: <?php echo $_SESSION['carrinho']['produtos'][$i]['tabela']; ?>,
                custo: <?php echo $_SESSION['carrinho']['produtos'][$i]['custo']; ?>,
                total: <?php echo ($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']); ?>,
                lote: <?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['lote']); ?>,
                local: <?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['local']); ?>,
            });
            
            contador++;
            
            $("#lancamentos-produtos tbody").append(tr);
                
            </script>    
            
            <?php

            $totalTabela += ($_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']);

            if ($_SESSION['carrinho']['produtos'][$i]['unitario'] > $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                $diferencaTabela += (
                    (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                    -

                    (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                );
            }

            else {
                if ($_SESSION['carrinho']['produtos'][$i]['unitario'] < $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                    $diferencaTabela -= (
                    (
                        $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )
        
                    -
        
                    (
                        $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )
        
                    );
                }
            }
        }

    }

    else {

        for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) {
            
            ?>
            
            <script>
            
            var tr = "<tr><td><?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?></td>";
            tr = tr + '<td><?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?></td>';
            tr = tr + "<td><?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade']); ?></td>";
            tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario']); ?></td>";
            tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['total']); ?></td>";
            tr = tr + "<td class='project-actions' style='width: 10%;'>";
                tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
                    tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
                tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
                    tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
                        
            arrayMaterial[contador] = ({
                codigo: parseInt(<?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?>),
                nome: '<?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?>',
                quantidade: <?php echo $_SESSION['carrinho']['produtos'][$i]['quantidade']; ?>,
                unitario: <?php echo $_SESSION['carrinho']['produtos'][$i]['unitario']; ?>,
                tabela: <?php echo $_SESSION['carrinho']['produtos'][$i]['tabela']; ?>,
                custo: <?php echo $_SESSION['carrinho']['produtos'][$i]['custo']; ?>,
                total: <?php echo ($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']); ?>,
            });
            
            contador++;
            
            $("#lancamentos-produtos tbody").append(tr);
                
            </script>    
            
            <?php

            $totalTabela += ($_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']);

            if ($_SESSION['carrinho']['produtos'][$i]['unitario'] > $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                $diferencaTabela += (
                    (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                    -

                    (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                );
            }

            else {
                if ($_SESSION['carrinho']['produtos'][$i]['unitario'] < $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                    $diferencaTabela -= (
                    (
                        $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )
        
                    -
        
                    (
                        $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )
        
                    );
                }
            }
        }

    }

    if ($diferencaTabela > 0) {

        $porcentagem = round(($diferencaTabela/$totalTabela)*100, 2);

        ?>

        <script>

        if (document.getElementById('divDesconto').classList.contains('d-none')) {
            document.getElementById('divDesconto').classList.remove("d-none");
            document.getElementById('divDesconto').classList.add("d-block");
        }

        document.getElementById('descontoLabel').innerHTML = "Acréscimo";

        document.getElementById('descAcresc').value = "R$ " + "<?php echo ValidaValor($diferencaTabela); ?>" + " | " + "<?php echo ValidaValor($porcentagem); ?>" + "%";

        </script>

        <?php
    }

    else {
        if ($diferencaTabela < 0) {

            $porcentagem = round((($diferencaTabela*(-1))/$totalTabela)*100, 2);

            ?>

            <script>
    
            if (document.getElementById('divDesconto').classList.contains('d-none')) {
                document.getElementById('divDesconto').classList.remove("d-none");
                document.getElementById('divDesconto').classList.add("d-block");
            }
    
            document.getElementById('descontoLabel').innerHTML = "Desconto";
    
            document.getElementById('descAcresc').value = "R$ " + "<?php echo ValidaValor($diferencaTabela); ?>" + " | " + "<?php echo ValidaValor($porcentagem); ?>" + "%";
    
            </script>
    
            <?php
        }

        else {
            ?>

            <script>
    
            if (document.getElementById('divDesconto').classList.contains('d-block')) {
                document.getElementById('divDesconto').classList.remove("d-block");
                document.getElementById('divDesconto').classList.add("d-none");
            }
    
            document.getElementById('descontoLabel').innerHTML = "Desconto/Acréscimo";
    
            document.getElementById('descAcresc').value = "";
    
            </script>
    
            <?php
        }
    }

   ?>

   <script>

   document.getElementById('descontoOrcamento').value = "";

   document.getElementById('total').value = "R$<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";
   arrayMaterial = <?php echo json_encode($_SESSION['carrinho']['produtos']); ?>;

   document.getElementById('codigoMaterial').focus();

   </script>

   <?php

}

else {
   ?>
   
   <script>

      Toast.fire({
         icon: 'error',
         title: 'Você não possui permissão para dar descontos em orçamentos.'
      });

      document.getElementById('descontoOrcamento').value = "";

   </script>

   <?php
}

   break;

   case 'aplicarDescontoReais':

if (isset($_POST['unitario'])) {
   $unitario = floatval($_POST['unitario']);

   $sql = $pdo->prepare("SELECT VendaV From Material WHERE Codigo = :codigo");
   $sql->bindValue(":codigo", $_POST['codigo']);
   $sql->execute();

   $resultVenda = $sql->fetch();

   $desconto = floatval($resultVenda['VendaV']) - $unitario;
}

else {
   $desconto = floatval($_POST['desconto']);
}

$sql = $pdo->prepare("SELECT Desconto FROM Parametros");
$sql->execute();
$descontoPermitido = $sql->fetch();

if ($descontoPermitido != false && $descontoPermitido != null) {
   if ($descontoPermitido['Desconto'] != null) {
      $descontoPermitido = floatval($descontoPermitido['Desconto']);
   }
}

$sql = $pdo->prepare("SELECT Descontos FROM Usuarios WHERE Id = :id");
$sql->bindValue(":id", $info['Id']);
$sql->execute();
$descontoPermitidoUsuario = $sql->fetch();

if ($descontoPermitidoUsuario != false && $descontoPermitidoUsuario != null) {
   if ($descontoPermitidoUsuario['Descontos'] != null && $descontoPermitidoUsuario['Descontos'] > 0) {
      $descontoPermitido = floatval($descontoPermitidoUsuario['Descontos']);
   }
}

if ($unitario < $resultVenda['VendaV']) {

    $sql = $pdo->prepare("SELECT IdUsuario FROM Direitos_Dados WHERE IdUsuario = :idusuario AND OpcoesPermitidas='300855'");
    $sql->bindValue(":idusuario", $info['Id']);
    $sql->execute();
    
    if ($sql->fetch() != false) {
    
        if (isset($_POST['unitario'])) {
    
            $desconto = Round($desconto / floatval($resultVenda['VendaV']) * 100, 6);
    
        }
    
        else {
    
            $totalOrcamento = 0;
    
            for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 
        
                if (round($_SESSION['carrinho']['produtos'][$i]['unitario'], 3) >= round($_SESSION['carrinho']['produtos'][$i]['tabela'], 3)) {
        
                $totalOrcamento += $_SESSION['carrinho']['produtos'][$i]['unitario'];
                
                }
    
                else {
    
                // JÁ APLICADO O DESCONTO
        
                exit;
                
                }
        
            }
        
            $desconto = Round($desconto / $totalOrcamento * 100, 6);
    
        }
    
        $sql = $pdo->prepare("SELECT IdUsuario FROM Direitos_Dados WHERE IdUsuario = :idusuario AND OpcoesPermitidas='300908'");
        $sql->bindValue(":idusuario", $info['Id']);
        $sql->execute();
    
        if ($sql->fetch() != false) {
            if ($desconto > $descontoPermitido) {
                ?>
    
                <script>
    
                Toast.fire({
                    icon: 'warning',
                    title: 'Atenção! Desconto acima do permitido nos parâmetros.'
                });
    
                </script>
    
                <?php
    
                if (isset($_POST['unitario'])) {
                ?>
    
                <script>
    
                var valorUnitario = parseFloat((document.getElementById("unitarioMaterial").value).toString().replace(",", "."));
                var valorQuantidade = parseFloat((document.getElementById("quantidadeMaterial").value).toString().replace(",", "."));
    
                if (valorUnitario == 0 || valorQuantidade == 0 || !valorUnitario || !valorQuantidade) {
                    document.getElementById("totalMaterial").value = 0;
                }
    
                else {
                    document.getElementById("totalMaterial").value = ((valorUnitario*valorQuantidade).toFixed(2)).toString().replace(".", ",");
                }
    
                </script>
    
    
                <?php
    
                exit;
                }
            }
    
            else {
                if (isset($_POST['unitario'])) {
                ?>
    
                <script>
    
                var valorUnitario = parseFloat((document.getElementById("unitarioMaterial").value).toString().replace(",", "."));
                var valorQuantidade = parseFloat((document.getElementById("quantidadeMaterial").value).toString().replace(",", "."));
    
                if (valorUnitario == 0 || valorQuantidade == 0 || !valorUnitario || !valorQuantidade) {
                    document.getElementById("totalMaterial").value = 0;
                }
    
                else {
                    document.getElementById("totalMaterial").value = ((valorUnitario*valorQuantidade).toFixed(2)).toString().replace(".", ",");
                }
    
                </script>
    
                <?php
    
                exit;
                }
            }
        }
    
        else {
            if ($desconto > $descontoPermitido) {
                ?>
    
                <script>
    
                Toast.fire({
                    icon: 'error',
                    title: 'Atenção! Desconto acima do permitido nos parâmetros.'
                });
    
                document.getElementById('descontoOrcamento').value = "";
    
                </script>
    
                <?php
    
                if (isset($_POST['unitario'])) {
                ?>
    
                <script>
    
                document.getElementById("unitarioMaterial").value = '<?php echo ValidaValor($resultVenda['VendaV'])?>';
                document.getElementById("totalMaterial").value = ((parseFloat((document.getElementById("unitarioMaterial").value).toString().replace(",", "."))*parseFloat((document.getElementById("quantidadeMaterial").value).toString().replace(",", "."))).toFixed(2)).toString().replace(".", ",");
    
                </script>
    
    
                <?php
                }
    
                exit;
            }
    
            else {
                if (isset($_POST['unitario'])) {
                ?>
    
                <script>
    
                var valorUnitario = parseFloat((document.getElementById("unitarioMaterial").value).toString().replace(",", "."));
                var valorQuantidade = parseFloat((document.getElementById("quantidadeMaterial").value).toString().replace(",", "."));
    
                if (valorUnitario == 0 || valorQuantidade == 0 || !valorUnitario || !valorQuantidade) {
                    document.getElementById("totalMaterial").value = 0;
                }
    
                else {
                    document.getElementById("totalMaterial").value = ((valorUnitario*valorQuantidade).toFixed(2)).toString().replace(".", ",");
                }
    
                </script>
    
                <?php
    
                exit;
                }
            }
        }
    
        $_SESSION['carrinho']['dados']['total'] = 0;
    
        if (isset($_SESSION['carrinho']['dados']['frete'])) {
            $_SESSION['carrinho']['dados']['total'] += $_SESSION['carrinho']['dados']['frete'];
        }
    
        for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 
            
            $sql = $pdo->prepare("SELECT VendaV, CustoV, MargemMinimaV FROM material WHERE Codigo = :codigo");
            $sql->bindValue(":codigo", $_SESSION['carrinho']['produtos'][$i]['codigo']);
            $sql->execute();
    
            $resultMaterial = $sql->fetch();
    
            $precoTabela = $_SESSION['carrinho']['produtos'][$i]['tabela'];
            $custoTabela = $resultMaterial['CustoV'];
            $margemTabela = $resultMaterial['MargemMinimaV'];
    
            if ($margemTabela > 0) {
                $precoMinimo = $custoTabela + round(($custoTabela * $margemTabela) / 100, 2);
            }
    
            else {
                $precoMinimo = 0;
            }
    
            if (round($_SESSION['carrinho']['produtos'][$i]['unitario'], 3) >= round($_SESSION['carrinho']['produtos'][$i]['tabela'], 3)) {
                
                $sql = $pdo->prepare("SELECT * FROM Direitos_Dados WHERE IdUsuario = :idusuario AND OpcoesPermitidas='300905'");
                $sql->bindValue(":idusuario", $info['Id']);
                $sql->execute();
    
                if ($sql->fetch() != false) {
                $sPermissaoDesconto = "S";
                }
    
                else {
                $sPermissaoDesconto = "N";
                }
    
                $precoAtual = Round($_SESSION['carrinho']['produtos'][$i]['unitario'] - Round(($_SESSION['carrinho']['produtos'][$i]['unitario'] * $desconto) / 100, 3), 2);
    
                if ((round($precoAtual, 3) < round($precoMinimo, 3)) && $sPermissaoDesconto != "S") {
                
                ?>
    
                <script>
    
                Toast.fire({
                    icon: 'error',
                    title: 'O preço mínimo do produto <?php echo $_SESSION["carrinho"]["produtos"][$i]["codigo"]; ?> é de R$<?php echo ValidaValor($precoMinimo); ?>'
                });
    
                </script>
    
                <?php
    
                }
    
                else {
                $_SESSION['carrinho']['produtos'][$i]['unitario'] =
                Round($_SESSION['carrinho']['produtos'][$i]['unitario'] - Round(($_SESSION['carrinho']['produtos'][$i]['unitario'] * $desconto) / 100, 3), 2);
    
                $_SESSION['carrinho']['produtos'][$i]['total'] =
                Round($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade'], 2);
    
                }
    
            }
    
            else {
                ?>
    
                <script>
    
                Toast.fire({
                    icon: 'error',
                    title: 'Já existe um desconto neste orçamento, volte o preço de tabela e tente novamente.'
                });
    
                </script>
    
                <?php
            }
    
            $_SESSION['carrinho']['dados']['total'] += TrataFloat($_SESSION['carrinho']['produtos'][$i]['total']);
    
        }
    
        ?>
    
        <script>
    
        $("#lancamentos-produtos tbody").empty();
    
        $('#confirmacaoDescontoReaisModal').modal('hide');
        
        contador = 0;
        arrayMaterial = [];
        
        </script>
        
        <?php
    
        $diferencaTabela = 0;
        $totalTabela = 0;

        if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {
    
            for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 
                
                $sql = $pdo->prepare("SELECT Descricao FROM loteestoque WHERE Codigo = :codigo");
                $sql->bindValue(":codigo", ValidaString($_SESSION['carrinho']['produtos'][$i]['lote']));
                $sql->execute();
        
                $nomeLote = $sql->fetch();
        
                if ($nomeLote == false) {
                    if ($_SESSION['carrinho']['produtos'][$i]['lote'] == 999999) {
                    $nomeLote['Descricao'] = "PRINCIPAL";
                    }
        
                    else {
                    $nomeLote['Descricao'] = "";
                    }
                }
        
                $sql = $pdo->prepare("SELECT Descricao FROM localestoque WHERE Codigo = :codigo");
                $sql->bindValue(":codigo", ValidaString($_SESSION['carrinho']['produtos'][$i]['local']));
                $sql->execute();
        
                $nomeLocal = $sql->fetch();
        
                if ($nomeLocal == false) {
                    if ($_SESSION['carrinho']['produtos'][$i]['local'] == 999999) {
                        $nomeLocal['Descricao'] = "PRINCIPAL";
                    }
        
                    else {
                        $nomeLocal['Descricao'] = "";
                    }
                }
                
                ?>
            
                <script>
            
                var tr = "<tr><td><?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?></td>";
                tr = tr + '<td><?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?></td>';
                tr = tr + "<td><?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade']); ?></td>";
                tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario']); ?></td>";
                tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['total']); ?></td>";
                tr = tr + "<td><?php echo ValidaString($nomeLote['Descricao']); ?></td>";
                tr = tr + "<td><?php echo ValidaString($nomeLocal['Descricao']); ?></td>";
                tr = tr + "<td class='project-actions' style='width: 10%;'>";
                    tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
                    tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
                    tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
                    tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
                        
                arrayMaterial[contador] = ({
                    codigo: parseInt(<?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?>),
                    nome: '<?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?>',
                    quantidade: <?php echo $_SESSION['carrinho']['produtos'][$i]['quantidade']; ?>,
                    unitario: <?php echo $_SESSION['carrinho']['produtos'][$i]['unitario']; ?>,
                    tabela: <?php echo $_SESSION['carrinho']['produtos'][$i]['tabela']; ?>,
                    custo: <?php echo $_SESSION['carrinho']['produtos'][$i]['custo']; ?>,
                    total: <?php echo ($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']); ?>,
                    lote: <?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['lote']); ?>,
                    local: <?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['local']); ?>,
                });
            
                contador++;
            
                $("#lancamentos-produtos tbody").append(tr);
                    
                </script>    
            
                <?php
        
                $totalTabela += ($_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']);
        
                if ($_SESSION['carrinho']['produtos'][$i]['unitario'] > $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                    $diferencaTabela += (
                    (
                        $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )
        
                    -
        
                    (
                        $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )
        
                    );
                }
        
                else {
                    if ($_SESSION['carrinho']['produtos'][$i]['unitario'] < $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                    $diferencaTabela -= (
                        (
                            $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                        )
        
                        -
        
                        (
                            $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                        )
        
                    );
                    }
                }
            }
        }

        else {

            for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) {
                
                ?>
            
                <script>
            
                var tr = "<tr><td><?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?></td>";
                tr = tr + '<td><?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?></td>';
                tr = tr + "<td><?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade']); ?></td>";
                tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario']); ?></td>";
                tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['total']); ?></td>";
                tr = tr + "<td class='project-actions' style='width: 10%;'>";
                    tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
                    tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
                    tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
                    tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
                        
                arrayMaterial[contador] = ({
                    codigo: parseInt(<?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?>),
                    nome: '<?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?>',
                    quantidade: <?php echo $_SESSION['carrinho']['produtos'][$i]['quantidade']; ?>,
                    unitario: <?php echo $_SESSION['carrinho']['produtos'][$i]['unitario']; ?>,
                    tabela: <?php echo $_SESSION['carrinho']['produtos'][$i]['tabela']; ?>,
                    custo: <?php echo $_SESSION['carrinho']['produtos'][$i]['custo']; ?>,
                    total: <?php echo ($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']); ?>,
                });
            
                contador++;
            
                $("#lancamentos-produtos tbody").append(tr);
                    
                </script>    
            
                <?php
        
                $totalTabela += ($_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']);
        
                if ($_SESSION['carrinho']['produtos'][$i]['unitario'] > $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                    $diferencaTabela += (
                    (
                        $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )
        
                    -
        
                    (
                        $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )
        
                    );
                }
        
                else {
                    if ($_SESSION['carrinho']['produtos'][$i]['unitario'] < $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                    $diferencaTabela -= (
                        (
                            $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                        )
        
                        -
        
                        (
                            $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                        )
        
                    );
                    }
                }
            }
        }
   
         if ($diferencaTabela > 0) {
   
         $porcentagem = round(($diferencaTabela/$totalTabela)*100, 2);
   
         ?>
   
         <script>
   
         if (document.getElementById('divDesconto').classList.contains('d-none')) {
            document.getElementById('divDesconto').classList.remove("d-none");
            document.getElementById('divDesconto').classList.add("d-block");
         }
   
         document.getElementById('descontoLabel').innerHTML = "Acréscimo";
   
         document.getElementById('descAcresc').value = "R$ " + "<?php echo ValidaValor($diferencaTabela); ?>" + " | " + "<?php echo ValidaValor($porcentagem); ?>" + "%";
   
         </script>
   
         <?php
         }
   
         else {
         if ($diferencaTabela < 0) {
   
            $porcentagem = round((($diferencaTabela*(-1))/$totalTabela)*100, 2);
   
            ?>
   
            <script>
   
            if (document.getElementById('divDesconto').classList.contains('d-none')) {
               document.getElementById('divDesconto').classList.remove("d-none");
               document.getElementById('divDesconto').classList.add("d-block");
            }
   
            document.getElementById('descontoLabel').innerHTML = "Desconto";
   
            document.getElementById('descAcresc').value = "R$ " + "<?php echo ValidaValor($diferencaTabela); ?>" + " | " + "<?php echo ValidaValor($porcentagem); ?>" + "%";
   
            </script>
   
            <?php
         }
   
         else {
            ?>
   
            <script>
   
            if (document.getElementById('divDesconto').classList.contains('d-block')) {
               document.getElementById('divDesconto').classList.remove("d-block");
               document.getElementById('divDesconto').classList.add("d-none");
            }
   
            document.getElementById('descontoLabel').innerHTML = "Desconto/Acréscimo";
   
            document.getElementById('descAcresc').value = "";
   
            </script>
   
            <?php
         }
      }
   
      ?>
   
      <script>
   
      document.getElementById('descontoOrcamento').value = "";
   
      document.getElementById('total').value = "R$<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";
      arrayMaterial = <?php echo json_encode($_SESSION['carrinho']['produtos']); ?>;
   
      document.getElementById('codigoMaterial').focus();
   
      </script>
   
      <?php
   
   }
   
   else {
      ?>
      
      <script>
   
         Toast.fire({
            icon: 'error',
            title: 'Você não possui permissão para dar descontos em orçamentos.'
         });
   
         document.getElementById('descontoOrcamento').value = "";
   
      </script>
   
      <?php
   }

}

   break;

   case 'aplicarAcrescimoReais':

$acrescimo = $_POST['acrescimo'];

if (isset($_SESSION['carrinho']['dados']['frete'])) {
   $acrescimo = round($acrescimo / ($_SESSION['carrinho']['dados']['total']-$_SESSION['carrinho']['dados']['frete']) * 100, 6);
}

else {
   $acrescimo = round($acrescimo / $_SESSION['carrinho']['dados']['total'] * 100, 6);
}

$_SESSION['carrinho']['dados']['total'] = 0;

if (isset($_SESSION['carrinho']['dados']['frete'])) {
   $_SESSION['carrinho']['dados']['total'] += $_SESSION['carrinho']['dados']['frete'];
}

for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 
   
   $_SESSION['carrinho']['produtos'][$i]['unitario'] += round(($_SESSION['carrinho']['produtos'][$i]['unitario'] * $acrescimo) / 100, 2);
   $_SESSION['carrinho']['produtos'][$i]['total'] = round($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade'], 2);

   $_SESSION['carrinho']['dados']['total'] += $_SESSION['carrinho']['produtos'][$i]['total'];

}

?>

<script>

$("#lancamentos-produtos tbody").empty();

$('#confirmacaoAcrescimoReaisModal').modal('hide');

contador = 0;
arrayMaterial = [];

</script>

<?php

$diferencaTabela = 0;
$totalTabela = 0;

if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

    for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 

        $sql = $pdo->prepare("SELECT Descricao FROM loteestoque WHERE Codigo = :codigo");
        $sql->bindValue(":codigo", ValidaString($_SESSION['carrinho']['produtos'][$i]['lote']));
        $sql->execute();

        $nomeLote = $sql->fetch();

        if ($nomeLote == false) {
            if ($_SESSION['carrinho']['produtos'][$i]['lote'] == 999999) {
                $nomeLote['Descricao'] = "PRINCIPAL";
            }

            else {
                $nomeLote['Descricao'] = "";
            }
        }

        $sql = $pdo->prepare("SELECT Descricao FROM localestoque WHERE Codigo = :codigo");
        $sql->bindValue(":codigo", ValidaString($_SESSION['carrinho']['produtos'][$i]['local']));
        $sql->execute();

        $nomeLocal = $sql->fetch();

        if ($nomeLocal == false) {
                if ($_SESSION['carrinho']['produtos'][$i]['local'] == 999999) {
                    $nomeLocal['Descricao'] = "PRINCIPAL";
                }

                else {
                    $nomeLocal['Descricao'] = "";
                }
        }

        ?>

        <script>

        var tr = "<tr><td><?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?></td>";
        tr = tr + '<td><?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?></td>';
        tr = tr + "<td><?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['total']); ?></td>";
        tr = tr + "<td><?php echo ValidaString($nomeLote['Descricao']); ?></td>";
        tr = tr + "<td><?php echo ValidaString($nomeLocal['Descricao']); ?></td>";
        tr = tr + "<td class='project-actions' style='width: 10%;'>";
            tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
            tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
                    
        arrayMaterial[contador] = ({
            codigo: parseInt(<?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?>),
            nome: '<?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?>',
            quantidade: <?php echo $_SESSION['carrinho']['produtos'][$i]['quantidade']; ?>,
            unitario: <?php echo $_SESSION['carrinho']['produtos'][$i]['unitario']; ?>,
            tabela: <?php echo $_SESSION['carrinho']['produtos'][$i]['tabela']; ?>,
            custo: <?php echo $_SESSION['carrinho']['produtos'][$i]['custo']; ?>,
            total: <?php echo ($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']); ?>,
            lote: <?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['lote']); ?>,
            local: <?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['local']); ?>,
        });

        contador++;

        $("#lancamentos-produtos tbody").append(tr);
            
        </script>    

        <?php

        $totalTabela += ($_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']);

        if ($_SESSION['carrinho']['produtos'][$i]['unitario'] > $_SESSION['carrinho']['produtos'][$i]['tabela']) {
            $diferencaTabela += (
                (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                )

                -

                (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                )

            );
        }

        else {
            if ($_SESSION['carrinho']['produtos'][$i]['unitario'] < $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                $diferencaTabela -= (
                    (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                    -

                    (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                );
            }
        }
    }

}

else {

    for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) {

        ?>

        <script>

        var tr = "<tr><td><?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?></td>";
        tr = tr + '<td><?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?></td>';
        tr = tr + "<td><?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['total']); ?></td>";
        tr = tr + "<td class='project-actions' style='width: 10%;'>";
            tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
            tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
                    
        arrayMaterial[contador] = ({
            codigo: parseInt(<?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?>),
            nome: '<?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?>',
            quantidade: <?php echo $_SESSION['carrinho']['produtos'][$i]['quantidade']; ?>,
            unitario: <?php echo $_SESSION['carrinho']['produtos'][$i]['unitario']; ?>,
            tabela: <?php echo $_SESSION['carrinho']['produtos'][$i]['tabela']; ?>,
            custo: <?php echo $_SESSION['carrinho']['produtos'][$i]['custo']; ?>,
            total: <?php echo ($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']); ?>,
        });

        contador++;

        $("#lancamentos-produtos tbody").append(tr);
            
        </script>    

        <?php

        $totalTabela += ($_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']);

        if ($_SESSION['carrinho']['produtos'][$i]['unitario'] > $_SESSION['carrinho']['produtos'][$i]['tabela']) {
            $diferencaTabela += (
                (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                )

                -

                (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                )

            );
        }

        else {
            if ($_SESSION['carrinho']['produtos'][$i]['unitario'] < $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                $diferencaTabela -= (
                    (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                    -

                    (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                );
            }
        }
    }

}

if ($diferencaTabela > 0) {

   $porcentagem = round(($diferencaTabela/$totalTabela)*100, 2);

   ?>

   <script>

   if (document.getElementById('divDesconto').classList.contains('d-none')) {
      document.getElementById('divDesconto').classList.remove("d-none");
      document.getElementById('divDesconto').classList.add("d-block");
   }

   document.getElementById('descontoLabel').innerHTML = "Acréscimo";

   document.getElementById('descAcresc').value = "R$ " + "<?php echo ValidaValor($diferencaTabela); ?>" + " | " + "<?php echo ValidaValor($porcentagem); ?>" + "%";

   </script>

   <?php
}

else {
   if ($diferencaTabela < 0) {

      $porcentagem = round((($diferencaTabela*(-1))/$totalTabela)*100, 2);

      ?>

      <script>

      if (document.getElementById('divDesconto').classList.contains('d-none')) {
         document.getElementById('divDesconto').classList.remove("d-none");
         document.getElementById('divDesconto').classList.add("d-block");
      }

      document.getElementById('descontoLabel').innerHTML = "Desconto";

      document.getElementById('descAcresc').value = "R$ " + "<?php echo ValidaValor($diferencaTabela); ?>" + " | " + "<?php echo ValidaValor($porcentagem); ?>" + "%";

      </script>

      <?php
   }

   else {
      ?>

      <script>

      if (document.getElementById('divDesconto').classList.contains('d-block')) {
         document.getElementById('divDesconto').classList.remove("d-block");
         document.getElementById('divDesconto').classList.add("d-none");
      }

      document.getElementById('descontoLabel').innerHTML = "Desconto/Acréscimo";

      document.getElementById('descAcresc').value = "";

      </script>

      <?php
   }
}

?>

<script>

document.getElementById('acrescimoOrcamento').value = "";

document.getElementById('total').value = "R$<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";
arrayMaterial = <?php echo json_encode($_SESSION['carrinho']['produtos']); ?>;

</script>

<?php

   break;

   case 'aplicarAcrescimoPorcentagem':

$acrescimo = $_POST['acrescimo'];

$_SESSION['carrinho']['dados']['total'] = 0;

if (isset($_SESSION['carrinho']['dados']['frete'])) {
   $_SESSION['carrinho']['dados']['total'] += $_SESSION['carrinho']['dados']['frete'];
}

for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 
   
   $_SESSION['carrinho']['produtos'][$i]['unitario'] += round(($_SESSION['carrinho']['produtos'][$i]['unitario'] * $acrescimo) / 100, 2);
   $_SESSION['carrinho']['produtos'][$i]['total'] = round($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade'], 2);

   $_SESSION['carrinho']['dados']['total'] += $_SESSION['carrinho']['produtos'][$i]['total'];

}

?>

<script>

$("#lancamentos-produtos tbody").empty();

$('#confirmacaoAcrescimoPorcentagemModal').modal('hide');

contador = 0;
arrayMaterial = [];

</script>

<?php

$diferencaTabela = 0;
$totalTabela = 0;

if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

    for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 

        $sql = $pdo->prepare("SELECT Descricao FROM loteestoque WHERE Codigo = :codigo");
        $sql->bindValue(":codigo", ValidaString($_SESSION['carrinho']['produtos'][$i]['lote']));
        $sql->execute();

        $nomeLote = $sql->fetch();

        if ($nomeLote == false) {
        if ($_SESSION['carrinho']['produtos'][$i]['lote'] == 999999) {
            $nomeLote['Descricao'] = "PRINCIPAL";
        }

        else {
            $nomeLote['Descricao'] = "";
        }
        }

        $sql = $pdo->prepare("SELECT Descricao FROM localestoque WHERE Codigo = :codigo");
        $sql->bindValue(":codigo", ValidaString($_SESSION['carrinho']['produtos'][$i]['local']));
        $sql->execute();

        $nomeLocal = $sql->fetch();

        if ($nomeLocal == false) {
            if ($_SESSION['carrinho']['produtos'][$i]['local'] == 999999) {
                $nomeLocal['Descricao'] = "PRINCIPAL";
            }

            else {
                $nomeLocal['Descricao'] = "";
            }
        }

        ?>

        <script>

        var tr = "<tr><td><?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?></td>";
        tr = tr + '<td><?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?></td>';
        tr = tr + "<td><?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['total']); ?></td>";
        tr = tr + "<td><?php echo ValidaString($nomeLote['Descricao']); ?></td>";
        tr = tr + "<td><?php echo ValidaString($nomeLocal['Descricao']); ?></td>";
        tr = tr + "<td class='project-actions' style='width: 10%;'>";
            tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
            tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
                    
        arrayMaterial[contador] = ({
            codigo: parseInt(<?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?>),
            nome: '<?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?>',
            quantidade: <?php echo $_SESSION['carrinho']['produtos'][$i]['quantidade']; ?>,
            unitario: <?php echo $_SESSION['carrinho']['produtos'][$i]['unitario']; ?>,
            tabela: <?php echo $_SESSION['carrinho']['produtos'][$i]['tabela']; ?>,
            custo: <?php echo $_SESSION['carrinho']['produtos'][$i]['custo']; ?>,
            total: <?php echo ($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']); ?>,
            lote: <?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['lote']); ?>,
            local: <?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['local']); ?>,
        });

        contador++;

        $("#lancamentos-produtos tbody").append(tr);
            
        </script>    

        <?php

        $totalTabela += ($_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']);

        if ($_SESSION['carrinho']['produtos'][$i]['unitario'] > $_SESSION['carrinho']['produtos'][$i]['tabela']) {
            $diferencaTabela += (
                (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                )

                -

                (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                )

            );
        }

        else {
            if ($_SESSION['carrinho']['produtos'][$i]['unitario'] < $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                $diferencaTabela -= (
                    (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                    -

                    (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                );
            }
        }
    }
}

else {

    for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) {
    
        ?>
    
        <script>
    
        var tr = "<tr><td><?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?></td>";
        tr = tr + '<td><?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?></td>';
        tr = tr + "<td><?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['total']); ?></td>";
        tr = tr + "<td class='project-actions' style='width: 10%;'>";
            tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
            tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
                    
        arrayMaterial[contador] = ({
            codigo: parseInt(<?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?>),
            nome: '<?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?>',
            quantidade: <?php echo $_SESSION['carrinho']['produtos'][$i]['quantidade']; ?>,
            unitario: <?php echo $_SESSION['carrinho']['produtos'][$i]['unitario']; ?>,
            tabela: <?php echo $_SESSION['carrinho']['produtos'][$i]['tabela']; ?>,
            custo: <?php echo $_SESSION['carrinho']['produtos'][$i]['custo']; ?>,
            total: <?php echo ($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']); ?>,
        });
    
        contador++;
    
        $("#lancamentos-produtos tbody").append(tr);
            
        </script>    
    
        <?php
    
        $totalTabela += ($_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']);
    
        if ($_SESSION['carrinho']['produtos'][$i]['unitario'] > $_SESSION['carrinho']['produtos'][$i]['tabela']) {
            $diferencaTabela += (
                (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                )
    
                -
    
                (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                )
    
            );
        }
    
        else {
            if ($_SESSION['carrinho']['produtos'][$i]['unitario'] < $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                $diferencaTabela -= (
                    (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )
    
                    -
    
                    (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )
    
                );
            }
        }
    }
}

if ($diferencaTabela > 0) {

$porcentagem = round(($diferencaTabela/$totalTabela)*100, 2);

?>

<script>

if (document.getElementById('divDesconto').classList.contains('d-none')) {
   document.getElementById('divDesconto').classList.remove("d-none");
   document.getElementById('divDesconto').classList.add("d-block");
}

document.getElementById('descontoLabel').innerHTML = "Acréscimo";

document.getElementById('descAcresc').value = "R$ " + "<?php echo ValidaValor($diferencaTabela); ?>" + " | " + "<?php echo ValidaValor($porcentagem); ?>" + "%";

</script>

<?php
}

else {
   if ($diferencaTabela < 0) {

      $porcentagem = round((($diferencaTabela*(-1))/$totalTabela)*100, 2);

      ?>

      <script>

      if (document.getElementById('divDesconto').classList.contains('d-none')) {
         document.getElementById('divDesconto').classList.remove("d-none");
         document.getElementById('divDesconto').classList.add("d-block");
      }

      document.getElementById('descontoLabel').innerHTML = "Desconto";

      document.getElementById('descAcresc').value = "R$ " + "<?php echo ValidaValor($diferencaTabela); ?>" + " | " + "<?php echo ValidaValor($porcentagem); ?>" + "%";

      </script>

      <?php
   }

   else {
      ?>

      <script>

      if (document.getElementById('divDesconto').classList.contains('d-block')) {
         document.getElementById('divDesconto').classList.remove("d-block");
         document.getElementById('divDesconto').classList.add("d-none");
      }

      document.getElementById('descontoLabel').innerHTML = "Desconto/Acréscimo";

      document.getElementById('descAcresc').value = "";

      </script>

      <?php
   }
}

?>

<script>

document.getElementById('acrescimoOrcamento').value = "";

document.getElementById('total').value = "R$<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";
arrayMaterial = <?php echo json_encode($_SESSION['carrinho']['produtos']); ?>;

</script>

<?php

   break;

   case 'voltarPreco':

$_SESSION['carrinho']['dados']['total'] = 0;

if (isset($_SESSION['carrinho']['dados']['frete'])) {
   $_SESSION['carrinho']['dados']['total'] += $_SESSION['carrinho']['dados']['frete'];
}

for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 

   $_SESSION['carrinho']['produtos'][$i]['unitario'] = $_SESSION['carrinho']['produtos'][$i]['tabela'];

   $_SESSION['carrinho']['produtos'][$i]['total'] =
   Round($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade'], 2);

   $_SESSION['carrinho']['dados']['total'] += TrataFloat($_SESSION['carrinho']['produtos'][$i]['total']);

}

?>

<script>

$("#lancamentos-produtos tbody").empty();

$('#confirmacaoPrecoTabelaModal').modal('hide');

contador = 0;
arrayMaterial = [];

</script>

<?php

$diferencaTabela = 0;
$totalTabela = 0;

if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

    for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 
    
        $sql = $pdo->prepare("SELECT Descricao FROM loteestoque WHERE Codigo = :codigo");
        $sql->bindValue(":codigo", ValidaString($_SESSION['carrinho']['produtos'][$i]['lote']));
        $sql->execute();

        $nomeLote = $sql->fetch();

        if ($nomeLote == false) {
            if ($_SESSION['carrinho']['produtos'][$i]['lote'] == 999999) {
                $nomeLote['Descricao'] = "PRINCIPAL";
            }

            else {
                $nomeLote['Descricao'] = "";
            }
        }

        $sql = $pdo->prepare("SELECT Descricao FROM localestoque WHERE Codigo = :codigo");
        $sql->bindValue(":codigo", ValidaString($_SESSION['carrinho']['produtos'][$i]['local']));
        $sql->execute();

        $nomeLocal = $sql->fetch();

        if ($nomeLocal == false) {
                if ($_SESSION['carrinho']['produtos'][$i]['local'] == 999999) {
                    $nomeLocal['Descricao'] = "PRINCIPAL";
                }

                else {
                    $nomeLocal['Descricao'] = "";
                }
        }
        
            ?>
        
            <script>
        
            var tr = "<tr><td><?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?></td>";
            tr = tr + '<td><?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?></td>';
            tr = tr + "<td><?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade']); ?></td>";
            tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario']); ?></td>";
            tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['total']); ?></td>";
            tr = tr + "<td><?php echo ValidaString($nomeLote['Descricao']); ?></td>";
            tr = tr + "<td><?php echo ValidaString($nomeLocal['Descricao']); ?></td>";
            tr = tr + "<td class='project-actions' style='width: 10%;'>";
                tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
                tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
                tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
                tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
                    
            arrayMaterial[contador] = ({
                codigo: parseInt(<?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?>),
                nome: '<?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?>',
                quantidade: <?php echo $_SESSION['carrinho']['produtos'][$i]['quantidade']; ?>,
                unitario: <?php echo $_SESSION['carrinho']['produtos'][$i]['unitario']; ?>,
                tabela: <?php echo $_SESSION['carrinho']['produtos'][$i]['tabela']; ?>,
                custo: <?php echo $_SESSION['carrinho']['produtos'][$i]['custo']; ?>,
                total: <?php echo ($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']); ?>,
                lote: <?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['lote']); ?>,
                local: <?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['local']); ?>,
            });
        
            contador++;
        
            $("#lancamentos-produtos tbody").append(tr);
                
            </script>    
        
            <?php

        $totalTabela += ($_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']);

        if ($_SESSION['carrinho']['produtos'][$i]['unitario'] > $_SESSION['carrinho']['produtos'][$i]['tabela']) {
            $diferencaTabela += (
                (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                )

                -

                (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                )

            );
        }

        else {
            if ($_SESSION['carrinho']['produtos'][$i]['unitario'] < $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                $diferencaTabela -= (
                    (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                    -

                    (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                );
            }
        }
    }
}

else {

    for ($i=0; $i < count($_SESSION['carrinho']['produtos']); $i++) { 
        
        ?>
    
        <script>
    
        var tr = "<tr><td><?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?></td>";
        tr = tr + '<td><?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?></td>';
        tr = tr + "<td><?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['quantidade']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['unitario']); ?></td>";
        tr = tr + "<td>R$<?php echo ValidaValor($_SESSION['carrinho']['produtos'][$i]['total']); ?></td>";
        tr = tr + "<td class='project-actions' style='width: 10%;'>";
            tr = tr + "<a class='btn btn-danger btn-sm desktop' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i> Excluir</a>";
            tr = tr + "<a class='btn btn-danger btn-sm mobile' id='botaoDeletar' onclick='excluirProduto(<?php echo $i; ?>)'>";
            tr = tr + "<i class='fas fa-trash'></i></a></td></tr>";
                
        arrayMaterial[contador] = ({
            codigo: parseInt(<?php echo $_SESSION['carrinho']['produtos'][$i]['codigo']; ?>),
            nome: '<?php echo ValidaString($_SESSION['carrinho']['produtos'][$i]['nome']); ?>',
            quantidade: <?php echo $_SESSION['carrinho']['produtos'][$i]['quantidade']; ?>,
            unitario: <?php echo $_SESSION['carrinho']['produtos'][$i]['unitario']; ?>,
            tabela: <?php echo $_SESSION['carrinho']['produtos'][$i]['tabela']; ?>,
            custo: <?php echo $_SESSION['carrinho']['produtos'][$i]['custo']; ?>,
            total: <?php echo ($_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']); ?>,
        });
    
        contador++;
    
        $("#lancamentos-produtos tbody").append(tr);
            
        </script>    
    
        <?php

        $totalTabela += ($_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']);

        if ($_SESSION['carrinho']['produtos'][$i]['unitario'] > $_SESSION['carrinho']['produtos'][$i]['tabela']) {
            $diferencaTabela += (
                (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                )

                -

                (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                )

            );
        }

        else {
            if ($_SESSION['carrinho']['produtos'][$i]['unitario'] < $_SESSION['carrinho']['produtos'][$i]['tabela']) {
                $diferencaTabela -= (
                    (
                    $_SESSION['carrinho']['produtos'][$i]['tabela'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                    -

                    (
                    $_SESSION['carrinho']['produtos'][$i]['unitario'] * $_SESSION['carrinho']['produtos'][$i]['quantidade']
                    )

                );
            }
        }
    }
}

if ($diferencaTabela > 0) {

   $porcentagem = round(($diferencaTabela/$totalTabela)*100, 2);

   ?>

   <script>

   if (document.getElementById('divDesconto').classList.contains('d-none')) {
      document.getElementById('divDesconto').classList.remove("d-none");
      document.getElementById('divDesconto').classList.add("d-block");
   }

   document.getElementById('descontoLabel').innerHTML = "Acréscimo";

   document.getElementById('descAcresc').value = "R$ " + "<?php echo ValidaValor($diferencaTabela); ?>" + " | " + "<?php echo ValidaValor($porcentagem); ?>" + "%";

   </script>

   <?php
}

else {
   if ($diferencaTabela < 0) {

      $porcentagem = round((($diferencaTabela*(-1))/$totalTabela)*100, 2);

      ?>

      <script>

      if (document.getElementById('divDesconto').classList.contains('d-none')) {
         document.getElementById('divDesconto').classList.remove("d-none");
         document.getElementById('divDesconto').classList.add("d-block");
      }

      document.getElementById('descontoLabel').innerHTML = "Desconto";

      document.getElementById('descAcresc').value = "R$ " + "<?php echo ValidaValor($diferencaTabela); ?>" + " | " + "<?php echo ValidaValor($porcentagem); ?>" + "%";

      </script>

      <?php
   }

   else {
      ?>

      <script>

      if (document.getElementById('divDesconto').classList.contains('d-block')) {
         document.getElementById('divDesconto').classList.remove("d-block");
         document.getElementById('divDesconto').classList.add("d-none");
      }

      document.getElementById('descontoLabel').innerHTML = "Desconto/Acréscimo";

      document.getElementById('descAcresc').value = "";

      </script>

      <?php
   }
}

?>

<script>

document.getElementById('total').value = "R$<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";
arrayMaterial = <?php echo json_encode($_SESSION['carrinho']['produtos']); ?>;

document.getElementById('descontoOrcamento').value = "";
document.getElementById('acrescimoOrcamento').value = "";

</script>

<?php

   break;

   case 'somarFrete':

$frete = $_POST['frete'];

if (isset($_SESSION['carrinho']['dados']['frete'])) {
   if ($_SESSION['carrinho']['dados']['frete'] > 0) {
      $_SESSION['carrinho']['dados']['total'] -= $_SESSION['carrinho']['dados']['frete'];
   }
}


$_SESSION['carrinho']['dados']['frete'] = $frete;
$_SESSION['carrinho']['dados']['total'] += $_SESSION['carrinho']['dados']['frete'];

?>

<script>

document.getElementById('total').value = "R$<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";

$('#confirmacaoFreteModal').modal('hide');

</script>

<?php

   break;

   case 'removerFrete':

$frete = 0;

if (isset($_SESSION['carrinho']['dados']['frete'])) {
   if ($_SESSION['carrinho']['dados']['frete'] > 0) {
      $_SESSION['carrinho']['dados']['total'] -= $_SESSION['carrinho']['dados']['frete'];
   }
}


$_SESSION['carrinho']['dados']['frete'] = 0;

?>

<script>

document.getElementById('total').value = "R$<?php echo ValidaValor($_SESSION['carrinho']['dados']['total']); ?>";

document.getElementById('freteOrcamento').value = "";

$('#confirmacaoExclusaoFreteModal').modal('hide');

</script>

<?php

   break;

   default:
   
   return false;

   break;
}