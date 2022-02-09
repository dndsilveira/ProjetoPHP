<link rel="stylesheet" href="dist/css/pages/vendasVendedorPrint.css" media="print" />

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
        <h3 class="card-title">Vendas nota a nota por vendedor</h3>
        <div id="lancamentos"></div>
        <form class="barraPesquisa border-top" method="POST">
          <?php if ($_SESSION['tema'] == 'branco') { ?>
          <div class="input-group barraPesquisa bordaBranca">
          <?php } else { ?>
          <div class="input-group sidebar-dark-primary barraPesquisa bordaPreta">
          <?php } ?>

            <div class="form-group col-2 my-filtros codigo">
              <label for="filtroVendedor">Vendedores</label>
              <div class="input-group">
                  <?php

                  if (isset($_SESSION['buscaRelatorioVendasPorVendedor']['vendedores']) && !empty($_SESSION['buscaRelatorioVendasPorVendedor']['vendedores'])) {
                     ?>
                     <input type="text" class="form-control text-center" name="filtroVendedor" value="<?php echo $_SESSION['buscaRelatorioVendasPorVendedor']['vendedores']; ?>" id="filtroVendedor" readonly>
                     <?php
                  }

                  else {
                     ?>
                     <input type="text" class="form-control text-center" name="filtroVendedor" id="filtroVendedor" readonly>
                     <?php
                  }

                  ?>
                  <div class="input-group-append">
                     <span class="input-group-text" data-toggle="modal" data-target="#buscarVariosVendedoresModal">
                     <i class="fas fa-search"></i>
                     </span>
                  </div>
              </div>
            </div>

            <div class="form-group col-2 my-filtros responsive1">
               <label class="lbl-group">Data início</label>
               <?php

               if (isset($_SESSION['buscaRelatorioVendasPorVendedor']['dataInicio']) && !empty($_SESSION['buscaRelatorioVendasPorVendedor']['dataInicio'])) {
                  ?>
                  <input class="form-control form-control-sidebar responsive2" id="filtroDataInicio" name="filtroDataInicio" type="date" value="<?php echo $_SESSION['buscaRelatorioVendasPorVendedor']['dataInicio']; ?>">       
                  <?php
               }

               else {
                  ?>
                  <input class="form-control form-control-sidebar responsive2" id="filtroDataInicio" name="filtroDataInicio" type="date" value="<?php echo date('Y-m-01'); ?>">
                  <?php
               }

               ?>
            </div>
            
            <div class="form-group col-2 my-filtros responsive1 responsive3">
               <label class="lbl-group">Data final</label>
               <?php

               if (isset($_SESSION['buscaRelatorioVendasPorVendedor']['dataFinal']) && !empty($_SESSION['buscaRelatorioVendasPorVendedor']['dataFinal'])) {
                  ?>
                  <input class="form-control form-control-sidebar responsive2" id="filtroDataFinal" name="filtroDataFinal" type="date" value="<?php echo $_SESSION['buscaRelatorioVendasPorVendedor']['dataFinal']; ?>">       
                  <?php
               }

               else {
                  ?>
                  <input class="form-control form-control-sidebar responsive2" id="filtroDataFinal" name="filtroDataFinal" type="date" value="<?php echo date('Y-m-d'); ?>">
                  <?php
               }

               ?>
            </div>

            <div class="form-group responsive4">
              <input type="submit" class="btn btn-info filtro" id="btn-filtrar" name="relatorioVendasPorVendedor" value="Consultar" />
            </div>

            <?php

            if (isset($_SESSION['buscaRelatorioVendasPorVendedor']['dataInicio']) && !empty($_SESSION['buscaRelatorioVendasPorVendedor']['dataInicio']) &&
            isset($_SESSION['buscaRelatorioVendasPorVendedor']['dataFinal']) && !empty($_SESSION['buscaRelatorioVendasPorVendedor']['dataFinal'])) {

            ?>

            <div class="form-group input responsive6">
               <button class="btn btn-info filtro" id="btn-imprimir" onClick="print();" name="relatorioVendasPorVendedor">Imprimir</button>
            </div>

            <div class="form-group input responsive5">
              <input type="submit" class="btn btn-info filtro" id="btn-excel" name="relatorioVendasPorVendedor" value="Gerar excel" />
            </div>

            <?php

            }

            ?>

          </div>
        </form>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped projects text-nowrap"  id="tableId">
            <?php

            if (isset($_SESSION['buscaRelatorioVendasPorVendedor']) && $_SESSION['buscaRelatorioVendasPorVendedor'] != 0) {

               echo "
               <thead>";

               if ($_SESSION['tema'] == 'branco') {
                  echo "<tr class='text-center linhaBrancaTitulo'>";

                  echo "
                     <th class='dataPrint'>
                        Data
                     </th>
                     <th class='numeroPrint'>
                        Número
                     </th>
                     <th class='nomePrint'>
                        Nome do cliente
                     </th>
                     <th class='qtdPrint'>
                        Qtd
                     </th>
                     <th class='totalPrint'>
                        Total
                     </th>";

                     if ($_SESSION['parametros']['verLucro'] == 'S') {

                        echo "
                        <th class='mgPrint'>
                           Mg %
                        </th>";
   
                     }

                     echo "
                     <th class='comissReaisPrint'>
                        Com. R$
                     </th>
                     <th class='comissPorcPrint'>
                        Com. %
                     </th>
                     <th class='refPrint'>
                        Ref. R$
                     </th>
                     <th class='internoPrint'>
                        Interno
                     </th>
                  </tr>
                  </thead>
                  <tbody>
                  ";
               }

               else {
                  echo "<tr class='text-center linhaPretaTitulo'>";

                  echo "
                     <th class='dataPrint'>
                        Data
                     </th>
                     <th class='numeroPrint'>
                        Número
                     </th>
                     <th class='nomePrint'>
                        Nome do cliente
                     </th>
                     <th class='qtdPrint'>
                        Qtd
                     </th>
                     <th class='totalPrint'>
                        Total
                     </th>";

                     if ($_SESSION['parametros']['verLucro'] == 'S') {

                     echo "
                     <th class='mgPrint'>
                        Mg %
                     </th>";

                     }

                     echo "
                     <th class='comissReaisPrint'>
                        Com. R$
                     </th>
                     <th class='comissPorcPrint'>
                        Com. %
                     </th>
                     <th class='refPrint'>
                        Ref. R$
                     </th>
                     <th class='internoPrint'>
                        Interno
                     </th>
                  </tr>
                  </thead>
                  <tbody>
                  ";
               }

               $uQuantGer = 0;
               $uValorGer = 0;
               $uCustoGer = 0;
               $uComisGer = 0;
               $uReferGer = 0;

               $contadorLinhas = 0;

               $sVerLucro = $_SESSION['parametros']['verLucro'];

               if (isset($_SESSION['buscaRelatorioVendasPorVendedor']['vendedores']) && !empty($_SESSION['buscaRelatorioVendasPorVendedor']['vendedores'])) {

                  $sql = $pdo->prepare("SELECT Codigo, Nome FROM Vendedores WHERE Inativo <> 'S' AND Codigo IN ( ".$_SESSION['buscaRelatorioVendasPorVendedor']['vendedores']." ) ORDER BY Nome");
                  $sql->execute();

               }

               else {

                  if ($_SESSION['parametros']['verSomenteSuasVendas'] == 'S') {

                     $sql = $pdo->prepare("SELECT Codigo, Nome FROM Vendedores WHERE Inativo <> 'S' AND Usuario = :usuario ORDER BY Nome");
                     $sql->bindValue(":usuario", $info['Id']);
                     $sql->execute();

                  }

                  else {

                     $sql = $pdo->prepare("SELECT Codigo, Nome FROM Vendedores WHERE Inativo <> 'S' ORDER BY Nome");
                     $sql->execute();

                  }

               }

               $result = $sql->fetchAll();
                
               if ($result != false) {
                  foreach ($result as $linha) {

                     $uQuantVen = 0;
                     $uValorVen = 0;
                     $uCustoVen = 0;
                     $uComisDia = 0;
                     $uComisVen = 0;
                     $uReferVen = 0;
                     
                     $lVendID = $linha['Codigo'];
                     $sNomeVendedor = $linha['Nome'];
                     $sEntrouVendedor = "N";

                     $sql = $pdo->prepare("SELECT Movimento.CodigoCliente, Movimento.Comissao as Comissao1, Movimento.ComissaoInterno as Comissao2, Movimento.CidadeCliente,
                     Material.Comissao as ComissaoCadastroProduto, Material.NaoEntraRentabilidade, Material.Colorante, Material.Comissao as ComissaoProduto,
                     Movimento.Comissao as ComisMov, Movimento.AcrescimoVenda as uAcrescimo, Movimento.MargemVenda, Movimento_Itens.Devolucao,
                     Movimento.Comissao as ComissaoPedido, Movimento_Itens.IndiceFinanceiro, Movimento_ITens.prazoMedio, Movimento_Itens.Descricao,
                     Movimento_Itens.PrecoTabela, Movimento_Itens.Unitario, Movimento_Itens.EntradaSaida, Movimento_Itens.Venda, Movimento.NomeCliente,
                     Movimento_ITens.NumeroControle, Movimento_ITens.NumeroNf, Movimento_ITens.Comissao, Movimento_ITens.CodigoProduto, Movimento_ITens.Tabela,
                     Movimento_ITens.IdMovimento, Movimento_ITens.Vendedor, Movimento_ITens.DataMovimento, Movimento_ITens.Quantidade, Movimento_ITens.Custo,
                     Movimento_ITens.Total, Movimento.Frete, Movimento.Desconto, Movimento.TotalNota, Movimento.MargemVenda, Movimento_Itens.Vendedor2,
                     Movimento_Itens.NumeroCupom FROM Movimento_ITens INNER JOIN Movimento ON Movimento_ITens.IdMovimento=Movimento.Id
                     INNER JOIN Material ON Movimento_Itens.CodigoProduto = Material.Codigo
                     WHERE Movimento_ITens.DataMovimento >= :datainicio AND Movimento_ITens.DataMovimento <= :datafinal
                     AND (Movimento_Itens.Vendedor = :vendedor OR Movimento_Itens.Vendedor2 = :vendedor)
                     ORDER BY Movimento_ITens.DataMovimento, Movimento_ITens.Vendedor, Movimento_ITens.NumeroNf, Movimento_ITens.NumeroControle");
                     $sql->bindValue(":datainicio", $_SESSION['buscaRelatorioVendasPorVendedor']['dataInicio']);
                     $sql->bindValue(":datafinal", $_SESSION['buscaRelatorioVendasPorVendedor']['dataFinal']);
                     $sql->bindValue(":vendedor", $linha['Codigo']);
                     $sql->execute();

                     $resultVenda = $sql->fetchAll();

                     $totalVendas = [];

                     if ($resultVenda != false) {

                        foreach ($resultVenda as $venda) {

                           $id = $venda['IdMovimento'];

                           if(array_key_exists($id, $totalVendas)) {

                              $totalVendas[$id]['sDividir'] = "N";
                              $totalVendas[$id]['sInternoExterno'] = "I";
                              $totalVendas[$id]['l2Vendedor'] = 0;
                              $totalVendas[$id]['Vendedor2'] = "";
                              
                              if ($venda['Vendedor'] > 0 && $venda['Vendedor2'] > 0) {
                                 $totalVendas[$id]['sDividir'] = 'S';
                              }
   
                              if ($venda['Vendedor'] == $linha['Codigo']) {
   
                                 $totalVendas[$id]['l2Vendedor'] = $venda['Vendedor2'];
   
                                 $sql = $pdo->prepare("SELECT Nome, InternoExterno FROM Vendedores WHERE Codigo = :codigo");
                                 $sql->bindValue(":codigo", $venda['Vendedor2']);
                                 $sql->execute();
   
                                 $resultVendedor = $sql->fetch();
   
                                 if ($resultVendedor != false) {
                                    $totalVendas[$id]['sInternoExterno'] = "";
                                    $totalVendas[$id]['Vendedor2'] = $resultVendedor['Nome'];

                                    if ($venda['Vendedor2'] == 0) {
                                       $totalVendas[$id]['Vendedor2'] = "";
                                    }

                                    if ($resultVendedor['InternoExterno'] != null && $resultVendedor['InternoExterno'] != false) {
                                       $totalVendas[$id]['sInternoExterno'] = $resultVendedor['InternoExterno'];
                                    }
                                 }
                              }
   
                              else {
   
                                 $totalVendas[$id]['l2Vendedor'] = $venda['Vendedor'];
   
                                 $sql = $pdo->prepare("SELECT Nome, InternoExterno FROM Vendedores WHERE Codigo = :codigo");
                                 $sql->bindValue(":codigo", $venda['Vendedor']);
                                 $sql->execute();
   
                                 $resultVendedor = $sql->fetch();
   
                                 if ($resultVendedor != false) {
                                    $totalVendas[$id]['sInternoExterno'] = "";
                                    $totalVendas[$id]['Vendedor2'] = $resultVendedor['Nome'];
                                    if ($resultVendedor['InternoExterno'] != null && $resultVendedor['InternoExterno'] != false) {
                                       $totalVendas[$id]['sInternoExterno'] = $resultVendedor['InternoExterno'];
                                    }
                                 }
                              }
   
                              $totalVendas[$id]['uTaxa'] = 0;
   
                              if ($lVendID == $venda['Vendedor']) {
                                 $totalVendas[$id]['uTaxa'] = $venda['Comissao1'];
                              }
   
                              else {
                                 $totalVendas[$id]['uTaxa'] = $venda['Comissao2'];
                              }
   
                              $totalVendas[$id]['sComNF'] = "S";
                              $totalVendas[$id]['lNro'] = $venda['IdMovimento'];
                              
                              if ($venda['NumeroNf'] == 0) {
                                 if ($venda['NumeroCupom'] == false || $venda['NumeroCupom'] == null) {
                                    $totalVendas[$id]['lNroNf'] = $venda['NumeroControle'];
                                    $totalVendas[$id]['sComNF'] = "";
                                 }
   
                                 else {
                                    if (Trim($venda['NumeroCupom']) == 0) {
                                       $totalVendas[$id]['lNroNf'] = $venda['NumeroControle'];
                                       $totalVendas[$id]['sComNF'] = "";
                                    }
   
                                    else {
                                       $totalVendas[$id]['lNroNf'] = $venda['NumeroCupom'];
                                       $totalVendas[$id]['sComNF'] = "C";
                                    }
                                 }
                              }
   
                              else {
                                 $totalVendas[$id]['lNroNf'] = $venda['NumeroNf'];
                                 $totalVendas[$id]['sComNF'] = "S";
                              }
   
                              $totalVendas[$id]['dData'] = $venda['DataMovimento'];
                              $totalVendas[$id]['sNomeCliente'] = $venda['NomeCliente'];
                              $totalVendas[$id]['sEntrouNota'] = "N";
   
                              $totalVendas[$id]['sEntra'] = "N";
   
                              if ($venda['Venda'] == "S" && $venda['EntradaSaida'] == "S") {
                                 $totalVendas[$id]['sEntra'] = "S";
                                 $totalVendas[$id]['sTipo'] = "V";
                              }
   
                              if ($venda['Devolucao'] == "S" && $venda['EntradaSaida'] == "E") {
                                 $totalVendas[$id]['sEntra'] = "S";
                                 $totalVendas[$id]['sTipo'] = "D";
                              }
   
                              $totalVendas[$id]['uCustoCFinanceiro'] = 0;
   
                              $totalVendas[$id]['uCustoP'] = 0;
   
                              $totalVendas[$id]['uCustoP'] = ($venda['Quantidade'] * $venda['Custo']);
   
                              if ($totalVendas[$id]['sEntra'] == 'S') {
   
                                 if ($totalVendas[$id]['sTipo'] == "D") {
                              
                                    $totalVendas[$id]['uQuantDia'] -= $venda['Quantidade'];
                                    $totalVendas[$id]['uCustoDia'] -= $totalVendas[$id]['uCustoP'];
                                    $uQuantGer -= $venda['Quantidade'];
                                    $uCustoGer -= $totalVendas[$id]['uCustoP'];
                                    $uQuantVen -= $venda['Quantidade'];
                                    $uCustoVen -= $totalVendas[$id]['uCustoP'];
                                 
                                 }
   
                                 else {
                                    
                                    $totalVendas[$id]['uQuantDia'] += $venda['Quantidade'];
                                    $totalVendas[$id]['uCustoDia'] += $totalVendas[$id]['uCustoP'];
                                    $uQuantGer += $venda['Quantidade'];
                                    $uCustoGer += $totalVendas[$id]['uCustoP'];
                                    $uQuantVen += $venda['Quantidade'];
                                    $uCustoVen += $totalVendas[$id]['uCustoP'];
                                 
                                 }
   
                                 $totalVendas[$id]['uDesconto'] = 0;
                                 if (($venda['TotalNota'] - $venda['Frete'] + $venda['Desconto']) != 0) {
                                    $totalVendas[$id]['uDesconto'] = ($venda['Desconto'] / ($venda['TotalNota'] - $venda['Frete'] + $venda['Desconto'])) * 100;
                                 }
   
                                 else {
                                    $totalVendas[$id]['uDesconto'] = 0;
                                 }
                           
                                 $totalVendas[$id]['uMargem'] = TrataNulo($venda['MargemVenda'], 0);
   
                                 if ($totalVendas[$id]['sTipo'] == "D") {
                           
                                    if ($totalVendas[$id]['uDesconto'] > 0) {
                                       
                                       if ($totalVendas[$id]['sDividir'] == "S") {
                                          $uReferGer -= ((($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100)) / 2);
                                          $uReferVen -= ((($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100)) / 2);
                                       }
   
                                       else {
                                          $uReferGer -= (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                          $uReferVen -= (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       }
                                       
                                       $uValorGer -= (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       $uValorVen -= (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       $totalVendas[$id]['uDia'] -= (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       $totalVendas[$id]['uBaseComis'] = (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
   
                                    }
                                    
                                    else {
                                       
                                       if ($totalVendas[$id]['sDividir'] == "S") {
                                          $uReferGer -= ($venda['Total'] / 2);
                                          $uReferVen -= ($venda['Total'] / 2);
                                       }
   
                                       else {
                                          $uReferGer -= $venda['Total'];
                                          $uReferVen -= $venda['Total'];
                                       }
                                       
                                       $uValorGer -= $venda['Total'];
                                       $uValorVen -= $venda['Total'];
                                       $totalVendas[$id]['uDia'] -= $venda['Total'];
                                       $totalVendas[$id]['uBaseComis'] = $venda['Total'];
                                    
                                    }
                                 
                                 }
   
                                 else {
                                    
                                    if ($totalVendas[$id]['uDesconto'] > 0) {
                                       
                                       if ($totalVendas[$id]['sDividir'] == "S") {
                                          $uReferGer += ((($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100)) / 2);
                                          $uReferVen += ((($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100)) / 2);
                                       }
   
                                       else {
                                          $uReferGer += (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                          $uReferVen += (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       }
                                       
                                       $uValorGer += (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       $uValorVen += (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       $totalVendas[$id]['uDia'] += (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       $totalVendas[$id]['uBaseComis'] = (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
   
                                    }
                                    
                                    else {
                                                                  
                                       if ($totalVendas[$id]['sDividir'] == "S") {
                                          $uReferGer += ($venda['Total'] / 2);
                                          $uReferVen += ($venda['Total'] / 2);
                                       }
   
                                       else {
                                          $uReferGer += $venda['Total'];
                                          $uReferVen += $venda['Total'];
                                       }
                                       
                                       $uValorGer += $venda['Total'];
                                       $uValorVen += $venda['Total'];
                                       $totalVendas[$id]['uDia'] += $venda['Total'];
                                       $totalVendas[$id]['uBaseComis'] = $venda['Total'];
                                    
                                    }
                                 }
                              }
                           }

                           // SETANDO A ARRAY

                           else {

                              $totalVendas[$id]['sDividir'] = "N";
                              $totalVendas[$id]['sInternoExterno'] = "I";
                              $totalVendas[$id]['l2Vendedor'] = 0;
                              $totalVendas[$id]['Vendedor2'] = "";
                              
                              if ($venda['Vendedor'] > 0 && $venda['Vendedor2'] > 0) {
                                 $totalVendas[$id]['sDividir'] = 'S';
                              }
   
                              if ($venda['Vendedor'] == $linha['Codigo']) {
   
                                 $totalVendas[$id]['l2Vendedor'] = $venda['Vendedor2'];
   
                                 $sql = $pdo->prepare("SELECT Nome, InternoExterno FROM Vendedores WHERE Codigo = :codigo");
                                 $sql->bindValue(":codigo", $venda['Vendedor2']);
                                 $sql->execute();
   
                                 $resultVendedor = $sql->fetch();
   
                                 if ($resultVendedor != false) {
                                    $totalVendas[$id]['sInternoExterno'] = "";
                                    $totalVendas[$id]['Vendedor2'] = $resultVendedor['Nome'];

                                    if ($venda['Vendedor2'] == 0) {
                                       $totalVendas[$id]['Vendedor2'] = "";
                                    }

                                    if ($resultVendedor['InternoExterno'] != null && $resultVendedor['InternoExterno'] != false) {
                                       $totalVendas[$id]['sInternoExterno'] = $resultVendedor['InternoExterno'];
                                    }
                                 }
                              }
   
                              else {
   
                                 $totalVendas[$id]['l2Vendedor'] = $venda['Vendedor'];
   
                                 $sql = $pdo->prepare("SELECT Nome, InternoExterno FROM Vendedores WHERE Codigo = :codigo");
                                 $sql->bindValue(":codigo", $venda['Vendedor']);
                                 $sql->execute();
   
                                 $resultVendedor = $sql->fetch();
   
                                 if ($resultVendedor != false) {
                                    $totalVendas[$id]['sInternoExterno'] = "";
                                    $totalVendas[$id]['Vendedor2'] = $resultVendedor['Nome'];
                                    if ($resultVendedor['InternoExterno'] != null && $resultVendedor['InternoExterno'] != false) {
                                       $totalVendas[$id]['sInternoExterno'] = $resultVendedor['InternoExterno'];
                                    }
                                 }
                              }
   
                              $totalVendas[$id]['uTaxa'] = 0;
   
                              if ($lVendID == $venda['Vendedor']) {
                                 $totalVendas[$id]['uTaxa'] = $venda['Comissao1'];
                              }
   
                              else {
                                 $totalVendas[$id]['uTaxa'] = $venda['Comissao2'];
                              }
   
                              $totalVendas[$id]['sComNF'] = "S";
                              $totalVendas[$id]['lNro'] = $venda['IdMovimento'];
                              
                              if ($venda['NumeroNf'] == 0) {
                                 if ($venda['NumeroCupom'] == false || $venda['NumeroCupom'] == null) {
                                    $totalVendas[$id]['lNroNf'] = $venda['NumeroControle'];
                                    $totalVendas[$id]['sComNF'] = "";
                                 }
   
                                 else {
                                    if (Trim($venda['NumeroCupom']) == 0) {
                                       $totalVendas[$id]['lNroNf'] = $venda['NumeroControle'];
                                       $totalVendas[$id]['sComNF'] = "";
                                    }
   
                                    else {
                                       $totalVendas[$id]['lNroNf'] = $venda['NumeroCupom'];
                                       $totalVendas[$id]['sComNF'] = "C";
                                    }
                                 }
                              }
   
                              else {
                                 $totalVendas[$id]['lNroNf'] = $venda['NumeroNf'];
                                 $totalVendas[$id]['sComNF'] = "S";
                              }
   
                              $totalVendas[$id]['dData'] = $venda['DataMovimento'];
                              $totalVendas[$id]['sNomeCliente'] = $venda['NomeCliente'];
                              $totalVendas[$id]['uMargem'] = 0;
                              $totalVendas[$id]['sEntrouNota'] = "N";
   
                              $totalVendas[$id]['sEntra'] = "N";
   
                              if ($venda['Venda'] == "S" && $venda['EntradaSaida'] == "S") {
                                 $totalVendas[$id]['sEntra'] = "S";
                                 $totalVendas[$id]['sTipo'] = "V";
                              }
   
                              if ($venda['Devolucao'] == "S" && $venda['EntradaSaida'] == "E") {
                                 $totalVendas[$id]['sEntra'] = "S";
                                 $totalVendas[$id]['sTipo'] = "D";
                              }
   
                              $totalVendas[$id]['uCustoCFinanceiro'] = 0;
   
                              $totalVendas[$id]['uCustoP'] = 0;
   
                              $totalVendas[$id]['uCustoP'] = ($venda['Quantidade'] * $venda['Custo']);
   
                              if ($totalVendas[$id]['sEntra'] == 'S') {
   
                                 if ($totalVendas[$id]['sTipo'] == "D") {
                              
                                    $totalVendas[$id]['uQuantDia'] = ($venda['Quantidade'] * (-1));
                                    $totalVendas[$id]['uCustoDia'] = ($totalVendas[$id]['uCustoP'] * (-1));
                                    $uQuantGer -= $venda['Quantidade'];
                                    $uCustoGer -= $totalVendas[$id]['uCustoP'];
                                    $uQuantVen -= $venda['Quantidade'];
                                    $uCustoVen -= $totalVendas[$id]['uCustoP'];
                                 
                                 }
   
                                 else {
                                    
                                    $totalVendas[$id]['uQuantDia'] = $venda['Quantidade'];
                                    $totalVendas[$id]['uCustoDia'] = $totalVendas[$id]['uCustoP'];
                                    $uQuantGer += $venda['Quantidade'];
                                    $uCustoGer += $totalVendas[$id]['uCustoP'];
                                    $uQuantVen += $venda['Quantidade'];
                                    $uCustoVen += $totalVendas[$id]['uCustoP'];
                                 
                                 }
   
                                 $totalVendas[$id]['uDesconto'] = 0;
                                 if (($venda['TotalNota'] - $venda['Frete'] + $venda['Desconto']) != 0) {
                                    $totalVendas[$id]['uDesconto'] = ($venda['Desconto'] / ($venda['TotalNota'] - $venda['Frete'] + $venda['Desconto'])) * 100;
                                 }
   
                                 else {
                                    $totalVendas[$id]['uDesconto'] = 0;
                                 }
                           
                                 $totalVendas[$id]['uMargem'] = TrataNulo($venda['MargemVenda'], 0);
   
                                 if ($totalVendas[$id]['sTipo'] == "D") {
                           
                                    if ($totalVendas[$id]['uDesconto'] > 0) {
                                       
                                       if ($totalVendas[$id]['sDividir'] == "S") {
                                          $uReferGer -= ((($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100)) / 2);
                                          $uReferVen -= ((($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100)) / 2);
                                       }
   
                                       else {
                                          $uReferGer -= (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                          $uReferVen -= (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       }
                                       
                                       $uValorGer -= (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       $uValorVen -= (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       $totalVendas[$id]['uDia'] = ((($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100)) * (-1));
                                       $totalVendas[$id]['uBaseComis'] = ((($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100)) * (-1));
   
                                    }
                                    
                                    else {
                                       
                                       if ($totalVendas[$id]['sDividir'] == "S") {
                                          $uReferGer -= ($venda['Total'] / 2);
                                          $uReferVen -= ($venda['Total'] / 2);
                                       }
   
                                       else {
                                          $uReferGer -= $venda['Total'];
                                          $uReferVen -= $venda['Total'];
                                       }
                                       
                                       $uValorGer -= $venda['Total'];
                                       $uValorVen -= $venda['Total'];
                                       $totalVendas[$id]['uDia'] = ($venda['Total'] * (-1));
                                       $totalVendas[$id]['uBaseComis'] = ($venda['Total'] * (-1));
                                    
                                    }
                                 
                                 }
   
                                 else {
                                    
                                    if ($totalVendas[$id]['uDesconto'] > 0) {
                                       
                                       if ($totalVendas[$id]['sDividir'] == "S") {
                                          $uReferGer += ((($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100)) / 2);
                                          $uReferVen += ((($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100)) / 2);
                                       }
   
                                       else {
                                          $uReferGer += (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                          $uReferVen += (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       }
                                       
                                       $uValorGer += (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       $uValorVen += (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       $totalVendas[$id]['uDia'] = (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
                                       $totalVendas[$id]['uBaseComis'] = (($venda['Total']) - (($venda['Total'] * $totalVendas[$id]['uDesconto']) / 100));
   
                                    }
                                    
                                    else {
                                                                  
                                       if ($totalVendas[$id]['sDividir'] == "S") {
                                          $uReferGer += ($venda['Total'] / 2);
                                          $uReferVen += ($venda['Total'] / 2);
                                       }
   
                                       else {
                                          $uReferGer += $venda['Total'];
                                          $uReferVen += $venda['Total'];
                                       }
                                       
                                       $uValorGer += $venda['Total'];
                                       $uValorVen += $venda['Total'];
                                       $totalVendas[$id]['uDia'] = $venda['Total'];
                                       $totalVendas[$id]['uBaseComis'] = $venda['Total'];
                                    
                                    }
                                 }
                              }
                           }
                        }

                        $_SESSION['impressao']['notaNotaVendedor'] = $totalVendas;

                        foreach ($totalVendas as $linhaVenda) {
                           
                           if ($linhaVenda['sEntra'] == "S") {

                              if ($sEntrouVendedor != 'S') {

                                 if ($_SESSION['tema'] == 'branco') {

                                    if ($_SESSION['parametros']['verLucro'] == 'S') {

                                       echo "
                                       <tr class='linhaBrancaTitulo'>
                                          <td colspan='10' class='nomeVendedorPrint brancoTitulo'>".$lVendID." - ".$sNomeVendedor."</td>
                                       </tr>
                                       ";

                                    }

                                    else {

                                       echo "
                                       <tr class='linhaBrancaTitulo'>
                                          <td colspan='9' class='nomeVendedorPrint brancoTitulo'>".$lVendID." - ".$sNomeVendedor."</td>
                                       </tr>
                                       ";

                                    }
                                 }

                                 else {

                                    if ($_SESSION['parametros']['verLucro'] == 'S') {

                                       echo "
                                       <tr class='linhaPretaTitulo'>
                                          <td colspan='10' class='nomeVendedorPrint pretoTitulo'>".$lVendID." - ".$sNomeVendedor."</td>
                                       </tr>
                                       ";

                                    }

                                    else {

                                       echo "
                                       <tr class='linhaPretaTitulo'>
                                          <td colspan='9' class='nomeVendedorPrint pretoTitulo'>".$lVendID." - ".$sNomeVendedor."</td>
                                       </tr>
                                       ";

                                    }
                                 }
                                 
                                 $contadorLinhas++;

                                 $sEntrouVendedor = "S";
                              }
                     
                              $uComissao = 0;
                              $uComissao = Round(($linhaVenda['uDia'] * $linhaVenda['uTaxa']) / 100, 2);
               
                              $uComisDia += Round(($linhaVenda['uDia'] * $linhaVenda['uTaxa']) / 100, 2);
                              $uComisVen += Round(($linhaVenda['uDia'] * $linhaVenda['uTaxa']) / 100, 2);
                              $uComisGer += Round(($linhaVenda['uDia'] * $linhaVenda['uTaxa']) / 100, 2);

                              if ($_SESSION['tema'] == 'branco') {

                                 if (($contadorLinhas % 45) == 0 || ((($contadorLinhas-1) % 45) == 0 && (($contadorLinhas-1) > 0))) {

                                    echo "<tr class='text-center quebrarLinha linhaBranca'>";

                                 }

                                 else {

                                    echo "<tr class='text-center linhaBranca'>";

                                 }

                              }

                              else {

                                 if (($contadorLinhas % 45) == 0) {

                                    echo "<tr class='text-center quebrarLinha linhaPreta' style='line-height: 35px;'>";

                                 }

                                 else {

                                    echo "<tr class='text-center linhaPreta' style='line-height: 35px;'>";

                                 }

                              }

                              $contadorLinhas++;
   
                              echo "<td class='dataPrint'>".date('d/m/Y', strtotime($linhaVenda['dData']))."</td>";
   
                              if ($linhaVenda['sComNF'] == "S" || $linhaVenda['sComNF'] == "C") {
                                 if ($linhaVenda['sComNF'] == "C") {
                                    echo "<td class='numeroPrint'>".str_pad($linhaVenda['lNroNf'], 6, 0, STR_PAD_LEFT)." CP</td>";
                                 }
   
                                 else {
                                    echo "<td class='numeroPrint'>".str_pad($linhaVenda['lNroNf'], 6, 0, STR_PAD_LEFT)." NF</td>";
                                 }
                              }
   
                              else {
                                 echo "<td class='numeroPrint'>".str_pad($linhaVenda['lNroNf'], 6, 0, STR_PAD_LEFT)." *</td>";
                              }
   
                              echo "<td class='nomePrint'>".$linhaVenda['sNomeCliente']."</td>";
                              echo "<td class='qtdPrint'>".ValidaValor($linhaVenda['uQuantDia'])."</td>";
                              echo "<td class='totalPrint'>R$".ValidaValor($linhaVenda['uDia'])."</td>";
   
                              if ($sVerLucro == "S") {
                                 echo "<td class='mgPrint'>".ValidaValor(Round((($linhaVenda['uDia'] - $linhaVenda['uCustoDia']) / $linhaVenda['uDia']) * 100, 2))."%</td>";
                              }
   
                              echo "<td class='comissReaisPrint'>R$".ValidaValor(Round(($linhaVenda['uDia'] * $linhaVenda['uTaxa']) / 100, 2))."</td>";
                              echo "<td class='comissPorcPrint'>".ValidaValor($linhaVenda['uTaxa'])."%</td>";
                              
                              if ($linhaVenda['sDividir'] == "S" ) {
                                 echo "<td class='refPrint'>R$".ValidaValor($linhaVenda['uDia'] / 2)."</td>";
                              }
   
                              else {
                                 echo "<td class='refPrint'>R$".ValidaValor($linhaVenda['uDia'])."</td>";
                              }
   
                              echo "<td class='internoPrint'>".$linhaVenda['Vendedor2']."</td>";
         
                              echo "</tr>";
                        
                              $linhaVenda['sEntrouNota'] = "S";
                                       
                           }
                        }

                        if ($uValorVen != 0) {

                           if ($_SESSION['tema'] == 'branco') {

                              if (($contadorLinhas % 45) == 0 || ($contadorLinhas % 45)+1 == 0)  {

                                 echo "<tr class='text-center quebrarLinha linhaBrancaTitulo'>";

                              }

                              else {

                                 echo "<tr class='text-center linhaBrancaTitulo'>";

                              }

                           }

                           else {

                              if (($contadorLinhas % 45) == 0 || ($contadorLinhas % 45)+1 == 0) {

                                 echo "<tr class='text-center quebrarLinha linhaPretaTitulo'>";

                              }

                              else {

                                 echo "<tr class='text-center linhaPretaTitulo'>";

                              }
                              
                           }

                           $contadorLinhas++;

                           echo "<td colspan='2'></td>";

                           echo "<td class='totalNomeVendedorPrint'>TOTAL: ".$sNomeVendedor."</td>";
                           echo "<td class='quantidadeVendedorPrint'>".ValidaValor($uQuantVen)."</td>";
                           echo "<td class='totalVendedorPrint'>R$".ValidaValor($uValorVen)."</td>";

                           if ($uValorVen == 0 || $uCustoVen == 0) {
                              echo "<td class='mgVendedorPrint'>".ValidaValor(0)."</td>";
                           }

                           else {
                              if ($sVerLucro == "S") {
                                 // if ChkMostrarMargem.Value = 1 ) {
                                    echo "<td class='mgVendedorPrint'>".ValidaValor(($uValorVen - $uCustoVen) / $uValorVen * 100)."%</td>";
                                 // }

                                 // else {
                                 //   MsVendas.TextMatrix(lRow, 5) = Format(0, "###,###,##0.00")
                                 // }
                              }
                           }

                           echo "<td class='comissReaisVendedorPrint'>R$".ValidaValor($uComisVen)."</td>";

                           if ($uValorVen > 0 && $uComisVen > 0) {
                              echo "<td class='comissPorcVendedorPrint'>".ValidaValor(Round(($uComisVen / $uValorVen) * 100, 2))."%</td>";
                           }

                           else {
                              echo "<td class='comissPorcVendedorPrint'>".ValidaValor(0)."%</td>";
                           }

                           echo "<td class='refVendedorPrint'>R$".ValidaValor($uReferVen)."</td>";

                           echo "<td class='internoVendedorPrint'></td>";

                           echo "</tr>";

                           if ($_SESSION['tema'] == 'branco') {

                              if ($_SESSION['parametros']['verLucro'] == 'S') {

                                 if (($contadorLinhas % 45) == 0) {
   
                                    echo "<tr class='quebrarLinha linhaBranca'><td class='linhaEmBrancoPrint' colspan='10'></td></tr>";
   
                                 }
   
                                 else {
   
                                    echo "<tr class='linhaBranca'><td class='linhaEmBrancoPrint' colspan='10'></td></tr>";
   
                                 }
   
                              }
   
                              else {
   
                                 if (($contadorLinhas % 45) == 0) {
   
                                    echo "<tr class='quebrarLinha linhaBranca'><td class='linhaEmBrancoPrint' colspan='9'></td></tr>";
   
                                 }
   
                                 else {
   
                                    echo "<tr class='linhaBranca'><td class='linhaEmBrancoPrint' colspan='9'></td></tr>";
   
                                 }
   
                              }

                           }

                           else {

                              if ($_SESSION['parametros']['verLucro'] == 'S') {

                                 if (($contadorLinhas % 45) == 0) {
   
                                    echo "<tr class='quebrarLinha linhaPreta'><td class='linhaEmBrancoPrint' colspan='10'></td></tr>";
   
                                 }
   
                                 else {
   
                                    echo "<tr class='linhaPreta'><td class='linhaEmBrancoPrint' colspan='10'></td></tr>";
   
                                 }
   
                              }
   
                              else {
   
                                 if (($contadorLinhas % 45) == 0) {
   
                                    echo "<tr class='quebrarLinha linhaPreta'><td class='linhaEmBrancoPrint' colspan='9'></td></tr>";
   
                                 }
   
                                 else {
   
                                    echo "<tr class='linhaPreta'><td class='linhaEmBrancoPrint' colspan='9'></td></tr>";
   
                                 }
   
                              }

                           }

                           $contadorLinhas++;

                           $uQuantVen = 0;
                           $uValorVen = 0;
                           $linhaVenda['uCustoVen'] = 0;
                           $uComisVen = 0;
                        
                        }
                     }
                  }

                  if ($_SESSION['tema'] == 'branco') {

                     if (($contadorLinhas % 45) == 0) {

                        echo "<tr class='text-center totalGeral quebrarLinha linhaBrancaTotal'>";

                     }

                     else {

                        echo "<tr class='text-center totalGeral linhaBrancaTotal'>";

                     }

                  }

                  else {

                     if (($contadorLinhas % 45) == 0) {

                        echo "<tr class='text-center totalGeral quebrarLinha linhaPretaTotal'>";

                     }

                     else {

                        echo "<tr class='text-center totalGeral linhaPretaTotal'>";

                     }

                  }

                  $contadorLinhas++;

                  echo "<td class='no-borderPrint' colspan='2'></td>";

                  echo "<td class='totalGeralPrint'>TOTAL GERAL: </td>";

                  echo "<td class='quantidadeGeralPrint'>".ValidaValor($uQuantGer)."</td>";
                  echo "<td class='valorGeralPrint'>R$".ValidaValor($uValorGer)."</td>";

                  if ($uValorGer == 0 || $uCustoGer == 0) {
                     echo "<td class='mgGeralPrint'>".ValidaValor(0)."</td>";
                  }

                  else {
                     if ($sVerLucro == "S") {
                        // If ChkMostrarMargem.Value = 1 Then
                           echo "<td class='mgGeralPrint'>".ValidaValor(($uValorGer - $uCustoGer) / $uValorGer * 100)."%</td>";
                        // Else
                        //   MsVendas.TextMatrix(lRow, 5) = Format(0, "###,###,##0.00")
                        // End If
                     }
                  }

                  echo "<td class='comissReaisGeralPrint'>R$".ValidaValor($uComisGer)."</td>";

                  if ($uValorGer > 0 && $uComisGer > 0 ) {
                     echo "<td class='comissPorcGeralPrint'>".ValidaValor(Round(($uComisGer / $uValorGer) * 100, 2))."%</td>";
                  }

                  else {
                     echo "<td class='comissPorcGeralPrint'>".ValidaValor(0)."</td>";
                  }

                  echo "<td class='refGeralPrint'>R$".ValidaValor($uReferGer)."</td>";

                  echo "<td class='internoGeralPrint'></td>";

                  echo "</tr>";

               }

               else {
                  if ($sVerLucro == "S") {
                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='text-center linhaBranca'><td colspan='10'>Nenhuma venda foi encontrada!</td></tr>";

                     }

                     else {
                        echo "<tr class='text-center linhaPreta'><td colspan='10'>Nenhuma venda foi encontrada!</td></tr>";
                     }
                  }

                  else {
                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='text-center linhaBranca'><td colspan='9'>Nenhuma venda foi encontrada!</td></tr>";

                     }

                     else {
                        echo "<tr class='text-center linhaPreta'><td colspan='9'>Nenhuma venda foi encontrada!</td></tr>";
                     }
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
<script src="plugins/pages/vendasVendedor/main.js"></script>