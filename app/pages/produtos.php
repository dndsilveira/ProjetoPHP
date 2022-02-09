<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
         <div class="col-sm-6">
            <h1 style="font-size: 25px;">Produtos</h1>
         </div>
         </div>
      </div>
   </section>

   <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Produtos cadastrados</h3>
          <form class="barraPesquisa" method="POST">
            <?php if ($_SESSION['tema'] == 'branco') { ?>
            <div class="input-group barraPesquisa bordaBranca">
            <?php } else { ?>
            <div class="input-group sidebar-dark-primary barraPesquisa bordaPreta">
            <?php } ?>
              <input class="form-control form-control-sidebar filtroNome" name="filtroNome" type="text" placeholder="Descrição">
              <div class="input-group-append">
                <div class="btn btn-sidebar">
                  <i class="fas fa-font fa-fw"></i>
                </div>
              </div>

              <input class="form-control form-control-sidebar filtroCodigo responsive2" name="filtroCodigo" type="text" placeholder="Código">
              <div class="input-group-append responsive5">
                <div class="btn btn-sidebar">
                  <i class="fas fa-at fa-fw"></i>
                </div>
              </div>

              <input class="form-control form-control-sidebar filtroCodigoBarras responsive2 responsive3" name="filtroCodigoBarras" type="text" placeholder="Código de barras">
              <div class="input-group-append responsive4">
                <div class="btn btn-sidebar">
                  <i class="fas fa-barcode fa-fw"></i>
                </div>
              </div>

              <input type="submit" class="btn btn-info filtros responsive1 responsive3" name="buscaProduto" value="Filtrar" />
            </div>
          </form>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-striped projects" id="example2">
              <?php

              if (isset($_SESSION['filtroNomeProduto']) OR isset($_SESSION['filtroCodigoProduto'])) {

                echo "
                <thead>
                  <tr class='text-center'>
                  <th>
                    #
                  </th>
                  <th style='min-width: 30%'>
                    Nome
                  </th>
                  <th>
                    Estoque
                  </th>
                  <th>
                    Unitário
                  </th>";

                  if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

                    echo "
                    <th style='width: 15%' class='text-center'>
                      Ações
                    </th>";

                  }

                echo"
                </tr>
                </thead>
                <tbody>
                ";

                if (isset($_SESSION['buscaProduto']) && $_SESSION['buscaProduto'] != 0) {

                  if (isset($_SESSION['filtroNomeProduto']) && !empty($_SESSION['filtroNomeProduto'])) {

                    $sql = $pdo->prepare("SELECT Codigo, Nome, Estoque, Reserva, VendaV, CustoV FROM material WHERE Ativo = 'S'
                    AND Nome LIKE CONCAT ('%', :nome , '%')");
                    $sql->bindValue(":nome", $_SESSION['filtroNomeProduto']);
                    $sql->execute();

                  }

                  elseif (isset($_SESSION['filtroCodigoProduto']) && !empty($_SESSION['filtroCodigoProduto'])) {

                    $sql = $pdo->prepare("SELECT Codigo, Nome, Estoque, Reserva, VendaV, CustoV FROM material WHERE Ativo = 'S'
                    AND Codigo = :codigo");
                    $sql->bindValue(":codigo", $_SESSION['filtroCodigoProduto']);
                    $sql->execute();

                  }
                  
                  elseif (isset($_SESSION['filtroCodigoBarrasProduto']) && !empty($_SESSION['filtroCodigoBarrasProduto'])) {

                    $sql = $pdo->prepare("SELECT Codigo, Nome, Estoque, Reserva, VendaV, CustoV FROM material WHERE Ativo = 'S'
                    AND CodigoBarra1 = :codigobarra");
                    $sql->bindValue(":codigobarra", $_SESSION['filtroCodigoBarrasProduto']);
                    $sql->execute();

                  }

                  else {

                    $sql = $pdo->prepare("SELECT Codigo, Nome, Estoque, Reserva, VendaV, CustoV FROM material WHERE Ativo = 'S'");
                    $sql->execute();
                    
                  }
            
                  $qtd = $sql->rowCount();  
                  $produtos = $sql->fetchAll();
                  
                  if ($produtos != false) {
                    foreach ($produtos as $linha) {
          
                      echo "<tr class='text-center' style='line-height: 35px;'>";
                        echo "<td scope='row'>".$linha['Codigo']."</td>";
                        echo "<td>".$linha['Nome']."</td>";
                        echo "<td>".($linha['Estoque']-$linha['Reserva'])."</td>";
                        echo "<td>R$".number_format(floatval($linha['VendaV']), 2, ",", ".")."</td>";

                        if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

                        if (!isset($_GET['id_produto_lotelocal'])) {
                          $_GET['id_produto_lotelocal'] = null;
                        }
                        
                        if ($_GET['id_produto_lotelocal'] == $linha['Codigo']) {
                          echo "
                          <td class='project-actions text-center' style='width: 10%;'>
                          <a class='btn btn-info btn-sm desktop' onclick='abrirModalLoteLocal()'><i class='fas fa-eye'></i> Visualizar estoque</a>
                      
                          <a class='btn btn-info btn-sm mobile' onclick='abrirModalLoteLocal()'><i class='fas fa-eye'></i></a>
                          </td>";
                        }

                        else {
                          echo "
                          <td class='project-actions text-center' style='width: 10%;'>
                          <a class='btn btn-info btn-sm desktop' href='produtos/lotelocal/".$linha['Codigo']."'><i class='fas fa-eye'></i> Visualizar estoque</a>
                      
                          <a class='btn btn-info btn-sm mobile' href='produtos/lotelocal/".$linha['Codigo']."'><i class='fas fa-eye'></i></a>
                          </td>";
                        }

                        }
                    
                      echo "</tr>";
                    }
                  }

                  else {
                    echo "<tr class='text-center'><td colspan='5'>Produto não encontrado!</td></tr>";
                  }
                }
              }

              elseif ((isset($_SESSION['filtroNomeProduto']) && !empty($_SESSION['filtroNomeProduto'])) || (isset($_SESSION['filtroCodigoProduto'])
              && !empty($_SESSION['filtroCodigoProduto'])) || (isset($_SESSION['filtroCodigoBarrasProduto']) && !empty($_SESSION['filtroCodigoBarrasProduto']))) {
                echo "<div class='text-center' style='padding-top: 5px;'>Produto não encontrado!</div>";
              }

              ?>
            </tbody>
          </table>
        </div>
      </div>
  </section>
  
<!-- Lote local modal -->
<div class="modal fade" id="lotelocalModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Visualizar estoque</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="card-body">
            <div class="row modal-responsive">
               <table class="table table-bordered table-hover">
               <?php

                  if (!empty($_GET['id_produto_lotelocal'])) {

                     $sql = $pdo->prepare("SELECT Codigo, Nome, Estoque, Reserva, Unidade FROM Material WHERE Codigo = :codigo AND Ativo = 'S'");
                     $sql->bindValue(":codigo", $_GET['id_produto_lotelocal']);
                     $sql->execute();

                     $linha = $sql->fetch();

                     echo "
                     <table class='table table-bordered table-hover'>
                     <thead>
                     <tr class='text-center'>
                        <th colspan='3'>".$linha['Codigo']." - ".$linha['Nome']." (".$linha['Unidade'].")</th>
                     </tr>
                     </thead>
                     <tbody>
                     ";

                     $sql = $pdo->prepare("SELECT LoteMaterial.*,
                     LoteEstoque.Descricao, LocalEstoque.Descricao AS DescSetor FROM LoteMaterial
                     LEFT JOIN LoteEstoque ON LoteEstoque.Codigo = LoteMaterial.CodigoLote
                     LEFT JOIN LocalEstoque ON LocalEstoque.Codigo = LoteMaterial.CodigoLocal
                     WHERE LoteMaterial.CodigoProduto = :codigo ORDER BY LoteMaterial.CodigoLote");
                     $sql->bindValue(":codigo", $_GET['id_produto_lotelocal']);
                     $sql->execute();

                     $resultEstoque = $sql->fetchAll();

                     $estoqueGeral = 0;

                     if ($resultEstoque != false) {

                           echo "
                           <tr class='text-center'>
                              <th>Lote</th>
                              <th>Local</th>
                              <th>Estoque</th>
                           </tr>
                           ";

                           foreach ($resultEstoque as $estoqueLote) {

                              $reservaLote = 0;

                              $sql = $pdo->prepare("SELECT Sum(Quantidade)
                              AS Reserva FROM OrcamentosItens INNER JOIN Orcamentos ON Orcamentos.Numero = OrcamentosItens.Numero
                              WHERE OrcamentosItens.CodigoProduto = :codigo AND OrcamentosItens.Local = :local
                              AND OrcamentosItens.Lote = :lote And Orcamentos.PedidoOrcamento = 'S'");
                              $sql->bindValue(":codigo", $_GET['id_produto_lotelocal']);
                              $sql->bindValue(":local", $estoqueLote['CodigoLocal']);
                              $sql->bindValue(":lote", $estoqueLote['CodigoLote']);
                              $sql->execute();

                              $resultLoteLocal = $sql->fetch();

                              if ($resultLoteLocal != false) {
                              $reservaLote = $resultLoteLocal['Reserva'];
                              }

                              else {
                              $reservaLote = TrataNulo($resultLoteLocal['Reserva'], 0);
                              }

                              echo "
                              <tr class='text-center'>";

                              if ($estoqueLote['CodigoLote'] == 999999) {
                              echo "<td>PRINCIPAL</td>";
                              }

                              else {
                              echo "<td>".$estoqueLote['Descricao']."</td>";
                              }

                              if ($estoqueLote['CodigoLocal'] == 999999) {
                              echo "<td>PRINCIPAL</td>";
                              }

                              else {
                              echo "<td>".$estoqueLote['DescSetor']."</td>";
                              }

                              echo "
                              <td>".(TrataNulo($estoqueLote['Estoque'], 0) - $reservaLote)."</td>
                              </tr>";

                              $estoqueGeral = $estoqueGeral + (TrataNulo($estoqueLote['Estoque'], 0) - $reservaLote);

                           }

                        echo "
                        <tr class='text-center'>
                           <td colspan='3'></td>
                        </tr>";

                     }

                     echo "
                     <tr class='text-center'>
                        <th colspan='3'>Estoque geral: ".TrataNulo($estoqueGeral, 0)."</th>
                     </tr>
                     ";

                  }

                  ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts de busca, add, edit... -->
<script src="plugins/pages/produtos/main.js"></script>