<?php

session_start();

$titulo = 'Erro 404';

$arquivo = 'erro404';

require '../app/config.php';

// VERIFICAÇÕES INICIAIS

require '../app/verif.php';

// FORMULÁRIOS

require '../app/forms.php';

// FUNCTIONS

include_once '../app/functions.php';

// MODAL
require '../app/modals.php';

// ALL MODALS
require '../app/allModals.php';

// HEADER
require '../app/navbar.php';

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Página não encontrada.</h3>

          <p>
            Não conseguimos encontrar a página que você procura.
            Volte para o início clicando <a href="index.php">aqui</a>.
          </p>

        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php 

// FOOTER
require '../app/footer.php';

?>