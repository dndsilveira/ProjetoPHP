<?php

if (isset($_SESSION['buscaRelatorioSaidasPorProdutos']['produto'])) {
   ?>

   <script>

   $(document).ready(function(){

      document.getElementById('filtroProduto').value = "<?php echo $_SESSION['buscaRelatorioSaidasPorProdutos']['produto']; ?>";
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
        <h3 class="card-title">Saídas por produtos</h3>
        <div id="lancamentos"></div>
        <form class="barraPesquisa border-top" method="POST">
          <?php if ($_SESSION['tema'] == 'branco') { ?>
          <div class="input-group barraPesquisa bordaBranca">
          <?php } else { ?>
          <div class="input-group sidebar-dark-primary barraPesquisa bordaPreta">
          <?php } ?>

            <div class="form-group col-2 codigo">
               <label for="filtroProduto">Produto</label>
               <div class="input-group">
                  <?php

                  if (isset($_SESSION['buscaRelatorioSaidasPorProdutos']['produto'])) {
                     ?>
                     <input type="text" class="form-control" name="filtroProduto" value="<?php echo $_SESSION['buscaRelatorioSaidasPorProdutos']['produto']; ?>" id="filtroProduto">
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

            <div class="form-group col-2 nomeProduto">
               <label for="nomeProduto">Nome</label>
               <input type="text" class="form-control" name="nomeProduto" id="nomeProduto" disabled>
            </div>

            <div class="form-group col-2 dataInicio">
               <label class="lbl-group">Data início</label>
               <?php

               if (isset($_SESSION['buscaRelatorioSaidasPorProdutos']['dataInicio']) && !empty($_SESSION['buscaRelatorioSaidasPorProdutos']['dataInicio'])) {
                  ?>
                  <input class="form-control form-control-sidebar" id="filtroDataInicio" name="filtroDataInicio" type="date" value="<?php echo $_SESSION['buscaRelatorioSaidasPorProdutos']['dataInicio']; ?>">       
                  <?php
               }

               else {
                  ?>
                  <input class="form-control form-control-sidebar" id="filtroDataInicio" name="filtroDataInicio" type="date" value="<?php echo date('Y-m-d', strtotime('first day of January', strtotime(date('Y-m-d')))); ?>">
                  <?php
               }

               ?>
            </div>
            
            <div class="form-group col-2 dataFinal">
               <label class="lbl-group">Data final</label>
               <?php

               if (isset($_SESSION['buscaRelatorioSaidasPorProdutos']['dataFinal']) && !empty($_SESSION['buscaRelatorioSaidasPorProdutos']['dataFinal'])) {
                  ?>
                  <input class="form-control form-control-sidebar" id="filtroDataFinal" name="filtroDataFinal" type="date" value="<?php echo $_SESSION['buscaRelatorioSaidasPorProdutos']['dataFinal']; ?>">       
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
              <input type="submit" class="btn btn-info filtro" id="btn-filtrar" name="relatorioSaidasPorProdutos" value="Consultar" />
            </div>

            <?php

            if (isset($_SESSION['buscaRelatorioSaidasPorProdutos']['dataInicio']) && !empty($_SESSION['buscaRelatorioSaidasPorProdutos']['dataInicio']) &&
            isset($_SESSION['buscaRelatorioSaidasPorProdutos']['dataFinal']) && !empty($_SESSION['buscaRelatorioSaidasPorProdutos']['dataFinal'])) {

            ?>

            <!--<div class="form-group input botoes">
               <button class="btn btn-info filtro" id="btn-imprimir" onClick="print();" name="relatorioSaidasPorProdutos">Imprimir</button>
            </div>-->

            <div class="form-group input botoes">
              <input type="submit" class="btn btn-info filtro" id="btn-excel" name="relatorioSaidasPorProdutos" value="Gerar excel" />
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

            if (isset($_SESSION['buscaRelatorioSaidasPorProdutos']) && $_SESSION['buscaRelatorioSaidasPorProdutos'] != 0) {

               echo "
               <thead>";

               if ($_SESSION['tema'] == 'branco') {
                  echo "<tr class='text-center linhaBrancaTitulo'>";

                  echo "
                     <th>
                        Documento
                     </th>
                     <th>
                        Cliente
                     </th>
                     <th>
                        Qtde
                     </th>
                     <th>
                        Unitário
                     </th>
                     <th>
                        Total
                     </th>";

                  if ($_SESSION['parametros']['verLucro'] == 'S')  {

                     echo "
                     <th>
                        Custo
                     </th>
                     <th>
                        Lucro R$
                     </th>
                     <th>
                        Lucro %
                     </th>";

                  }

                     echo "
                     <th>
                        Valor tabela
                     </th>
                     <th>
                        Desconto praticado
                     </th>
                     <th>
                        Prazo
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
                        Documento
                     </th>
                     <th>
                        Cliente
                     </th>
                     <th>
                        Qtde
                     </th>
                     <th>
                        Unitário
                     </th>
                     <th>
                        Total
                     </th>";

                  if ($_SESSION['parametros']['verLucro'] == 'S')  {

                     echo "
                     <th>
                        Custo
                     </th>
                     <th>
                        Lucro R$
                     </th>
                     <th>
                        Lucro %
                     </th>";

                  }

                     echo "
                     <th>
                        Valor tabela
                     </th>
                     <th>
                        Desconto praticado
                     </th>
                     <th>
                        Prazo
                     </th>
                     <th>
                        Vendedor
                     </th>";

                     echo "
                  </tr>
                  </thead>
                  <tbody>";

               }

               if (isset($_SESSION['buscaRelatorioSaidasPorProdutos']['produto'])) {

                  $sql = $pdo->prepare("SELECT Movimento_ITens.IdMovimento, Movimento_ITens.DataCancelamento, Movimento_ITens.Devolucao,
                  Movimento_ITens.Tabela, Movimento_ITens.CodigoProduto, Movimento_ITens.DataMovimento, Movimento_ITens.Quantidade,
                  Movimento_ITens.Custo, Movimento_ITens.Unitario, Movimento_ITens.Total, Movimento_ITens.IdMovimento, Movimento_ITens.Venda,
                  Movimento_ITens.EntradaSaida, Movimento_ITens.NumeroControle, Movimento_ITens.NumeroNF, Movimento_Itens.PrecoTabela, 
                  Material.GrupoId, Material.Codigo, Material.Nome, Grupo.Id, Grupo.Descricao FROM Movimento_ITens Use Index(CodigoProduto)
                  INNER JOIN Material ON Movimento_ITens.CodigoProduto = Material.Codigo
                  LEFT JOIN Grupo On Material.GrupoId = Grupo.Id
                  WHERE Movimento_ITens.CodigoProduto = :codigo AND Movimento_ITens.DataMovimento >= :datainicio 
                  AND Movimento_ITens.DataMovimento <= :datafinal 
                  ORDER BY Movimento_ITens.DataMovimento, Movimento_Itens.Id DESC");
                  $sql->bindValue(":codigo", $_SESSION['buscaRelatorioSaidasPorProdutos']['produto']);
                  $sql->bindValue(":datainicio", date('Y/m/d', strtotime($_SESSION['buscaRelatorioSaidasPorProdutos']['dataInicio'])));
                  $sql->bindValue(":datafinal",  date('Y/m/d', strtotime($_SESSION['buscaRelatorioSaidasPorProdutos']['dataFinal'])));
                  $sql->execute();

               }

               $result = $sql->fetchAll();
                
               if ($result != false) {
                  
                  $uQuantGer = 0;
                  $uValorGer = 0;
                  $uCustoGer = 0;

                  foreach ($result as $linha) {

                     $uQuantPro = 0;
                     $uValorPro = 0;
                     $uCustoPro = 0;

                     $sEntra = "N";
                     $sTipo = "V";

                     if ($linha['Venda'] == "S" && $linha['EntradaSaida'] == 'S') {
                        $sEntra = "S";
                        $sTipo = "V";
                     }

                     if ($linha['EntradaSaida'] == "E" && $linha['Devolucao'] == 'S') {
                        $sEntra = "S";
                        $sTipo = "D";
                     }

                     if ($sEntra == "S") {

                        $uDesconto = 0;
                        $sCliente = "Não encontrado";
                        $sPrazo = "Não encontrado";
                        $sVendedor = "Não encontrado";

                        $sql = $pdo->prepare("SELECT NomeCliente, Vendedor, NumeroNF, Tabela, NumeroControle, NumeroCupom, DataMovimento FROM Movimento
                        Use Index(Id) WHERE Id = :idmovimento");
                        $sql->bindValue(":idmovimento", $linha['IdMovimento']);
                        $sql->execute();

                        $resultMovto = $sql->fetch();

                        if ($resultMovto != false) {

                           $sCliente = $resultMovto['NomeCliente'];

                           $sql = $pdo->prepare("SELECT Nome FROM Vendedores WHERE Codigo = :codigo");
                           $sql->bindValue(":codigo", $resultMovto['Vendedor']);
                           $sql->execute();

                           $resultVendedor = $sql->fetch();

                           if ($resultVendedor != false) {
                              $sVendedor = $resultVendedor['Nome'];
                           }

                           $sql = $pdo->prepare("SELECT Descricao FROM CondicoesPagamentos WHERE Id = :id");
                           $sql->bindValue(":id", $resultMovto['Tabela']);
                           $sql->execute();

                           $resultCondicao = $sql->fetch();

                           if ($resultCondicao != false) {
                              $sPrazo = $resultCondicao['Descricao'];
                           }

                           if ($linha['NumeroControle'] > 0) {

                              if ($resultMovto['NumeroCupom'] == null || empty($resultMovto['NumeroCupom'])) {

                                 $sNroNf = str_pad($linha['NumeroControle'], 6, 0, STR_PAD_LEFT)." * - ".date('d/m/Y', strtotime($linha['DataMovimento']));

                              }

                              else {

                                 if (Trim($resultMovto['NumeroCupom']) == "") {

                                    $sNroNf = str_pad($linha['NumeroControle'], 6, 0, STR_PAD_LEFT)." * - ".date('d/m/Y', strtotime($linha['DataMovimento']));

                                 }

                                 else {

                                    $sNroNf = str_pad($resultMovto['NumeroCupom'], 6, 0, STR_PAD_LEFT)." CP - ".date('d/m/Y', strtotime($linha['DataMovimento']));

                                 }

                              }

                           }

                           else {

                              $sNroNf = str_pad($resultMovto['NumeroCupom'], 6, 0, STR_PAD_LEFT)." NF - ".date('d/m/Y', strtotime($linha['DataMovimento']));

                           }

                        }

                        if ($sTipo == "D") {

                           $uQuantPro = $linha['Quantidade'] * (-1);
                           $uCustoPro = ($linha['Quantidade'] * $linha['Custo']) * (-1);
                     
                           $uQuantGer -= $linha['Quantidade'];
                           $uCustoGer -= $linha['Quantidade'] * $linha['Custo'];

                           $uValorPro = $linha['Total'] * (-1);
                           $uValorGer -= $linha['Total'];

                        }

                        else {

                           $uQuantPro = $linha['Quantidade'];
                           $uCustoPro = $linha['Quantidade'] * $linha['Custo'];
                     
                           $uQuantGer += $linha['Quantidade'];
                           $uCustoGer += $linha['Quantidade'] * $linha['Custo'];
                     
                           $uValorPro = $linha['Total'];
                           $uValorGer += $linha['Total'];

                        }

                        if ($_SESSION['tema'] == 'branco') {
                           echo "<tr class='linhaBranca'>";
                        }

                        else {
                           echo "<tr class='linhaPreta'>";
                        }
                        
                        echo "<td>".$sNroNf."</td>";

                        echo "<td>".$sCliente."</td>";

                        echo "<td>".ValidaValor($uQuantPro)."</td>";

                        if ($uValorPro != 0 && $uQuantPro != 0) {

                           echo "<td>R$".ValidaValor($uValorPro/$uQuantPro)."</td>";

                        }

                        else {

                           echo "<td>R$".ValidaValor(0)."</td>";

                        }

                        echo "<td>R$".ValidaValor($uValorPro)."</td>";

                        if ($_SESSION['parametros']['verLucro'] == 'S')  {

                           echo "<td>R$".ValidaValor($uCustoPro)."</td>";
                           
                           echo "<td>R$".ValidaValor($uValorPro - $uCustoPro)."</td>";

                           echo "<td>".ValidaValor((($uValorPro - $uCustoPro) / $uValorPro) * 100)."%</td>";

                        }

                        echo "<td>R$".ValidaValor($linha['PrecoTabela'])."</td>";

                        if ($linha['PrecoTabela'] > 0 && $linha['Unitario'] > 0) {

                           echo "<td>R$".ValidaValor($linha['PrecoTabela'] - $linha['Unitario'])." (".ValidaValor(100 - (($linha['Unitario']/$linha['PrecoTabela']) * 100))."%)</td>";

                        }

                        else {

                           echo "<td>R$".ValidaValor($linha['PrecoTabela'] - $linha['Unitario'])."</td>";

                        }

                        echo "<td>".$sPrazo."</td>";

                        echo "<td>".$sVendedor."</td>";

                     }

                  }

                  if ($_SESSION['tema'] == 'branco') {
                     echo "<tr class='linhaBrancaTitulo'>";
                  }

                  else {
                     echo "<tr class='linhaPretaTitulo'>";
                  }

                  echo "<td></td>";

                  echo "<td>TOTAL: </td>";

                  echo "<td>".ValidaValor($uQuantGer)."</td>";

                  if ($uValorGer != 0 && $uQuantGer != 0) {

                     echo "<td>R$".ValidaValor($uValorGer/$uQuantGer)."</td>";

                  }

                  else {

                     echo "<td>R$".ValidaValor(0)."</td>";

                  }

                  echo "<td>R$".ValidaValor($uValorGer)."</td>";

                  echo "<td>R$".ValidaValor($uCustoGer)."</td>";

                  if ($_SESSION['parametros']['verLucro'] == 'S')  {
                     
                     echo "<td>R$".ValidaValor($uValorGer - $uCustoGer)."</td>";

                     if ($uValorGer != 0 && $uCustoGer != 0) {

                        echo "<td>".ValidaValor((($uValorGer - $uCustoGer) / $uValorGer) * 100)."%</td>";

                     }

                     else {

                        echo "<td>".ValidaValor(0)."%</td>";

                     }

                  }

                  echo "<td></td>";

                  echo "<td></td>";

                  echo "<td></td>";

                  echo "<td></td>";

                  echo "</tr>";                  

                  echo "</tbody>
                  </table";

               }

               else {
                  if ($_SESSION['parametros']['verLucro'] == 'S')  {
                     if ($_SESSION['tema'] == 'branco') {
                        echo "<tr class='linhaBranca'><td colspan='12'>Nenhuma venda foi encontrada!</td></tr>";
                     }
   
                     else {
                        echo "<tr><td colspan='12'>Nenhuma venda foi encontrada!</td></tr>";
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
<script src="plugins/pages/saidasProdutos/main.js"></script>