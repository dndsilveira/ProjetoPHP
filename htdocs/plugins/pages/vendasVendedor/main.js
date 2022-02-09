var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

$(document).ready(function(){
   $("#buscarVariosVendedoresModal").on('shown.bs.modal', function () {
      buscarVendedoresEmpresa();
   });
});

// INCLUIR EMPRESA MODAL
function incluirEmpresaModal(intValue) {

   document.getElementById('filtroModalEmpresa').value = intValue;
   $('#buscarEmpresaModal').modal('toggle');
   document.getElementById('filtroModalEmpresa').focus();

   document.getElementById('btn-filtrarEmpresaModal').focus();
}

// BUSCAR VENDEDORES POR EMPRESA
function buscarVendedoresEmpresa() {

   var paginaOperacao = 'buscarVendedoresEmpresa';
   
   var empresa = document.getElementById("filtroModalEmpresa").value;
   
   if (!empresa) {
      empresa = 0;
   }
   
   $.ajax
   ({
       //Configurações
       type: 'POST',//Método que está sendo utilizado.
       dataType: 'html',//É o tipo de dado que a página vai retornar.
       url: 'queryAjax/vendasVendedor.php',//Indica a página que está sendo solicitada.
       //função que vai ser executada assim que a requisição for enviada
       data: {empresa: empresa,
       paginaOperacao: paginaOperacao,},//Dados para consulta
       //função que será executada quando a solicitação for finalizada.
       success: function (msg)
       {
           $("#buscarVendedoresEmpresaTable").html(msg);
       }
   });
}

var tabModalEmpresa = document.getElementById("filtroModalEmpresa");

// TAB NO INPUT VENDEDOR
tabModalEmpresa.onblur = function(){

   var paginaOperacao = 'tabModalEmpresa';

   var codigoTab = document.getElementById("filtroModalEmpresa").value;

   $.ajax
      ({
      //Configurações
      type: 'POST',//Método que está sendo utilizado.
      dataType: 'html',//É o tipo de dado que a página vai retornar.
      url: 'queryAjax/vendasVendedor.php',//Indica a página que está sendo solicitada.
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

function selecionaVendedoresFiltro() {

   var inputVendedores = "";
   arrayVendedores = [];

   $("input:checked").each(function(){
      if (($(this).attr("id")) != undefined && ($(this).attr("id")) != false && ($(this).attr("id")) && ($(this).is(":checked"))) {
         if (($(this).attr("id")) != "checkAll") {
            if (!(arrayVendedores.includes(($(this).attr("id"))))) {
               arrayVendedores.push(($(this).attr("id")));
               inputVendedores = inputVendedores + (($(this).attr("id"))) + ", ";
            }
         }
      }
   });

   inputVendedores = inputVendedores.substring(0, inputVendedores.length-2);
   
   document.getElementById('filtroVendedor').value = inputVendedores;
}

$("#checkAll").click(function(){
  $('input:checkbox').not(this).prop('checked', this.checked);
});

$("#btn-excel").click(function(e) {
   var a = document.createElement('a');
   var data_type = 'data:application/vnd.ms-excel;';
   var table_div = document.getElementById('tableId');
   var table_html = table_div.outerHTML.replace(/ /g, '%20');

   table_html = table_html.normalize('NFD').replace(/[\u0300-\u036f]/g, "");

   a.href = data_type + ', ' + table_html;
   a.download = 'RelatorioVendasNotaANotaPorVendedor.xls';
   a.click();
   e.preventDefault();
});