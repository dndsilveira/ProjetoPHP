<?php

session_start();

require '../app/config.php';

// VERIFICAÇÕES INICIAIS

require '../app/verif.php';

// FORMULÁRIOS

require '../app/forms.php';

// FUNCTIONS

include_once '../app/functions.php';

// PÁGINAS

switch ($pag) {

   case '':

      $titulo = 'Home';

      $arquivo = 'home';

      // HEADER
      require '../app/navbar.php';

      // MODAL
      require '../app/modals.php';

      // ALL MODALS
      require '../app/allModals.php';

      // PÁGINA
      require '../app/pages/home.php';

      // FOOTER
      require '../app/footer.php';

   break;

   case 'index':

      $titulo = 'Home';

      $arquivo = 'home';

      // HEADER
      require '../app/navbar.php';

      // MODAL
      require '../app/modals.php';

      // ALL MODALS
      require '../app/allModals.php';

      // PÁGINA
      require '../app/pages/home.php';

      // FOOTER
      require '../app/footer.php';

   break;

   case 'home':

      $titulo = 'Home';

      $arquivo = 'home';

      // HEADER
      require '../app/navbar.php';

      // MODAL
      require '../app/modals.php';

      // ALL MODALS
      require '../app/allModals.php';

      // PÁGINA
      require '../app/pages/home.php';

      // FOOTER
      require '../app/footer.php';

   break;

   case 'pedidos':

      $titulo = 'Pedidos';

      $arquivo = 'pedidos';

      // HEADER
      require '../app/navbar.php';

      // MODAL
      require '../app/modals.php';

      // ALL MODALS
      require '../app/allModals.php';

      // PÁGINA
      require '../app/pages/pedidos.php';

      // FOOTER
      require '../app/footer.php';

   break;

   case 'produtos':

      $titulo = 'Preços e estoque';

      $arquivo = 'produtos';

      // HEADER
      require '../app/navbar.php';

      // MODAL
      require '../app/modals.php';

      // ALL MODALS
      require '../app/allModals.php';

      // PÁGINA
      require '../app/pages/produtos.php';

      // FOOTER
      require '../app/footer.php';

   break;

   case 'saidasprodutos':

      $titulo = 'Saídas por produtos';

      $arquivo = 'saidasprodutos';

      // HEADER
      require '../app/navbar.php';

      // MODAL
      require '../app/modals.php';

      // ALL MODALS
      require '../app/allModals.php';

      // PÁGINA
      require '../app/pages/saidasProdutos.php';

      // FOOTER
      require '../app/footer.php';

   break;

   case 'promocoes':

      $titulo = 'Produtos em promoção';

      $arquivo = 'promocoes';

      // HEADER
      require '../app/navbar.php';

      // MODAL
      require '../app/modals.php';

      // ALL MODALS
      require '../app/allModals.php';

      // PÁGINA
      require '../app/pages/promocoes.php';

      // FOOTER
      require '../app/footer.php';

   break;

   case 'clientes':

      $titulo = 'Clientes';

      $arquivo = 'clientes';

      // HEADER
      require '../app/navbar.php';

      // MODAL
      require '../app/modals.php';

      // ALL MODALS
      require '../app/allModals.php';

      // PÁGINA
      require '../app/pages/clientes.php';

      // FOOTER
      require '../app/footer.php';

   break;

   case 'saidas-cliente':

      $titulo = 'Relatório de saídas por cliente';

      $arquivo = 'saidasCliente';

      // HEADER
      require '../app/navbar.php';

      // MODAL
      require '../app/modals.php';

      // ALL MODALS
      require '../app/allModals.php';

      // PÁGINA
      require '../app/pages/saidasClientes.php';

      // FOOTER
      require '../app/footer.php';

   break;

   /*

   case 'debitoscliente':

      $titulo = 'Débitos por cliente';

      $arquivo = 'debitosCliente';

      // HEADER
      require '../app/navbar.php';

      // MODAL
      require '../app/modals.php';

      // ALL MODALS
      require '../app/allModals.php';

      // PÁGINA
      require '../app/pages/debitosClientes.php';

      // FOOTER
      require '../app/footer.php';

   break;

   */

   /*

   case 'vendas-vendedor':

      $titulo = 'Relatório de vendas nota a nota por vendedor';

      $arquivo = 'vendasVendedor';

      // HEADER
      require '../app/navbar.php';

      // MODAL
      require '../app/modals.php';

      // ALL MODALS
      require '../app/allModals.php';

      // PÁGINA
      require '../app/pages/vendasVendedor.php';

      // FOOTER
      require '../app/footer.php';

   break;

   */

   case 'grafico-ticketmedio':

      $titulo = 'Gráfico de ticket médio mês a mês';

      $arquivo = 'graficoTicketMedio';

      // HEADER
      require '../app/navbar.php';

      // MODAL
      require '../app/modals.php';

      // ALL MODALS
      require '../app/allModals.php';

      // PÁGINA
      require '../app/pages/graficoTicketMedio.php';

      // FOOTER
      require '../app/footer.php';

   break;

   /*

   case 'recebimentos':

      $titulo = 'Recebimentos';

      $arquivo = 'recebimentos';

      // HEADER
      require '../app/navbar.php';

      // MODAL
      require '../app/modals.php';

      // ALL MODALS
      require '../app/allModals.php';

      // PÁGINA
      require '../app/pages/recebimentos.php';

      // FOOTER
      require '../app/footer.php';

   break;

   */

   default:

      header("Location: 404.php");

   break;

}

?>