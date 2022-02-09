var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

$(document).ready(function(){

   document.getElementById("filtroProduto").focus();

});

$("#buscaNomeProduto").keypress(function(event) {
   if (event.keyCode === 13) {
       $("#buscarProduto").click();
   }
});

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
       url: 'queryAjax/saidasProdutos.php',//Indica a página que está sendo solicitada.
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

function tabProduto() {

   var paginaOperacao = 'tabProduto';
   
   var codigoTab = document.getElementById("filtroProduto").value;
   
   $.ajax
       ({
       //Configurações
       type: 'POST',//Método que está sendo utilizado.
       dataType: 'html',//É o tipo de dado que a página vai retornar.
       url: 'queryAjax/saidasProdutos.php',//Indica a página que está sendo solicitada.
       //função que vai ser executada assim que a requisição for enviada
       data: {codigoTab: codigoTab,
       paginaOperacao: paginaOperacao,},//Dados para consulta
       //função que será executada quando a solicitação for finalizada.
       success: function (msg)
       {
           $("#lancamentos").html(msg);
       }
   });
   
   }

var inputCodigoMaterial = document.getElementById("filtroProduto");

// TAB NO INPUT PRODUTO
inputCodigoMaterial.onblur = function(){

tabProduto();

}

// INCLUIR PRODUTO
function incluirProduto(intValue) {

   document.getElementById('filtroProduto').value = intValue;
   $('#buscarProdutoModal').modal('toggle');
   
   tabProduto();

}

$("#btn-excel").click(function(e) {
   var a = document.createElement('a');
   var data_type = 'data:application/vnd.ms-excel;';
   var table_div = document.getElementById('tableId');
   var table_html = table_div.outerHTML.replace(/ /g, '%20');

   table_html = table_html.normalize('NFD').replace(/[\u0300-\u036f]/g, "");

   a.href = data_type + ', ' + table_html;
   a.download = 'RelatorioSaidasPorProdutos.xls';
   a.click();
   e.preventDefault();
});