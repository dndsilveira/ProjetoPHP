<?php

/* if (isset($_GET['id_cliente'])) {
   $_SESSION['buscaRelatorioDebitosPorCliente']['cliente'] = $_GET['id_cliente'];
   $_SESSION['buscaRelatorioDebitosPorCliente']['dataInicio'] = date('Y-m-d', strtotime('first day of January', strtotime(date('Y-m-d'))));
   $_SESSION['buscaRelatorioDebitosPorCliente']['dataFinal'] = date('Y-m-d');
} */

if (isset($_SESSION['buscaRelatorioDebitosPorCliente']['cliente'])) {
   ?>
 
   <script>
 
   $(document).ready(function() {
     tabCliente();
   });
 
   </script>
 
   <?php
}

?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="font-size: 25px;">Relatório</h1>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Débitos por cliente</h3>
        <div id="lancamentos"></div>
        <form class="barraPesquisa border-top" method="POST">
          <?php if ($_SESSION['tema'] == 'branco') { ?>
          <div class="input-group barraPesquisa bordaBranca">
          <?php } else { ?>
          <div class="input-group sidebar-dark-primary barraPesquisa bordaPreta">
          <?php } ?>

            <div class="form-group col-2 my-filtros codigo">
               <label for="filtroCliente">Cliente</label>
               <div class="input-group">
                  <?php

                  if (isset($_SESSION['buscaRelatorioDebitosPorCliente']['cliente'])) {
                     ?>
                     <input type="text" class="form-control" name="filtroCliente" value="<?php echo $_SESSION['buscaRelatorioDebitosPorCliente']['cliente']; ?>" id="filtroCliente" required>
                     <?php
                  }

                  else {
                     ?>
                     <input type="text" class="form-control" name="filtroCliente" id="filtroCliente" required>
                     <?php
                  }

                  ?>
                  <div class="input-group-append">
                     <span class="input-group-text" data-toggle="modal" data-target="#buscarClienteModal">
                     <i class="fas fa-search"></i>
                     </span>
                  </div>
               </div>
            </div>

            <div class="form-group col-2 my-filtros nomeCliente">
               <label for="nomeCliente">Nome</label>
               <input type="text" class="form-control" name="nomeCliente" id="nomeCliente" disabled>
            </div>

            <div class="form-group col-2 my-filtros dataInicio">
               <label class="lbl-group">Data início</label>
               <?php

               if (isset($_SESSION['buscaRelatorioDebitosPorCliente']['dataInicio']) && !empty($_SESSION['buscaRelatorioDebitosPorCliente']['dataInicio'])) {
                  ?>
                  <input class="form-control form-control-sidebar responsive1" id="filtroDataInicio" name="filtroDataInicio" type="date" value="<?php echo $_SESSION['buscaRelatorioDebitosPorCliente']['dataInicio']; ?>">       
                  <?php
               }

               else {
                  ?>
                  <input class="form-control form-control-sidebar responsive1" id="filtroDataInicio" name="filtroDataInicio" type="date" value="<?php echo date('Y-m-d', strtotime('first day of January', strtotime(date('Y-m-d')))); ?>">
                  <?php
               }

               ?>
            </div>
            
            <div class="form-group col-2 my-filtros dataFinal">
               <label class="lbl-group">Data final</label>
               <?php

               if (isset($_SESSION['buscaRelatorioDebitosPorCliente']['dataFinal']) && !empty($_SESSION['buscaRelatorioDebitosPorCliente']['dataFinal'])) {
                  ?>
                  <input class="form-control form-control-sidebar responsive1" id="filtroDataFinal" name="filtroDataFinal" type="date" value="<?php echo $_SESSION['buscaRelatorioDebitosPorCliente']['dataFinal']; ?>">       
                  <?php
               }

               else {
                  ?>
                  <input class="form-control form-control-sidebar responsive1" id="filtroDataFinal" name="filtroDataFinal" type="date" value="<?php echo date('Y-m-d', strtotime('+5 year', strtotime(date('Y-m-d')))); ?>">
                  <?php
               }

               ?>
            </div>

            <div class="form-check my-filtros-2 somenteAberto">
               <?php

               if (isset($_SESSION['buscaRelatorioDebitosPorCliente']['somenteAberto'])) {
                  if ($_SESSION['buscaRelatorioDebitosPorCliente']['somenteAberto'] == "S") {
                     ?>
                     <input type="checkbox" class="form-check-input" name="somenteAberto" value="1" id="somenteAberto" checked>
                     <?php
                  }

                  else {
                     ?>
                     <input type="checkbox" class="form-check-input" name="somenteAberto" value="1" id="somenteAberto">
                     <?php
                  }
               }

               else {
                  ?>
                  <input type="checkbox" class="form-check-input" name="somenteAberto" value="1" id="somenteAberto" checked>
                  <?php
               }

               ?>
               <label class="form-check-label" for="somenteAberto">Somente em aberto</label>
            </div>

            <div class="form-check my-filtros-2">
               <?php

               if (isset($_SESSION['buscaRelatorioDebitosPorCliente']['mostrarCheques'])) {
                  if ($_SESSION['buscaRelatorioDebitosPorCliente']['mostrarCheques'] == "S") {
                     ?>
                     <input type="checkbox" class="form-check-input" name="mostrarCheques" value="1" id="mostrarCheques" checked>
                     <?php
                  }

                  else {
                     ?>
                     <input type="checkbox" class="form-check-input" name="mostrarCheques" value="1" id="mostrarCheques">
                     <?php
                  }
               }

               else {
                  ?>
                  <input type="checkbox" class="form-check-input" name="mostrarCheques" value="1" id="mostrarCheques" checked>
                  <?php
               }

               ?>
               <label class="form-check-label" for="mostrarCheques">Mostrar cheques</label>
            </div>

            <div class="form-group my-filtros-3">
               <?php

               if (isset($_SESSION['buscaRelatorioDebitosPorCliente']['vencimentoEmissao'])) {
                  if ($_SESSION['buscaRelatorioDebitosPorCliente']['vencimentoEmissao'] == "V") {
                     ?>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="vencimentoEmissao" id="porVencimento" value="V" checked>
                        <label class="form-check-label lbl-desc">Por vencimento</label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="vencimentoEmissao" id="porEmissao" value="E">
                        <label class="form-check-label lbl-desc">Por emissão</label>
                     </div>
                     <?php
                  }

                  else {
                     ?>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="vencimentoEmissao" id="porVencimento" value="V">
                        <label class="form-check-label lbl-desc">Por vencimento</label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="vencimentoEmissao" id="porEmissao" value="E" checked>
                        <label class="form-check-label lbl-desc">Por emissão</label>
                     </div>
                     <?php
                  }
               }

               else {
                  ?>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="vencimentoEmissao" id="porVencimento" value="V" checked>
                     <label class="form-check-label lbl-desc">Por vencimento</label>
                  </div>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="vencimentoEmissao" id="porEmissao" value="E">
                     <label class="form-check-label lbl-desc">Por emissão</label>
                  </div>
                  <?php
               }

               ?>
            </div>

            <div class="form-group">
              <input type="submit" class="btn btn-info filtro" id="btn-filtrar" name="relatorioDebitosPorCliente" value="Consultar" />
            </div>

            <?php

            if (isset($_SESSION['buscaRelatorioDebitosPorCliente']['dataInicio']) && !empty($_SESSION['buscaRelatorioDebitosPorCliente']['dataInicio']) &&
            isset($_SESSION['buscaRelatorioDebitosPorCliente']['dataFinal']) && !empty($_SESSION['buscaRelatorioDebitosPorCliente']['dataFinal'])) {

            ?>

            <!--<div class="form-group input">
               <button class="btn btn-info filtro" id="btn-imprimir" onClick="print();" name="relatorioDebitosPorCliente">Imprimir</button>
            </div>-->

            <div class="form-group input">
              <input type="submit" class="btn btn-info filtro" id="btn-excel" name="relatorioDebitosPorCliente" value="Gerar excel" />
            </div>

            <?php

            }

            ?>

          </div>
        </form>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped projects" id="tableId">
            <?php

            if (isset($_SESSION['buscaRelatorioDebitosPorCliente']) && $_SESSION['buscaRelatorioDebitosPorCliente'] != 0) {

               echo "
               <thead>";

               if ($_SESSION['tema'] == 'branco') {
                  echo "<tr class='text-center linhaBrancaTitulo'>";

                  echo "
                     <th>
                        Título
                     </th>
                     <th>
                        Emissão
                     </th>
                     <th>
                        Vencimento
                     </th>
                     <th>
                        Atraso
                     </th>
                     <th>
                        Valor
                     </th>
                     <th>
                        Saldo
                     </th>
                     <th>
                        Acumulado
                     </th>
                     <th>
                        Juros/multa
                     </th>
                     <th>
                        Acumulado juros/multa
                     </th>
                     <th>
                        Tipo
                     </th>
                     <th>
                        Banco
                     </th>
                     <th>
                        Vendedor
                     </th>";

                     echo "
                  </tr>
                  </thead>
                  <tbody>
                  ";
               }

               else {
                  echo "<tr class='text-center linhaPretaTitulo'>";

                  echo "
                     <th>
                        Título
                     </th>
                     <th>
                        Emissão
                     </th>
                     <th>
                        Vencimento
                     </th>
                     <th>
                        Atraso
                     </th>
                     <th>
                        Valor
                     </th>
                     <th>
                        Saldo
                     </th>
                     <th>
                        Acumulado
                     </th>
                     <th>
                        Juros/multa
                     </th>
                     <th>
                        Acumulado juros/multa
                     </th>
                     <th>
                        Tipo
                     </th>
                     <th>
                        Banco
                     </th>
                     <th>
                        Vendedor
                     </th>";

                     echo "
                  </tr>
                  </thead>
                  <tbody>";
               }

               $sVerLucro = $_SESSION['parametros']['verLucro'];

               if (isset($_SESSION['buscaRelatorioDebitosPorCliente']['cliente'])) {

                  $sComplemento = "";

                  if ($_SESSION['buscaRelatorioDebitosPorCliente']['somenteAberto'] == "S") {
                     $sComplemento = " AND Round(Duplicatas.Saldo, 2) > 0 ";
                  }

                  if ($_SESSION['buscaRelatorioDebitosPorCliente']['somenteAberto'] == "V") {

                     $sql = $pdo->prepare("SELECT Saldo, Nro, Emissao, Vencimento, Id, Valor, Tipo, Banco, Vendedor FROM Duplicatas Use Index(Cliente_Fornecedor) WHERE Cliente_Fornecedor = :codigo AND Receber_Pagar = 1
                     AND Duplicatas.Vencimento >= :datainicio AND Duplicatas.Vencimento <= :datafinal ".$sComplemento." ORDER BY Duplicatas.Vencimento, Duplicatas.Nro ASC");
                     $sql->bindValue(":codigo", $_SESSION['buscaRelatorioDebitosPorCliente']['cliente']);
                     $sql->bindValue(":datainicio", $_SESSION['buscaRelatorioDebitosPorCliente']['dataInicio']);
                     $sql->bindValue(":datafinal", $_SESSION['buscaRelatorioDebitosPorCliente']['dataFinal']);
                     $sql->execute();

                  }

                  else {

                     $sql = $pdo->prepare("SELECT Saldo, Nro, Emissao, Vencimento, Id, Valor, Tipo, Banco, Vendedor FROM Duplicatas Use Index(Cliente_Fornecedor) WHERE Cliente_Fornecedor = :codigo AND Receber_Pagar = 1
                     AND Duplicatas.Emissao >= :datainicio AND Duplicatas.Emissao <= :datafinal ".$sComplemento." ORDER BY Duplicatas.Emissao , Duplicatas.ID , Duplicatas.Nro ASC");
                     $sql->bindValue(":codigo", $_SESSION['buscaRelatorioDebitosPorCliente']['cliente']);
                     $sql->bindValue(":datainicio", $_SESSION['buscaRelatorioDebitosPorCliente']['dataInicio']);
                     $sql->bindValue(":datafinal", $_SESSION['buscaRelatorioDebitosPorCliente']['dataFinal']);
                     $sql->execute();
                     
                  }

               }

               $result = $sql->fetchAll();

               $uDupVencidas = 0;
               $uDupAVencer = 0;
               $uTotalJurosMulta = 0;
               $dTotalTitulo = 0;
               $dTotalAPagar = 0;

               if ($result != false) {

                  $sql = $pdo->prepare("SELECT Multa, IndiceFinanceiroJuros FROM parametros");
                  $sql->execute();

                  $resultParametros = $sql->fetch();

                  $multa = $resultParametros['Multa'];
                  $juros = $resultParametros['IndiceFinanceiroJuros'];

                  $dAcumulado = 0;
                  $dAcumuladoJuros = 0;

                  foreach ($result as $linha) {

                     $sEntra = "S";

                     if ($_SESSION['buscaRelatorioDebitosPorCliente']['somenteAberto'] == "S") {
                        if (round($linha['Saldo'], 2) <= 0) {
                           $sEntra = "N";
                        }
                     }

                     if ($sEntra == "S") {

                        if ($_SESSION['tema'] == 'branco') {
                           echo "<tr class='linhaBranca'>";
                        }
   
                        else {
                           echo "<tr class='linhaPreta'>";
                        }

                        echo "<td>".$linha['Nro']."</td>";

                        if ($linha['Saldo'] > 0) {
                           $dAcumulado += $linha['Saldo'];
                        }
                        
                        echo "<td>".date('d/m/Y', strtotime($linha['Emissao']))."</td>";
                        echo "<td>".date('d/m/Y', strtotime($linha['Vencimento']))."</td>";

                        $sPaga = "";

                        $IdBaixa = $linha['Id'];

                        $sql = $pdo->prepare("SELECT Data FROM Pagtos Use Index (IdTitulo) WHERE IdTitulo = :idbaixa AND Receber_Pagar = 1 ORDER BY Data DESC");
                        $sql->bindValue(":idbaixa", $IdBaixa);
                        $sql->execute();

                        $resultPagto = $sql->fetch();

                        if ($resultPagto != false) {

                           if ($resultPagto['Data'] == null) {
                              $sPaga = "";
                           }

                           else {
                              $sPaga = $resultPagto['Data'];
                           }

                        }

                        $dAtr = 0;

                        if (round($linha['Saldo'], 2) == 0) {

                           if (Trim($sPaga) == "") {
                              $dAtr = 0;
                           }

                           else {
                              $dAtr = intval(str_replace("-", "", $linha['Vencimento'])) - intval(str_replace("-", "", $sPaga));
                           }

                        }

                        else {

                           $dataVenc = intval(str_replace("-", "", $linha['Vencimento']));
                           $dataAtual = intval(str_replace("-", "", date('Y-m-d')));

                           if ($dataVenc >= $dataAtual) {

                              $dAtr = $dataVenc - $dataAtual;

                              $uDupAVencer += $linha['Saldo'];
                              $dAcumuladoJuros += $linha['Saldo'];

                           }

                           else {

                              $dAtr = $dataVenc - $dataAtual;
                              $uDupVencidas += $linha['Saldo'];
                           
                              $uValorMulta = 0;

                              if ($multa > 0 && $dAtr < 0) {
                                 $uValorMulta = round($linha['Saldo'] * $multa / 100, 2);
                              }
                           
                              if ($juros > 0 && $dAtr < 0) {
                                 $uValorJuros = round(($linha['Saldo'] * (($juros / 30) * $dAtr * -1)) / 100, 2);
                                 $dAcumuladoJuros += ($linha['Saldo'] + $uValorJuros + $uValorMulta);
                                 $uTotalJurosMulta += $uValorJuros + $uValorMulta;
                              }

                              else {
                                 $dAcumuladoJuros += ($linha['Saldo'] + $uValorMulta);
                                 $uTotalJurosMulta += $uValorMulta;
                              }

                           }

                        }

                        if ($dAtr >= 0) {

                           echo "<td class='text-success'>".$dAtr."</td>";

                        }

                        else {

                           echo "<td class='text-danger'>".$dAtr."</td>";

                        }

                        echo "<td>R$".ValidaValor($linha['Valor'])."</td>";

                        echo "<td>R$".ValidaValor($linha['Saldo'])."</td>";

                        echo "<td>R$".ValidaValor($dAcumulado)."</td>";

                        if ($dAtr >= 0) {

                           echo "<td>R$".ValidaValor(0)."</td>";

                        }

                        else {

                           echo "<td>R$".ValidaValor($uValorJuros + $uValorMulta)."</td>";

                        }

                        echo "<td>R$".ValidaValor($dAcumuladoJuros)."</td>";

                        $sql = $pdo->prepare("SELECT Descricao FROM Tipo WHERE Id = :id");
                        $sql->bindValue(":id", $linha['Tipo']);
                        $sql->execute();

                        $resultTipo = $sql->fetch();

                        if ($resultTipo != false) {
                           
                           echo "<td>".$resultTipo['Descricao']."</td>";

                        }

                        else {

                           echo "<td>Tipo inválido</td>";

                        }

                        $sql = $pdo->prepare("SELECT Descricao FROM banco WHERE Id = :id");
                        $sql->bindValue(":id", $linha['Banco']);
                        $sql->execute();

                        $resultBanco = $sql->fetch();

                        if ($resultBanco != false) {

                           echo "<td>".$resultBanco['Descricao']."</td>";

                        }

                        else {

                           echo "<td>Banco inválido</td>";

                        }

                        $sql = $pdo->prepare("SELECT Nome FROM vendedores WHERE Codigo = :codigo");
                        $sql->bindValue(":codigo", $linha['Vendedor']);
                        $sql->execute();

                        $resultVendedor = $sql->fetch();

                        if ($resultVendedor != false) {

                           echo "<td>".$resultVendedor['Nome']."</td>";

                        }

                        else {

                           echo "<td>Vendedor inválido</td>";

                        }

                        $dTotalTitulo += $linha['Valor'];

                        if ($linha['Saldo'] > 0) {
                           $dTotalAPagar += $linha['Saldo'];
                        }

                        echo "</tr>";

                     }

                  }

                  if ($uDupVencidas > 0) {

                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='linhaBrancaTitulo'>";
                     }

                     else {
                        echo "<tr class='linhaPretaTitulo'>";
                     }

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td>VENCIDAS: </td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td>".ValidaValor($uDupVencidas)."</td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "</tr>";

                  }

                  if ($uDupAVencer > 0) {

                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='linhaBrancaTitulo'>";
                     }

                     else {
                        echo "<tr class='linhaPretaTitulo'>";
                     }

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td>A VENCER: </td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td>".ValidaValor($uDupAVencer)."</td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";
                     
                     echo "</tr>";

                  }

                  if ($dTotalTitulo > 0) {

                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='linhaBrancaTitulo'>";
                     }

                     else {
                        echo "<tr class='linhaPretaTitulo'>";
                     }

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td>TOTAL: </td>";

                     echo "<td></td>";

                     echo "<td>R$".ValidaValor($dTotalTitulo)."</td>";

                     echo "<td>R$".ValidaValor($dTotalAPagar)."</td>";

                     echo "<td>R$".ValidaValor($dAcumulado)."</td>";

                     echo "<td>R$".ValidaValor($uTotalJurosMulta)."</td>";

                     echo "<td>R$".ValidaValor($dAcumuladoJuros)."</td>";
                     
                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "</tr>";

                  }
                  
                  // CHEQUES

                  $uTotalCheques = 0;
                  $uSaldoCheques = 0;

                  if ($_SESSION['buscaRelatorioDebitosPorCliente']['mostrarCheques'] == "S") {

                     $sComplementoCheque = "";

                     if ($_SESSION['buscaRelatorioDebitosPorCliente']['vencimentoEmissao'] == "E") {

                        $sComplementoCheque = " ORDER BY Emissao ASC";

                     }

                     else {

                        $sComplementoCheque = " ORDER BY Vencimento ASC";

                     }

                     if ($_SESSION['buscaRelatorioDebitosPorCliente']['somenteAberto'] == "S") {

                        $sql = $pdo->prepare("SELECT * FROM Cheques WHERE Cliente = :cliente AND Vencimento >= :datainicio AND Vencimento <= :datafinal AND Baixado = '0000-00-00'");

                     }

                     else {

                        $sql = $pdo->prepare("SELECT * FROM Cheques WHERE Cliente = :cliente AND Vencimento >= :datainicio AND Vencimento <= :datafinal");

                     }

                     $sql->bindValue(":cliente", $_SESSION['buscaRelatorioDebitosPorCliente']['cliente']);
                     $sql->bindValue(":datainicio", $_SESSION['buscaRelatorioDebitosPorCliente']['dataInicio']);
                     $sql->bindValue(":datafinal", $_SESSION['buscaRelatorioDebitosPorCliente']['dataFinal']);
                     $sql->execute();

                     $resultCheques = $sql->fetchAll();

                     if ($resultCheques != false) {

                        $uSaldoCheques = 0;
                        $uChequesVencidos = 0;
                        $uChequesAVencer = 0;

                        if ($_SESSION['tema'] == 'branco') {
                           echo "<tr class='linhaBranca'>";
                        }
   
                        else {
                           echo "<tr class='linhaPreta'>";
                        }
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
                        
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "</tr>";

                        foreach ($resultCheques as $linhaCheque) {

                           if ($linhaCheque['Baixado'] == "0000-00-00") {

                              $linhaCheque['Baixado'] = null;

                           }

                           $sEntra = "S";

                           $sDevolvido = "N";

                           if ($linhaCheque['Devolucao1'] != null) {

                              if (Trim($linhaCheque['Devolucao1']) != "") {

                                 $sDevolvido = "S";

                              }

                           }

                           if ($linhaCheque['Devolucao2'] != null) {

                              if (Trim($linhaCheque['Devolucao2']) != "") {

                                 $sDevolvido = "S";

                              }

                           }

                           if ($sEntra == "S") {

                              if ($_SESSION['tema'] == 'branco') {
                                 echo "<tr class='linhaBranca'>";
                              }
         
                              else {
                                 echo "<tr class='linhaPreta'>";
                              }
         
                              echo "<td>Cheque: ".$linhaCheque['NroCheque']."</td>";

                              if ($linhaCheque['Baixado'] == null) {

                                 $dAcumulado += $linhaCheque['Valor'];
                                 $uSaldoCheques += $linhaCheque['Valor'];

                              }

                              if (isset($linhaCheque['ValorOriginal'])) {

                                 if ($linhaCheque['ValorOriginal'] == 0) {

                                    $uTotalCheques += $linhaCheque['Valor'];

                                 }

                                 else {

                                    $uTotalCheques += $linhaCheque['ValorOriginal'];

                                 }

                              }

                              else {

                                 $uTotalCheques += $linhaCheque['Valor'];

                              }

                              echo "<td>".date('d/m/Y', strtotime($linhaCheque['Emissao']))."</td>";

                              echo "<td>".date('d/m/Y', strtotime($linhaCheque['Vencimento']))."</td>";

                              $sPaga = "";

                              $IdBaixa = $linhaCheque['Id'];

                              $sql = $pdo->prepare("SELECT Vencimento, Baixado FROM cheques WHERE Id = :id");
                              $sql->bindValue(":id", $IdBaixa);
                              $sql->execute();

                              $resultChequeTemp = $sql->fetchAll();

                              if ($resultChequeTemp != false) {

                                 foreach ($resultChequeTemp as $linhaChequeTemp) {

                                    if ($linhaChequeTemp['Baixado'] = "0000-00-00") {

                                       $linhaChequeTemp['Baixado'] = null;
                                       
                                    }

                                    if (isset($linhaChequeTemp['Baixado'])) {

                                       if ($linhaChequeTemp['Baixado'] != null && !empty($linhaChequeTemp['Baixado'])) {

                                          $dAtr = intval(str_replace("/", "", $linhaChequeTemp['Vencimento'])) - intval(str_replace("/", "", $linhaChequeTemp['Baixado']));
                                          $sPaga = "S";
   
                                       }

                                    }

                                 }

                              }

                              $uValorJuros = 0;

                              if (Trim($sPaga) == "") {

                                 if (intval(str_replace("-", "", $linhaCheque['Vencimento'])) > intval(str_replace("-", "", date('Y-m-d')))) {

                                    $dAtr = 0;
                                    $uChequesAVencer += $linhaCheque['Valor'];
                                    $dAcumuladoJuros += $linhaCheque['Valor'];

                                 }

                                 else {

                                    $dAtr = intval(str_replace("-", "", $linhaCheque['Vencimento'])) - intval(str_replace("-", "", date('Y-m-d')));

                                    $uChequesVencidos += $linhaCheque['Valor'];

                                    $uValorMulta = 0;
                                    if ($multa > 0) {
                                       $uValorMulta = 0;
                                       $uValorMulta = round($linhaCheque['Valor'] * $multa / 100, 2);
                                    }
                                    
                                    if ($juros > 0) {
                                       $uValorJuros = 0;
                                       $uValorJuros = round($linhaCheque['Valor'] * (($juros / 30) * $dAtr * -1) / 100, 2);
                                    }
                                    
                                    $dAcumuladoJuros += ($linhaCheque['Valor'] + $uValorJuros + $uValorMulta);

                                 }

                              }

                              else {

                                 $dAtr = intval(str_replace("-", "", $linhaCheque['Vencimento'])) - intval(str_replace("-", "", str_replace("/", "", $linhaCheque['Baixado'])));

                              }

                              if ($dAtr >= 0) {

                                 echo "<td class='text-success'>".$dAtr."</td>";

                              }

                              else {

                                 echo "<td class='text-danger'>".$dAtr."</td>";

                              }

                              if (isset($linhaCheque['ValorOriginal'])) {

                                 if ($linhaCheque['ValorOriginal'] == 0) {

                                    echo "<td>R$".ValidaValor($linhaCheque['Valor'])."</td>";

                                 }

                                 else {

                                    echo "<td>R$".ValidaValor($linhaCheque['ValorOriginal'])."</td>";

                                 }

                              }

                              else {

                                 echo "<td>R$".ValidaValor($linhaCheque['Valor'])."</td>";

                              }

                              if (isset($linhaCheque['Baixado'])) {

                                 if (!empty($linhaCheque['Baixado'])) {

                                    echo "<td>R$".ValidaValor($linhaCheque['Valor'])."</td>";

                                    echo "<td>R$".ValidaValor($dAcumulado)."</td>";

                                    echo "<td></td>";
   
                                    echo "<td>R$".ValidaValor($dAcumuladoJuros)."</td>";

                                 }

                                 else {

                                    echo "<td>R$".ValidaValor(0)."</td>";
                                 
                                    echo "<td>R$".ValidaValor(0)."</td>";

                                    echo "<td></td>";
   
                                    echo "<td>R$".ValidaValor(0)."</td>";

                                 }

                              }

                              else {

                                 echo "<td>R$".ValidaValor($linhaCheque['Valor'])."</td>";

                                 echo "<td>R$".ValidaValor($dAcumulado)."</td>";

                                 echo "<td></td>";

                                 echo "<td>R$".ValidaValor($dAcumuladoJuros)."</td>";

                              }

                              $sDevolvido = "N";

                              if (isset($linhaCheque['Devolucao1'])) {

                                 if (!empty($linhaCheque['Devolucao1'])) {

                                    echo "<td>".$linhaCheque['Devolucao1']."</td>";
                                    $sDevolvido = "S";

                                 }

                                 else {

                                    echo "<td></td>";

                                 }

                              }

                              else {

                                 echo "<td></td>";

                              }

                              if (isset($linhaCheque['Devolucao2'])) {

                                 if (!empty($linhaCheque['Devolucao2'])) {

                                    echo "<td>".$linhaCheque['Devolucao2']."</td>";
                                    $sDevolvido = "S";

                                 }

                                 else {

                                    echo "<td></td>";

                                 }

                              }

                              else {

                                 echo "<td></td>";

                              }

                              echo "<td></td>";

                              echo "</tr>";

                           }
                           
                        }

                        if ($uChequesVencidos > 0) {

                           if ($_SESSION['tema'] == 'branco') {
                              echo "<tr class='linhaBrancaTitulo'>";
                           }
      
                           else {
                              echo "<tr class='linhaPretaTitulo'>";
                           }
      
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "<td>VENCIDOS: </td>";
      
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "<td>R$".ValidaValor($uChequesVencidos)."</td>";
      
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "<td></td>";
                           
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "</tr>";

                        }

                        if ($uChequesAVencer > 0) {

                           if ($_SESSION['tema'] == 'branco') {
                              echo "<tr class='linhaBrancaTitulo'>";
                           }
      
                           else {
                              echo "<tr class='linhaPretaTitulo'>";
                           }
      
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "<td>A VENCER: </td>";
      
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "<td>R$".ValidaValor($uChequesAVencer)."</td>";
      
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "<td></td>";
                           
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "</tr>";

                        }

                        if ($_SESSION['tema'] == 'branco') {
                           echo "<tr class='linhaBrancaTitulo'>";
                        }
   
                        else {
                           echo "<tr class='linhaPretaTitulo'>";
                        }
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td>TOTAL CHEQUES: </td>";
   
                        echo "<td></td>";
   
                        echo "<td>R$".ValidaValor($uTotalCheques)."</td>";
   
                        echo "<td>R$".ValidaValor($uSaldoCheques)."</td>";
   
                        echo "<td>R$".ValidaValor($dAcumulado)."</td>";

                        echo "<td></td>";
   
                        echo "<td>R$".ValidaValor($dAcumuladoJuros)."</td>";
                        
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "</tr>";

                     }

                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='linhaBrancaTitulo'>";
                     }

                     else {
                        echo "<tr class='linhaPretaTitulo'>";
                     }

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td>TOTAL GERAL: </td>";

                     echo "<td></td>";

                     echo "<td>R$".ValidaValor($dTotalTitulo + $uTotalCheques)."</td>";

                     echo "<td>R$".ValidaValor($dTotalAPagar + $uSaldoCheques)."</td>";

                     echo "<td>R$".ValidaValor($dAcumulado)."</td>";

                     echo "<td>R$".ValidaValor($uTotalJurosMulta)."</td>";

                     echo "<td>R$".ValidaValor($dAcumuladoJuros)."</td>";
                     
                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "</tr>";

                  }

                  echo "</tbody>
                  </table";

               }

               else {
                  if ($_SESSION['tema'] == 'branco') {
                     echo "<tr class='linhaBranca'><td colspan='12'>Nenhuma venda foi encontrada!</td></tr>";
                  }

                  else {
                     echo "<tr><td colspan='12'>Nenhuma venda foi encontrada!</td></tr>";
                  }
               }
            }

            ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

<!-- Scripts de busca, add, edit... -->
<script src="plugins/pages/debitosCliente/main.js"></script>