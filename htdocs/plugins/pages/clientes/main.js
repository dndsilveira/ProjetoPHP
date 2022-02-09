var Toast = Swal.mixin({
   toast: true,
   position: 'top-end',
   showConfirmButton: false,
   timer: 3000
});

$(document).ready(function(){
   $("#addModal").on('shown.bs.modal', function () {
      document.getElementById('nome').focus();
   });
});

$("#buscaNomeCidade").keypress(function(event) {
   if (event.keyCode === 13) {
       $("#buscarCidade").click();
   }
});

// INCLUIR CIDADE
function incluirCidade(intValue) {

   document.getElementById('codigoCidade').value = intValue;
   $('#buscarCidadeModal').modal('toggle');
   document.getElementById('codigoCidade').focus();

   document.getElementById('cep').focus();
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
      url: 'queryAjax/clientes.php',//Indica a página que está sendo solicitada.
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

var inputCodigoCidade = document.getElementById("codigoCidade");

// TAB NO INPUT CIDADE
inputCodigoCidade.onblur = function(){

   var paginaOperacao = 'tabCidade';

   var codigoTab = document.getElementById("codigoCidade").value;

   $.ajax
      ({
      //Configurações
      type: 'POST',//Método que está sendo utilizado.
      dataType: 'html',//É o tipo de dado que a página vai retornar.
      url: 'queryAjax/clientes.php',//Indica a página que está sendo solicitada.
      //função que vai ser executada assim que a requisição for enviada
      data: {codigoTab: codigoTab,
      paginaOperacao: paginaOperacao,},//Dados para consulta
      //função que será executada quando a solicitação for finalizada.
      success: function (msg)
      {
         $("#lancamentosAdd").html(msg);
      }
   });

}

function abrirModalEdit() {
   $("#editModal").modal();
}

// VERIFICANDO CAMPOS PREENCHIDOS
function validaCamposClientes() {

   $("#validaCliente").submit(function(e) {

      if (!document.getElementById('nome').value || document.getElementById('nome').value == 0) {
         e.preventDefault();
            
         Toast.fire({
            icon: 'error',
            title: 'Erro ao adicionar o cliente, nenhum nome foi informado.'
         })

         document.getElementById('nome').focus();
      }

      else if (!document.getElementById('documento').value || document.getElementById('documento').value == 0 || document.getElementById('documento').value.length <= 10) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhum CPF/CNPJ foi informado.'
         })

         document.getElementById('documento').focus();

      }

      else if (!document.getElementById('rua').value || document.getElementById('rua').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhuma rua foi informada.'
         })

         document.getElementById('rua').focus();

      }

      else if (!document.getElementById('numero').value || document.getElementById('numero').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhum número foi informado.'
         })

         document.getElementById('numero').focus();

      }

      else if (!document.getElementById('bairro').value || document.getElementById('bairro').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhum bairro foi informado.'
         })

         document.getElementById('bairro').focus();

      }

      else if (!document.getElementById('codigoCidade').value || document.getElementById('codigoCidade').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhuma cidade foi informada.'
         })

         document.getElementById('codigoCidade').focus();

      }

      else if (!document.getElementById('cep').value || document.getElementById('cep').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhum CEP foi informado.'
         })

         document.getElementById('cep').focus();

      }

      else if (!document.getElementById('telefone').value || document.getElementById('telefone').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhum telefone foi informado.'
         })

         document.getElementById('telefone').focus();

      }

      else if (!document.getElementById('email').value || document.getElementById('email').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhum email foi informado.'
         })

         document.getElementById('email').focus();

      } 

   });
}

// VERIFICANDO CAMPOS PREENCHIDOS DO MODAL EDIT
function validaCamposClientesEdit() {

   $("#validaClienteEdit").submit(function(e) {

      if (!document.getElementById('nomeEdit').value || document.getElementById('nomeEdit').value == 0) {
         e.preventDefault();
            
         Toast.fire({
            icon: 'error',
            title: 'Erro ao adicionar o cliente, nenhum nome foi informado.'
         })

         document.getElementById('nomeEdit').focus();
      }

      else if (!document.getElementById('documentoEdit').value || document.getElementById('documentoEdit').value == 0 || document.getElementById('documentoEdit').value.length <= 10) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhum CPF/CNPJ foi informado.'
         })

         document.getElementById('documentoEdit').focus();

      }

      else if (!document.getElementById('ruaEdit').value || document.getElementById('ruaEdit').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhuma rua foi informada.'
         })

         document.getElementById('ruaEdit').focus();

      }

      else if (!document.getElementById('numeroEdit').value || document.getElementById('numeroEdit').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhum número foi informado.'
         })

         document.getElementById('numeroEdit').focus();

      }

      else if (!document.getElementById('bairroEdit').value || document.getElementById('bairroEdit').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhum bairro foi informado.'
         })

         document.getElementById('bairroEdit').focus();

      }

      else if (!document.getElementById('codigoCidadeEdit').value || document.getElementById('codigoCidadeEdit').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhuma cidade foi informada.'
         })

         document.getElementById('codigoCidadeEdit').focus();

      }

      else if (!document.getElementById('cepEdit').value || document.getElementById('cepEdit').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhum CEP foi informado.'
         })

         document.getElementById('cepEdit').focus();

      }

      else if (!document.getElementById('telefoneEdit').value || document.getElementById('telefoneEdit').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhum telefone foi informado.'
         })

         document.getElementById('telefoneEdit').focus();

      }

      else if (!document.getElementById('emailEdit').value || document.getElementById('emailEdit').value == 0) {
         e.preventDefault();
               
         Toast.fire({
             icon: 'error',
             title: 'Erro ao adicionar o cliente, nenhum email foi informado.'
         })

         document.getElementById('emailEdit').focus();

      } 

   });
}