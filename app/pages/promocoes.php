<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Promoções</h1>
        </div>
      </div>
    </div>
  </div>

    <section class="content">
        <div class="card card-solid">
            <div class="card-header">
                <h5 class="card-title">Produtos em promoção</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped projects" id="example2">
                    <div id="lancamentos"></div>
                    <?php

                    $qtdPedido = 0;
                    $qtdVendido = 0;
                    $qtdDevolvido = 0;

                    $sql = $pdo->prepare("SELECT Codigo, Nome, deDataPromocao, AteDataPromocao, QuantidadePromocao, PrecoPromocao, Unidade, VendaV, Foto
                    FROM Material WHERE deDataPromocao <= :inicio AND AteDataPromocao >= :fim AND PrecoPromocao > 0 AND (AtivoPromocao = 'S' OR AtivoPromocao = ' '
                    OR AtivoPromocao IS NULL) ORDER BY Nome");
                    $sql->bindValue(":inicio", date('Y/m/d'));
                    $sql->bindValue(":fim", date('Y/m/d'));
                    $sql->execute();

                    $result = $sql->fetchAll();

                    if ($result != false) {

                        echo "
                        <thead>
                            <tr class='text-center'>
                                <th>
                                    Imagem
                                </th>
                                <th>
                                    Produto
                                </th>
                                <th>
                                    Preço na promoção
                                </th>
                                <th>
                                    Preço original
                                </th>
                                <th>
                                    Disponível
                                </th>
                                <th style='width: 15%' class='text-center'>
                                    Ações
                                </th>
                            </tr>
                        </thead>";

                        foreach ($result as $linha) {  

                        $sql = $pdo->prepare("SELECT Sum(Quantidade) As uVenda FROM OrcamentosItens INNER JOIN Orcamentos
                        ON OrcamentosItens.Numero = Orcamentos.Numero WHERE Orcamentos.PedidoOrcamento = 'S'  AND OrcamentosItens.CodigoProduto = :codigo");
                        $sql->bindValue(":codigo", $linha['Codigo']);
                        $sql->execute();

                        $result = $sql->fetch();
                        
                        if ($result != false) {
                            $qtdPedido = $qtdPedido + $result['uVenda'];
                        }

                        else {
                            $qtdPedido = 0;
                        }
                        
                        $sql = $pdo->prepare("SELECT Sum(Quantidade) as uVenda FROM Movimento_Itens WHERE Venda = 'S' AND EntradaSaida = 'S'
                        AND DataMovimento >= :inicio AND DataMovimento <= :fim AND CodigoProduto = :codigo");
                        $sql->bindValue(":inicio", $linha['deDataPromocao']);
                        $sql->bindValue(":fim", $linha['AteDataPromocao']);
                        $sql->bindValue(":codigo", $linha['Codigo']);
                        $sql->execute();

                        $result = $sql->fetch();
                        
                        if ($result != false) {
                            $qtdVendido = $qtdVendido + $result['uVenda'];
                        }

                        else {
                            $qtdVendido = 0;
                        }
                        
                        $sql = $pdo->prepare("SELECT Sum(Quantidade) as uVenda FROM Movimento_Itens  WHERE EntradaSaida = 'E' AND Devolucao = 'S'
                        AND DataMovimento >= :inicio  AND DataMovimento <= :fim  AND CodigoProduto = :codigo");
                        $sql->bindValue(":inicio", $linha['deDataPromocao']);
                        $sql->bindValue(":fim", $linha['AteDataPromocao']);
                        $sql->bindValue(":codigo", $linha['Codigo']);
                        $sql->execute();

                        $result = $sql->fetch();
                        
                        if ($result != false) {
                            $qtdDevolvido = $qtdDevolvido + $result['uVenda'];
                        }

                        else {
                            $qtdDevolvido = 0;
                        }

                        $qtdTotal = 0;
                        $qtdTotal = $linha['QuantidadePromocao'] - (($qtdPedido+$qtdVendido)-$qtdDevolvido);

                        $linha['Nome'] = str_replace('"', '', $linha['Nome']);
                        $linha['Nome'] = str_replace("'", '', $linha['Nome']);
                        $linha['Nome'] = addslashes($linha['Nome']);

                        $urlFoto = substr(str_replace("%", "/", $linha['Foto']), 34, 100);

                        ?>

                        <tr class="text-center">
                            <td>
                                <?php

                                if (isset($urlFoto) && !empty($urlFoto)) {
                                    ?>
                                        <img src="../../../dist/img/produtos/<?php echo $urlFoto; ?>" class="product-image" alt="Imagem do produto">
                                    <?php
                                }

                                else {
                                    ?>
                                        <img src="../../../dist/img/produtos/nao_excluir.png" class="product-image" alt="Imagem do produto">
                                    <?php
                                }

                                ?>
                            </td>
                            <td>
                                <?php echo $linha['Nome']; ?> - (<?php echo $linha['Unidade']; ?>)
                            </td>
                            <td>
                                R$<?php echo number_format(floatval($linha['PrecoPromocao']), 2, ",", "."); ?>
                            </td>
                            <td>
                                R$<?php echo number_format(floatval($linha['VendaV']), 2, ",", "."); ?>
                            </td>
                            <td>
                                <?php echo $qtdTotal; ?>
                            </td>
                            <td class='project-actions text-center' style='width: 10%;'>
                                <a class='btn btn-info btn-sm desktop'
                                onclick="escolherLoteLocal(<?php echo $linha['Codigo']; ?>, <?php echo floatval($linha['PrecoPromocao']); ?>)">
                                <i class='fas fa-cart-plus'></i> Adicionar ao carrinho</a>
                            
                                <a class='btn btn-info btn-sm mobile'
                                onclick="escolherLoteLocal(<?php echo $linha['Codigo']; ?>, <?php echo floatval($linha['PrecoPromocao']); ?>)">
                                <i class='fas fa-cart-plus'></i></a>
                            </td>
                        </tr>
                        <?php
                        
                        }
                    }

                    ?>
                </table>
            </div>
        </div>
    </section>

<!-- Scripts de busca, add, edit... -->
<script src="plugins/pages/promocoes/main.js"></script>
<script src="plugins/pages/promocoes/addGeral.js"></script>

<?php

if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') {

  ?>
  <script src="plugins/pages/promocoes/addLote.js"></script>
  <?php

}

else {

  ?>
  <script src="plugins/pages/promocoes/addSemLote.js"></script>
  <?php

}

?>