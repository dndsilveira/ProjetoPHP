<?php

// VERIFICA SE O USUÁRIO PODE ALTERAR O PRAZO DE PAGAMENTO
$sql = $pdo->prepare("SELECT IdUsuario FROM Direitos_Dados WHERE IdUsuario = :usuario AND OpcoesPermitidas = '150027'");
$sql->bindValue(":usuario", $info['Id']);
$sql->execute();

if ($sql->fetch() != false) {
   $alterarPrazoPagamento = "S";
}

else {
   $alterarPrazoPagamento = "N";
}

// VERIFICA SE O USUÁRIO PODE ALTERAR O TIPO DE PAGAMENTO
$sql = $pdo->prepare("SELECT IdUsuario FROM Direitos_Dados WHERE IdUsuario = :usuario AND OpcoesPermitidas = '150085'");
$sql->bindValue(":usuario", $info['Id']);
$sql->execute();

if ($sql->fetch() != false) {
   $alterarTipoPagamento = "S";
}

else {
   $alterarTipoPagamento = "N";
}

// VERIFICA SE O USUÁRIO PODE ALTERAR O BANCO DE PAGAMENTO
$sql = $pdo->prepare("SELECT IdUsuario FROM Direitos_Dados WHERE IdUsuario = :usuario AND OpcoesPermitidas = '150086'");
$sql->bindValue(":usuario", $info['Id']);
$sql->execute();

if ($sql->fetch() != false) {
   $alterarBancoPagamento = "S";
}

else {
   $alterarBancoPagamento = "N";
}

?>

<script>

$(document).ready(function(){
   $('#pills-tab a[href="#pills-home"]').on('shown.bs.tab', function () {
      document.getElementById('codigoCliente').focus();
   });

   $('#pills-tab a[href="#pills-profile"]').on('shown.bs.tab', function () {
      document.getElementById('codigoMaterial').focus();
   });
});

</script>

<?php

if (isset($_SESSION['carrinho'])) {
   ?>
 
   <script>
 
   $(document).ready(function() {
     var paginaOperacao = 'carregarCarrinhoDados';
 
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
         $("#lancamentos-tab1").html(msg);
       }
     });
   });
 
   </script>
 
   <?php
}

else {

   ?>

   <script>

   $(document).ready(function(){

      document.getElementById('bancoPagamento').value = "<?php if (isset($_SESSION['parametros']['bancoPagamentoPadrao']) && !empty($_SESSION['parametros']['bancoPagamentoPadrao'])) { echo $_SESSION['parametros']['bancoPagamentoPadrao']; } ?>";
      tabBancoPagamento();
      document.getElementById('prazoPagamento').value = "<?php if (isset($_SESSION['parametros']['prazoPagamentoPadrao']) && !empty($_SESSION['parametros']['prazoPagamentoPadrao'])) { echo $_SESSION['parametros']['prazoPagamentoPadrao']; } ?>";
      tabPrazoPagamento();
      document.getElementById('tipoPagamento').value = "<?php if (isset($_SESSION['parametros']['tipoPagamentoPadrao']) && !empty($_SESSION['parametros']['tipoPagamentoPadrao'])) { echo $_SESSION['parametros']['tipoPagamentoPadrao']; } ?>";
      tabTipoPagamento();
      document.getElementById('codigoCidadeCliente').value = "<?php echo $_SESSION['parametros']['codigoCidadeOrcamentos']; ?>";
      tabCidade();
   
   });

   </script>
   
   <?php
   
   if ($_SESSION['parametros']['respeitarVendedorCadastro'] == 'N') {
     ?>
   
   <script>
   $(document).ready(function(){
     document.getElementById('codigoVendedor').value = "<?php echo $_SESSION['parametros']['vendedorLogado']['Codigo']; ?>";
     document.getElementById('nomeVendedor').value = "<?php echo $_SESSION['parametros']['vendedorLogado']['Nome']; ?>";
     document.getElementById('codigoVendedor').focus();
     document.getElementById('codigoCliente').focus();
   });
   </script>
   
     <?php
   }

}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="font-size: 25px;">Pedidos</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="botoes novo-pedido"><button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#novoPedidoModal">Novo pedido</button></li>
            <li class="botoes"><button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#buscarPedidoModal">Buscar orçamentos</button></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" id="cabecalho">
            <?php

            if (isset($_SESSION['carrinho'])) {
              if (isset($_SESSION['carrinho']['dados']['numero'])) {
                if (TrataInt($_SESSION['carrinho']['dados']['numero']) != 0) {

                  $sql = $pdo->prepare("SELECT Numero FROM Orcamentos WHERE Numero = :numero");
                  $sql->bindValue(":numero", $_SESSION['carrinho']['dados']['numero']);
                  $sql->execute();

                  if ($sql->fetch() == false) {
                     unset($_SESSION['carrinho']);
                     echo "Novo pedido";
                  }

                  else {
                     echo "Alterando pedido n° ".$_SESSION['carrinho']['dados']['numero'];
                  }
                }

                else {
                  echo "Novo pedido";
                }
              }
  
              else {
                echo "Novo pedido";
              }
            }

            else {
              echo "Novo pedido";
            }

            ?>
          </h3>
        </div>
        <div class="row">
        <div class="card-body table-responsive">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Cliente</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Itens e prazos</a>
            </li>
            <!--<li class="nav-item">
              <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
            </li>-->
          </ul>
          <div id="lancamentos"></div>
          
            <!-- Aqui eu faço em duas divs pra quem usa lote/local e pra quem não usa -->
            <?php if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') { ?>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="col-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div id="lancamentos-tab1"></div>
                            <div class="form-group col-2 codigo">
                            <label for="codigoCliente">Cliente</label>
                            <div class="input-group mb-3">
                            <input type="text" name="codigoCliente" class="form-control" id="codigoCliente" required>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="modal" data-target="#buscarClienteModal">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            </div>
                            </div>
                            <div class="form-group col-4 responsive4">
                            <label for="nomeCliente">Nome do cliente</label>
                            <input type="text" name="nomeCliente" class="form-control" id="nomeCliente" required>
                            </div>
                            <div class="form-group col-6 responsive6"></div>
                            <div class="form-group col-3 responsive2 responsive47">
                            <label for="enderecoCliente">Endereço</label>
                            <input type="text" name="enderecoCliente" class="form-control" id="enderecoCliente">
                            </div>
                            <div class="form-group col-2 responsive2 responsive47">
                            <label for="bairroCliente">Bairro</label>
                            <input type="text" name="bairroCliente" class="form-control" id="bairroCliente">
                            </div>
                            <div class="form-group col-2 codigo responsive44">
                            <label for="codigoCidadeCliente">Cidade</label>
                            <div class="input-group mb-3">
                            <input type="text" name="codigoCidadeCliente" class="form-control" id="codigoCidadeCliente" required>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="modal" data-target="#buscarCidadeModal">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            </div>
                            </div>
                            <div class="form-group col-2 responsive3 responsive44">
                            <label for="nomeCidadeCliente">Nome da cidade</label>
                            <input type="text" name="nomeCidadeCliente" class="form-control" id="nomeCidadeCliente" disabled>
                            </div>
                            <div class="form-group col-2 estadoCliente responsive45">
                            <label for="estadoCliente">UF</label>
                            <input type="text" name="estadoCliente" class="form-control" id="estadoCliente" disabled>
                            </div>
                            <div class="form-group col-2 CEPCliente responsive45">
                            <label for="CEPCliente">CEP</label>
                            <input type="text" name="CEPCliente" class="form-control" id="CEPCliente">
                            </div>
                            <div class="form-group col-2 documentoCliente responsive46">
                            <label for="documentoCliente">CPF/CNPJ</label>
                            <input type="text" name="documentoCliente" class="form-control" id="documentoCliente">
                            </div>
                            <div class="form-group col-2 documentoCliente responsive46">
                            <label for="inscricaoCliente">Inscrição Estadual</label>
                            <input type="text" name="inscricaoCliente" class="form-control" id="inscricaoCliente">
                            </div>
                            <div class="form-group col-8 responsive1"></div>
                            <div class="form-group col-2 codigo responsive40 responsive42 responsive43">
                            <label for="codigoVendedor">Vendedor</label>
                            <div class="input-group mb-3">
                                <input type="text" name="codigoVendedor" class="form-control" id="codigoVendedor" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="modal" data-target="#buscarVendedorModal">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>
                            </div>
                            <div class="form-group col-3 responsive5 responsive42 responsive43">
                            <label for="nomeVendedor">Nome</label>
                            <input type="text" name="nomeVendedor" class="form-control" id="nomeVendedor" disabled>
                            </div>
                            <div class="form-group col-2 codigo5 responsive41 responsive42 responsive43">
                            <label for="comissaoVendedor">Comissão</label>
                            <input type="text" name="comissaoVendedor" class="form-control" id="comissaoVendedor" readonly>
                            </div>
                            <div class="form-group col-3 responsive39 responsive42"></div>
                            <div class="form-group col-2 codigo responsive40 responsive42 responsive48">
                            <label for="codigoVendedorInterno">Interno</label>
                            <div class="input-group mb-3">
                                <input type="text" name="codigoVendedorInterno" class="form-control" id="codigoVendedorInterno" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="modal" data-target="#buscarVendedorInternoModal">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>
                            </div>
                            <div class="form-group col-3 responsive5 responsive42 responsive48">
                            <label for="nomeVendedorInterno">Nome</label>
                            <input type="text" name="nomeVendedorInterno" class="form-control" id="nomeVendedorInterno" disabled>
                            </div>
                            <div class="form-group col-2 codigo5 responsive41 responsive42">
                            <label for="comissaoVendedorInterno">Comissão</label>
                            <input type="text" name="comissaoVendedorInterno" class="form-control" id="comissaoVendedorInterno" readonly>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="col-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <div class="col">
                            <div class="row">
                            <div class="form-group col-2 responsive22">
                                <label for="prazoPagamento">Prazo</label>
                                <div class="input-group">
                                    <?php

                                    if ($alterarPrazoPagamento == "S") {
                                        ?>
                                        <input type="text" name="prazoPagamento" class="form-control" id="prazoPagamento" required>
                                        <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="modal" data-target="#buscarPrazoPagamentoModal">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        </div>
                                        <?php
                                    }

                                    else {
                                        ?>
                                        <input type="text" name="prazoPagamento" class="form-control" id="prazoPagamento" disabled>
                                        <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        </div>
                                        <?php
                                    }

                                    ?>
                                </div>
                            </div>
                            <div class="form-group col-4 responsive23 responsive30">
                                <label for="nomePrazo">Descrição</label>
                                <input type="text" name="nomePrazo" class="form-control" id="nomePrazo" disabled>
                            </div>
                            <div class="form-group col-2 responsive22">
                                <label for="tipoPagamento">Tipo</label>
                                <div class="input-group">
                                    <?php

                                    if ($alterarTipoPagamento == "S") {
                                        ?>
                                        <input type="text" name="tipoPagamento" class="form-control" id="tipoPagamento" required>
                                        <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="modal" data-target="#buscarTipoPagamentoModal">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        </div>
                                        <?php
                                    }

                                    else {
                                        ?>
                                        <input type="text" name="tipoPagamento" class="form-control" id="tipoPagamento" disabled>
                                        <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        </div>
                                        <?php
                                    }

                                    ?>
                                </div>
                            </div>
                            <div class="form-group col-4 responsive23">
                                <label for="nomeTipo">Descrição</label>
                                <input type="text" name="nomeTipo" class="form-control" id="nomeTipo" disabled>
                            </div>
                            <div class="form-group col-2 responsive22">
                                <label for="bancoPagamento">Banco</label>
                                <div class="input-group mb-3">
                                    <?php

                                    if ($alterarBancoPagamento == "S") {
                                        ?>
                                        <input type="text" name="bancoPagamento" class="form-control" id="bancoPagamento" required>
                                        <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="modal" data-target="#buscarBancoModal">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        </div>
                                        <?php
                                    }

                                    else {
                                        ?>
                                        <input type="text" name="bancoPagamento" class="form-control" id="bancoPagamento" disabled>
                                        <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        </div>
                                        <?php
                                    }

                                    ?>
                                </div>
                            </div>
                            <div class="form-group col-4 responsive23 responsive32">
                                <label for="nomeBanco">Descrição</label>
                                <input type="text" name="nomeBanco" class="form-control" id="nomeBanco" disabled>
                            </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-row-reverse responsive24">
                            <div class="form-group col-2 responsive36 responsive33 responsive34">
                                <div class="input-group responsive31">
                                    <a class='btn btn-info btn-sm' onclick="voltarPrecoTabela()"><i class='fas fa-dollar-sign'></i> Voltar preço de tabela</a>
                                </div>
                            </div>
                            <div class="form-group col-2 responsive36 responsive35 responsive21 responsive26 responsive28">
                                <label for="prazoPagamento">Desconto</label>
                                <div class="input-group">
                                <input type="text" name="prazoPagamento" class="form-control" tabindex="3" id="descontoOrcamento">
                                    <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-percentage" id="iDesconto"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-2 responsive36 responsive35 responsive21 responsive26 responsive38">
                                <label for="prazoPagamento">Acréscimo</label>
                                <div class="input-group">
                                <input type="text" name="prazoPagamento" class="form-control" tabindex="2" id="acrescimoOrcamento" disabled>
                                    <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-percentage" id="iAcrescimo"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-2 responsive36 ml-12px responsive21 responsive29">
                                <label for="prazoPagamento">Frete</label>
                                <div class="input-group">
                                <input type="text" name="prazoPagamento" class="form-control" tabindex="1" id="freteOrcamento">
                                    <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-28px ml-12px responsive27 responsive37">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="descontoAcrescimo" id="acrescimo">
                                    <label class="form-check-label lbl-desc">Acréscimo</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="formatoDesconto" id="descontoReais">
                                    <label class="form-check-label lbl-desc">Valor</label>
                                </div>
                            </div>
                            <div class="form-group mt-28px responsive25 responsive27">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="descontoAcrescimo" id="desconto" checked>
                                    <label class="form-check-label lbl-desc">Desconto</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="formatoDesconto" id="descontoPorcentagem" checked>
                                    <label class="form-check-label lbl-desc">Porcentagem</label>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-12">
                        <hr style="border: 0; border-top: 1px solid rgba(0, 0, 0, 0.1);" />
                        </div>
                        <div class="row">
                        <div class="card-body">
                            <div class="row" id="enterForm">
                            <div id="lancamentos-tab2"></div>
                            <div class="form-group col-2 responsive9">
                                <label for="codigoMaterial">Código</label>
                                <div class="input-group mb-3">
                                <input type="text" name="codigoMaterial" class="form-control" id="codigoMaterial" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="modal" data-target="#buscarProdutoModal"><i class="fas fa-search"></i></span>
                                </div>
                                </div>
                            </div>
                            <div class="form-group col-4 responsive8">
                                <label for="nomeMaterial">Descrição</label>
                                <input type="text" name="nomeMaterial" class="form-control" id="nomeMaterial" disabled>
                            </div>
                            <div class="col-6 responsive12"></div>
                            <!--<div class="form-group col-1 codigo3">
                                <label for="estoqueMaterial">Estoque</label>
                                <input type="text" name="estoqueMaterial" class="form-control" id="estoqueMaterial" disabled>
                            </div>-->
                            <div class="form-group col-1 codigo3">
                                <label for="quantidadeMaterial">Qtde</label>
                                <input type="text" name="quantidadeMaterial" class="form-control" id="quantidadeMaterial" min="0" required>
                            </div>
                            <div class="form-group col-1 codigo3">
                                <label for="unitarioMaterial">Unitário</label>
                                <input type="text" name="unitarioMaterial" class="form-control" id="unitarioMaterial" required>
                            </div>
                            <div class="form-group col-1 codigo3">
                                <label for="totalMaterial">Total</label>
                                <input type="text" name="totalMaterial" class="form-control" id="totalMaterial" value="0" disabled>
                            </div>
                            <div class="col-8 responsive12 responsive13"></div>
                            <div class="form-group col-1 codigo5">
                                <label for="loteMaterial">Lote</label>
                                <div class="input-group mb-3">
                                <input type="text" name="loteMaterial" class="form-control" id="loteMaterial" disabled>
                                </div>
                            </div>
                            <div class="form-group col-2 responsive11">
                                <label for="nomeLote">Nome</label>
                                <input type="text" name="nomeLote" class="form-control" id="nomeLote" disabled>
                            </div>
                            <div class="form-group col-1 codigo5">
                                <label for="localMaterial">Local</label>
                                <div class="input-group mb-3">
                                <input type="text" name="localMaterial" class="form-control" id="localMaterial" disabled>
                                </div>
                            </div>
                            <div class="form-group col-2 responsive11">
                                <label for="nomeLocal">Nome</label>
                                <input type="text" name="nomeLocal" class="form-control" id="nomeLocal" disabled>
                            </div>
                            <div class="form-group col-2">
                                <button class="btn btn-info lancar" id="adicionarProduto" onclick="adicionarProduto(false)">Lançar</button>
                            </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                            <div class="modal-body">
                            <div class="card-body">
                                <div class="row modal-responsive">
                                <table class="table table-bordered table-hover" id="lancamentos-produtos">
                                <thead>
                                <tr class='text-center'>
                                    <th style="width: 8%">Código</th>
                                    <th style="min-width: 250px;">Nome</th>
                                    <th>Qtde</th>
                                    <th>Unitário</th>
                                    <th>Total</th>
                                    <th>Lote</th>
                                    <th>Local</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody id="table">

                                    <!-- Aqui é inserido as linhas que vem do script -->

                                </tbody>
                                </table>
                                </div>
                                <div class="py-3">
                                <div class="form-group col-1 codigo4">
                                    <label for="total">Total</label>
                                    <input type="text" name="total" class="form-control" id="total" disabled>
                                </div>
                                <div class="form-group col-1 codigo4 d-none" id="divDesconto">
                                    <label for="descAcresc" id="descontoLabel">Desconto</label>
                                    <input type="text" name="descAcresc" class="form-control" id="descAcresc" disabled>
                                </div>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                            <label for="observacoes">Observações</label>
                            <textarea class="form-control" name="observacoes" id="observacoes" rows="3"></textarea>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <!--<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>-->
                </div>
                <div class="float-right">
                    <?php if ($_SESSION['parametros']['usaExpedicao'] == 'S') { ?>
                    <button class="btn btn-success" id="btn-salvar" onclick="verificaCamposPedido()">Salvar</button>
                    <?php } else { ?>
                    <button class="btn btn-success" id="btn-salvar" onclick="confirmaExpedicao()">Salvar</button>
                    <?php } ?>
                    <form method="POST" id="validaPedido">
                        <input type="submit" id="submitForm" name="pedido_orcamento" value="Salvar" hidden>
                    </form>
                </div>
                <div class="float-right px-2">
                <input type="submit" class="btn btn-default" onclick="confirmaResetOrcamento()" value="Limpar">
                </div>
            </div>

            <?php } else { ?>
            
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="col-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div id="lancamentos-tab1"></div>
                            <div class="form-group col-2 codigo">
                            <label for="codigoCliente">Cliente</label>
                            <div class="input-group mb-3">
                            <input type="text" name="codigoCliente" class="form-control" id="codigoCliente" required>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="modal" data-target="#buscarClienteModal">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            </div>
                            </div>
                            <div class="form-group col-4 responsive4">
                            <label for="nomeCliente">Nome do cliente</label>
                            <input type="text" name="nomeCliente" class="form-control" id="nomeCliente" required>
                            </div>
                            <div class="form-group col-6 responsive6"></div>
                            <div class="form-group col-3 responsive2 responsive47">
                            <label for="enderecoCliente">Endereço</label>
                            <input type="text" name="enderecoCliente" class="form-control" id="enderecoCliente">
                            </div>
                            <div class="form-group col-2 responsive2 responsive47">
                            <label for="bairroCliente">Bairro</label>
                            <input type="text" name="bairroCliente" class="form-control" id="bairroCliente">
                            </div>
                            <div class="form-group col-2 codigo responsive44">
                            <label for="codigoCidadeCliente">Cidade</label>
                            <div class="input-group mb-3">
                            <input type="text" name="codigoCidadeCliente" class="form-control" id="codigoCidadeCliente" required>
                            <div class="input-group-append">
                                <span class="input-group-text" data-toggle="modal" data-target="#buscarCidadeModal">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            </div>
                            </div>
                            <div class="form-group col-2 responsive3 responsive44">
                            <label for="nomeCidadeCliente">Nome da cidade</label>
                            <input type="text" name="nomeCidadeCliente" class="form-control" id="nomeCidadeCliente" disabled>
                            </div>
                            <div class="form-group col-2 estadoCliente responsive45">
                            <label for="estadoCliente">UF</label>
                            <input type="text" name="estadoCliente" class="form-control" id="estadoCliente" disabled>
                            </div>
                            <div class="form-group col-2 CEPCliente responsive45">
                            <label for="CEPCliente">CEP</label>
                            <input type="text" name="CEPCliente" class="form-control" id="CEPCliente">
                            </div>
                            <div class="form-group col-2 documentoCliente responsive46">
                            <label for="documentoCliente">CPF/CNPJ</label>
                            <input type="text" name="documentoCliente" class="form-control" id="documentoCliente">
                            </div>
                            <div class="form-group col-2 documentoCliente responsive46">
                            <label for="inscricaoCliente">Inscrição Estadual</label>
                            <input type="text" name="inscricaoCliente" class="form-control" id="inscricaoCliente">
                            </div>
                            <div class="form-group col-8 responsive1"></div>
                            <div class="form-group col-2 codigo responsive40 responsive42 responsive43">
                            <label for="codigoVendedor">Vendedor</label>
                            <div class="input-group mb-3">
                                <input type="text" name="codigoVendedor" class="form-control" id="codigoVendedor" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="modal" data-target="#buscarVendedorModal">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>
                            </div>
                            <div class="form-group col-3 responsive5 responsive42 responsive43">
                            <label for="nomeVendedor">Nome</label>
                            <input type="text" name="nomeVendedor" class="form-control" id="nomeVendedor" disabled>
                            </div>
                            <div class="form-group col-2 codigo5 responsive41 responsive42 responsive43">
                            <label for="comissaoVendedor">Comissão</label>
                            <input type="text" name="comissaoVendedor" class="form-control" id="comissaoVendedor" readonly>
                            </div>
                            <div class="form-group col-3 responsive39 responsive42"></div>
                            <div class="form-group col-2 codigo responsive40 responsive42 responsive48">
                            <label for="codigoVendedorInterno">Interno</label>
                            <div class="input-group mb-3">
                                <input type="text" name="codigoVendedorInterno" class="form-control" id="codigoVendedorInterno" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="modal" data-target="#buscarVendedorInternoModal">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>
                            </div>
                            <div class="form-group col-3 responsive5 responsive42 responsive48">
                            <label for="nomeVendedorInterno">Nome</label>
                            <input type="text" name="nomeVendedorInterno" class="form-control" id="nomeVendedorInterno" disabled>
                            </div>
                            <div class="form-group col-2 codigo5 responsive41 responsive42">
                            <label for="comissaoVendedorInterno">Comissão</label>
                            <input type="text" name="comissaoVendedorInterno" class="form-control" id="comissaoVendedorInterno" readonly>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="col-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <div class="col">
                            <div class="row">
                            <div class="form-group col-2 responsive22">
                                <label for="prazoPagamento">Prazo</label>
                                <div class="input-group">
                                    <?php

                                    if ($alterarPrazoPagamento == "S") {
                                        ?>
                                        <input type="text" name="prazoPagamento" class="form-control" id="prazoPagamento" required>
                                        <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="modal" data-target="#buscarPrazoPagamentoModal">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        </div>
                                        <?php
                                    }

                                    else {
                                        ?>
                                        <input type="text" name="prazoPagamento" class="form-control" id="prazoPagamento" disabled>
                                        <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        </div>
                                        <?php
                                    }

                                    ?>
                                </div>
                            </div>
                            <div class="form-group col-4 responsive23 responsive30">
                                <label for="nomePrazo">Descrição</label>
                                <input type="text" name="nomePrazo" class="form-control" id="nomePrazo" disabled>
                            </div>
                            <div class="form-group col-2 responsive22">
                                <label for="tipoPagamento">Tipo</label>
                                <div class="input-group">
                                    <?php

                                    if ($alterarTipoPagamento == "S") {
                                        ?>
                                        <input type="text" name="tipoPagamento" class="form-control" id="tipoPagamento" required>
                                        <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="modal" data-target="#buscarTipoPagamentoModal">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        </div>
                                        <?php
                                    }

                                    else {
                                        ?>
                                        <input type="text" name="tipoPagamento" class="form-control" id="tipoPagamento" disabled>
                                        <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        </div>
                                        <?php
                                    }

                                    ?>
                                </div>
                            </div>
                            <div class="form-group col-4 responsive23">
                                <label for="nomeTipo">Descrição</label>
                                <input type="text" name="nomeTipo" class="form-control" id="nomeTipo" disabled>
                            </div>
                            <div class="form-group col-2 responsive22">
                                <label for="bancoPagamento">Banco</label>
                                <div class="input-group mb-3">
                                    <?php

                                    if ($alterarBancoPagamento == "S") {
                                        ?>
                                        <input type="text" name="bancoPagamento" class="form-control" id="bancoPagamento" required>
                                        <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="modal" data-target="#buscarBancoModal">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        </div>
                                        <?php
                                    }

                                    else {
                                        ?>
                                        <input type="text" name="bancoPagamento" class="form-control" id="bancoPagamento" disabled>
                                        <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        </div>
                                        <?php
                                    }

                                    ?>
                                </div>
                            </div>
                            <div class="form-group col-4 responsive23 responsive32">
                                <label for="nomeBanco">Descrição</label>
                                <input type="text" name="nomeBanco" class="form-control" id="nomeBanco" disabled>
                            </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-row-reverse responsive24">
                            <div class="form-group col-2 responsive36 responsive33 responsive34">
                                <div class="input-group responsive31">
                                    <a class='btn btn-info btn-sm' onclick="voltarPrecoTabela()"><i class='fas fa-dollar-sign'></i> Voltar preço de tabela</a>
                                </div>
                            </div>
                            <div class="form-group col-2 responsive36 responsive35 responsive21 responsive26 responsive28">
                                <label for="prazoPagamento">Desconto</label>
                                <div class="input-group">
                                <input type="text" name="prazoPagamento" class="form-control" tabindex="3" id="descontoOrcamento">
                                    <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-percentage" id="iDesconto"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-2 responsive36 responsive35 responsive21 responsive26 responsive38">
                                <label for="prazoPagamento">Acréscimo</label>
                                <div class="input-group">
                                <input type="text" name="prazoPagamento" class="form-control" tabindex="2" id="acrescimoOrcamento" disabled>
                                    <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-percentage" id="iAcrescimo"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-2 responsive36 ml-12px responsive21 responsive29">
                                <label for="prazoPagamento">Frete</label>
                                <div class="input-group">
                                <input type="text" name="prazoPagamento" class="form-control" tabindex="1" id="freteOrcamento">
                                    <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-28px ml-12px responsive27 responsive37">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="descontoAcrescimo" id="acrescimo">
                                    <label class="form-check-label lbl-desc">Acréscimo</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="formatoDesconto" id="descontoReais">
                                    <label class="form-check-label lbl-desc">Valor</label>
                                </div>
                            </div>
                            <div class="form-group mt-28px responsive25 responsive27">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="descontoAcrescimo" id="desconto" checked>
                                    <label class="form-check-label lbl-desc">Desconto</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="formatoDesconto" id="descontoPorcentagem" checked>
                                    <label class="form-check-label lbl-desc">Porcentagem</label>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-12">
                        <hr style="border: 0; border-top: 1px solid rgba(0, 0, 0, 0.1);" />
                        </div>
                        <div class="row">
                        <div class="card-body">
                            <div class="row" id="enterForm">
                            <div id="lancamentos-tab2"></div>
                            <div class="form-group col-2 responsive9">
                                <label for="codigoMaterial">Código</label>
                                <div class="input-group mb-3">
                                <input type="text" name="codigoMaterial" class="form-control" id="codigoMaterial" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="modal" data-target="#buscarProdutoModal"><i class="fas fa-search"></i></span>
                                </div>
                                </div>
                            </div>
                            <div class="form-group col-4 responsive8">
                                <label for="nomeMaterial">Descrição</label>
                                <input type="text" name="nomeMaterial" class="form-control" id="nomeMaterial" disabled>
                            </div>
                            <div class="col-6 responsive12"></div>
                            <!--<div class="form-group col-1 codigo3">
                                <label for="estoqueMaterial">Estoque</label>
                                <input type="text" name="estoqueMaterial" class="form-control" id="estoqueMaterial" disabled>
                            </div>-->
                            <div class="form-group col-1 codigo3">
                                <label for="quantidadeMaterial">Qtde</label>
                                <input type="text" name="quantidadeMaterial" class="form-control" id="quantidadeMaterial" min="0" required>
                            </div>
                            <div class="form-group col-1 codigo3">
                                <label for="unitarioMaterial">Unitário</label>
                                <input type="text" name="unitarioMaterial" class="form-control" id="unitarioMaterial" required>
                            </div>
                            <div class="form-group col-1 codigo3">
                                <label for="totalMaterial">Total</label>
                                <input type="text" name="totalMaterial" class="form-control" id="totalMaterial" value="0" disabled>
                            </div>
                            <div class="form-group col-2">
                                <button class="btn btn-info lancar" id="adicionarProduto" onclick="adicionarProduto(false)">Lançar</button>
                            </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                            <div class="modal-body">
                            <div class="card-body">
                                <div class="row modal-responsive">
                                <table class="table table-bordered table-hover" id="lancamentos-produtos">
                                <thead>
                                <tr class='text-center'>
                                    <th style="width: 8%">Código</th>
                                    <th style="min-width: 250px;">Nome</th>
                                    <th>Qtde</th>
                                    <th>Unitário</th>
                                    <th>Total</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody id="table">

                                    <!-- Aqui é inserido as linhas que vem do script -->

                                </tbody>
                                </table>
                                </div>
                                <div class="py-3">
                                <div class="form-group col-1 codigo4">
                                    <label for="total">Total</label>
                                    <input type="text" name="total" class="form-control" id="total" disabled>
                                </div>
                                <div class="form-group col-1 codigo4 d-none" id="divDesconto">
                                    <label for="descAcresc" id="descontoLabel">Desconto</label>
                                    <input type="text" name="descAcresc" class="form-control" id="descAcresc" disabled>
                                </div>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                            <label for="observacoes">Observações</label>
                            <textarea class="form-control" name="observacoes" id="observacoes" rows="3"></textarea>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <!--<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>-->
                </div>
                <div class="float-right">
                    <?php if ($_SESSION['parametros']['usaExpedicao'] == 'S') { ?>
                    <button class="btn btn-success" id="btn-salvar" onclick="verificaCamposPedido()">Salvar</button>
                    <?php } else { ?>
                    <button class="btn btn-success" id="btn-salvar" onclick="confirmaExpedicao()">Salvar</button>
                    <?php } ?>
                    <form method="POST" id="validaPedido">
                        <input type="submit" id="submitForm" name="pedido_orcamento" value="Salvar" hidden>
                    </form>
                </div>
                <div class="float-right px-2">
                <input type="submit" class="btn btn-default" onclick="confirmaResetOrcamento()" value="Limpar">
                </div>
            </div>
            
            <?php } ?>

        </div>
      </div>
  </section>

<!-- Buscar pedido modal -->
<div class="modal fade" id="buscarPedidoModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buscar orçamentos</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if ($_SESSION['tema'] == 'branco') { ?>
        <div class="input-group barraPesquisa bordaBranca">
        <?php } else { ?>
        <div class="input-group sidebar-dark-primary barraPesquisa bordaPreta">
        <?php } ?>

          <div class="form-group w100px responsive20">
            <label class="lbl-group">Vendedor</label>
            <input class="form-control form-control-sidebar filtroGeral" id="filtroVendedor" type="text">
          </div>

          <div class="form-group w100px ml-12px responsive20">
            <label class="lbl-group">Pedido</label>
            <input class="form-control form-control-sidebar filtroGeral" id="filtroPedido" type="text">
          </div>

          <div class="form-group w350px ml-12px responsive19">
            <label class="lbl-group">Nome do cliente</label>
            <input class="form-control form-control-sidebar filtroGeral" id="filtroCliente" type="text">
          </div>

          <div class="form-group ml-12px responsive16">
            <label class="lbl-group">Data início</label>
            <input class="form-control form-control-sidebar filtroDataInicio" id="filtroDataInicio" type="date" value="<?php echo date('Y-m-d', strtotime('-3 days', strtotime(date('Y-m-d')))); ?>">
          </div>
          
          <div class="form-group ml-12px responsive15">
            <label class="lbl-group">Data final</label>
            <input class="form-control form-control-sidebar filtroDataFinal" id="filtroDataFinal" type="date" value="<?php echo date('Y-m-d'); ?>">
          </div>

          <div class="form-group ml-24px responsive17">
            <input type="submit" class="btn btn-info mt-24px responsive18" id="buscarOrcamento" onclick="filtrarOrcamento()" value="Filtrar" />
          </div>
        </div>
        <div class="card-body">
          <div class="row modal-responsive">
          <table class="table table-bordered table-hover">
            <thead>
            <tr class='text-center'>
              <th style="width: 16%">Data</th>
              <th>Valor</th>
              <th>Cliente</th>
              <th>Vendedor</th>
              <th>Número</th>
              <th style="width: 15%">Ações</th>
            </tr>
            </thead>
            <tbody id="buscarPedidoTable">

              <!-- Aqui é inserido as linhas que vem do script -->

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
<!-- Novo pedido modal -->
<div class="modal fade" id="novoPedidoModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Novo orçamento</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Tem certeza que deseja abrir um novo orçamento? As alterações feitas neste orçamento serão perdidas.</h6>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <form method="POST">
          <div>
            <input type="submit" class="btn btn-success" onclick="novoOrcamento()" value="Confirmar">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Confirmar incluir orçamento modal -->
<div class="modal fade" id="confirmarIncluirOrcamentoModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Incluir orçamento</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Tem certeza que deseja incluir este orçamento? Caso outro orçamento esteja aberto, as alterações serão perdidas.</h6>
      </div>
      <div class="modal-footer justify-content-between">
        <input type="hidden" id="incluir-id">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          <div>
            <input type="submit" class="btn btn-success" onclick="incluirOrcamento(document.getElementById('incluir-id').value)" value="Confirmar">
          </div>
      </div>
    </div>
  </div>
</div>
<!-- Reset modal -->
<div class="modal fade" id="confirmarResetModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Limpar orçamento</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Tem certeza que deseja limpar este orçamento?</h6>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <form method="POST">
          <div>
            <input type="submit" class="btn btn-danger" onclick="limpaCamposPedido()" value="Limpar">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Sugestão de quantidade modal -->
<div class="modal fade" id="sugestaoModal">
  <div class="modal-dialog modal-sm sugestao-material">
    <div class="modal-content">
      <?php

        if (isset($_SESSION['sugestaoMaterial']) && !empty($_SESSION['sugestaoMaterial'])) {
          ?>
      <div class="modal-header">
        <h4 class="modal-title">Este produto possui embalagem de <?php echo ValidaValor($_SESSION['sugestaoMaterial']['embalagem']); ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>A quantidade sugerida para este produto é de <?php echo ValidaValor($_SESSION['sugestaoMaterial']['sugestao']); ?>,
        deseja alterar a quantidade conforme a sugestão?</h6>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          <div>
            <input type="submit" class="btn btn-success" onclick="alteraQuantidadeSugestao(<?php echo $_SESSION['sugestaoMaterial']['sugestao']; ?>)" value="Alterar">
          </div>
      </div>
          <?php

          unset($_SESSION['sugestaoMaterial']);

        }

      ?>
    </div>
  </div>
</div>
<!-- Liberar embalagem do material modal -->
<div class="modal fade" id="validaEmbalagemMaterial">
  <div class="modal-dialog confirmacao-embalagem">
    <div class="modal-content">
      <?php

        if (isset($_SESSION['sugestaoMaterial2']) && !empty($_SESSION['sugestaoMaterial2'])) {
          ?>
      <div class="modal-header">
        <h4 class="modal-title">Este produto possui embalagem de <?php echo ValidaValor($_SESSION['sugestaoMaterial2']['embalagem']); ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6 class="mb-4">A quantidade sugerida para este produto é de <?php echo ValidaValor($_SESSION['sugestaoMaterial2']['sugestao']); ?>.
        Por favor, informe seu login e senha para liberar a quantidade informada.</h6>
        <div class="d-flex justify-content-center">
          <div class="form-group w-40">
            <label>Usuário</label>
            <input class="form-control form-control-sidebar" id="validaEmbalagemMaterialUsuario" type="text" required>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <div class="form-group w-40">
            <label>Senha</label>
            <input class="form-control form-control-sidebar" id="validaEmbalagemMaterialSenha" type="password" required>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          <div>
            <input type="submit" class="btn btn-success" onclick="validaEmbalagemMaterialUsuario()" value="Liberar">
          </div>
      </div>
          <?php

          unset($_SESSION['sugestaoMaterial2']);

        }

      ?>
    </div>
  </div>
</div>
<!-- Escolher lote e local do produto modal -->
<div class="modal fade" id="escolherLoteLocal">
  <div class="modal-dialog modal-lg lotelocal-produto">
    <div class="modal-content">
      <?php

        if (isset($_SESSION['loteLocalProduto']) && !empty($_SESSION['loteLocalProduto'])) {
          ?>
      <div class="modal-header">
        <h4 class="modal-title">Escolha o lote e local para o produto <?php echo $_SESSION['loteLocalProduto']['nome']; ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="row modal-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="text-center">
                  <th>Lote</th>
                  <th>Local</th>
                  <th>Estoque</th>
                  <th style="width: 25%">Ações</th>
                </tr>
              </thead>
              <tbody>
               <?php

                  $sql = $pdo->prepare("SELECT LoteMaterial.*, LoteEstoque.Descricao, LocalEstoque.Descricao AS DescSetor FROM LoteMaterial
                  LEFT JOIN LoteEstoque ON LoteEstoque.Codigo = LoteMaterial.CodigoLote
                  LEFT JOIN LocalEstoque ON LocalEstoque.Codigo = LoteMaterial.CodigoLocal
                  WHERE LoteMaterial.CodigoProduto = :codigo ORDER BY LoteMaterial.CodigoLote");
                  $sql->bindValue(":codigo", $_SESSION['loteLocalProduto']['codigo']);
                  $sql->execute();

                  $resultEstoque = $sql->fetchAll();
         
                  if ($resultEstoque != false) {

                     foreach ($resultEstoque as $estoqueLote) {

                        echo "<tr class='text-center'>";

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

                        $sql = $pdo->prepare("SELECT Sum(Quantidade)
                        AS Reserva FROM OrcamentosItens INNER JOIN Orcamentos ON Orcamentos.Numero = OrcamentosItens.Numero
                        WHERE OrcamentosItens.CodigoProduto = :codigo AND OrcamentosItens.Local = :local
                        AND OrcamentosItens.Lote = :lote And Orcamentos.PedidoOrcamento = 'S'");
                        $sql->bindValue(":codigo", $_SESSION['loteLocalProduto']['codigo']);
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

                        echo "<td>".(TrataNulo($estoqueLote['Estoque'], 0) - $reservaLote)."</td>";

                        echo "<td class='project-actions text-center' style='width: 10%;'>
                           <a class='btn btn-success btn-sm desktop'
                           onclick='incluirLoteLocal(".$estoqueLote['CodigoLocal'].", ".$estoqueLote['CodigoLote'].")'>
                           <i class='fas fa-check'></i> Escolher</a>
                        
                           <a class='btn btn-success btn-sm mobile'
                           onclick='incluirLoteLocal(".$estoqueLote['CodigoLocal'].", ".$estoqueLote['CodigoLote'].")'>
                           <i class='fas fa-check'></i></a>
                        </td>";

                        echo "</tr>";

                     }

                  }

                  else {

                     $sql = $pdo->prepare("SELECT Estoque, Reserva FROM Material WHERE Codigo = :codigo");
                     $sql->bindValue(":codigo", $_SESSION['loteLocalProduto']['codigo']);
                     $sql->execute();

                     $resultMaterial = $sql->fetch();
                   
                     echo "<tr class='text-center'>";

                     echo "<td>PRINCIPAL</td>";
                     echo "<td>PRINCIPAL</td>";

                     echo "<td>".TrataNulo($resultMaterial['Estoque'], 0) - TrataNulo($resultMaterial['Reserva'], 0)."</td>";

                     echo "<td class='project-actions text-center' style='width: 10%;'>
                        <a class='btn btn-success btn-sm desktop'
                        onclick='incluirLoteLocal(999999, 999999)'>
                        <i class='fas fa-check'></i> Escolher</a>
                     
                        <a class='btn btn-success btn-sm mobile'
                        onclick='incluirLoteLocal(999999, 999999)'>
                        <i class='fas fa-check'></i></a>
                     </td>";

                     echo "</tr>";

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
          <?php

          unset($_SESSION['loteLocalProduto']);

        }

      ?>
    </div>
  </div>
</div>
<!-- Confirmação do desconto em porcentagem modal -->
<div class="modal fade" id="confirmacaoDescontoPorcentagemModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmação de desconto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Deseja realmente aplicar um desconto de <strong id="descontoModalPorcentagem"></strong> neste orçamento?</h6>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          <div>
            <input type="submit" class="btn btn-success" onclick="aplicarDesconto()" value="Confirmar">
          </div>
      </div>
    </div>
  </div>
</div>
<!-- Confirmação do desconto em reais modal -->
<div class="modal fade" id="confirmacaoDescontoReaisModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmação de desconto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Deseja realmente aplicar um desconto de <strong id="descontoModalReais"></strong> neste orçamento?</h6>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          <div>
            <input type="submit" class="btn btn-success" onclick="aplicarDesconto()" value="Confirmar">
          </div>
      </div>
    </div>
  </div>
</div>
<!-- Confirmação do acréscimo em porcentagem modal -->
<div class="modal fade" id="confirmacaoAcrescimoPorcentagemModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmação de acréscimo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Deseja realmente aplicar um acréscimo de <strong id="acrescimoModalPorcentagem"></strong> neste orçamento?</h6>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          <div>
            <input type="submit" class="btn btn-success" onclick="aplicarAcrescimo()" value="Confirmar">
          </div>
      </div>
    </div>
  </div>
</div>
<!-- Confirmação do acréscimo em reais modal -->
<div class="modal fade" id="confirmacaoAcrescimoReaisModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmação de acréscimo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Deseja realmente aplicar um acréscimo de <strong id="acrescimoModalReais"></strong> neste orçamento?</h6>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          <div>
            <input type="submit" class="btn btn-success" onclick="aplicarAcrescimo()" value="Confirmar">
          </div>
      </div>
    </div>
  </div>
</div>
<!-- Confirmação do preço de tabela modal -->
<div class="modal fade" id="confirmacaoPrecoTabelaModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Voltar o preço de tabela</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Deseja realmente voltar o preço de tabela para todos os produtos neste orçamento?</h6>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          <div>
            <input type="submit" class="btn btn-success" onclick="confirmarPrecoTabela()" value="Confirmar">
          </div>
      </div>
    </div>
  </div>
</div>
<!-- Confirmação do frete modal -->
<div class="modal fade" id="confirmacaoFreteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Adicionar valor do frete</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Deseja realmente acrescentar <strong id="freteModal"></strong> no valor total deste orçamento?</h6>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          <div>
            <input type="submit" class="btn btn-success" onclick="confirmarFrete()" value="Confirmar">
          </div>
      </div>
    </div>
  </div>
</div>
<!-- Confirmação da remoção do frete modal -->
<div class="modal fade" id="confirmacaoExclusaoFreteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Removeer valor do frete</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Deseja realmente remover o valor do frete no total deste orçamento?</h6>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          <div>
            <input type="submit" class="btn btn-success" onclick="confirmarRemocaoFrete()" value="Confirmar">
          </div>
      </div>
    </div>
  </div>
</div>
<!-- Expedição modal -->
<div class="modal fade" id="expedicaoModal">
  <div class="modal-dialog modal-xl expedicaoClass">
    <div class="modal-content">
      <?php

        if (isset($_SESSION['expedicao']) && !empty($_SESSION['expedicao'])) {
          ?>
      <div class="modal-header">
        <h4 class="modal-title">Expedição de produtos</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="row modal-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="text-center">
                    <th><input type="checkbox" class="checkBoxExpedicao" id="checkBoxExpedicao" onclick="checkAllExpedicao(this)" /></th>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th style="min-width: 150px">Status</th>
                    <th>Data</th>
                </tr>
              </thead>
              <tbody>
               <?php

                for ($i=0; $i < count($_SESSION['expedicao']); $i++) {
                    
                    echo "<tr>";

                        echo "<td><input class='checkBoxExpedicao' type='checkbox' id='checkExpedicao".$i."' /></td>";
                        echo "<td>".$_SESSION['expedicao'][$i]['codigo']."</td>";
                        echo "<td>".$_SESSION['expedicao'][$i]['nome']."</td>";
                        echo "<td>".$_SESSION['expedicao'][$i]['quantidade']."</td>";

                        echo "
                        <td>
                            <select class='form-control' name='statusExpedicao' id='statusExpedicao".$i."'>
                                <option value='Retira' id='optExpedicao".$i."'>Retira</option>
                                <option value='Entrega' id='optExpedicao".$i."'>Entrega</option>
                            </select>
                        </td>";

                        echo "<td><input class='form-control form-control-sidebar' id='dataExpedicao".$i."' type='date' value='".date('Y-m-d')."'></td>";

                    echo "</tr>";

                }

               ?>
              </tbody>
            </table>

            <label for="observacoesExpedicao">Observações da expedição</label>
            <textarea class="form-control" name="observacoesExpedicao" id="observacoesExpedicao" rows="3"></textarea>  

          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-success" onclick="confirmaExpedicao()" data-dismiss="modal">Confirmar</button>
      </div>
          <?php

          unset($_SESSION['expedicao']);

        }

      ?>
    </div>
  </div>
</div>

<!-- Scripts de busca, add, edit... -->

<?php if ($_SESSION['parametros']['usaLoteMaterial'] == 'S') { ?>

<script src="../../../plugins/pages/pedidos/mainLote.js"></script>
<script src="../../../plugins/pages/pedidos/addGeralLote.js"></script>

<?php } else { ?>

<script src="../../../plugins/pages/pedidos/mainSemLote.js"></script>
<script src="../../../plugins/pages/pedidos/addGeralSemLote.js"></script>

<?php } ?>