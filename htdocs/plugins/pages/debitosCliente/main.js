var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

$(document).ready(function(){

   document.getElementById("filtroCliente").focus();

});

$("#buscaNomeCliente").keypress(function(event) {
   if (event.keyCode === 13) {
      $("#buscarCliente").click();
   }
});

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
      url: 'queryAjax/debitosCliente.php',//Indica a página que está sendo solicitada.
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

// INCLUIR CLIENTE
function incluirCliente(intValue) {

   document.getElementById('filtroCliente').value = intValue;
   $('#buscarClienteModal').modal('toggle');
   
   tabCliente();
   
}

var inputCodigoCliente = document.getElementById("filtroCliente");

// TAB NO INPUT CLIENTE
inputCodigoCliente.onblur = function(){

tabCliente();

}

function tabCliente() {

var paginaOperacao = 'tabCliente';

var codigoTab = document.getElementById("filtroCliente").value;

$.ajax
   ({
   //Configurações
   type: 'POST',//Método que está sendo utilizado.
   dataType: 'html',//É o tipo de dado que a página vai retornar.
   url: 'queryAjax/debitosCliente.php',//Indica a página que está sendo solicitada.
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

$("#btn-excel").click(function(e) {
   var a = document.createElement('a');
   var data_type = 'data:application/vnd.ms-excel;';
   var table_div = document.getElementById('tableId');
   var table_html = table_div.outerHTML.replace(/ /g, '%20');

   table_html = table_html.normalize('NFD').replace(/[\u0300-\u036f]/g, "");

   a.href = data_type + ', ' + table_html;
   a.download = 'RelatorioDebitosPorCliente.xls';
   a.click();
   e.preventDefault();
});