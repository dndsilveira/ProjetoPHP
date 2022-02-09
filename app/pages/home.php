<?php

/* $sql = $pdo->prepare("SELECT Round(Sum(Saldo), 2) As Saldo FROM Duplicatas LEFT JOIN Cliente ON Duplicatas.Cliente_Fornecedor=Cliente.Codigo
LEFT JOIN Cidade ON Cidade.Id = Cliente.CodigoCidade WHERE Duplicatas.Vencimento >= :datainicio
AND Duplicatas.Vencimento <= :datafinal AND Round(Duplicatas.Saldo, 2) > 0
AND Duplicatas.Receber_Pagar=1 AND IFNULL(Duplicatas.Provisionamento, '') <> 'S'");
$sql->bindValue(":datainicio", date('Y-m-01'));
$sql->bindValue(":datafinal", date('Y-m-31'));
$sql->execute();

$contasReceberMesAtual = $sql->fetch();

$contasReceberMesAtual = $contasReceberMesAtual['Saldo'];

$sql = $pdo->prepare("SELECT Round(Sum(Saldo), 2) As Saldo FROM Duplicatas LEFT JOIN Cliente ON Duplicatas.Cliente_Fornecedor=Cliente.Codigo
LEFT JOIN Cidade ON Cidade.Id = Cliente.CodigoCidade WHERE Duplicatas.Vencimento >= :datainicio
AND Duplicatas.Vencimento <= :datafinal AND Round(Duplicatas.Saldo, 2) > 0
AND Duplicatas.Receber_Pagar=2 AND IFNULL(Duplicatas.Provisionamento, '') <> 'S'");
$sql->bindValue(":datainicio", date('Y-m-01'));
$sql->bindValue(":datafinal", date('Y-m-31'));
$sql->execute();

$contasPagarMesAtual = $sql->fetch();

$contasPagarMesAtual = $contasPagarMesAtual['Saldo']; */

if ($_SESSION['parametros']['verLucro'] == 'S') {

   if ($_SESSION['parametros']['verSomenteSuasVendas'] == 'N') {
      $sql = $pdo->prepare("SELECT Count(Id) AS Vendas FROM Movimento Use Index(DataMovimento) WHERE DataMovimento >= :datainicio AND DataMovimento <= :datafinal");
      $sql->bindValue(":datainicio", date('Y-m-01'));
      $sql->bindValue(":datafinal", date('Y-m-31'));
   }

   else {
      $sql = $pdo->prepare("SELECT Count(Id) AS Vendas FROM Movimento Use Index(DataMovimento) WHERE DataMovimento >= :datainicio AND DataMovimento <= :datafinal AND Vendedor = :vendedor");
      $sql->bindValue(":datainicio", date('Y-m-01'));
      $sql->bindValue(":datafinal", date('Y-m-31'));
      $sql->bindValue(":vendedor", $_SESSION['vendedorLogado']['Codigo']);
   }

   $sql->execute();

   $totalVendasMes = $sql->fetch();

   $totalVendasMes = $totalVendasMes['Vendas'];

   if ($_SESSION['parametros']['verSomenteSuasVendas'] == 'N') {
      $sql = $pdo->prepare("SELECT Sum(TotalNota) AS Valor FROM Movimento Use Index(DataMovimento) WHERE DataMovimento >= :datainicio AND DataMovimento <= :datafinal");
      $sql->bindValue(":datainicio", date('Y-m-01'));
      $sql->bindValue(":datafinal", date('Y-m-31'));
   }

   else {
      $sql = $pdo->prepare("SELECT Sum(TotalNota) AS Valor FROM Movimento Use Index(DataMovimento) WHERE DataMovimento >= :datainicio AND DataMovimento <= :datafinal AND Vendedor = :vendedor");
      $sql->bindValue(":datainicio", date('Y-m-01'));
      $sql->bindValue(":datafinal", date('Y-m-31'));
      $sql->bindValue(":vendedor", $_SESSION['vendedorLogado']['Codigo']);
   }

   $sql->execute();

   $totalValorMes = $sql->fetch();

   $totalValorMes = intval($totalValorMes['Valor']);

   $sql = $pdo->prepare("SELECT Count(Codigo) AS Clientes FROM Cliente WHERE DataCadastro >= :datainicio AND DataCadastro <= :datafinal");
   $sql->bindValue(":datainicio", date('Y-m-01'));
   $sql->bindValue(":datafinal", date('Y-m-31'));
   $sql->execute();

   $totalClientesMes = $sql->fetch();

   $totalClientesMes = $totalClientesMes['Clientes'];

   $sql = $pdo->prepare("SELECT Round((Sum(TotalNota)/Count(Id)), 2) AS Ticket FROM Movimento Use Index(DataMovimento) WHERE DataMovimento >= :datainicio AND DataMovimento <= :datafinal");
   $sql->bindValue(":datainicio", date('Y-m-01'));
   $sql->bindValue(":datafinal", date('Y-m-31'));
   $sql->execute();

   $ticketMedioMes = $sql->fetch();

   $ticketMedioMes = $ticketMedioMes['Ticket'];

}

?>

<div class="content-wrapper wllpp-2">
   <div class="wllpp"></div>
      <div class="content-header">
         <div class="container-fluid">
            <div class="row">
               <?php if ($_SESSION['parametros']['verLucro'] == 'S') { ?>
               <div class="col-12 col-sm-6 col-md-3">
                  <div class="info-box">
                     <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                     <div class="info-box-content">
                     <span class="info-box-text">Novos clientes no mês</span>
                     <span class="info-box-number"><?php echo $totalClientesMes; ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-12 col-sm-6 col-md-3">
                  <div class="info-box mb-3">
                     <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dollar-sign"></i></span>
                     <div class="info-box-content">
                     <span class="info-box-text">Valor de vendas no mês</span>
                     <span class="info-box-number">R$<?php echo ValidaValor($totalValorMes); ?></span>
                     </div>
                  </div>
               </div>

               <div class="clearfix hidden-md-up"></div>

               <div class="col-12 col-sm-6 col-md-3">
                  <div class="info-box mb-3">
                     <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
                     <div class="info-box-content">
                     <span class="info-box-text">Quantidade de vendas no mês</span>
                     <span class="info-box-number"><?php echo $totalVendasMes; ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-12 col-sm-6 col-md-3">
                  <div class="info-box mb-3">
                     <span class="info-box-icon bg-success elevation-1"><i class="fas fa-chart-line"></i></span>
                     <div class="info-box-content">
                     <span class="info-box-text">Ticket médio no mês</span>
                     <span class="info-box-number">R$<?php echo ValidaValor($ticketMedioMes); ?></span>
                     </div>
                  </div>
               </div>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>