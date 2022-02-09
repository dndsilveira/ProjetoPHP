var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

$("input[name='formatoDesconto']").change(function(){
    if (document.getElementById('descontoReais').checked) {
        document.getElementById('iAcrescimo').classList.remove('fa-percentage');
        document.getElementById('iDesconto').classList.remove('fa-percentage');
        document.getElementById('iAcrescimo').classList.add('fa-dollar-sign');
        document.getElementById('iDesconto').classList.add('fa-dollar-sign');
    }

    else {
        document.getElementById('iAcrescimo').classList.remove('fa-dollar-sign');
        document.getElementById('iDesconto').classList.remove('fa-dollar-sign');
        document.getElementById('iAcrescimo').classList.add('fa-percentage');
        document.getElementById('iDesconto').classList.add('fa-percentage');
    }
});

$("input[name='descontoAcrescimo']").change(function(){
    if (document.getElementById('acrescimo').checked) {
        $("#descontoOrcamento").prop('disabled', true);
        $("#acrescimoOrcamento").prop('disabled', false);
        document.getElementById('descontoOrcamento').value = "";
    }

    else {
        $("#descontoOrcamento").prop('disabled', false);
        $("#acrescimoOrcamento").prop('disabled', true);
        document.getElementById('acrescimoOrcamento').value = "";
    }
});

$(document).ready(function(){
    $("#buscarPedidoModal").on('shown.bs.modal', function () {
        var paginaOperacao = 'buscarOrcamentos';

        var dataInicio = document.getElementById('filtroDataInicio').value;
        var dataFinal = document.getElementById('filtroDataFinal').value;
        
        $.ajax
        ({
            //Configurações
            type: 'POST',//Método que está sendo utilizado.
            dataType: 'html',//É o tipo de dado que a página vai retornar.
            url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
            //função que vai ser executada assim que a requisição for enviada
            data: {dataInicio: dataInicio,
            dataFinal: dataFinal,
            paginaOperacao: paginaOperacao,},//Dados para consulta
            //função que será executada quando a solicitação for finalizada.
            success: function (msg)
            {
                $("#buscarPedidoTable").html(msg);
            }
        });
    });

    $("#validaEmbalagemMaterial").on('shown.bs.modal', function () {
        $("#validaEmbalagemMaterialUsuario").focus();
    });

    $("#buscarPrazoPagamentoModal").on('shown.bs.modal', function () {
        $("#buscarPrazoPagamento").click();
    });

    $("#buscarTipoPagamentoModal").on('shown.bs.modal', function () {
        $("#buscarTipoPagamento").click();
    });

    $("#buscarBancoPagamentoModal").on('shown.bs.modal', function () {
        $("#buscarBancoPagamento").click();
    });
});
  
$("#enterForm").keypress(function(event) {
if (event.keyCode === 13) {
    if (document.getElementById('adicionarProduto') != document.activeElement) {
        $("#adicionarProduto").click();
    }
}
});

$("#buscarPedidoModal").keypress(function(event) {
if (event.keyCode === 13) {
    $("#buscarOrcamento").click();
}
});

$("#buscaNomeCliente").keypress(function(event) {
if (event.keyCode === 13) {
    $("#buscarCliente").click();
}
});

$("#buscaNomeProduto").keypress(function(event) {
if (event.keyCode === 13) {
    $("#buscarProduto").click();
}
});

$("#buscaNomeCidade").keypress(function(event) {
if (event.keyCode === 13) {
    $("#buscarCidade").click();
}
});

$("#buscaNomeVendedor").keypress(function(event) {
if (event.keyCode === 13) {
    $("#buscarVendedor").click();
}
});

$("#buscaNomeVendedorInterno").keypress(function(event) {
   if (event.keyCode === 13) {
       $("#buscarVendedorInterno").click();
   }
   });

$("#buscaNomePrazoPagamento").keypress(function(event) {
if (event.keyCode === 13) {
    $("#buscarPrazoPagamento").click();
}
});

$("#buscaNomeTipoPagamento").keypress(function(event) {
if (event.keyCode === 13) {
    $("#buscarTipoPagamento").click();
}
});

$("#buscaNomeBanco").keypress(function(event) {
if (event.keyCode === 13) {
    $("#buscarBanco").click();
}
});

// INCLUIR CLIENTE
function incluirCliente(intValue) {

document.getElementById('codigoCliente').value = intValue;
$('#buscarClienteModal').modal('toggle');
document.getElementById('codigoCliente').focus();

if (intValue == 0) {
    document.getElementById('nomeCliente').value = "CONSUMIDOR";
    document.getElementById('enderecoCliente').value = "";
    document.getElementById('bairroCliente').value = "";
    document.getElementById('codigoCidadeCliente').value = "<?php echo $_SESSION['parametros']['codigoCidadeOrcamentos']; ?>";
    document.getElementById('codigoCidadeCliente').focus();
    document.getElementById('CEPCliente').value = "";
    document.getElementById('documentoCliente').value = "";
    document.getElementById('inscricaoCliente').value = "";
    document.getElementById('nomeCliente').focus();
}

else {
    document.getElementById('enderecoCliente').focus();
}

}

// INCLUIR PRODUTO
function incluirProduto(intValue) {

    document.getElementById('codigoMaterial').value = intValue;
    $('#buscarProdutoModal').modal('toggle');
    document.getElementById('codigoMaterial').focus();

    document.getElementById('quantidadeMaterial').focus();

}

// INCLUIR VENDEDOR
function incluirVendedor(intValue) {

    document.getElementById('codigoVendedor').value = intValue;
    $('#buscarVendedorModal').modal('toggle');
    document.getElementById('codigoVendedor').focus();

    document.getElementById('codigoVendedorInterno').focus();
}

// INCLUIR VENDEDOR INTERNO
function incluirVendedorInterno(intValue) {

   document.getElementById('codigoVendedorInterno').value = intValue;
   $('#buscarVendedorInternoModal').modal('toggle');
   document.getElementById('codigoVendedorInterno').focus();

   document.getElementById('btn-salvar').focus();
}

// INCLUIR CIDADE
function incluirCidade(intValue) {

    document.getElementById('codigoCidadeCliente').value = intValue;
    $('#buscarCidadeModal').modal('toggle');
    document.getElementById('codigoCidadeCliente').focus();

    document.getElementById('CEPCliente').focus();
}

// INCLUIR PRAZO PAGAMENTO
function incluirPrazoPagamento(intValue) {

    document.getElementById('prazoPagamento').value = intValue;
    $('#buscarPrazoPagamentoModal').modal('toggle');
    document.getElementById('prazoPagamento').focus();

    document.getElementById('tipoPagamento').focus();
}

// INCLUIR TIPO PAGAMENTO
function incluirTipoPagamento(intValue) {

    document.getElementById('tipoPagamento').value = intValue;
    $('#buscarTipoPagamentoModal').modal('toggle');
    document.getElementById('tipoPagamento').focus();

    document.getElementById('codigoMaterial').focus();
}

// INCLUIR BANCO
function incluirBanco(intValue) {

    document.getElementById('bancoPagamento').value = intValue;
    $('#buscarBancoModal').modal('toggle');
    document.getElementById('bancoPagamento').focus();

    document.getElementById('codigoMaterial').focus();
}

// BUSCAR CLIENTES
function buscarCliente() {

var paginaOperacao = 'buscarCliente';

var nome = document.getElementById("buscaNomeCliente").value;

if (!nome) {
    nome = '';
}

$.ajax
({
    //Configurações
    type: 'POST',//Método que está sendo utilizado.
    dataType: 'html',//É o tipo de dado que a página vai retornar.
    url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
    //função que vai ser executada assim que a requisição for enviada
    data: {nome: nome,
    paginaOperacao: paginaOperacao,},//Dados para consulta
    //função que será executada quando a solicitação for finalizada.
    success: function (msg)
    {
        $("#buscarClienteTable").html(msg);
    }
});
}
  
// BUSCAR PRODUTOS
function buscarProduto() {

var paginaOperacao = 'buscarProduto';

var nome = document.getElementById("buscaNomeProduto").value;

if (!nome) {
    nome = '';
}

$.ajax
({
    //Configurações
    type: 'POST',//Método que está sendo utilizado.
    dataType: 'html',//É o tipo de dado que a página vai retornar.
    url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
    //função que vai ser executada assim que a requisição for enviada
    data: {nome: nome,
    paginaOperacao: paginaOperacao,},//Dados para consulta
    //função que será executada quando a solicitação for finalizada.
    success: function (msg)
    {
        $("#buscarProdutoTable").html(msg);
    }
});
}

// BUSCAR VENDEDOR
function buscarVendedor() {

var paginaOperacao = 'buscarVendedor';

var nome = document.getElementById("buscaNomeVendedor").value;

if (!nome) {
    nome = '';
}

$.ajax
({
    //Configurações
    type: 'POST',//Método que está sendo utilizado.
    dataType: 'html',//É o tipo de dado que a página vai retornar.
    url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
    //função que vai ser executada assim que a requisição for enviada
    data: {nome: nome,
    paginaOperacao: paginaOperacao,},//Dados para consulta
    //função que será executada quando a solicitação for finalizada.
    success: function (msg)
    {
        $("#buscarVendedorTable").html(msg);
    }
});
}

// BUSCAR VENDEDOR INTERNO
function buscarVendedorInterno() {

   var paginaOperacao = 'buscarVendedorInterno';
   
   var nome = document.getElementById("buscaNomeVendedorInterno").value;
   
   if (!nome) {
       nome = '';
   }
   
   $.ajax
   ({
       //Configurações
       type: 'POST',//Método que está sendo utilizado.
       dataType: 'html',//É o tipo de dado que a página vai retornar.
       url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
       //função que vai ser executada assim que a requisição for enviada
       data: {nome: nome,
       paginaOperacao: paginaOperacao,},//Dados para consulta
       //função que será executada quando a solicitação for finalizada.
       success: function (msg)
       {
           $("#buscarVendedorInternoTable").html(msg);
       }
   });
   }

// BUSCAR CIDADES
function buscarCidade() {

   var paginaOperacao = 'buscarCidade';

   var nome = document.getElementById("buscaNomeCidade").value;

   if (!nome) {
      nome = '';
   }

   $.ajax
   ({
      //Configurações
      type: 'POST',//Método que está sendo utilizado.
      dataType: 'html',//É o tipo de dado que a página vai retornar.
      url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
      //função que vai ser executada assim que a requisição for enviada
      data: {nome: nome,
      paginaOperacao: paginaOperacao,},//Dados para consulta
      //função que será executada quando a solicitação for finalizada.
      success: function (msg)
      {
         $("#buscarCidadeTable").html(msg);
      }
   });
}

// BUSCAR PRAZO PAGAMENTO
function buscarPrazoPagamento() {

var paginaOperacao = 'buscarPrazoPagamento';

var nome = document.getElementById("buscaNomePrazoPagamento").value;

if (!nome) {
    nome = '';
}

$.ajax
({
    //Configurações
    type: 'POST',//Método que está sendo utilizado.
    dataType: 'html',//É o tipo de dado que a página vai retornar.
    url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
    //função que vai ser executada assim que a requisição for enviada
    data: {nome: nome,
    paginaOperacao: paginaOperacao,},//Dados para consulta
    //função que será executada quando a solicitação for finalizada.
    success: function (msg)
    {
        $("#buscarPrazoPagamentoTable").html(msg);
    }
});
}

// BUSCAR TIPO PAGAMENTO
function buscarTipoPagamento() {

var paginaOperacao = 'buscarTipoPagamento';

var nome = document.getElementById("buscaNomeTipoPagamento").value;

if (!nome) {
    nome = '';
}

$.ajax
({
    //Configurações
    type: 'POST',//Método que está sendo utilizado.
    dataType: 'html',//É o tipo de dado que a página vai retornar.
    url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
    //função que vai ser executada assim que a requisição for enviada
    data: {nome: nome,
    paginaOperacao: paginaOperacao,},//Dados para consulta
    //função que será executada quando a solicitação for finalizada.
    success: function (msg)
    {
        $("#buscarTipoPagamentoTable").html(msg);
    }
});
}

// BUSCAR BANCO
function buscarBanco() {

var paginaOperacao = 'buscarBanco';

var nome = document.getElementById("buscaNomeBanco").value;

if (!nome) {
    nome = '';
}

$.ajax
({
    //Configurações
    type: 'POST',//Método que está sendo utilizado.
    dataType: 'html',//É o tipo de dado que a página vai retornar.
    url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
    //função que vai ser executada assim que a requisição for enviada
    data: {nome: nome,
    paginaOperacao: paginaOperacao,},//Dados para consulta
    //função que será executada quando a solicitação for finalizada.
    success: function (msg)
    {
        $("#buscarBancoTable").html(msg);
    }
});

}

function filtrarOrcamento() {
   
   var paginaOperacao = 'buscarOrcamentos';

   var vendedor = document.getElementById('filtroVendedor').value;
   var pedido = document.getElementById('filtroPedido').value;
   var cliente = document.getElementById('filtroCliente').value;
   var dataInicio = document.getElementById('filtroDataInicio').value;
   var dataFinal = document.getElementById('filtroDataFinal').value;

   if (!vendedor) {
      vendedor = null;
   }

   if (!pedido) {
      pedido = null;
   }

   if (!cliente) {
      cliente = null;
   }

   $.ajax
   ({
      //Configurações
      type: 'POST',//Método que está sendo utilizado.
      dataType: 'html',//É o tipo de dado que a página vai retornar.
      url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
      //função que vai ser executada assim que a requisição for enviada
      data: {dataInicio: dataInicio,
      dataFinal: dataFinal,
      vendedor: vendedor,
      pedido: pedido,
      cliente: cliente,
      paginaOperacao: paginaOperacao,},//Dados para consulta
      //função que será executada quando a solicitação for finalizada.
      success: function (msg)
      {
         $("#buscarPedidoTable").html(msg);
      }
   });
}

var inputDesconto = document.getElementById("descontoOrcamento");

// TAB NO INPUT DESCONTO
inputDesconto.onblur = function(){

   if (document.getElementById('iDesconto').classList.contains('fa-percentage')) {
      var paginaOperacao = 'validaDescontoOrcamentoPorcentagem';
   }

   else {
      var paginaOperacao = 'validaDescontoOrcamentoReais';
   }

   var desconto = parseFloat((document.getElementById("descontoOrcamento").value).toString().replace(",", "."));

   if (desconto > 0 && desconto != "") {
      if (arrayMaterial.length > 0) {
         $.ajax
            ({
            //Configurações
            type: 'POST',//Método que está sendo utilizado.
            dataType: 'html',//É o tipo de dado que a página vai retornar.
            url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
            //função que vai ser executada assim que a requisição for enviada
            data: {desconto: desconto,
            paginaOperacao: paginaOperacao,},//Dados para consulta
            //função que será executada quando a solicitação for finalizada.
            success: function (msg)
            {
               $("#lancamentos-tab2").html(msg);
            }
         });
      }

      else {
         Toast.fire({
            icon: 'error',
            title: 'Atenção! Nenhum produto foi informado neste orçamento.'
         });

         document.getElementById('descontoOrcamento').value = "";
      }
   }

}

function aplicarDesconto() {

   if (document.getElementById('iDesconto').classList.contains('fa-percentage')) {
      var paginaOperacao = 'aplicarDescontoPorcentagem';
   }
   
   else {
      var paginaOperacao = 'aplicarDescontoReais';
   }

   var desconto = parseFloat((document.getElementById("descontoOrcamento").value).toString().replace(",", "."));

   $.ajax
      ({
      //Configurações
      type: 'POST',//Método que está sendo utilizado.
      dataType: 'html',//É o tipo de dado que a página vai retornar.
      url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
      //função que vai ser executada assim que a requisição for enviada
      data: {desconto: desconto,
      paginaOperacao: paginaOperacao,},//Dados para consulta
      //função que será executada quando a solicitação for finalizada.
      success: function (msg)
      {
         $("#lancamentos").html(msg);
      }
   });
}

var inputAcrescimo = document.getElementById("acrescimoOrcamento");

// TAB NO INPUT ACRÉSCIMO
inputAcrescimo.onblur = function(){

   var acrescimo = parseFloat((document.getElementById("acrescimoOrcamento").value).toString().replace(",", "."));

   if (acrescimo > 0 && acrescimo != "") {
      if (arrayMaterial.length > 0) {
         if (document.getElementById('iAcrescimo').classList.contains('fa-percentage')) {

            document.getElementById("descontoOrcamento").focus();

            $('#confirmacaoAcrescimoPorcentagemModal').modal();
         
            document.getElementById('acrescimoModalPorcentagem').innerHTML = (acrescimo).toString().replace(".", ",")+"%";
         }
      
         else {

            document.getElementById("descontoOrcamento").focus();

            $('#confirmacaoAcrescimoReaisModal').modal();
         
            document.getElementById('acrescimoModalReais').innerHTML = (acrescimo).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
         }
      }

      else {
         Toast.fire({
            icon: 'error',
            title: 'Atenção! Nenhum produto foi informado neste orçamento.'
         });

         document.getElementById('acrescimoOrcamento').value = "";
      }
   }

}

function aplicarAcrescimo() {

   if (document.getElementById('iAcrescimo').classList.contains('fa-percentage')) {
      var paginaOperacao = 'aplicarAcrescimoPorcentagem';
   }
   
   else {
      var paginaOperacao = 'aplicarAcrescimoReais';
   }

   var acrescimo = parseFloat((document.getElementById("acrescimoOrcamento").value).toString().replace(",", "."));

   $.ajax
      ({
      //Configurações
      type: 'POST',//Método que está sendo utilizado.
      dataType: 'html',//É o tipo de dado que a página vai retornar.
      url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
      //função que vai ser executada assim que a requisição for enviada
      data: {acrescimo: acrescimo,
      paginaOperacao: paginaOperacao,},//Dados para consulta
      //função que será executada quando a solicitação for finalizada.
      success: function (msg)
      {
         $("#lancamentos").html(msg);
      }
   });
}

function voltarPrecoTabela() {

   if (arrayMaterial.length > 0) {

      $("#confirmacaoPrecoTabelaModal").modal();

   }

   else {
      Toast.fire({
         icon: 'error',
         title: 'Atenção! Nenhum produto foi informado neste orçamento.'
      });
   }

}

function confirmarPrecoTabela() {

   var paginaOperacao = 'voltarPreco';

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
         $("#lancamentos").html(msg);
      }
   });

}

var inputFrete = document.getElementById("freteOrcamento");

// TAB NO INPUT FRETE
inputFrete.onblur = function(){

   var frete = parseFloat((document.getElementById("freteOrcamento").value).toString().replace(",", "."));

   if (frete > 0 && frete != "") {

      if (arrayMaterial.length > 0) {

         document.getElementById("acrescimoOrcamento").focus();

         $('#confirmacaoFreteModal').modal();
      
         document.getElementById('freteModal').innerHTML = (frete).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});

      }

      else {
         Toast.fire({
            icon: 'error',
            title: 'Atenção! Nenhum produto foi informado neste orçamento.'
         });

         document.getElementById('freteOrcamento').value = "";

      }
   
   
   }

   else {

      if (frete == 0) {

         $('#confirmacaoExclusaoFreteModal').modal();

      }

   }

}

function confirmarFrete() {

   var paginaOperacao = 'somarFrete';

   var frete = parseFloat((document.getElementById("freteOrcamento").value).toString().replace(",", "."));

   $.ajax
      ({
      //Configurações
      type: 'POST',//Método que está sendo utilizado.
      dataType: 'html',//É o tipo de dado que a página vai retornar.
      url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
      //função que vai ser executada assim que a requisição for enviada
      data: {frete: frete,
      paginaOperacao: paginaOperacao,},//Dados para consulta
      //função que será executada quando a solicitação for finalizada.
      success: function (msg)
      {
         $("#lancamentos").html(msg);
      }
   });

}

function confirmarRemocaoFrete() {

   var paginaOperacao = 'removerFrete';

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
         $("#lancamentos").html(msg);
      }
   });
}

function checkAllExpedicao(checkBoxAll) {

    $('input:checkbox').not(checkBoxAll).prop('checked', checkBoxAll.checked);

}