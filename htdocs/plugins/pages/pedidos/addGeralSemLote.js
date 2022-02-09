var arrayMaterial = [];
var contador = 0;

var inputCodigoCliente = document.getElementById("codigoCliente");

// TAB NO INPUT CLIENTE
inputCodigoCliente.onblur = function(){

var paginaOperacao = 'tabCliente';

var codigoTab = document.getElementById("codigoCliente").value;

$.ajax
    ({
    //Configurações
    type: 'POST',//Método que está sendo utilizado.
    dataType: 'html',//É o tipo de dado que a página vai retornar.
    url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
    //função que vai ser executada assim que a requisição for enviada
    data: {codigoTab: codigoTab,
    paginaOperacao: paginaOperacao,},//Dados para consulta
    //função que será executada quando a solicitação for finalizada.
    success: function (msg)
    {
        $("#lancamentos-tab1").html(msg);
    }
});

}

var inputCodigoMaterial = document.getElementById("codigoMaterial");

// TAB NO INPUT PRODUTO
inputCodigoMaterial.onblur = function(){

var paginaOperacao = 'tabProduto';

var codigoTab = document.getElementById("codigoMaterial").value;

$.ajax
    ({
    //Configurações
    type: 'POST',//Método que está sendo utilizado.
    dataType: 'html',//É o tipo de dado que a página vai retornar.
    url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
    //função que vai ser executada assim que a requisição for enviada
    data: {codigoTab: codigoTab,
    paginaOperacao: paginaOperacao,},//Dados para consulta
    //função que será executada quando a solicitação for finalizada.
    success: function (msg)
    {
        $("#lancamentos-tab2").html(msg);
    }
});

}

var inputCodigoVendedor = document.getElementById("codigoVendedor");

// TAB NO INPUT VENDEDOR
inputCodigoVendedor.onblur = function(){

tabVendedor();

}

function tabVendedor() {

var paginaOperacao = 'tabVendedor';

var codigoTab = document.getElementById("codigoVendedor").value;

if (!document.getElementById("codigoCidadeCliente").value || document.getElementById("codigoCidadeCliente").value == 0) {
   var codigoCidade = "";
}

else {
   var codigoCidade = document.getElementById("codigoCidadeCliente").value;
}

if (!document.getElementById("codigoVendedorInterno").value || document.getElementById("codigoVendedorInterno").value == 0) {
   var vendedorInterno = 0;
}

else {
   var vendedorInterno = document.getElementById("codigoVendedorInterno").value;
}

$.ajax
   ({
   //Configurações
   type: 'POST',//Método que está sendo utilizado.
   dataType: 'html',//É o tipo de dado que a página vai retornar.
   url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
   //função que vai ser executada assim que a requisição for enviada
   data: {codigoTab: codigoTab,
   codigoCidade: codigoCidade,
   vendedorInterno: vendedorInterno,
   paginaOperacao: paginaOperacao,},//Dados para consulta
   //função que será executada quando a solicitação for finalizada.
   success: function (msg)
   {
      $("#lancamentos-tab1").html(msg);
   }
});

}

var inputCodigoVendedorInterno = document.getElementById("codigoVendedorInterno");

// TAB NO INPUT VENDEDOR INTERNO
inputCodigoVendedorInterno.onblur = function(){

tabVendedorInterno();

}

function tabVendedorInterno() {

var paginaOperacao = 'tabVendedorInterno';

if (!document.getElementById("codigoVendedorInterno").value || document.getElementById("codigoVendedorInterno").value == 0) {
   var vendedorInterno = 0;
}

else {
   var vendedorInterno = document.getElementById("codigoVendedorInterno").value;
}

if (!document.getElementById("codigoCidadeCliente").value || document.getElementById("codigoCidadeCliente").value == 0) {
   var codigoCidade = "";
}

else {
   var codigoCidade = document.getElementById("codigoCidadeCliente").value;
}

if (!document.getElementById("codigoVendedor").value || document.getElementById("codigoVendedor").value == 0) {
   var codigoTab = 0;
}

else {
   var codigoTab = document.getElementById("codigoVendedor").value;
}

if (vendedorInterno != 0) {

   $.ajax
   ({
   //Configurações
   type: 'POST',//Método que está sendo utilizado.
   dataType: 'html',//É o tipo de dado que a página vai retornar.
   url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
   //função que vai ser executada assim que a requisição for enviada
   data: {codigoTab: codigoTab,
   codigoCidade: codigoCidade,
   vendedorInterno: vendedorInterno,
   paginaOperacao: paginaOperacao,},//Dados para consulta
   //função que será executada quando a solicitação for finalizada.
   success: function (msg)
   {
      $("#lancamentos-tab1").html(msg);
   }
});

}

}

var inputCodigoCidade = document.getElementById("codigoCidadeCliente");

// TAB NO INPUT CIDADE
inputCodigoCidade.onblur = function(){

tabCidade();

}

function tabCidade() {

   var paginaOperacao = 'tabCidade';

   var codigoTab = document.getElementById("codigoCidadeCliente").value;

   $.ajax
      ({
      //Configurações
      type: 'POST',//Método que está sendo utilizado.
      dataType: 'html',//É o tipo de dado que a página vai retornar.
      url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
      //função que vai ser executada assim que a requisição for enviada
      data: {codigoTab: codigoTab,
      paginaOperacao: paginaOperacao,},//Dados para consulta
      //função que será executada quando a solicitação for finalizada.
      success: function (msg)
      {
         $("#lancamentos-tab1").html(msg);
      }
   });

}

var inputCodigoPrazoPagamento = document.getElementById("prazoPagamento");

// TAB NO PRAZO PAGAMENTO
inputCodigoPrazoPagamento.onblur = function(){

tabPrazoPagamento();

}

function tabPrazoPagamento() {

var paginaOperacao = 'tabPrazoPagamento';

var codigoTab = document.getElementById("prazoPagamento").value;

$.ajax
    ({
    //Configurações
    type: 'POST',//Método que está sendo utilizado.
    dataType: 'html',//É o tipo de dado que a página vai retornar.
    url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
    //função que vai ser executada assim que a requisição for enviada
    data: {codigoTab: codigoTab,
    paginaOperacao: paginaOperacao,},//Dados para consulta
    //função que será executada quando a solicitação for finalizada.
    success: function (msg)
    {
        $("#lancamentos-tab2").html(msg);
    }
});

}

var inputCodigoTipoPagamento = document.getElementById("tipoPagamento");

// TAB NO INPUT TIPO PAGAMENTO
inputCodigoTipoPagamento.onblur = function(){

tabTipoPagamento();

}

function tabTipoPagamento() {

var paginaOperacao = 'tabTipoPagamento';

var codigoTab = document.getElementById("tipoPagamento").value;

$.ajax
    ({
    //Configurações
    type: 'POST',//Método que está sendo utilizado.
    dataType: 'html',//É o tipo de dado que a página vai retornar.
    url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
    //função que vai ser executada assim que a requisição for enviada
    data: {codigoTab: codigoTab,
    paginaOperacao: paginaOperacao,},//Dados para consulta
    //função que será executada quando a solicitação for finalizada.
    success: function (msg)
    {
        $("#lancamentos-tab2").html(msg);
    }
});

}

var inputCodigoBanco = document.getElementById("bancoPagamento");

// TAB NO INPUT BANCO
inputCodigoBanco.onblur = function(){

tabBancoPagamento()

}

function tabBancoPagamento() {

var paginaOperacao = 'tabBanco';

var codigoTab = document.getElementById("bancoPagamento").value;

$.ajax
    ({
    //Configurações
    type: 'POST',//Método que está sendo utilizado.
    dataType: 'html',//É o tipo de dado que a página vai retornar.
    url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
    //função que vai ser executada assim que a requisição for enviada
    data: {codigoTab: codigoTab,
    paginaOperacao: paginaOperacao,},//Dados para consulta
    //função que será executada quando a solicitação for finalizada.
    success: function (msg)
    {
        $("#lancamentos-tab2").html(msg);
    }
});

}

var inputUnitario = document.getElementById("unitarioMaterial");

// TAB NO INPUT UNITARIO
inputUnitario.onblur = function(){

   var paginaOperacao = 'aplicarDescontoReais';

   var unitario = parseFloat((document.getElementById("unitarioMaterial").value).toString().replace(",", "."));

   var codigo = document.getElementById("codigoMaterial").value;

   if (unitario || unitario != "") {

      if (unitario > 0) {

         $.ajax
            ({
            //Configurações
            type: 'POST',//Método que está sendo utilizado.
            dataType: 'html',//É o tipo de dado que a página vai retornar.
            url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
            //função que vai ser executada assim que a requisição for enviada
            data: {unitario: unitario,
            codigo: codigo,
            paginaOperacao: paginaOperacao,},//Dados para consulta
            //função que será executada quando a solicitação for finalizada.
            success: function (msg)
            {
               $("#lancamentos-tab2").html(msg);
            }
         });

      }

   }
   
}

var inputQuantidade = document.getElementById("quantidadeMaterial");

// TAB NO INPUT QUANTIDADE
inputQuantidade.onblur = function(){
    
   validaQuantidade(0);
    
}

function validaQuantidade(intValue){

    var operacao = intValue;
    
    var valorUnitario = parseFloat((document.getElementById("unitarioMaterial").value).toString().replace(",", "."));
    var valorQuantidade = parseFloat((document.getElementById("quantidadeMaterial").value).toString().replace(",", "."));
    var codigoTab = document.getElementById("codigoMaterial").value;

    if (valorUnitario == 0 || valorQuantidade == 0 || !valorUnitario || !valorQuantidade) {
        document.getElementById("totalMaterial").value = 0;
    }

    else {
        document.getElementById("totalMaterial").value = ((valorUnitario*valorQuantidade).toFixed(2)).toString().replace(".", ",");
    }

    if (codigoTab != 0 && codigoTab > 0 && codigoTab != null) {

        var paginaOperacao = 'tabQuantidade';

        $.ajax
            ({
            //Configurações
            type: 'POST',//Método que está sendo utilizado.
            dataType: 'html',//É o tipo de dado que a página vai retornar.
            url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
            //função que vai ser executada assim que a requisição for enviada
            data: {codigoTab: codigoTab,
            valorQuantidade: valorQuantidade,
            operacao: operacao,
            paginaOperacao: paginaOperacao,},//Dados para consulta
            //função que será executada quando a solicitação for finalizada.
            success: function (msg)
            {
                $("#lancamentos-tab2").html(msg);
            }
        });

    }
    
}

// EXCLUIR PRODUTO
function excluirProduto(intValue) {

   var paginaOperacao = 'excluirProduto';

   var indiceArray = intValue;
   
   var total = 0.00;

   for (var i = 0; i < arrayMaterial.length; i++) {

      if (i != indiceArray) {
         total = parseFloat(total) + parseFloat(arrayMaterial[i]['total']);
      }

   }
   
   if (arrayMaterial[indiceArray]['codigo'] != null || arrayMaterial[indiceArray]['codigo'] != false || arrayMaterial[indiceArray]['codigo'] != "") {      

      arrayMaterial.splice(indiceArray, 1);
      contador--;

   }

   $.ajax
      ({
      //Configurações
      type: 'POST',//Método que está sendo utilizado.
      dataType: 'html',//É o tipo de dado que a página vai retornar.
      url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
      //função que vai ser executada assim que a requisição for enviada
      data: {indiceArray: indiceArray,
      total: total,
      arrayMaterial: arrayMaterial,
      paginaOperacao: paginaOperacao,},//Dados para consulta
      //função que será executada quando a solicitação for finalizada.
      success: function (msg)
      {
         $("#table").html(msg);
      }
   });
}

// VERIFICA OS PRODUTOS E MANDA PRA EXPEDIÇÃO
function verificaCamposPedido() {

    if (arrayMaterial.length == 0) {
 
       Toast.fire({
          icon: 'error',
          title: 'Erro ao salvar o orçamento, nenhum produto foi informado.'
       })
 
       if(document.getElementById('pills-profile').classList.contains("active")){
          $('#pills-tab a[href="#pills-home"]').tab('dispose');
       }
 
       else {
          $('#pills-tab a[href="#pills-profile"]').tab('show');
       }
 
       document.getElementById('codigoMaterial').focus();
 
    }
 
    else {
 
       var paginaOperacao = 'abrirExpedicao';
 
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
             $("#lancamentos-tab2").html(msg);
          }
       });
 
       $("#expedicaoModal").modal();
 
    }
 
 }
 
// CONFIRMA O PEDIDO
function confirmaExpedicao() {
 
    var contadorErros = 0;
 
    if (!document.getElementById('codigoCidadeCliente').value || document.getElementById('codigoCidadeCliente').value == 0) {
             
       Toast.fire({
          icon: 'error',
          title: 'Erro ao salvar o orçamento, nenhuma cidade foi informada.'
       })
 
       if(document.getElementById('pills-home').classList.contains("active")){
          $('#pills-tab a[href="#pills-profile"]').tab('dispose');
       }
 
       else {
          $('#pills-tab a[href="#pills-home"]').tab('show');
       }
 
       document.getElementById('codigoCidadeCliente').focus();
 
       contadorErros++;
    }
 
    else if (!document.getElementById('codigoVendedor').value || document.getElementById('codigoVendedor').value == 0) {
       
       Toast.fire({
          icon: 'error',
          title: 'Erro ao salvar o orçamento, nenhum vendedor foi informado.'
       })
 
       if(document.getElementById('pills-home').classList.contains("active")){
          $('#pills-tab a[href="#pills-profile"]').tab('dispose');
       }
 
       else {
          $('#pills-tab a[href="#pills-home"]').tab('show');
       }
 
       document.getElementById('codigoVendedor').focus();
 
       contadorErros++;
    }
 
    else if (arrayMaterial.length == 0) {
 
       Toast.fire({
          icon: 'error',
          title: 'Erro ao salvar o orçamento, nenhum produto foi informado.'
       })
 
       if(document.getElementById('pills-profile').classList.contains("active")){
          $('#pills-tab a[href="#pills-home"]').tab('dispose');
       }
 
       else {
          $('#pills-tab a[href="#pills-profile"]').tab('show');
       }
 
       document.getElementById('codigoMaterial').focus();
 
       contadorErros++;
    }
 
    else if (contadorErros == 0) {

        var paginaOperacao = 'salvarDadosCarrinho';
 
       if (!document.getElementById('codigoCliente').value) {
          var codigoCliente = 0;
          var nomeCliente = "CONSUMIDOR"
       }
 
       else {
          var codigoCliente = document.getElementById('codigoCliente').value;
          var nomeCliente = document.getElementById('nomeCliente').value;
       }
 
       if (!document.getElementById('enderecoCliente').value) {
          var enderecoCliente = "";
       }
 
       else {
          var enderecoCliente = document.getElementById('enderecoCliente').value;
       }
 
       if (!document.getElementById('bairroCliente').value) {
          var bairroCliente = "";
       }
 
       else {
          var bairroCliente = document.getElementById('bairroCliente').value;
       }
 
       if (!document.getElementById('codigoCidadeCliente').value) {
          var codigoCidadeCliente = "";
       }
 
       else {
          var codigoCidadeCliente = document.getElementById('codigoCidadeCliente').value;
       }
 
       if (!document.getElementById('nomeCidadeCliente').value) {
          var nomeCidadeCliente = "";
       }
 
       else {
          var nomeCidadeCliente = document.getElementById('nomeCidadeCliente').value;
       }
 
       if (!document.getElementById('CEPCliente').value) {
          var CEPCliente = "";
       }
 
       else {
          var CEPCliente = document.getElementById('CEPCliente').value;
       }
 
       if (!document.getElementById('estadoCliente').value) {
          var estadoCliente = "";
       }
 
       else {
          var estadoCliente = document.getElementById('estadoCliente').value;
       }
 
       if (!document.getElementById('documentoCliente').value) {
          var documentoCliente = "";
       }
 
       else {
          var documentoCliente = document.getElementById('documentoCliente').value;
       }
 
       if (!document.getElementById('inscricaoCliente').value) {
          var inscricaoCliente = "";
       }
 
       else {
          var inscricaoCliente = document.getElementById('inscricaoCliente').value;
       }
 
       if (!document.getElementById('codigoVendedor').value) {
          var codigoVendedor = "";
       }
 
       else {
          var codigoVendedor = document.getElementById('codigoVendedor').value;
       }
 
       if (!document.getElementById('comissaoVendedor').value) {
          var comissao = 0;
       }
 
       else {
          var comissao = document.getElementById("comissaoVendedor").value;
          comissao = comissao.substring(0, comissao.length - 1);
          comissao = parseFloat((comissao).toString().replace(",", "."));
       }
 
       if (!document.getElementById('codigoVendedorInterno').value) {
          var codigoVendedorInterno = 0;
       }
 
       else {
          var codigoVendedorInterno = document.getElementById('codigoVendedorInterno').value;
       }
 
       if (!document.getElementById('comissaoVendedorInterno').value) {
          var comissaoInterno = 0;
       }
 
       else {
          var comissaoInterno = document.getElementById("comissaoVendedorInterno").value;
          comissaoInterno = comissaoInterno.substring(0, comissaoInterno.length - 1);
          comissaoInterno = parseFloat((comissaoInterno).toString().replace(",", "."));
       }
 
       if (!document.getElementById('prazoPagamento').value) {
          var prazoPagamento = "";
       }
 
       else {
          var prazoPagamento = document.getElementById('prazoPagamento').value;
       }
 
       if (!document.getElementById('tipoPagamento').value) {
          var tipoPagamento = "";
       }
 
       else {
          var tipoPagamento = document.getElementById('tipoPagamento').value;
       }
 
       if (!document.getElementById('bancoPagamento').value) {
          var bancoPagamento = "";
       }
 
       else {
          var bancoPagamento = document.getElementById('bancoPagamento').value;
       }
 
       if (!document.getElementById('descontoOrcamento').value) {
          var desconto = 0;
       }
 
       else {
          var desconto = document.getElementById('descontoOrcamento').value;
       }
 
       if (!document.getElementById('acrescimoOrcamento').value) {
          var acrescimo = 0;
       }
 
       else {
          var acrescimo = document.getElementById('acrescimoOrcamento').value;
       }
 
       if (!document.getElementById('freteOrcamento').value) {
          var frete = 0;
       }
 
       else {
          var frete = document.getElementById('freteOrcamento').value;
       }
       
       if (!document.getElementById('observacoes').value) {
          var observacoes = "";
       }
 
       else {
          var observacoes = document.getElementById('observacoes').value;
       }

        arrayExpedicao = [];

        for (var i = 0; i < arrayMaterial.length; i++) {

            if (document.getElementById("checkExpedicao"+i).checked) {

                arrayExpedicao.push({
                    statusExpedicao: document.getElementById("statusExpedicao"+i).options[document.getElementById("statusExpedicao"+i).selectedIndex].value,
                    dataExpedicao: document.getElementById("dataExpedicao"+i).value,
                });

            }

            else {
                
                arrayExpedicao.push({
                    statusExpedicao: "",
                    dataExpedicao: "",
                });

            }

        }

        var observacoesExpedicao = document.getElementById("observacoesExpedicao").value;
 
        $.ajax
            ({
            //Configurações
            type: 'POST',//Método que está sendo utilizado.
            dataType: 'html',//É o tipo de dado que a página vai retornar.
            url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
            //função que vai ser executada assim que a requisição for enviada
            data: {arrayExpedicao: arrayExpedicao,
            observacoesExpedicao: observacoesExpedicao,
            codigoCliente: codigoCliente,
            nomeCliente: nomeCliente,
            enderecoCliente: enderecoCliente,
            bairroCliente: bairroCliente,
            codigoCidadeCliente: codigoCidadeCliente,
            nomeCidadeCliente: nomeCidadeCliente,
            estadoCliente: estadoCliente,
            CEPCliente: CEPCliente,
            documentoCliente: documentoCliente,
            inscricaoCliente: inscricaoCliente,
            codigoVendedor: codigoVendedor,
            comissao: comissao,
            codigoVendedorInterno: codigoVendedorInterno,
            comissaoInterno: comissaoInterno,
            prazoPagamento: prazoPagamento,
            tipoPagamento: tipoPagamento,
            observacoes: observacoes,
            desconto: desconto,
            acrescimo: acrescimo,
            frete: frete,
            bancoPagamento: bancoPagamento,
            paginaOperacao: paginaOperacao,},//Dados para consulta
            //função que será executada quando a solicitação for finalizada.
            success: function (msg)
            {
                $("#lancamentos-tab2").html(msg);
            }
        });
    }
 }

// BOTÃO LANÇAR
function adicionarProduto(operacao) {

    var liberouEmbalagemMaterial = operacao;

    var paginaOperacao = 'lancarProduto';
    
    var codigoMaterial = document.getElementById('codigoMaterial').value;
    var nomeMaterial = document.getElementById('nomeMaterial').value;
    var quantidadeMaterial = parseFloat((document.getElementById("quantidadeMaterial").value).toString().replace(",", "."));
    var unitarioMaterial = parseFloat((document.getElementById("unitarioMaterial").value).toString().replace(",", "."));
    var total = 0;

    if (!codigoMaterial | codigoMaterial <= 0) {
        Toast.fire({
        icon: 'error',
        title: 'Código do produto inválido, por favor insira um código.'
        })
        document.getElementById('codigoMaterial').focus();
    }

    else {
        if (!quantidadeMaterial | quantidadeMaterial <= 0) {
            Toast.fire({
            icon: 'error',
            title: 'Quantidade inválida, por favor insira uma quantidade.'
            })
            document.getElementById('quantidadeMaterial').focus();
        }
        
        else {
    
            if (!unitarioMaterial | unitarioMaterial <= 0) {
                Toast.fire({
                icon: 'error',
                title: 'Valor unitário inválido, por favor insira um valor.'
                })
                document.getElementById('unitarioMaterial').focus();
            }
    
            else {
                        
                if (!liberouEmbalagemMaterial) {
                validaQuantidade(1);
                return false;
                }

                if (liberouEmbalagemMaterial) {
                    for (var i = 0; i < arrayMaterial.length; i++) {
                        if (arrayMaterial[i]['codigo'] == (parseInt(codigoMaterial))) {
                            Toast.fire({
                                icon: 'warning',
                                title: 'Atenção, este código já está inserido na lista.'
                            })
                        }
                    }
            
                    contador++;
                
                    arrayMaterial.push({
                        codigo: parseInt(codigoMaterial),
                        nome: nomeMaterial,
                        quantidade: quantidadeMaterial,
                        unitario: unitarioMaterial,
                        tabela: unitarioMaterial,
                        total: (quantidadeMaterial*unitarioMaterial),
                    });

                    for (var i = 0; i < arrayMaterial.length; i++) {
                        total = total + arrayMaterial[i]['total'];
                    }

                    document.getElementById('total').value = "R$" + ((parseFloat(total).toFixed(2)).toString().replace(".", ","));
            
                    $.ajax
                    ({
                        //Configurações
                        type: 'POST',//Método que está sendo utilizado.
                        dataType: 'html',//É o tipo de dado que a página vai retornar.
                        url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
                        //função que vai ser executada assim que a requisição for enviada
                        data: {codigoMaterial: codigoMaterial,
                        contador: contador,
                        arrayMaterial: arrayMaterial,
                        paginaOperacao: paginaOperacao,},//Dados para consulta
                        //função que será executada quando a solicitação for finalizada.
                        success: function (msg)
                        {
                            $("#table").html(msg);
                        }
                    });
                }

                else {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Atenção, quantidade do produto inválida ou necessita de liberação.'
                    })
                }

            }
        }
    }
}

function confirmaResetOrcamento() {

    $(function(){
        $('#confirmarResetModal').modal();
    });

}

function confirmaIncluirOrcamento(intValue) {

    $('#buscarPedidoModal').modal('hide');

    $('#confirmarIncluirOrcamentoModal').modal();

    document.getElementById('incluir-id').value = intValue;

}

function incluirOrcamento(intValue) {

    $('#confirmarIncluirOrcamentoModal').modal('hide');

    var paginaOperacao = 'trocarCarrinho';

    var orcamentoIncluir = intValue;

    $.ajax
    ({
        //Configurações
        type: 'POST',//Método que está sendo utilizado.
        dataType: 'html',//É o tipo de dado que a página vai retornar.
        url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
        //função que vai ser executada assim que a requisição for enviada
        data: {orcamentoIncluir: orcamentoIncluir,
        paginaOperacao: paginaOperacao,},//Dados para consulta
        //função que será executada quando a solicitação for finalizada.
        success: function (msg)
        {
            $("#lancamentos").html(msg);
        }
    });
}

function alteraQuantidadeSugestao(floatValue) {

    document.getElementById("quantidadeMaterial").value = ((floatValue).toFixed(2)).toString().replace(".", ",");

    $('#sugestaoModal').modal('hide');

    document.getElementById("unitarioMaterial").focus();

}

function novoOrcamento() {

    var paginaOperacao = 'resetCarrinho';

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
            $("#table").html(msg);
        }
    });
    
}

function limpaCamposPedido() {

    var paginaOperacao = 'resetCarrinho';

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
            $("#table").html(msg);
        }
    });

}

function validaEmbalagemMaterialUsuario() {

    var paginaOperacao = 'validaEmbalagemMaterial';

    var nome = document.getElementById('validaEmbalagemMaterialUsuario').value;
    var senha = document.getElementById('validaEmbalagemMaterialSenha').value;

    if (!nome) {
        Toast.fire({
            icon: 'warning',
            title: 'Falha ao acessar, preencha seus dados corretamente.'
        })
        document.getElementById('validaEmbalagemMaterialUsuario').focus();
    }

    else {
        if (!senha) {
            Toast.fire({
                icon: 'warning',
                title: 'Falha ao acessar, preencha seus dados corretamente.'
            })
            document.getElementById('validaEmbalagemMaterialSenha').focus();
        }

        else {
            $.ajax
            ({
                //Configurações
                type: 'POST',//Método que está sendo utilizado.
                dataType: 'html',//É o tipo de dado que a página vai retornar.
                url: 'queryAjax/pedidos.php',//Indica a página que está sendo solicitada.
                //função que vai ser executada assim que a requisição for enviada
                data: {nome: nome,
                senha: senha,
                paginaOperacao: paginaOperacao,},//Dados para consulta
                //função que será executada quando a solicitação for finalizada.
                success: function (msg)
                {
                    $("#lancamentos-tab2").html(msg);
                }
            });
        }
    }

}