<?php

// FUNCTIONS
include_once 'functions.php';

// TROCAR TEMA
if (empty($_POST['trocarTema'])) {
	$_POST['trocarTema'] = 0;
}

else {
	if ($_SESSION['tema'] == 'branco') {
		$_SESSION['tema'] = 'preto';
	}

	else {
		$_SESSION['tema'] = 'branco';
	}
}

if (empty($_POST['pedido_orcamento'])) {
	$_POST['pedido_orcamento'] = 0;
}

switch ($_POST['pedido_orcamento']) {

	case 'Salvar':

	if (isset($_SESSION['carrinho'])) {
		
		$contadorErro = 0;

		$sql = $pdo->prepare("SET TRANSACTION ISOLATION LEVEL READ COMMITTED");
		$sql->execute();

		salvaOrcamento($pdo, $contadorErro, $_SESSION['carrinho'], $primeironome);
		
	}

	break;

	default:

	break;
}

if (empty($_POST['buscaProduto'])) {
	$_POST['buscaProduto'] = 0;
}

if (empty($_SESSION['buscaProduto'])) {
	$_SESSION['buscaProduto'] = 0;
}

switch ($_POST['buscaProduto']) {
	
	// FILTRO DE PRODUTOS
	case 'Filtrar':

	$_SESSION['buscaProduto'] = 'Filtrar';

	// NOME
	if (isset($_POST['filtroNome']) && !empty($_POST['filtroNome'])) {
		$_SESSION['filtroNomeProduto'] = $_POST['filtroNome'];
	}

	else {
		$_SESSION['filtroNomeProduto'] = '';
	}

	// CÓDIGO
	if (isset($_POST['filtroCodigo']) && !empty($_POST['filtroCodigo'])) {
		$_SESSION['filtroCodigoProduto'] = $_POST['filtroCodigo'];
	}

	else {
		$_SESSION['filtroCodigoProduto'] = '';
	}

	// CÓDIGO DE BARRAS
	if (isset($_POST['filtroCodigoBarras']) && !empty($_POST['filtroCodigoBarras'])) {
		$_SESSION['filtroCodigoBarrasProduto'] = $_POST['filtroCodigoBarras'];
	}

	else {
		$_SESSION['filtroCodigoBarrasProduto'] = '';
	}

	header("Location: http://solucaosistemasctdv.ddns.net:8081/produtos");

	break;

	default:

	break;

}

if (empty($_POST['buscaCliente'])) {
	$_POST['buscaCliente'] = 0;
}

if (empty($_SESSION['buscaCliente'])) {
	$_SESSION['buscaCliente'] = 0;
}

switch ($_POST['buscaCliente']) {
	
	// FILTRO DE PRODUTOS
	case 'Filtrar':

	$_SESSION['buscaCliente'] = 'Filtrar';

	// NOME
	if (isset($_POST['filtroNome']) && !empty($_POST['filtroNome'])) {
		$_SESSION['filtroNomeCliente'] = $_POST['filtroNome'];
	}

	else {
		$_SESSION['filtroNomeCliente'] = '';
	}

	// CÓDIGO
	if (isset($_POST['filtroCodigo']) && !empty($_POST['filtroCodigo'])) {
		$_SESSION['filtroCodigoCliente'] = $_POST['filtroCodigo'];
	}

	else {
		$_SESSION['filtroCodigoCliente'] = '';
	}

	header("Location: http://solucaosistemasctdv.ddns.net:8081/clientes");

	break;

	default:

	break;

}

if (empty($_POST['adicionarCliente'])) {
	$_POST['adicionarCliente'] = 0;
}

switch ($_POST['adicionarCliente']) {
	
	case 'Adicionar':

   $sql = $pdo->prepare("SELECT Max(Codigo) As Codigo FROM Cliente");
   $sql->execute();

   $result = $sql->fetch();

   if ($result != false) {
      $codigo = $result['Codigo']+1;  
   }

   else {
      $codigo = 1;
   }

   $documento = str_replace(".", "", $_POST['documento']);
   $documento = str_replace("-", "", $documento);
   $documento = str_replace(",", "", $documento);
   $documento = str_replace("/", "", $documento);

   $nascimento = '0000-00-00';

   if (isset($_POST['nascimento']) && !empty($_POST['nascimento'])) {
      $nascimento = date('Y-m-d', strtotime($_POST['nascimento']));
   }

   $rg = "";
   $inscricao = "";
   $apelido = "";

   if (isset($_POST['apelido']) && !empty($_POST['apelido'])) {
      $apelido = addslashes($_POST['apelido']);
   }

   if (strlen($documento) <= 11) {

      // É CPF
      $documento = substr($documento, 0, 3).".".substr($documento, 3, 3).".".substr($documento, 6, 3)."-".substr($documento, 9, 2);

      $rg = $_POST['inscricao'];

   }

   else {

      // É CNPJ
      $documento = substr($documento, 0, 2).".".substr($documento, 2, 3).".".substr($documento, 5, 3)."/".substr($documento, 8, 4)."-".substr($documento, 12, 2);

      $inscricao = $_POST['inscricao'];

   }

   $sql = $pdo->prepare("INSERT INTO cliente
   (Codigo, Nome, Endereco, Bairro, CodigoCidade, NomeCidade, Cep, Estado, Telefone, Fax, DataCadastro, WebPagina, E_Mail, CNPJ, InscricaoEstadual, InscricaoMunicipal, InscricaoProdutor, RG, 
   DataRG, EstadoRG, DataUltimaAlteracao, Limite, Bloqueado, Negativo, SPC, Tipo, Vendedor, Observacoes, Banco1, Agencia1, Conta1, TelefoneBancario1, CidadeBancaria1, AnaliseBancaria1, 
   Banco2, Agencia2, Conta2, TelefoneBancario2, CidadeBancaria2, AnaliseBancaria2, Fornecedor1, FoneFornecedor1, DesdeFor1, MaiorFat1, MaiorAcum1, HabPag1, UltimaComp1, VlrUltima1, AnaliseFor1, 
   Fornecedor2, FoneFornecedor2, DesdeFor2, MaiorFat2, MaiorAcum2, HabPag2, UltimaComp2, VlrUltima2, AnaliseFor2, NomeSocio1, Nascimento1, CPF1, RG1, NomeSocio2, Nascimento2, CPF2, 
   RG2, Responsavel, TipoPagamento, DataFundacao, PrevisaoVendas, Analista, RamoEmpresarial, DataConstit, NroEmpregados, OutrasReferencias, DataResponsavel, NomeResponsavel, GerenteLoja, 
   NomeConjuge, NascimentoConjuge, RGConjuge, CPFConjuge, OndeTrabalhaConjuge, CargoConjuge, FoneComercialConjuge, EmpresaTrabalha, Cargo, EnderecoTrabalha, BairroTrabalha, CidadeTrabalha, 
   CepTrabalha, FoneTrabalha, Salario, Nascimento, MaiorAcum3, 
   Pagamento, Contato, LiberadoFaturamento, Numero, Revenda, VencimentoSerasa, Interno, InscricaoSuframa, Suframa, Inativo, Apelido, DescontoIRPISCOFINS, Tabela, Banco, Mensalista,
   Complemento, Indicacao, Origem, DiasAgendamento, UsuarioCadastrou,
   PermiteCR, IcmsIpi, DescontoBoleto, AceitaBoleto, EnviarEnvelope, ObservacoesAvisos, ObservacoesBens, DataAcordo, NomeAdvogado, NaoContribuinteICMS, Pai, Mae, SalarioConjuge, CentrodeCusto,
   Categoria, Transportadora, Redespacho, Comissao, RetemISS, RegimeEspecial, SimplesNacional, IncentivoFiscal, ControladoEcommerce, AtualizarEcommerce, 
   CreditoLiberado, ClienteBloqueou)
   VALUES
   (:codigo, :nome, :endereco, :bairro, :codigocidade, :nomecidade, :cep, :estado, :telefone, '', :data, '', :email, :documento, :inscricao, '', '', :rg, 
   '0000-00-00', '', :data, 0, 'N', 'S', 'S', 0, :vendedor, '', '', '', '', '', '', '',
   '', '', '', '', '', '', '', '', '0000-00-00', 0, 0, '', '0000-00-00', 0, '',
   '', '', '0000-00-00', 0, 0, '', '0000-00-00', 0, '', '', '0000-00-00', '', '', '', '0000-00-00', '',
   '', 0, :tipopagamento, '0000-00-00', 0.00000, '', 0, '0000-00-00', 0, '', '0000-00-00', '', '',
   '', '0000-00-00', '', '', '', '', 0, '', '', '', '', 0.00000,
   '__-___-___', '', 0.00000, :nascimento, 0,
   :pagamento, '', 'N', :numero, 'N', '0000-00-00', 0, '', 
   0, 'N', :apelido, 0, 1, :banco, 'N', '', 0, 6,
   0, :usuario, 'N', 'N', 0, 'N', 'N', '', '',
   '0000-00-00', '', 'N', '', '', 0, '__.___.____.____.____.____', 0, 0, 0, 0, '', '', '', 
   '', 'N', 'S', 'S', 'N')");
   $sql->bindValue(":codigo", $codigo);
   $sql->bindValue(":nome", addslashes($_POST['nome']));
   $sql->bindValue(":endereco", addslashes($_POST['rua']));
   $sql->bindValue(":bairro", addslashes($_POST['bairro']));
   $sql->bindValue(":codigocidade", addslashes($_POST['codigoCidade']));
   $sql->bindValue(":nomecidade", addslashes($_POST['nomeCidade']));
   $sql->bindValue(":cep", addslashes($_POST['cep']));
   $sql->bindValue(":estado", addslashes($_POST['estado']));
   $sql->bindValue(":telefone", addslashes($_POST['telefone']));
   $sql->bindValue(":data", date('Y-m-d'));
   $sql->bindValue(":email", addslashes($_POST['email']));
   $sql->bindValue(":documento", $documento);
   $sql->bindValue(":inscricao", $inscricao);
   $sql->bindValue(":rg", $rg);
   $sql->bindValue(":vendedor", addslashes($_SESSION['parametros']['vendedorLogado']['Codigo']));
   $sql->bindValue(":tipopagamento", $_SESSION['parametros']['tipoPagamentoPadrao']);
   $sql->bindValue(":nascimento", $nascimento);
   $sql->bindValue(":pagamento", $_SESSION['parametros']['prazoPagamentoPadrao']);
   $sql->bindValue(":numero", addslashes($_POST['numero']));
   $sql->bindValue(":apelido", $apelido);
   $sql->bindValue(":banco", $_SESSION['parametros']['bancoPagamentoPadrao']);
   $sql->bindValue(":usuario", $info['Nome']);
   $sql->execute();

   header("Location: http://solucaosistemasctdv.ddns.net:8081/clientes");

   $_SESSION['openSuccessModal'] = 'O cliente com código '.$codigo.' foi cadastrado com sucesso.';

   exit;

	break;

   case 'Salvar':

   $codigo = addslashes($_POST['codigo']);

   $documento = str_replace(".", "", $_POST['documento']);
   $documento = str_replace("-", "", $documento);
   $documento = str_replace(",", "", $documento);
   $documento = str_replace("/", "", $documento);

   $rg = "";
   $inscricao = "";
   $apelido = "";

   if (isset($_POST['apelido']) && !empty($_POST['apelido'])) {
      $apelido = addslashes($_POST['apelido']);
   }

   if (strlen($documento) <= 11) {

      // É CPF
      $documento = substr($documento, 0, 3).".".substr($documento, 3, 3).".".substr($documento, 6, 3)."-".substr($documento, 9, 2);

      $rg = $_POST['inscricao'];

   }

   else {

      // É CNPJ
      $documento = substr($documento, 0, 2).".".substr($documento, 2, 3).".".substr($documento, 5, 3)."/".substr($documento, 8, 4)."-".substr($documento, 12, 2);

      $inscricao = $_POST['inscricao'];

   }

   $sql = $pdo->prepare("UPDATE cliente SET Nome = :nome, Endereco = :endereco, Bairro = :bairro, CodigoCidade = :codigocidade, NomeCidade = :nomecidade,
   CEP = :cep, Estado = :estado, Telefone = :telefone, DataUltimaAlteracao = :data, E_Mail = :email, CNPJ = :documento, InscricaoEstadual = :inscricao,
   RG = :rg, Nascimento = :nascimento, Numero = :numero, Apelido = :apelido WHERE Codigo = :codigo");
   $sql->bindValue(":codigo", $codigo);
   $sql->bindValue(":nome", addslashes($_POST['nome']));
   $sql->bindValue(":endereco", addslashes($_POST['rua']));
   $sql->bindValue(":bairro", addslashes($_POST['bairro']));
   $sql->bindValue(":codigocidade", addslashes($_POST['codigoCidade']));
   $sql->bindValue(":nomecidade", addslashes($_POST['nomeCidade']));
   $sql->bindValue(":cep", addslashes($_POST['cep']));
   $sql->bindValue(":estado", addslashes($_POST['estado']));
   $sql->bindValue(":telefone", addslashes($_POST['telefone']));
   $sql->bindValue(":data", date('Y-m-d'));
   $sql->bindValue(":email", addslashes($_POST['email']));
   $sql->bindValue(":documento", $documento);
   $sql->bindValue(":inscricao", $inscricao);
   $sql->bindValue(":rg", $rg);
   $sql->bindValue(":nascimento", date('Y-m-d', strtotime($_POST['nascimento'])));
   $sql->bindValue(":numero", addslashes($_POST['numero']));
   $sql->bindValue(":apelido", $apelido);
   $sql->execute();

   header("Location: http://solucaosistemasctdv.ddns.net:8081/clientes");

   $_SESSION['openSuccessModal'] = 'O cliente com código '.$codigo.' foi alterado com sucesso.';

   exit;

   break;

	default:

	break;

}

if (empty($_POST['relatorioVendasPorVendedor'])) {
	$_POST['relatorioVendasPorVendedor'] = 0;
}

if (empty($_SESSION['buscaRelatorioVendasPorVendedor'])) {
	$_SESSION['buscaRelatorioVendasPorVendedor'] = 0;
}

switch ($_POST['relatorioVendasPorVendedor']) {
	
	// FILTRO DE VENDAS
	case 'Consultar':

   unset($_SESSION['buscaRelatorioVendasPorVendedor']);

   $_SESSION['buscaRelatorioVendasPorVendedor'] = array();

   $_SESSION['buscaRelatorioVendasPorVendedor']['dataInicio'] = $_POST['filtroDataInicio'];
   $_SESSION['buscaRelatorioVendasPorVendedor']['dataFinal'] = $_POST['filtroDataFinal'];

	// VENDEDORES
	if (isset($_POST['filtroVendedor']) && !empty($_POST['filtroVendedor'])) {
		$_SESSION['buscaRelatorioVendasPorVendedor']['vendedores'] = addslashes($_POST['filtroVendedor']);
	}

	header("Location: http://solucaosistemasctdv.ddns.net:8081/vendasvendedor");

	break;

	default:

	break;

}

if (empty($_POST['relatorioSaidasPorCliente'])) {
	$_POST['relatorioSaidasPorCliente'] = 0;
}

if (empty($_SESSION['buscaRelatorioSaidasPorCliente'])) {
	$_SESSION['buscaRelatorioSaidasPorCliente'] = 0;
}

switch ($_POST['relatorioSaidasPorCliente']) {
	
	// FILTRO DE VENDAS
	case 'Consultar':

   unset($_SESSION['buscaRelatorioSaidasPorCliente']);

   $_SESSION['buscaRelatorioSaidasPorCliente'] = array();

   $_SESSION['buscaRelatorioSaidasPorCliente']['dataInicio'] = $_POST['filtroDataInicio'];
   $_SESSION['buscaRelatorioSaidasPorCliente']['dataFinal'] = $_POST['filtroDataFinal'];

	// CLIENTE
	if (isset($_POST['filtroCliente'])) {
		$_SESSION['buscaRelatorioSaidasPorCliente']['cliente'] = addslashes($_POST['filtroCliente']);
	}

   // PRODUTO
	if (isset($_POST['filtroProduto']) && !empty($_POST['filtroProduto'])) {
		$_SESSION['buscaRelatorioSaidasPorCliente']['produto'] = addslashes($_POST['filtroProduto']);
	}

   // PARTE DO NOME DO PRODUTO
	if (isset($_POST['parteNomeProduto']) && !empty($_POST['parteNomeProduto'])) {
		$_SESSION['buscaRelatorioSaidasPorCliente']['parteNomeProduto'] = addslashes($_POST['parteNomeProduto']);
	}

   // ENDEREÇO/OBRA
	if (isset($_POST['enderecoObra']) && !empty($_POST['enderecoObra'])) {
		$_SESSION['buscaRelatorioSaidasPorCliente']['enderecoObra'] = addslashes($_POST['enderecoObra']);
	}

   // SOMENTE DEVOLUÇÃO E VENDA
	if (isset($_POST['vendaDevolucao']) && !empty($_POST['vendaDevolucao']) && $_POST['vendaDevolucao'] == 1) {
		$_SESSION['buscaRelatorioSaidasPorCliente']['vendaDevolucao'] = "S";
	}
   
   else {
      $_SESSION['buscaRelatorioSaidasPorCliente']['vendaDevolucao'] = "N";
   }

   // MOSTRAR PREÇO DE TABELA/DESCONTOS
	if (isset($_POST['tabelaDescontos']) && !empty($_POST['tabelaDescontos']) && $_POST['tabelaDescontos'] == 1) {
		$_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] = "S";
	}

   else {
      $_SESSION['buscaRelatorioSaidasPorCliente']['tabelaDescontos'] = "N";
   }

   // MOSTRAR ENTREGAS
	if (isset($_POST['mostrarEntregas']) && !empty($_POST['mostrarEntregas']) && $_POST['mostrarEntregas'] == 1) {
		$_SESSION['buscaRelatorioSaidasPorCliente']['mostrarEntregas'] = "S";
	}

   else {
      $_SESSION['buscaRelatorioSaidasPorCliente']['mostrarEntregas'] = "N";
   }

	header("Location: http://solucaosistemasctdv.ddns.net:8081/saidascliente");

	break;

	default:

	break;

}

if (empty($_POST['relatorioDebitosPorCliente'])) {
	$_POST['relatorioDebitosPorCliente'] = 0;
}

if (empty($_SESSION['buscaRelatorioDebitosPorCliente'])) {
	$_SESSION['buscaRelatorioDebitosPorCliente'] = 0;
}

switch ($_POST['relatorioDebitosPorCliente']) {
	
	// FILTRO DE VENDAS
	case 'Consultar':

   unset($_SESSION['buscaRelatorioDebitosPorCliente']);

   $_SESSION['buscaRelatorioDebitosPorCliente'] = array();

   $_SESSION['buscaRelatorioDebitosPorCliente']['dataInicio'] = $_POST['filtroDataInicio'];
   $_SESSION['buscaRelatorioDebitosPorCliente']['dataFinal'] = $_POST['filtroDataFinal'];

	// CLIENTE
	if (isset($_POST['filtroCliente'])) {
		$_SESSION['buscaRelatorioDebitosPorCliente']['cliente'] = addslashes($_POST['filtroCliente']);
	}

   // SOMENTE ABERTO
	if (isset($_POST['somenteAberto']) && !empty($_POST['somenteAberto']) && $_POST['somenteAberto'] == 1) {
		$_SESSION['buscaRelatorioDebitosPorCliente']['somenteAberto'] = "S";
	}
   
   else {
      $_SESSION['buscaRelatorioDebitosPorCliente']['somenteAberto'] = "N";
   }

   // MOSTRAR CHEQUES
	if (isset($_POST['mostrarCheques']) && !empty($_POST['mostrarCheques']) && $_POST['mostrarCheques'] == 1) {
		$_SESSION['buscaRelatorioDebitosPorCliente']['mostrarCheques'] = "S";
	}
   
   else {
      $_SESSION['buscaRelatorioDebitosPorCliente']['mostrarCheques'] = "N";
   }

   // POR EMISSAO OU VENCIMENTO
	if (isset($_POST['vencimentoEmissao']) && !empty($_POST['vencimentoEmissao']) && $_POST['vencimentoEmissao'] == "E") {
		$_SESSION['buscaRelatorioDebitosPorCliente']['vencimentoEmissao'] = "E";
	}

   else {
      $_SESSION['buscaRelatorioDebitosPorCliente']['vencimentoEmissao'] = "V";
   }

	header("Location: http://solucaosistemasctdv.ddns.net:8081/debitoscliente");

	break;

	default:

	break;

}

if (empty($_POST['relatorioSaidasPorProdutos'])) {
	$_POST['relatorioSaidasPorProdutos'] = 0;
}

if (empty($_SESSION['buscaRelatorioSaidasPorProdutos'])) {
	$_SESSION['buscaRelatorioSaidasPorProdutos'] = 0;
}

switch ($_POST['relatorioSaidasPorProdutos']) {
	
	// FILTRO DE VENDAS
	case 'Consultar':

   unset($_SESSION['buscaRelatorioSaidasPorProdutos']);

   $_SESSION['buscaRelatorioSaidasPorProdutos'] = array();

   $_SESSION['buscaRelatorioSaidasPorProdutos']['dataInicio'] = $_POST['filtroDataInicio'];
   $_SESSION['buscaRelatorioSaidasPorProdutos']['dataFinal'] = $_POST['filtroDataFinal'];

   // PRODUTO
	if (isset($_POST['filtroProduto']) && !empty($_POST['filtroProduto'])) {
		$_SESSION['buscaRelatorioSaidasPorProdutos']['produto'] = addslashes($_POST['filtroProduto']);
	}


	header("Location: http://solucaosistemasctdv.ddns.net:8081/saidasprodutos");

	break;

	default:

	break;

}

?>