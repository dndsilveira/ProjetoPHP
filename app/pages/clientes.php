<?php

// EDITAR CLIENTE
if (!empty($_GET['id_cliente']) && $_GET['func'] == 'edit') {

	$sql = $pdo->prepare("SELECT Codigo, Nome, Apelido, CNPJ, RG, InscricaoEstadual, Endereco, Numero, Bairro, CodigoCidade, NomeCidade,
   Estado, CEP, Telefone, E_Mail, Nascimento FROM cliente WHERE Codigo = :codigo");
	$sql->bindValue(":codigo", $_GET['id_cliente']);
	$sql->execute();

	if ($sql->rowCount() > 0) {

      $linhaCliente = $sql->fetch();

	?>
	
	<script>
		$(function(){
			$('#editModal').modal();
		});
	</script>

	<?php
	}
}

?>
<div class="content-wrapper">
   <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="font-size: 25px;">Clientes</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li ><button type="button" class="btn btn-block btn-success novoClienteBtn" data-toggle="modal" data-target="#addModal">Novo cliente</button></li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Clientes cadastrados</h3>
        <form class="barraPesquisa" method="POST">
          <?php if ($_SESSION['tema'] == 'branco') { ?>
          <div class="input-group barraPesquisa bordaBranca">
          <?php } else { ?>
          <div class="input-group sidebar-dark-primary barraPesquisa bordaPreta">
          <?php } ?>

            <input class="form-control form-control-sidebar filtroNome" name="filtroNome" type="text" placeholder="Nome">
            <div class="input-group-append">
              <div class="btn btn-sidebar">
                <i class="fas fa-font fa-fw"></i>
              </div>
            </div>

            <input class="form-control form-control-sidebar filtroCodigo" name="filtroCodigo" type="text" placeholder="Código">
            <div class="input-group-append">
              <div class="btn btn-sidebar">
                <i class="fas fa-at fa-fw"></i>
              </div>
            </div>

            <input type="submit" class="btn btn-info filtros" name="buscaCliente" value="Filtrar" />
          </div>
        </form>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-striped projects" id="example2">
            <?php

            if (isset($_SESSION['filtroNomeCliente']) OR isset($_SESSION['filtroCodigoCliente'])) {

               echo "
               <thead>
                  <tr class='text-center'>
                  <th>
                     #
                  </th>
                  <th style='min-width: 30%'>
                     Nome
                  </th>
                  <th>
                     CPF/CNPJ
                  </th>
                  <th>
                     Cidade
                  </th>
                  <th>
                     UF
                  </th>
                  <th>
                     Telefone
                  </th>
                  <th>
                     Apelido
                  </th>
                  <th style='width: 15%' class='text-center'>
                     Ações
                  </th>";

               echo"
               </tr>
               </thead>
               <tbody>
               ";

               if (isset($_SESSION['buscaCliente']) && $_SESSION['buscaCliente'] != 0) {

                  if (isset($_SESSION['filtroNomeCliente']) && !empty($_SESSION['filtroNomeCliente'])) {

                     $sql = $pdo->prepare("SELECT Codigo, Nome, CNPJ, NomeCidade, Estado, Telefone, Apelido FROM cliente WHERE nome LIKE CONCAT
                     (:nome , '%') AND Inativo = 'N' ORDER BY Nome ASC");
                     $sql->bindValue(":nome", $_SESSION['filtroNomeCliente']);
                     $sql->execute();

                  }

                  elseif (isset($_SESSION['filtroCodigoCliente']) && !empty($_SESSION['filtroCodigoCliente'])) {

                     $sql = $pdo->prepare("SELECT Codigo, Nome, CNPJ, NomeCidade, Estado, Telefone, Apelido FROM cliente WHERE codigo = :codigo
                     AND Inativo = 'N' ORDER BY Nome ASC");
                     $sql->bindValue(":codigo", $_SESSION['filtroCodigoCliente']);
                     $sql->execute();

                  }

                  else {

                     $sql = $pdo->prepare("SELECT Codigo, Nome, CNPJ, NomeCidade, Estado, Telefone, Apelido FROM cliente WHERE Inativo = 'N' ORDER BY Nome ASC");
                     $sql->execute();

                  }
            
                  $qtd = $sql->rowCount();  
                  $clientes = $sql->fetchAll();
                  
                  if ($clientes != false) {
                     foreach ($clientes as $linha) {
         
                     echo "<tr class='text-center' style='line-height: 35px;'>";
                        echo "<td scope='row'>".$linha['Codigo']."</td>";
                        echo "<td>".$linha['Nome']."</td>";
                        echo "<td>".$linha['CNPJ']."</td>";
                        echo "<td>".$linha['NomeCidade']."</td>";
                        echo "<td>".$linha['Estado']."</td>";
                        echo "<td>".$linha['Telefone']."</td>";
                        echo "<td>".$linha['Apelido']."</td>";

                        if (!isset($_GET['id_cliente'])) {
                           $_GET['id_cliente'] = null;
                        }
                        
                        if ($_GET['id_cliente'] == $linha['Codigo']) {
                           echo "
                           <td class='project-actions text-center' style='width: 10%;'>

                           <a class='btn btn-info btn-sm desktop' onclick='abrirModalEdit()'><i class='fas fa-pencil-alt'></i> Editar</a>
                     
                           <a class='btn btn-info btn-sm mobile' onclick='abrirModalEdit()'><i class='fas fa-pencil-alt'></i></a>

                           </td>";
                        }

                        else {
                           echo "
                           <td class='project-actions text-center' style='width: 10%;'>

                           <a class='btn btn-info btn-sm desktop' href='clientes/edit/".$linha['Codigo']."'><i class='fas fa-pencil-alt'></i> Editar</a>
                     
                           <a class='btn btn-info btn-sm mobile' href='clientes/edit/".$linha['Codigo']."'><i class='fas fa-pencil-alt'></i></a>

                           </td>";
                        }
                     
                     echo "</tr>";
                     }
                  }

                  else {
                     echo "<tr class='text-center'><td colspan='8'>Cliente não encontrado!</td></tr>";
                  }
               }
            }

            elseif ((isset($_SESSION['filtroNomeCliente']) && !empty($_SESSION['filtroNomeCliente'])) || (isset($_SESSION['filtroCodigoCliente'])
            && !empty($_SESSION['filtroCodigoCliente']))) {
              echo "<div class='text-center' style='padding-top: 5px;'>Cliente não encontrado!</div>";
            }

            ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

<!-- Novo usuário modal -->
<div class="modal fade" id="addModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="padding: 0rem;">
         <div class="col-sm-6" style="padding: 0.5rem;">
            <h4 class="modal-title novoCliente">Novo cliente</h4>
        </div>
      </div>
      <form method="POST" id="validaCliente">
      <div class="modal-body">
         <div class="row">
            <div id="lancamentosAdd"></div>
            <div class="form-group col-8 inputs responsive15">
               <label for="nome">Nome/razão social</label>
               <input class="form-control form-control-sidebar" name="nome" id="nome" type="text" required>
            </div>
            <div class="form-group col-4 inputs responsive15">
               <label for="apelido">Apelido</label>
               <input class="form-control form-control-sidebar" name="apelido" id="apelido" type="text">
            </div>
            <div class="form-group col-6 inputs responsive14">
               <label for="documento">CPF/CNPJ</label>
               <input class="form-control form-control-sidebar" name="documento" id="documento" type="text" required>
            </div>
            <div class="form-group col-6 responsive13"></div>
            <div class="form-group col-6 inputs responsive14">
               <label for="inscricao">RG/Inscrição Estadual</label>
               <input class="form-control form-control-sidebar" name="inscricao" id="inscricao" type="text">
            </div>
            <div class="form-group col-3 inputs responsive6">
               <label for="telefone">Telefone</label>
               <input class="form-control form-control-sidebar" name="telefone" id="telefone" type="text" required>
            </div>
            <div class="form-group col-5 inputs responsive7">
               <label for="email">Email</label>
               <input class="form-control form-control-sidebar" name="email" id="email" type="text" required>
            </div>
            <div class="form-group col-4 responsive3"></div>
            <div class="form-group col-4 inputs responsive4">
               <label for="nascimento">Nascimento</label>
               <input class="form-control form-control-sidebar" name="nascimento" id="nascimento" type="date">
            </div>
            <div class="form-group col-8 responsive1"></div>
            <div class="form-group col-6 inputs responsive12">
               <label for="rua">Endereço</label>
               <input class="form-control form-control-sidebar" name="rua" id="rua" type="text" required>
            </div>
            <div class="form-group col-2 inputs codigos">
               <label for="numero">Número</label>
               <input class="form-control form-control-sidebar" name="numero" id="numero" type="text" required>
            </div>
            <div class="form-group col-4 inputs responsive8">
               <label for="bairro">Bairro</label>
               <input class="form-control form-control-sidebar" name="bairro" id="bairro" type="text" required>
            </div>
            <div class="form-group col-3 inputs codigos responsive11">
               <label for="codigoCidade">Cidade</label>
               <div class="input-group mb-3">
                  <input class="form-control form-control-sidebar" name="codigoCidade" id="codigoCidade" type="text" required>
                  <div class="input-group-append">
                     <span class="input-group-text" data-toggle="modal" data-target="#buscarCidadeModal">
                     <i class="fas fa-search"></i>
                     </span>
                  </div>
               </div>
            </div>
            <div class="form-group col-5 inputs responsive9">
               <label for="nomeCidade">Nome da cidade</label>
               <input class="form-control form-control-sidebar" name="nomeCidade" id="nomeCidade" type="text" readonly>
            </div>
            <div class="form-group col-4 responsive1"></div>
            <div class="form-group col-1 inputs responsive2 codigos">
               <label for="estado">Estado</label>
               <input class="form-control form-control-sidebar" name="estado" id="estado" type="text" readonly>
            </div>
            <div class="form-group col-3 inputs codigos responsive10">
               <label for="cep">CEP</label>
               <input class="form-control form-control-sidebar" name="cep" id="cep" type="text" required>
            </div>
         </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            <input type="submit" class="btn btn-success" onclick="validaCamposClientes()" name="adicionarCliente" value="Adicionar">
      </div>
      </form>
    </div>
  </div>
</div>

<?php if (isset($_GET['id_cliente']) && !empty($_GET['id_cliente'])) { ?>

<!-- Editar cliente modal -->
<div class="modal fade" id="editModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="padding: 0rem;">
         <div class="col-sm-6" style="padding: 0.5rem;">
            <h4 class="modal-title novoCliente">Cliente <?php echo $linhaCliente['Codigo']; ?></h4>
        </div>
      </div>
      <form method="POST" id="validaClienteEdit">
      <div class="modal-body">
         <div class="row">
            <?php if ($_SESSION['tema'] == 'branco') { ?>
            <div>
            <?php } else { ?>
            <div class="sidebar-dark-primary">
            <?php } ?>
               <div id="lancamentosAdd"></div>
               <input type="text" name="codigo" value="<?php echo $linhaCliente['Codigo']; ?>" hidden>
               <div class="form-group col-8 inputs responsive15">
                  <label for="nome">Nome/razão social</label>
                  <input class="form-control form-control-sidebar" name="nome" id="nomeEdit" value="<?php echo $linhaCliente['Nome']; ?>" type="text" required>
               </div>
               <div class="form-group col-4 inputs responsive15">
                  <label for="apelido">Apelido</label>
                  <input class="form-control form-control-sidebar" name="apelido" id="apelidoEdit" value="<?php echo $linhaCliente['Apelido']; ?>" type="text">
               </div>
               <div class="form-group col-6 inputs responsive14">
                  <label for="documento">CPF/CNPJ</label>
                  <input class="form-control form-control-sidebar" name="documento" id="documentoEdit" value="<?php echo $linhaCliente['CNPJ']; ?>" type="text" required>
               </div>
               <div class="form-group col-6 responsive13"></div>
               <div class="form-group col-6 inputs responsive14">
                  <label for="inscricao">RG/Inscrição Estadual</label>
                  <input class="form-control form-control-sidebar" name="inscricao" id="inscricaoEdit" value="<?php echo $linhaCliente['InscricaoEstadual'].$linhaCliente['RG']; ?>" type="text">
               </div>
               <div class="form-group col-3 inputs responsive6">
                  <label for="telefone">Telefone</label>
                  <input class="form-control form-control-sidebar" name="telefone" id="telefoneEdit" value="<?php echo $linhaCliente['Telefone']; ?>" type="text" required>
               </div>
               <div class="form-group col-5 inputs responsive7">
                  <label for="email">Email</label>
                  <input class="form-control form-control-sidebar" name="email" id="emailEdit" value="<?php echo $linhaCliente['E_Mail']; ?>" type="text" required>
               </div>
               <div class="form-group col-4 responsive3"></div>
               <div class="form-group col-4 inputs responsive4">
                  <label for="nascimento">Nascimento</label>
                  <input class="form-control form-control-sidebar" name="nascimento" id="nascimentoEdit" value="<?php echo $linhaCliente['Nascimento']; ?>" type="date">
               </div>
               <div class="form-group col-8 responsive1"></div>
               <div class="form-group col-6 inputs responsive12">
                  <label for="rua">Endereço</label>
                  <input class="form-control form-control-sidebar" name="rua" id="ruaEdit" value="<?php echo $linhaCliente['Endereco']; ?>" type="text" required>
               </div>
               <div class="form-group col-2 inputs codigos">
                  <label for="numero">Número</label>
                  <input class="form-control form-control-sidebar" name="numero" id="numeroEdit" value="<?php echo $linhaCliente['Numero']; ?>" type="text" required>
               </div>
               <div class="form-group col-4 inputs responsive8">
                  <label for="bairro">Bairro</label>
                  <input class="form-control form-control-sidebar" name="bairro" id="bairroEdit" value="<?php echo $linhaCliente['Bairro']; ?>" type="text" required>
               </div>
               <div class="form-group col-3 inputs codigos responsive11">
                  <label for="codigoCidade">Cidade</label>
                  <div class="input-group mb-3">
                     <input class="form-control form-control-sidebar" name="codigoCidade" id="codigoCidadeEdit" value="<?php echo $linhaCliente['CodigoCidade']; ?>" type="text" required>
                     <div class="input-group-append">
                        <span class="input-group-text" data-toggle="modal" data-target="#buscarCidadeModal">
                        <i class="fas fa-search"></i>
                        </span>
                     </div>
                  </div>
               </div>
               <div class="form-group col-5 inputs responsive9">
                  <label for="nomeCidade">Nome da cidade</label>
                  <input class="form-control form-control-sidebar" name="nomeCidade" id="nomeCidadeEdit" value="<?php echo $linhaCliente['NomeCidade']; ?>" type="text" readonly>
               </div>
               <div class="form-group col-4 responsive1"></div>
               <div class="form-group col-1 inputs responsive2 codigos">
                  <label for="estado">Estado</label>
                  <input class="form-control form-control-sidebar" name="estado" id="estadoEdit" value="<?php echo $linhaCliente['Estado']; ?>" type="text" readonly>
               </div>
               <div class="form-group col-3 inputs codigos responsive10">
                  <label for="cep">CEP</label>
                  <input class="form-control form-control-sidebar" name="cep" id="cepEdit" value="<?php echo $linhaCliente['CEP']; ?>" type="text" required>
               </div>
            </div>
         </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            <input type="submit" class="btn btn-success" onclick="validaCamposClientesEdit()" name="adicionarCliente" value="Salvar">
      </div>
      </form>
    </div>
  </div>
</div>

<?php } ?>

<!-- Scripts de busca, add, edit... -->
<script src="plugins/pages/clientes/main.js"></script>