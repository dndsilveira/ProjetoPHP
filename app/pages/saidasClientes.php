<?php

if (isset($_GET['id_cliente'])) {
   $_SESSION['buscaRelatorioSaidasPorCliente']['cliente'] = $_GET['id_cliente'];
   $_SESSION['buscaRelatorioSaidasPorCliente']['dataInicio'] = date('Y-m-d', strtotime('first day of January', strtotime(date('Y-m-d'))));
   $_SESSION['buscaRelatorioSaidasPorCliente']['dataFinal'] = date('Y-m-d');
}

if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['cliente'])) {
   ?>
 
   <script>
 
   $(document).ready(function() {
     tabCliente();
   });
 
   </script>
 
   <?php
}

if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['produto'])) {
   ?>

   <script>

   $(document).ready(function(){

      document.getElementById('filtroProduto').value = "<?php echo $_SESSION['buscaRelatorioSaidasPorCliente']['produto']; ?>";
      tabProduto();
   
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
        <h3 class="card-title">Saídas por clientes</h3>
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

                  if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['cliente'])) {
                     ?>
                     <input type="text" class="form-control" name="filtroCliente" value="<?php echo $_SESSION['buscaRelatorioSaidasPorCliente']['cliente']; ?>" id="filtroCliente" required>
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

            <div class="form-group col-2 my-filtros responsive7 responsive10">
               <label for="nomeCliente">Nome</label>
               <input type="text" class="form-control" name="nomeCliente" id="nomeCliente" disabled>
            </div>

            <div class="form-group col-2 my-filtros codigo responsive12">
               <label for="filtroProduto">Produto</label>
               <div class="input-group">
                  <?php

                  if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['produto'])) {
                     ?>
                     <input type="text" class="form-control" name="filtroProduto" value="<?php echo $_SESSION['buscaRelatorioSaidasPorCliente']['produto']; ?>" id="filtroProduto">
                     <?php
                  }

                  else {
                     ?>
                     <input type="text" class="form-control" name="filtroProduto" id="filtroProduto">
                     <?php
                  }

                  ?>
                  <div class="input-group-append">
                     <span class="input-group-text" data-toggle="modal" data-target="#buscarProdutoModal">
                     <i class="fas fa-search"></i>
                     </span>
                  </div>
               </div>
            </div>

            <div class="form-group col-2 my-filtros responsive7 responsive11">
               <label for="nomeProduto">Nome</label>
               <input type="text" class="form-control" name="nomeProduto" id="nomeProduto" disabled>
            </div>

            <div class="form-group col-2 my-filtros responsive7 responsive9">
               <label for="parteNomeProduto">Parte do nome</label>
               <input type="text" class="form-control" name="parteNomeProduto" id="parteNomeProduto">
            </div>

            <div class="form-group col-2 my-filtros responsive7 responsive8">
               <label for="enderecoObra">Endereço/obra</label>
               <select class="form-control" name="enderecoObra" id="enderecoObra" disabled>
                  <option value="0"></option>
               </select>
            </div>

            <div class="form-check my-filtros-2 responsive13">
               <?php

               if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['vendaDevolucao'])) {
                  if ($_SESSION['buscaRelatorioSaidasPorCliente']['vendaDevolucao'] == "S") {
                     ?>
                     <input type="checkbox" class="form-check-input" name="vendaDevolucao" value="1" id="vendaDevolucao" checked>
                     <?php
                  }

                  else {
                     ?>
                     <input type="checkbox" class="form-check-input" name="vendaDevolucao" value="1" id="vendaDevolucao">
                     <?php
                  }
               }

               else {
                  ?>
                  <input type="checkbox" class="form-check-input" name="vendaDevolucao" value="1" id="vendaDevolucao" checked>
                  <?php
               }

               ?>
               <label class="form-check-label" for="vendaDevolucao">Somente venda e devolução</label>
            </div>

            <div class="form-check my-filtros-2">
               <?php

               if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'])) {
                  if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S") {
                     ?>
                     <input type="checkbox" class="form-check-input" name="tabelaDescontos" value="1" id="tabelaDescontos" checked>
                     <?php
                  }

                  else {
                     ?>
                     <input type="checkbox" class="form-check-input" name="tabelaDescontos" value="1" id="tabelaDescontos">
                     <?php
                  }
               }

               else {
                  ?>
                  <input type="checkbox" class="form-check-input" name="tabelaDescontos" value="1" id="tabelaDescontos" checked>
                  <?php
               }

               ?>
               <label class="form-check-label" for="tabelaDescontos">Mostrar preço de tabela/descontos</label>
            </div>

            <div class="form-check my-filtros-2">
               <?php

               if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['mostrarEntregas'])) {
                  if ($_SESSION['buscaRelatorioSaidasPorCliente']['mostrarEntregas'] == "S") {
                     ?>
                     <input type="checkbox" class="form-check-input" name="mostrarEntregas" value="1" id="mostrarEntregas" checked>
                     <?php
                  }

                  else {
                     ?>
                     <input type="checkbox" class="form-check-input" name="mostrarEntregas" value="1" id="mostrarEntregas">
                     <?php
                  }
               }

               else {
                  ?>
                  <input type="checkbox" class="form-check-input" name="mostrarEntregas" value="1" id="mostrarEntregas">
                  <?php
               }

               ?>
               <label class="form-check-label" for="mostrarEntregas">Mostrar entregas</label>
            </div>

            <div class="form-group col-2 responsive1">
               <label class="lbl-group">Data início</label>
               <?php

               if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['dataInicio']) && !empty($_SESSION['buscaRelatorioSaidasPorCliente']['dataInicio'])) {
                  ?>
                  <input class="form-control form-control-sidebar responsive2" id="filtroDataInicio" name="filtroDataInicio" type="date" value="<?php echo $_SESSION['buscaRelatorioSaidasPorCliente']['dataInicio']; ?>">       
                  <?php
               }

               else {
                  ?>
                  <input class="form-control form-control-sidebar responsive2" id="filtroDataInicio" name="filtroDataInicio" type="date" value="<?php echo date('Y-m-d', strtotime('first day of January', strtotime(date('Y-m-d')))); ?>">
                  <?php
               }

               ?>
            </div>
            
            <div class="form-group col-2 responsive1 responsive3">
               <label class="lbl-group">Data final</label>
               <?php

               if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['dataFinal']) && !empty($_SESSION['buscaRelatorioSaidasPorCliente']['dataFinal'])) {
                  ?>
                  <input class="form-control form-control-sidebar responsive2" id="filtroDataFinal" name="filtroDataFinal" type="date" value="<?php echo $_SESSION['buscaRelatorioSaidasPorCliente']['dataFinal']; ?>">       
                  <?php
               }

               else {
                  ?>
                  <input class="form-control form-control-sidebar responsive2" id="filtroDataFinal" name="filtroDataFinal" type="date" value="<?php echo date('Y-m-d'); ?>">
                  <?php
               }

               ?>
            </div>

            <div class="form-group responsive4 botoes">
              <input type="submit" class="btn btn-info filtro" id="btn-filtrar" name="relatorioSaidasPorCliente" value="Consultar" />
            </div>

            <?php

            if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['dataInicio']) && !empty($_SESSION['buscaRelatorioSaidasPorCliente']['dataInicio']) &&
            isset($_SESSION['buscaRelatorioSaidasPorCliente']['dataFinal']) && !empty($_SESSION['buscaRelatorioSaidasPorCliente']['dataFinal'])) {

            ?>

            <!--<div class="form-group input responsive6 botoes">
               <button class="btn btn-info filtro" id="btn-imprimir" onClick="print();" name="relatorioSaidasPorCliente">Imprimir</button>
            </div>-->

            <div class="form-group input responsive5 botoes">
              <input type="submit" class="btn btn-info filtro" id="btn-excel" name="relatorioSaidasPorCliente" value="Gerar excel" />
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

            if (isset($_SESSION['buscaRelatorioSaidasPorCliente']) && $_SESSION['buscaRelatorioSaidasPorCliente'] != 0) {

               echo "
               <thead>";

               if ($_SESSION['tema'] == 'branco') {
                  echo "<tr class='text-center linhaBrancaTitulo'>";

                  echo "
                     <th>
                        Descrição
                     </th>
                     <th>
                        Quantidade
                     </th>
                     <th>
                        Unitário
                     </th>
                     <th>
                        Total
                     </th>";

                  if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {

                     echo "
                     <th>
                        Valor tabela
                     </th>
                     <th>
                        Desc. praticado
                     </th>";

                  }

                     echo "
                     <th>
                        Vendedor
                     </th>
                     <th>
                        Interno
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
                        Descrição
                     </th>
                     <th>
                        Quantidade
                     </th>
                     <th>
                        Unitário
                     </th>
                     <th>
                        Total
                     </th>";

                  if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {

                     echo "
                     <th>
                        Valor tabela
                     </th>
                     <th>
                        Desc. praticado
                     </th>";

                  }

                     echo "
                     <th>
                        Vendedor
                     </th>
                     <th>
                        Interno
                     </th>";

                     echo "
                  </tr>
                  </thead>
                  <tbody>";
               }

               $sVerLucro = $_SESSION['parametros']['verLucro'];

               if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['cliente'])) {

                  $sComplemento = "";

                  if ($_SESSION['buscaRelatorioSaidasPorCliente']['vendaDevolucao'] == "S") {
                     $sComplemento = " AND (Movimento.Venda = 'S' OR Movimento.Devolucao = 'S') ";
                  }

                  if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['enderecoObra']) && !empty($_SESSION['buscaRelatorioSaidasPorCliente']['enderecoObra'])) {

                     $sComplemento = $sComplemento." AND Movimento.EnderecoCliente = :endereco ";
                     $endereco = $_SESSION['buscaRelatorioSaidasPorCliente']['enderecoObra'];

                  }

                  else {

                     $endereco = null;

                  }

                  if ((!isset($_SESSION['buscaRelatorioSaidasPorCliente']['produto']) || empty($_SESSION['buscaRelatorioSaidasPorCliente']['produto']))
                  && (!isset($_SESSION['buscaRelatorioSaidasPorCliente']['parteNomeProduto']) || empty($_SESSION['buscaRelatorioSaidasPorCliente']['parteNomeProduto']))) {

                     $sql = $pdo->prepare("SELECT * FROM Movimento Use Index (Cliente) WHERE CodigoCliente = :codigo".$sComplemento."
                     AND DataEmissao >= :datainicio AND DataEmissao <= :datafinal ORDER BY DataEmissao, Id ASC");
                     $sql->bindValue(":codigo", $_SESSION['buscaRelatorioSaidasPorCliente']['cliente']);
                     $sql->bindValue(":datainicio", $_SESSION['buscaRelatorioSaidasPorCliente']['dataInicio']);
                     $sql->bindValue(":datafinal", $_SESSION['buscaRelatorioSaidasPorCliente']['dataFinal']);
                     $sql->execute();

                  }

                  else {

                     $sComplemento2 = "";

                     if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['produto'])) {

                        $sComplemento2 = " AND Movimento_ITens.CodigoProduto = :codigoproduto ";
                        $produto = $_SESSION['buscaRelatorioSaidasPorCliente']['produto'];

                     }

                     else {

                        $produto = null;

                     }

                     if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['parteNomeProduto'])) {

                        $sComplemento2 = $sComplemento2. " AND Movimento_Itens.Descricao LIKE CONCAT ('%', :nomeproduto , '%') ";
                        $nomeproduto = $_SESSION['buscaRelatorioSaidasPorCliente']['parteNomeProduto'];

                     }

                     else {

                        $nomeproduto = null;

                     }

                     $sql = $pdo->prepare("SELECT DISTINCT Movimento.Tipo, Movimento.Banco, Movimento.NumeroNFEletronica, Movimento.Observacoes, 
                     Movimento.Empresa, Movimento.Venda, Movimento.Devolucao, Movimento.Brinde,  Movimento.Tabela, Movimento.Vendedor2, Movimento.TotalNota,
                     Movimento.Id, Movimento.DataEmissao, Movimento.Vendedor, Movimento.NumeroNF, Movimento.NumeroControle, Movimento.NumeroCupom
                     FROM Movimento Use Index (Cliente)
                     INNER JOIN Movimento_ITens ON Movimento.Id=Movimento_ITens.IdMovimento
                     INNER JOIN Material ON Material.Codigo = Movimento_Itens.CodigoProduto 
                     WHERE Movimento.CodigoCliente = :codigo ".$sComplemento2.$sComplemento." AND Movimento.DataEmissao >= :datainicio
                     AND Movimento.DataEmissao <= :datafinal ORDER BY Movimento.DataEmissao, Movimento.Id ASC");
                     $sql->bindValue(":codigo", $_SESSION['buscaRelatorioSaidasPorCliente']['cliente']);
                     $sql->bindValue(":datainicio", $_SESSION['buscaRelatorioSaidasPorCliente']['dataInicio']);
                     $sql->bindValue(":datafinal", $_SESSION['buscaRelatorioSaidasPorCliente']['dataFinal']);
                     if ($produto != null) {
                        $sql->bindValue(":codigoproduto", $produto);
                     }
                     if ($nomeproduto != null) {
                        $sql->bindValue(":nomeproduto", $nomeproduto);
                     }
                     $sql->execute();

                  }

               }

               $result = $sql->fetchAll();
                
               if ($result != false) {

                  $sNumeroPed = " ";
                  $uVenda = 0;
                  $uDevolucao = 0;
                  $dTotalGeral = 0;

                  foreach ($result as $linha) {

                     $sTipoPedido = "";
                     $sServico = "N";
                     $sCargas = "";
                     $sNumeroPed = "";

                     $sTipoPedido = "";

                     if ($linha['Devolucao'] == "S") {
                        $sTipoPedido = "Devolucao";
                     }

                     if ($linha['Brinde'] == "S") {
                        $sTipoPedido = "Brinde";
                     }

                     $sKey = "N".str_pad($linha['Id'], 10, 0, STR_PAD_LEFT);

                     $sAnexo = "";

                     if ($linha['NumeroControle'] != 0) {

                        if (TrataInt($linha['NumeroCupom']) > 0) {

                           $sNumero = str_pad($linha['NumeroCupom'], 6, 0 , STR_PAD_LEFT)."*CP ".$sTipoPedido;

                        }

                        else {
                         
                           $sNumero = str_pad($linha['NumeroControle'], 6, 0 , STR_PAD_LEFT)."* ".$sTipoPedido;

                        }

                     }

                     else {

                        $sNumero = str_pad($linha['NumeroNF'], 6, 0 , STR_PAD_LEFT)." ".$sTipoPedido;

                     }

                     $sPrazo = " ";

                     $sql = $pdo->prepare("SELECT Descricao FROM CondicoesPagamentos Use Index (Codigo) WHERE Id = :id");
                     $sql->bindValue(":id", $linha['Tabela']);
                     $sql->execute();

                     $resultPrazo = $sql->fetch();

                     if ($resultPrazo != false) {

                        $sPrazo = $resultPrazo['Descricao'];

                     }

                     else {

                        $sPrazo = "(Indefinido)";

                     }

                     $lTipo = 0;

                     $lTipo = $linha['Tipo'];

                     if ($linha['Tipo'] != null) {
                        $sql = $pdo->prepare("SELECT Descricao FROM Tipo WHERE Id = :id");
                        $sql->bindValue(":id", $linha['Tipo']);
                        $sql->execute();

                        $resultTipo = $sql->fetch();

                        if ($resultTipo != false) {
                           $sPrazo = $sPrazo." ".$resultTipo['Descricao'];
                        }

                     }

                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='linhaBranca'>";
                     }

                     else {
                        echo "<tr class='linhaPreta'>";
                     }

                     echo "<td>".$sNumero." Data: ".date('d/m/Y', strtotime($linha['DataEmissao']))." Prazo: ".$sPrazo."</td>";

                     if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {

                     echo "<td></td>";

                     }

                     echo "<td></td>";
                     echo "<td></td>";
                     echo "<td></td>";
                     echo "<td></td>";

                     $dTotalGeral += $linha['TotalNota'];

                     if ($linha['Venda'] == 'S') {
                        $uVenda += $linha['TotalNota'];
                     }

                     else {
                        if ($linha['Devolucao'] == "S") {
                           $uDevolucao += $linha['TotalNota'];
                        }
                     }

                     $sql = $pdo->prepare("SELECT Nome FROM Vendedores Use Index(Codigo) WHERE Codigo = :codigo");
                     $sql->bindValue(":codigo", $linha['Vendedor']);
                     $sql->execute();

                     $resultVendedor = $sql->fetch();

                     echo "<td>".$linha['Vendedor']." ".$resultVendedor['Nome']."</td>";

                     if ($linha['Vendedor2'] == null || $linha['Vendedor2'] == 0) {

                        echo "<td></td>";

                     }

                     else {

                        $sql = $pdo->prepare("SELECT Nome FROM Vendedores Use Index(Codigo) WHERE Codigo = :codigo");
                        $sql->bindValue(":codigo", $linha['Vendedor2']);
                        $sql->execute();

                        $resultVendedorInterno = $sql->fetch();

                        echo "<td>".$linha['Vendedor2']." ".$resultVendedorInterno['Nome']."</td>";

                     }

                     echo "</tr>";

                     $sNFE = "";

                     if ($linha['NumeroNFEletronica'] != null) {
                        if ($linha['NumeroNFEletronica'] == "S") {
                           $sNFE = "S";
                        }

                        else {
                           $sNFE = "N";
                        }
                     }

                     $dDesco = 0;
                     $dAcres = 0;
                     $dFrete = 0;
                     $dIPI = 0;
                     $dSubs = 0;
                     $dTotalNota = 0;

                     $sql = $pdo->prepare("SELECT TotalNota, Frete, ImpostoIPI FROM Movimento Use Index (Id) WHERE Id = :id");
                     $sql->bindValue(":id", $linha['Id']);
                     $sql->execute();

                     $resultMovto = $sql->fetch();

                     if ($resultMovto != false) {

                        $sNumeroPed = "";

                        $dFrete = $resultMovto['Frete'];
                        $dTotalNota = $resultMovto['TotalNota'];
                        $dIPI = $resultMovto['ImpostoIPI'];
                        $dSubs = 0;

                        $uPorcento = 0;
                        
                        if (isset($linha['NumeroOrcamento'])) {
                           $numeroOrcamento = TrataNulo($linha['NumeroOrcamento'], 0);
                        }

                     }

                     $sql = $pdo->prepare("SELECT Movimento_Itens.*, Marca.Descricao AS DescMarca FROM Movimento_Itens Use Index (IdMovimento)
                     INNER JOIN Material ON Material.Codigo = Movimento_Itens.CodigoProduto
                     LEFT JOIN Marca ON Marca.Id = Material.Marca
                     WHERE IdMovimento = :idmovimento");
                     $sql->bindValue(":idmovimento", $linha['Id']);
                     $sql->execute();

                     $resultMovtoItens = $sql->fetchAll();

                     $dTotalProduto = 0;

                     foreach ($resultMovtoItens as $linhaItem) {

                        if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['produto'])) {

                           if ($linhaItem['CodigoProduto'] != $_SESSION['buscaRelatorioSaidasPorCliente']['produto']) {
                              continue;
                           }

                        }

                        if (isset($_SESSION['buscaRelatorioSaidasPorCliente']['parteNomeProduto']) && !empty($_SESSION['buscaRelatorioSaidasPorCliente']['parteNomeProduto'])) {

                           if (str_contains($linhaItem['Descricao'], strtoupper($_SESSION['buscaRelatorioSaidasPorCliente']['parteNomeProduto'])) == false) {
                              continue;
                           }

                        }
                        
                        $sDestaca = "";
                        $sMaterial2 = "";

                        if ($_SESSION['tema'] == 'branco') {
                           echo "<tr class='linhaBranca'>";
                        }

                        else {
                           echo "<tr class='linhaPreta'>";
                        }

                        echo '<td>'.$linhaItem['CodigoProduto'].' - '.$linhaItem['Descricao'].'</td>';

                        echo "<td>".ValidaValor($linhaItem['Quantidade'])."</td>";

                        if ($linhaItem['PrecoTabela'] > $linhaItem['Unitario']) {
                           $dDesco = $dDesco + ($linhaItem['Quantidade'] * ($linhaItem['PrecoTabela'] - $linhaItem['Unitario']));
                        }

                        else {
                           $dAcres = $dAcres + ($linhaItem['Quantidade'] * ($linhaItem['Unitario'] - $linhaItem['PrecoTabela']));
                        }

                        $uValorPro = $linhaItem['Unitario'];

                        $dTotal = $linhaItem['Quantidade'] * $uValorPro;

                        $dTotalProduto += ($linhaItem['Quantidade'] * $uValorPro);
                        
                        echo "<td>R$".ValidaValor($uValorPro)."</td>";
                        echo "<td>R$".ValidaValor($dTotal)."</td>";

                        if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {

                           echo "<td>R$".ValidaValor($linhaItem['PrecoTabela'])."</td>";

                           $uTab = 0;
                           $uTab = $linhaItem['PrecoTabela'];
                           $uVendaItem = 0;
                           $uVendaItem = $linhaItem['Unitario'];
                           $uDesc = 0;

                           if ($uTab > 0 && $uVenda > 0) {
                              $uDesc = 100 - Round((($uVendaItem / $uTab) * 100), 3);
                              echo "<td>".ValidaValor($linhaItem['PrecoTabela'] - $linhaItem['Unitario'])." (".ValidaValor($uDesc)."%)</td>";
                           }

                           else {
                              echo "<td>".ValidaValor($linhaItem['PrecoTabela'] - $linhaItem['Unitario'])." (0.00%)</td>";
                           }

                        }

                        $sql = $pdo->prepare("SELECT Descricao FROM LoteEstoque WHERE Codigo = :codigo");
                        $sql->bindValue(":codigo", $linhaItem['Lote']);
                        $sql->execute();

                        $resultLote = $sql->fetch();

                        if ($resultLote != false) {
                           echo "<td>Lote: ".$linhaItem['Lote']." ".$resultLote['Descricao']."</td>";
                        }

                        else {
                           if ($linhaItem['Lote'] == 999999) {
                              echo "<td>Lote: 999999 PRINCIPAL</td>";
                           }

                           else {
                              echo "<td>Lote: não informado</td>";
                           }
                        }

                        $sql = $pdo->prepare("SELECT Descricao FROM LocalEstoque WHERE Codigo = :codigo");
                        $sql->bindValue(":codigo", $linhaItem['Local']);
                        $sql->execute();

                        $resultLocal = $sql->fetch();

                        if ($resultLocal != false) {
                           echo "<td>Local: ".$linhaItem['Local']." ".$resultLocal['Descricao']."</td>";
                        }

                        else {
                           if ($linhaItem['Local'] == 999999) {
                              echo "<td>Local: 999999 PRINCIPAL</td>";
                           }

                           else {
                              echo "<td>Local: não informado</td>";
                           }
                        }

                        echo "</tr>";

                        if ($_SESSION['buscaRelatorioSaidasPorCliente']['mostrarEntregas'] == "S")  {

                           $sql = $pdo->prepare("SELECT * FROM RegistroEntrega WHERE IdItem = :id ORDER BY Seq ");
                           $sql->bindValue(":id", $linhaItem['Id']);

                           $resultEntrega = $sql->fetchAll();

                           if ($resultEntrega != false) {

                              foreach ($resultEntrega as $linhaEntrega) {

                                 if ($_SESSION['tema'] == 'branco') {
                                    echo "<tr class='linhaBranca'>";
                                 }

                                 else {
                                    echo "<tr class='linhaPreta'>";
                                 }

                                 echo "<td>Entregue: ".Date('d/m/Y', strtotime($linhaEntrega['Data']))." Qtde: ".ValidaValor($linhaEntrega['Qtde'])."</td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
            
                                 echo "<td></td>";
            
                                 }
            
                                 echo "</tr>";

                              }
                           }
                        }
                     }

                     if ($linha['NumeroControle'] != 0) {

                        if (isset($linha['IdTransportadora'])) {

                           if (TrataNulo($linha['IdTransportadora'], 0) > 0) {
               
                              $sql = $pdo->prepare("SELECT Nome FROM Transportadora WHERE Id = :transportadora");
                              $sql->bindValue(":transportadora", $linha['IdTransportadora']);
                              $sql->execute();
   
                              $resultTransportadora = $sql->fetch();
   
                              if ($resultTransportadora != false) {
   
                                 if ($_SESSION['tema'] == 'branco') {
                                    echo "<tr class='linhaBranca'>";
                                 }
         
                                 else {
                                    echo "<tr class='linhaPreta'>";
                                 }
         
                                 echo "<td>Transportadora: ".$resultTransportadora['Nome']."</td>";
         
                                 echo "<td></td>";
         
                                 echo "<td></td>";
         
                                 echo "<td></td>";
         
                                 echo "<td></td>";
         
                                 echo "<td></td>";
         
                                 echo "<td></td>";
         
                                 if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
         
                                 echo "<td></td>";
         
                                 }
         
                                 echo "</tr>";
   
                              }
                              
                           }

                        }

                        if (isset($linha['IdRedespacho'])) {

                           if (TrataNulo($linha['IdRedespacho'], 0) > 0) {

                              $sql = $pdo->prepare("SELECT Nome FROM Transportadora WHERE Id = :transportadora");
                              $sql->bindValue(":transportadora", $linha['IdRedespacho']);
                              $sql->execute();
   
                              $resultTransportadora = $sql->fetch();
   
                              if ($resultTransportadora != false) {
   
                                 if ($_SESSION['tema'] == 'branco') {
                                    echo "<tr class='linhaBranca'>";
                                 }
         
                                 else {
                                    echo "<tr class='linhaPreta'>";
                                 }
         
                                 echo "<td>Redespacho: ".$resultTransportadora['Nome']."</td>";
         
                                 echo "<td></td>";
         
                                 echo "<td></td>";
         
                                 echo "<td></td>";
         
                                 echo "<td></td>";
         
                                 echo "<td></td>";
         
                                 echo "<td></td>";
         
                                 if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
         
                                 echo "<td></td>";
         
                                 }
         
                                 echo "</tr>";
   
                              }
                              
                           }

                        }

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

                        if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {

                        echo "<td></td>";

                        }

                        echo "</tr>";

                     }

                     else {

                        $sql = $pdo->prepare("SELECT Obs1, Obs2, Obs3, Obs4, Obs5, Obs6 FROM NotasTransportadora WHERE NumeroNF = :numeronf
                        AND Empresa = :empresa AND NumeroNFEletronica = :nfe");
                        $sql->bindValue(":numeronf", $linha['NumeroNF']);
                        $sql->bindValue(":empresa", $linha['Empresa']);
                        $sql->bindValue(":nfe", $sNFE);
                        $sql->execute();

                        $resultObsTransportadora = $sql->fetch();

                        if ($resultObsTransportadora != false) {
                           if ($resultObsTransportadora['Obs1'] != null) {
                              if (Trim($resultObsTransportadora['Obs1']) != "") {
                                 if ($_SESSION['tema'] == 'branco') {
                                    echo "<tr class='linhaBranca'>";
                                 }
            
                                 else {
                                    echo "<tr class='linhaPreta'>";
                                 }
            
                                 echo "<td>Obs.: ".$resultObsTransportadora['Obs1']."</td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
            
                                 echo "<td></td>";
            
                                 }
            
                                 echo "</tr>";
                              }
                           }

                           if ($resultObsTransportadora['Obs2'] != null) {
                              if (Trim($resultObsTransportadora['Obs2']) != "") {
                                 if ($_SESSION['tema'] == 'branco') {
                                    echo "<tr class='linhaBranca'>";
                                 }
            
                                 else {
                                    echo "<tr class='linhaPreta'>";
                                 }
            
                                 echo "<td>Obs.: ".$resultObsTransportadora['Obs2']."</td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
            
                                 echo "<td></td>";
            
                                 }
            
                                 echo "</tr>";
                              }
                           }

                           if ($resultObsTransportadora['Obs3'] != null) {
                              if (Trim($resultObsTransportadora['Obs3']) != "") {
                                 if ($_SESSION['tema'] == 'branco') {
                                    echo "<tr class='linhaBranca'>";
                                 }
            
                                 else {
                                    echo "<tr class='linhaPreta'>";
                                 }
            
                                 echo "<td>Obs.: ".$resultObsTransportadora['Obs3']."</td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
            
                                 echo "<td></td>";
            
                                 }
            
                                 echo "</tr>";
                              }
                           }

                           if ($resultObsTransportadora['Obs4'] != null) {
                              if (Trim($resultObsTransportadora['Obs4']) != "") {
                                 if ($_SESSION['tema'] == 'branco') {
                                    echo "<tr class='linhaBranca'>";
                                 }
            
                                 else {
                                    echo "<tr class='linhaPreta'>";
                                 }
            
                                 echo "<td>Obs.: ".$resultObsTransportadora['Obs4']."</td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
            
                                 echo "<td></td>";
            
                                 }
            
                                 echo "</tr>";
                              }
                           }

                           if ($resultObsTransportadora['Obs5'] != null) {
                              if (Trim($resultObsTransportadora['Obs5']) != "") {
                                 if ($_SESSION['tema'] == 'branco') {
                                    echo "<tr class='linhaBranca'>";
                                 }
            
                                 else {
                                    echo "<tr class='linhaPreta'>";
                                 }
            
                                 echo "<td>Obs.: ".$resultObsTransportadora['Obs5']."</td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
            
                                 echo "<td></td>";
            
                                 }
            
                                 echo "</tr>";
                              }
                           }

                           if ($resultObsTransportadora['Obs6'] != null) {
                              if (Trim($resultObsTransportadora['Obs6']) != "") {
                                 if ($_SESSION['tema'] == 'branco') {
                                    echo "<tr class='linhaBranca'>";
                                 }
            
                                 else {
                                    echo "<tr class='linhaPreta'>";
                                 }
            
                                 echo "<td>Obs.: ".$resultObsTransportadora['Obs6']."</td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 echo "<td></td>";
            
                                 if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
            
                                 echo "<td></td>";
            
                                 }
            
                                 echo "</tr>";
                              }
                           }
                        }
                     }

                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='linhaBranca'>";
                     }

                     else {
                        echo "<tr class='linhaPreta'>";
                     }

                     echo "<td>".$sNumeroPed."</td>";

                     echo "<td></td>";

                     echo "<td>Produtos: </td>";

                     echo "<td>R$".ValidaValor($dTotalProduto)."</td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {

                     echo "<td></td>";

                     }

                     echo "</tr>";

                     if ($dFrete > 0) {

                        if ($_SESSION['tema'] == 'branco') {
                           echo "<tr class='linhaBranca'>";
                        }
   
                        else {
                           echo "<tr class='linhaPreta'>";
                        }

                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td>Frete: </td>";
   
                        echo "<td>R$".ValidaValor($dFrete)."</td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";

                        if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
   
                        echo "<td></td>";

                        }

                        echo "</tr>";

                     }

                     if ($dIPI > 0) {

                        if ($_SESSION['tema'] == 'branco') {
                           echo "<tr class='linhaBranca'>";
                        }
   
                        else {
                           echo "<tr class='linhaPreta'>";
                        }

                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td>IPI: </td>";
   
                        echo "<td>R$".ValidaValor($dIPI)."</td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";

                        if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
   
                        echo "<td></td>";

                        }

                        echo "</tr>";

                     }

                     if ($dSubs > 0) {

                        if ($_SESSION['tema'] == 'branco') {
                           echo "<tr class='linhaBranca'>";
                        }
   
                        else {
                           echo "<tr class='linhaPreta'>";
                        }

                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td>Subst. trib.: </td>";
   
                        echo "<td>R$".ValidaValor($dSubs)."</td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";

                        if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
   
                        echo "<td></td>";

                        }

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

                     echo "<td>Geral: </td>";

                     echo "<td>R$".ValidaValor($dTotalProduto + $dFrete)."</td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {

                     echo "<td></td>";

                     }

                     echo "</tr>";

                     if ($dDesco > 0) {

                        if ($_SESSION['tema'] == 'branco') {
                           echo "<tr class='linhaBrancaTitulo'>";
                        }
   
                        else {
                           echo "<tr class='linhaPretaTitulo'>";
                        }

                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td>Desconto: </td>";
   
                        echo "<td>R$".ValidaValor($dDesco)."</td>";
   
                        echo "<td>".ValidaValor(($dDesco / ($dTotalProduto + $dDesco) * 100))."%</td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";

                        if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
   
                        echo "<td></td>";

                        }
   
                        echo "</tr>";
                     
                     }

                     if (Trim($linha['Observacoes']) != "") {

                        if ($_SESSION['tema'] == 'branco') {
                           echo "<tr class='linhaBranca'>";
                        }
   
                        else {
                           echo "<tr class='linhaPreta'>";
                        }

                        echo "<td>Obs.: ".$linha['Observacoes']."</td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";
   
                        echo "<td></td>";

                        if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
   
                        echo "<td></td>";

                        }
   
                        echo "</tr>";

                     }

                     if (isset($linha['ObsOrcamento'])) {

                        if (Trim($linha['ObsOrcamento']) != "") {

                           if ($_SESSION['tema'] == 'branco') {
                              echo "<tr class='linhaBranca'>";
                           }
      
                           else {
                              echo "<tr class='linhaPreta'>";
                           }
   
                           echo "<td>Obs. interna: ".$linha['ObsOrcamento']."</td>";
      
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "<td></td>";
      
                           echo "<td></td>";
   
                           if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
      
                           echo "<td></td>";
   
                           }
      
                           echo "</tr>";
   
                        }

                     }

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

                     if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {

                     echo "<td></td>";

                     }

                     echo "</tr>";

                  }

                  if ($_SESSION['buscaRelatorioSaidasPorCliente']['vendaDevolucao'] == "S") {

                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='linhaBrancaTitulo'>";
                     }

                     else {
                        echo "<tr class='linhaPretaTitulo'>";
                     }

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td>VENDA: </td>";

                     echo "<td>R$".ValidaValor($uVenda)."</td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {

                     echo "<td></td>";

                     }

                     echo "</tr>";


                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='linhaBrancaTitulo'>";
                     }

                     else {
                        echo "<tr class='linhaPretaTitulo'>";
                     }

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td>DEVOLUÇÃO: </td>";

                     echo "<td>R$".ValidaValor($uDevolucao)."</td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     echo "<td></td>";

                     if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {

                     echo "<td></td>";

                     }

                     echo "</tr>";

                  }

                  if ($dTotalGeral > 0) {

                     if ((!isset($_SESSION['buscaRelatorioSaidasPorCliente']['filtroProduto']) || empty($_SESSION['buscaRelatorioSaidasPorCliente']['filtroProduto']))
                     && (!isset($_SESSION['buscaRelatorioSaidasPorCliente']['parteNomeProduto']) || empty($_SESSION['buscaRelatorioSaidasPorCliente']['parteNomeProduto'])))  {

                        if ($_SESSION['tema'] == 'branco') {
                           echo "<tr class='linhaBrancaTotal'>";
                        }
   
                        else {
                           echo "<tr class='linhaPretaTotal'>";
                        }

                        echo "<td></td>";

                        echo "<td></td>";

                        echo "<td>TOTAL: </td>";

                        echo "<td>R$".ValidaValor($dTotalGeral)."</td>";

                        echo "<td></td>";

                        echo "<td></td>";

                        echo "<td></td>";

                        if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {

                        echo "<td></td>";

                        }

                        echo "</tr>";

                     }
                  
                  }

                  echo "</tbody>
                  </table";

               }

               else {
                  if ($_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] == "S")  {
                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='linhaBranca'><td colspan='8'>Nenhuma venda foi encontrada!</td></tr>";
                     }
   
                     else {
                        echo "<tr><td colspan='8'>Nenhuma venda foi encontrada!</td></tr>";
                     }
                  }

                  else {
                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='linhaBranca'><td colspan='6'>Nenhuma venda foi encontrada!</td></tr>";
                     }
   
                     else {
                        echo "<tr><td colspan='6'>Nenhuma venda foi encontrada!</td></tr>";
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
<script src="plugins/pages/saidasCliente/main.js"></script>