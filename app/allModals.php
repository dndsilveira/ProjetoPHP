<script>
$(document).ready(function(){
  $("#buscarClienteModal").on('shown.bs.modal', function () {
   document.getElementById('buscaNomeCliente').focus();
  });

  $("#buscarProdutoModal").on('shown.bs.modal', function () {
   document.getElementById('buscaNomeProduto').focus();
  });

  $("#buscarCidadeModal").on('shown.bs.modal', function () {
   document.getElementById('buscaNomeCidade').focus();
  });

  $("#buscarVariosVendedoresModal").on('shown.bs.modal', function () {
   document.getElementById('filtroModalEmpresa').focus();
  });

  $("#buscarVendedorModal").on('shown.bs.modal', function () {
   document.getElementById('buscaNomeVendedor').focus();
  });

  $("#buscarVendedorInternoModal").on('shown.bs.modal', function () {
   document.getElementById('buscaNomeVendedorInterno').focus();
  });

  $("#buscarPrazoPagamentoModal").on('shown.bs.modal', function () {
   document.getElementById('buscaNomePrazoPagamento').focus();
  });

  $("#buscarTipoPagamentoModal").on('shown.bs.modal', function () {
   document.getElementById('buscaNomeTipoPagamento').focus();
  });

  $("#buscarBancoModal").on('shown.bs.modal', function () {
   document.getElementById('buscaNomeBanco').focus();
  });

  $("#buscarLocalModal").on('shown.bs.modal', function () {
   document.getElementById('buscaNomeLocal').focus();
  });

  $("#buscarLoteModal").on('shown.bs.modal', function () {
   document.getElementById('buscaNomeLote').focus();
  });

  $("#buscarUsuarioModal").on('shown.bs.modal', function () {
   document.getElementById('buscaNomeUsuario').focus();
  });
});
</script>

<!-- CLIENTES -->
<div class="modal fade modal-geral" id="buscarClienteModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buscar cliente</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <?php if ($_SESSION['tema'] == 'branco') { ?>
            <div class="input-group">
            <?php } else { ?>
            <div class="input-group sidebar-dark-primary">
            <?php } ?>
              <input class="form-control form-control-sidebar inputModalBusca" name="buscaNomeCliente" id="buscaNomeCliente" type="text" placeholder="Pesquisar">
              <div class="input-group-append">
                <button class="btn btn-sidebar" id="buscarCliente" onclick="buscarCliente()">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="row modal-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="text-center">
                  <th>Código</th>
                  <th>Nome</th>
                  <th>CPF/CNPJ</th>
                  <th>Cidade</th>
                  <th>UF</th>
                  <th>Telefone</th>
                  <th>Apelido</th>
                  <th style="width: 25%">Ações</th>
                </tr>
              </thead>
              <tbody id="buscarClienteTable">

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
<!-- PRODUTOS -->
<div class="modal fade modal-geral" id="buscarProdutoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buscar produto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <?php if ($_SESSION['tema'] == 'branco') { ?>
            <div class="input-group">
            <?php } else { ?>
            <div class="input-group sidebar-dark-primary">
            <?php } ?>
              <input class="form-control form-control-sidebar inputModalBusca" name="buscaNomeProduto" id="buscaNomeProduto" type="text" placeholder="Pesquisar">
              <div class="input-group-append">
                <button class="btn btn-sidebar" id="buscarProduto" onclick="buscarProduto()">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="row modal-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="text-center">
                  <th style="width: 15%">Código</th>
                  <th>Nome</th>
                  <th>Estoque</th>
                  <th style="width: 25%">Ações</th>
                </tr>
              </thead>
              <tbody id="buscarProdutoTable">

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
<!-- VENDEDORES -->
<div class="modal fade modal-geral" id="buscarVendedorModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buscar vendedor</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <?php if ($_SESSION['tema'] == 'branco') { ?>
            <div class="input-group">
            <?php } else { ?>
            <div class="input-group sidebar-dark-primary">
            <?php } ?>
              <input class="form-control form-control-sidebar inputModalBusca" name="buscaNomeVendedor" id="buscaNomeVendedor" type="text" placeholder="Pesquisar">
              <div class="input-group-append">
                <button class="btn btn-sidebar" id="buscarVendedor" onclick="buscarVendedor()">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="row modal-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="text-center">
                  <th style="width: 15%">Código</th>
                  <th>Nome</th>
                  <th style="width: 25%">Ações</th>
                </tr>
              </thead>
              <tbody id="buscarVendedorTable">

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
<!-- VENDEDORES INTERNOS -->
<div class="modal fade modal-geral" id="buscarVendedorInternoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buscar vendedor interno</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <?php if ($_SESSION['tema'] == 'branco') { ?>
            <div class="input-group">
            <?php } else { ?>
            <div class="input-group sidebar-dark-primary">
            <?php } ?>
              <input class="form-control form-control-sidebar inputModalBusca" name="buscaNomeVendedorInterno" id="buscaNomeVendedorInterno" type="text" placeholder="Pesquisar">
              <div class="input-group-append">
                <button class="btn btn-sidebar" id="buscarVendedorInterno" onclick="buscarVendedorInterno()">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="row modal-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="text-center">
                  <th style="width: 15%">Código</th>
                  <th>Nome</th>
                  <th style="width: 25%">Ações</th>
                </tr>
              </thead>
              <tbody id="buscarVendedorInternoTable">

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
<!-- VÁRIOS VENDEDORES -->
<div class="modal fade modal-geral" id="buscarVariosVendedoresModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buscar vendedores</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <?php if ($_SESSION['tema'] == 'branco') { ?>
            <div class="input-group">
            <?php } else { ?>
            <div class="input-group sidebar-dark-primary">
            <?php } ?>
              <div class="form-group col-2 my-filtros codigo-filtro">
                <label for="filtroModalEmpresa">Empresa</label>
                <div class="input-group mb-3">
                  <input type="text" name="filtroModalEmpresa" class="form-control" id="filtroModalEmpresa" required>
                  <div class="input-group-append">
                    <span class="input-group-text" data-toggle="modal" data-target="#buscarEmpresaModal">
                      <i class="fas fa-search"></i>
                    </span>
                  </div>
                </div>
              </div>

              <div class="form-group col-2 my-filtros nome-filtro">
                <label for="nomeModalEmpresa">Nome</label>
                <div class="input-group mb-3">
                  <input type="text" name="nomeModalEmpresa" class="form-control" id="nomeModalEmpresa" disabled>
                </div>
              </div>

              <div class="form-group col-2 responsive-filtro-empresa">
                <input type="submit" class="btn btn-info filtro" id="btn-filtrarEmpresaModal "onclick="buscarVendedoresEmpresa()" name="filtraEmpresa" value="Filtrar" />
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
         <div class="card-body">
            <div class="row modal-responsive">
               <table class="table table-bordered table-hover">
                  <thead>
                     <tr class="text-center">
                        <th><input type="checkbox" id="checkAll" /></th>
                        <th style="width: 15%">Código</th>
                        <th>Nome</th>
                     </tr>
                  </thead>
                  <tbody id="buscarVendedoresEmpresaTable">

                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="selecionaVendedoresFiltro()">Confirmar</button>
      </div>
    </div>
  </div>
</div>
<!-- EMPRESAS -->
<div class="modal fade modal-geral" id="buscarEmpresaModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buscar empresa</h4>
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
                     <th style="width: 15%">Código</th>
                     <th>Razão social</th>
                     <th>Abreviação</th>
                     <th style="width: 20%">CNPJ</th>
                     <th style="width: 15%">Ações</th>
                  </tr>
               </thead>
               <tbody id="buscarEmpresaTable">
                  <?php

                  $sql = $pdo->prepare("SELECT Codigo, Nome, Abreviatura, CNPJ FROM empresa ORDER BY Codigo ASC");
                  $sql->execute();

                  foreach ($sql->fetchAll() as $modalEmpresa) {

                     echo "
                     <tr class='text-center'>
                        <td>".$modalEmpresa['Codigo']."</td>
                        <td>".$modalEmpresa['Nome']."</td>
                        <td>".$modalEmpresa['Abreviatura']."</td>
                        <td>".$modalEmpresa['CNPJ']."</td>

                        <td class='project-actions' style='width: 15%;'>
                          <a class='btn btn-success btn-sm' onclick='incluirEmpresaModal(".$modalEmpresa['Codigo'].")'><i class='fas fa-plus'></i> Selecionar</a>
                        </td>   
                     </tr>";

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
    </div>
  </div>
</div>
<!-- CIDADES -->
<div class="modal fade modal-geral" id="buscarCidadeModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buscar cidade</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <?php if ($_SESSION['tema'] == 'branco') { ?>
            <div class="input-group">
            <?php } else { ?>
            <div class="input-group sidebar-dark-primary">
            <?php } ?>
              <input class="form-control form-control-sidebar inputModalBusca" name="buscaNomeCidade" id="buscaNomeCidade" type="text" placeholder="Pesquisar">
              <div class="input-group-append">
                <button class="btn btn-sidebar" id="buscarCidade" onclick="buscarCidade()">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="row modal-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="text-center">
                  <th style="width: 15%">Código</th>
                  <th>Nome</th>
                  <th>Estado</th>
                  <th style="width: 25%">Ações</th>
                </tr>
              </thead>
              <tbody id="buscarCidadeTable">

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
<!-- PRAZO DE PAGAMENTO -->
<div class="modal fade modal-geral" id="buscarPrazoPagamentoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buscar prazo de pagamento</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <?php if ($_SESSION['tema'] == 'branco') { ?>
            <div class="input-group">
            <?php } else { ?>
            <div class="input-group sidebar-dark-primary">
            <?php } ?>
              <input class="form-control form-control-sidebar inputModalBusca" name="buscaNomePrazoPagamento" id="buscaNomePrazoPagamento" type="text" placeholder="Pesquisar">
              <div class="input-group-append">
                <button class="btn btn-sidebar" id="buscarPrazoPagamento" onclick="buscarPrazoPagamento()">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="row modal-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="text-center">
                  <th style="width: 15%">Código</th>
                  <th>Descrição</th>
                  <th style="width: 25%">Ações</th>
                </tr>
              </thead>
              <tbody id="buscarPrazoPagamentoTable">

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
<!-- TIPO DE PAGAMENTO -->
<div class="modal fade modal-geral" id="buscarTipoPagamentoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buscar tipo de pagamento</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <?php if ($_SESSION['tema'] == 'branco') { ?>
            <div class="input-group">
            <?php } else { ?>
            <div class="input-group sidebar-dark-primary">
            <?php } ?>
              <input class="form-control form-control-sidebar inputModalBusca" name="buscaNomeTipoPagamento" id="buscaNomeTipoPagamento" type="text" placeholder="Pesquisar">
              <div class="input-group-append">
                <button class="btn btn-sidebar" id="buscarTipoPagamento" onclick="buscarTipoPagamento()">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="row modal-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="text-center">
                  <th style="width: 15%">Código</th>
                  <th>Nome</th>
                  <th style="width: 25%">Ações</th>
                </tr>
              </thead>
              <tbody id="buscarTipoPagamentoTable">

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
<!-- BANCO -->
<div class="modal fade modal-geral" id="buscarBancoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buscar banco</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <?php if ($_SESSION['tema'] == 'branco') { ?>
            <div class="input-group">
            <?php } else { ?>
            <div class="input-group sidebar-dark-primary">
            <?php } ?>
              <input class="form-control form-control-sidebar inputModalBusca" name="buscaNomeBanco" id="buscaNomeBanco" type="text" placeholder="Pesquisar">
              <div class="input-group-append">
                <button class="btn btn-sidebar" id="buscarBanco" onclick="buscarBanco()">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="row modal-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="text-center">
                  <th style="width: 15%">Código</th>
                  <th>Nome</th>
                  <th style="width: 25%">Ações</th>
                </tr>
              </thead>
              <tbody id="buscarBancoTable">

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
<!-- LOTES -->
<div class="modal fade modal-geral" id="buscarLoteModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buscar lote</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <?php if ($_SESSION['tema'] == 'branco') { ?>
            <div class="input-group">
            <?php } else { ?>
            <div class="input-group sidebar-dark-primary">
            <?php } ?>
              <input class="form-control form-control-sidebar" name="buscaNomeLote" id="buscaNomeLote" type="text" placeholder="Pesquisar">
              <div class="input-group-append">
                <button class="btn btn-sidebar" id="buscarLote" onclick="buscarLote()">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="row modal-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="text-center">
                  <th style="width: 15%">Código</th>
                  <th>Descrição</th>
                  <th style="width: 25%">Ações</th>
                </tr>
              </thead>
              <tbody id="buscarLoteTable">

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
<!-- LOCAIS -->
<div class="modal fade modal-geral" id="buscarLocalModal">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
         <h4 class="modal-title">Buscar local</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
         </div>
         <div class="card card-primary">
         <div class="card-body">
            <div class="row">
               <?php if ($_SESSION['tema'] == 'branco') { ?>
               <div class="input-group">
               <?php } else { ?>
               <div class="input-group sidebar-dark-primary">
               <?php } ?>
               <input class="form-control form-control-sidebar" name="buscaNomeLocal" id="buscaNomeLocal" type="text" placeholder="Pesquisar">
               <div class="input-group-append">
                  <button class="btn btn-sidebar" id="buscarLocal" onclick="buscarLocal()">
                     <i class="fas fa-search fa-fw"></i>
                  </button>
               </div>
               </div>
            </div>
         </div>
         </div>
         <div class="modal-body">
         <div class="card-body">
            <div class="row modal-responsive">
               <table class="table table-bordered table-hover">
               <thead>
                  <tr class="text-center">
                     <th style="width: 15%">Código</th>
                     <th>Descrição</th>
                     <th style="width: 25%">Ações</th>
                  </tr>
               </thead>
               <tbody id="buscarLocalTable">

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
<!-- USUÁRIO -->
<div class="modal fade modal-geral" id="buscarUsuarioModal">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
         <h4 class="modal-title">Buscar usuário</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
         </div>
         <div class="card card-primary">
         <div class="card-body">
            <div class="row">
               <?php if ($_SESSION['tema'] == 'branco') { ?>
               <div class="input-group">
               <?php } else { ?>
               <div class="input-group sidebar-dark-primary">
               <?php } ?>
               <input class="form-control form-control-sidebar" name="buscaNomeUsuario" id="buscaNomeUsuario" type="text" placeholder="Pesquisar">
               <div class="input-group-append">
                  <button class="btn btn-sidebar" id="buscarUsuario" onclick="buscarUsuario()">
                     <i class="fas fa-search fa-fw"></i>
                  </button>
               </div>
               </div>
            </div>
         </div>
         </div>
         <div class="modal-body">
         <div class="card-body">
            <div class="row modal-responsive">
               <table class="table table-bordered table-hover">
               <thead>
                  <tr class="text-center">
                     <th style="width: 15%">Código</th>
                     <th>Nome</th>
                     <th style="width: 25%">Ações</th>
                  </tr>
               </thead>
               <tbody id="buscarUsuarioTable">

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