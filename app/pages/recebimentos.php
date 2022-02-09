<?php

if (isset($_SESSION['buscaRelatorioRecebimentos']['cliente'])) {
   ?>
 
   <script>
 
   $(document).ready(function() {

      document.getElementById('filtroCliente').value = "<?php echo $_SESSION['buscaRelatorioRecebimentos']['cliente']; ?>";
      tabCliente();

   });
 
   </script>
 
   <?php
}

if (isset($_SESSION['buscaRelatorioRecebimentos']['usuario'])) {
   ?>

   <script>

   $(document).ready(function(){

      document.getElementById('filtroUsuario').value = "<?php echo $_SESSION['buscaRelatorioRecebimentos']['usuario']; ?>";
      tabUsuario();
   
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
        <h3 class="card-title">Recebimentos</h3>
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

                  if (isset($_SESSION['buscaRelatorioRecebimentos']['cliente'])) {
                     ?>
                     <input type="text" class="form-control" name="filtroCliente" value="<?php echo $_SESSION['buscaRelatorioRecebimentos']['cliente']; ?>" id="filtroCliente" required>
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

            <div class="form-group col-2 my-filtros nomes">
               <label for="nomeCliente">Nome</label>
               <input type="text" class="form-control" name="nomeCliente" id="nomeCliente" disabled>
            </div>

            <div class="form-group col-2 my-filtros codigo codigoUsuario">
               <label for="filtroUsuario">Usuário</label>
               <div class="input-group">
                  <?php

                  if (isset($_SESSION['buscaRelatorioRecebimentos']['produto'])) {
                     ?>
                     <input type="text" class="form-control" name="filtroUsuario" value="<?php echo $_SESSION['buscaRelatorioRecebimentos']['usuario']; ?>" id="filtroUsuario">
                     <?php
                  }

                  else {
                     ?>
                     <input type="text" class="form-control" name="filtroUsuario" id="filtroUsuario">
                     <?php
                  }

                  ?>
                  <div class="input-group-append">
                     <span class="input-group-text" data-toggle="modal" data-target="#buscarUsuarioModal">
                     <i class="fas fa-search"></i>
                     </span>
                  </div>
               </div>
            </div>

            <div class="form-group col-2 my-filtros nomes nomeUsuario">
               <label for="nomeUsuario">Nome</label>
               <input type="text" class="form-control" name="nomeUsuario" id="nomeUsuario" disabled>
            </div>

            <div class="form-check my-filtros-2 analitico">
               <?php

               if (isset($_SESSION['buscaRelatorioRecebimentos']['analitico'])) {
                  if ($_SESSION['buscaRelatorioRecebimentos']['analitico'] == "S") {
                     ?>
                     <input type="checkbox" class="form-check-input" name="analitico" value="1" id="analitico" checked>
                     <?php
                  }

                  else {
                     ?>
                     <input type="checkbox" class="form-check-input" name="analitico" value="1" id="analitico">
                     <?php
                  }
               }

               else {
                  ?>
                  <input type="checkbox" class="form-check-input" name="analitico" value="1" id="analitico" checked>
                  <?php
               }

               ?>
               <label class="form-check-label" for="analitico">Analítico</label>
            </div>

            <div class="form-group my-filtros-3">
               <?php

               if (isset($_SESSION['buscaRelatorioRecebimentos']['tipo'])) {
                  if ($_SESSION['buscaRelatorioRecebimentos']['tipo'] == "E") {
                     ?>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo" id="porRecebimento" value="R">
                        <label class="form-check-label lbl-desc">Por recebimento</label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo" id="porVencimento" value="V">
                        <label class="form-check-label lbl-desc">Por vencimento</label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo" id="porEmissao" value="E" checked>
                        <label class="form-check-label lbl-desc">Por emissão</label>
                     </div>
                     <?php
                  }

                  else {
                     if ($_SESSION['buscaRelatorioRecebimentos']['tipo'] == "V") {
                     ?>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo" id="porRecebimento" value="R">
                        <label class="form-check-label lbl-desc">Por recebimento</label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo" id="porVencimento" value="V" checked>
                        <label class="form-check-label lbl-desc">Por vencimento</label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo" id="porEmissao" value="E">
                        <label class="form-check-label lbl-desc">Por emissão</label>
                     </div>
                     <?php
                     }

                     else {
                        ?>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="tipo" id="porRecebimento" value="R" checked>
                           <label class="form-check-label lbl-desc">Por recebimento</label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="tipo" id="porVencimento" value="V">
                           <label class="form-check-label lbl-desc">Por vencimento</label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="tipo" id="porEmissao" value="E">
                           <label class="form-check-label lbl-desc">Por emissão</label>
                        </div>
                        <?php
                     }
                  }
               }

               else {
                  ?>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="tipo" id="porRecebimento" value="R" checked>
                     <label class="form-check-label lbl-desc">Por recebimento</label>
                  </div>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="tipo" id="porVencimento" value="V">
                     <label class="form-check-label lbl-desc">Por vencimento</label>
                  </div>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="tipo" id="porEmissao" value="E">
                     <label class="form-check-label lbl-desc">Por emissão</label>
                  </div>
                  <?php
               }

               ?>
            </div>

            <div class="form-group col-2 my-filtros dataInicio">
               <label class="lbl-group">Data início</label>
               <?php

               if (isset($_SESSION['buscaRelatorioRecebimentos']['dataInicio']) && !empty($_SESSION['buscaRelatorioRecebimentos']['dataInicio'])) {
                  ?>
                  <input class="form-control form-control-sidebar" id="filtroDataInicio" name="filtroDataInicio" type="date" value="<?php echo $_SESSION['buscaRelatorioRecebimentos']['dataInicio']; ?>">       
                  <?php
               }

               else {
                  ?>
                  <input class="form-control form-control-sidebar" id="filtroDataInicio" name="filtroDataInicio" type="date" value="<?php echo date('Y-m-d', strtotime('first day of January', strtotime(date('Y-m-d')))); ?>">
                  <?php
               }

               ?>
            </div>
            
            <div class="form-group col-2 my-filtros dataFinal">
               <label class="lbl-group">Data final</label>
               <?php

               if (isset($_SESSION['buscaRelatorioRecebimentos']['dataFinal']) && !empty($_SESSION['buscaRelatorioRecebimentos']['dataFinal'])) {
                  ?>
                  <input class="form-control form-control-sidebar" id="filtroDataFinal" name="filtroDataFinal" type="date" value="<?php echo $_SESSION['buscaRelatorioRecebimentos']['dataFinal']; ?>">       
                  <?php
               }

               else {
                  ?>
                  <input class="form-control form-control-sidebar" id="filtroDataFinal" name="filtroDataFinal" type="date" value="<?php echo date('Y-m-d'); ?>">
                  <?php
               }

               ?>
            </div>

            <div class="form-group botoes">
              <input type="submit" class="btn btn-info filtro" id="btn-filtrar" name="relatorioSaidasPorCliente" value="Consultar" />
            </div>

            <?php

            if (isset($_SESSION['buscaRelatorioRecebimentos']['dataInicio']) && !empty($_SESSION['buscaRelatorioRecebimentos']['dataInicio']) &&
            isset($_SESSION['buscaRelatorioRecebimentos']['dataFinal']) && !empty($_SESSION['buscaRelatorioRecebimentos']['dataFinal'])) {

            ?>
            

            <div class="form-group input botoes">
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

            if (isset($_SESSION['buscaRelatorioRecebimentos']) && $_SESSION['buscaRelatorioRecebimentos'] != 0) {

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

                  if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {

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

                  if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {

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

               if (isset($_SESSION['buscaRelatorioRecebimentos'])) {

                  $sComplemento = "";

                  if (isset($_SESSION['buscaRelatorioRecebimentos']['cliente'])) {
                     $sComplemento = " AND Duplicatas.Cliente_Fornecedor = :cliente ";
                     $cliente = $_SESSION['buscaRelatorioRecebimentos']['cliente'];
                  }

                  else {
                     $cliente = false;
                  }

                  if (isset($_SESSION['buscaRelatorioRecebimentos']['usuario'])) {
                     $sComplemento = $sComplemento." AND Controle_Recebimentos.Usuario = :usuario ";
                     $usuario = $_SESSION['buscaRelatorioRecebimentos']['usuario'];
                  }

                  else {
                     $usuario = false;
                  }

                  if ($_SESSION['buscaRelatorioRecebimentos']['analitico'] == "S") {
                     
                     $sql = $pdo->prepare("SELECT Controle_Recebimentos.*, Duplicatas.Nro, Duplicatas.Empresa FROM Controle_Recebimentos
                     LEFT JOIN Duplicatas ON Duplicatas.Id = Controle_Recebimentos.IdTitulos WHERE Controle_Recebimentos.IdControle > 0
                     AND Controle_Recebimentos.Data >= :datainicio AND Controle_Recebimentos.Data <= :datafinal ".$sComplemento."
                     ORDER BY Controle_Recebimentos.IdControle, Controle_Recebimentos.Id");
                     $sql->bindValue(":datainicio", $_SESSION['buscaRelatorioRecebimentos']['dataInicio']);
                     $sql->bindValue(":datafinal", $_SESSION['buscaRelatorioRecebimentos']['dataFinal']);
                     if($cliente != false) {
                        $sql->bindValue(":cliente", $cliente);
                     }
                     if($usuario != false) {
                        $sql->bindValue(":usuario", $usuario);
                     }
                     $sql->execute();


                  }

                  else {

                     $sql = $pdo->prepare("SELECT Controle_Recebimentos.*, Duplicatas.Nro, Duplicatas.Empresa FROM Controle_Recebimentos
                     LEFT JOIN Duplicatas ON Duplicatas.Id = Controle_Recebimentos.IdTitulos WHERE Controle_Recebimentos.IdControle > 0
                     AND Controle_Recebimentos.Data >= :datainicio  AND Controle_Recebimentos.Data <= :datafinal ".$sComplemento."
                     ORDER BY Duplicatas.Nro, Controle_Recebimentos.IdControle, Controle_Recebimentos.Id");
                     $sql->bindValue(":datainicio", $_SESSION['buscaRelatorioRecebimentos']['dataInicio']);
                     $sql->bindValue(":datafinal", $_SESSION['buscaRelatorioRecebimentos']['dataFinal']);
                     if($cliente != false) {
                        $sql->bindValue(":cliente", $cliente);
                     }
                     if($usuario != false) {
                        $sql->bindValue(":usuario", $usuario);
                     }
                     $sql->execute();
                     
                  }

               }

               $result = $sql->fetchAll();
                
               if ($result != false) {

                  foreach ($result as $linha) {

                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='linhaBranca'>";
                     }

                     else {
                        echo "<tr class='linhaPreta'>";
                     }

                     echo "<td>".$sNumero." Data: ".date('d/m/Y', strtotime($linha['DataEmissao']))." Prazo: ".$sPrazo."</td>";

                     if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {

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

                        if (isset($_SESSION['buscaRelatorioRecebimentos']['produto'])) {

                           if ($linhaItem['CodigoProduto'] != $_SESSION['buscaRelatorioRecebimentos']['produto']) {
                              continue;
                           }

                        }

                        if (isset($_SESSION['buscaRelatorioRecebimentos']['parteNomeProduto']) && !empty($_SESSION['buscaRelatorioRecebimentos']['parteNomeProduto'])) {

                           if (str_contains($linhaItem['Descricao'], strtoupper($_SESSION['buscaRelatorioRecebimentos']['parteNomeProduto'])) == false) {
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

                        if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {

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

                        if ($_SESSION['buscaRelatorioRecebimentos']['mostrarEntregas'] == "S")  {

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
            
                                 if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
            
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
         
                                 if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
         
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
         
                                 if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
         
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

                        if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {

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
            
                                 if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
            
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
            
                                 if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
            
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
            
                                 if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
            
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
            
                                 if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
            
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
            
                                 if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
            
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
            
                                 if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
            
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

                     if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {

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

                        if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
   
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

                        if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
   
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

                        if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
   
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

                     if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {

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

                        if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
   
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

                        if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
   
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
   
                           if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
      
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

                     if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {

                     echo "<td></td>";

                     }

                     echo "</tr>";

                  }

                  if ($_SESSION['buscaRelatorioRecebimentos']['vendaDevolucao'] == "S") {

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

                     if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {

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

                     if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {

                     echo "<td></td>";

                     }

                     echo "</tr>";

                  }

                  if ($dTotalGeral > 0) {

                     if ((!isset($_SESSION['buscaRelatorioRecebimentos']['filtroProduto']) || empty($_SESSION['buscaRelatorioRecebimentos']['filtroProduto']))
                     && (!isset($_SESSION['buscaRelatorioRecebimentos']['parteNomeProduto']) || empty($_SESSION['buscaRelatorioRecebimentos']['parteNomeProduto'])))  {

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

                        if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {

                        echo "<td></td>";

                        }

                        echo "</tr>";

                     }
                  
                  }

                  echo "</tbody>
                  </table";

               }

               else {
                  if ($_SESSION['buscaRelatorioRecebimentos']['tabelaDescontos'] == "S")  {
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
<script src="plugins/pages/recebimentos/main.js"></script>