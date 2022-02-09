<?php

// VERIFICAÇÃO PADRÃO

if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])) {

	$sql = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
	$sql->bindValue(":id", $_SESSION['usuario']);
	$sql->execute();

	$info = $sql->fetch();

  $nome = $info['Usuario'];
}

else {
	header("Location: login");
	exit;
}

// PARÂMETROS
$sql = $pdo->prepare("SELECT codigoCidadeOrcamentos, nomeCidadeOrcamentos, respeitarVendedorCadastro FROM parametros");
$sql->execute();
$_SESSION['parametros'] = $sql->fetch();

if ($_SESSION['parametros']['respeitarVendedorCadastro'] == 'S') {
	$_SESSION['parametros']['respeitarVendedorCadastro'] = 'S';

   $sql = $pdo->prepare("SELECT * FROM vendedores WHERE usuario = :usuario");
	$sql->bindValue(":usuario", $info['Id']);
	$sql->execute();
	$_SESSION['parametros']['vendedorLogado'] = $sql->fetch();
}

else {
	$_SESSION['parametros']['respeitarVendedorCadastro'] = 'N';

  	$sql = $pdo->prepare("SELECT * FROM vendedores WHERE usuario = :usuario");
	$sql->bindValue(":usuario", $info['Id']);
	$sql->execute();
	$_SESSION['parametros']['vendedorLogado'] = $sql->fetch();
}

// VERIFICA O TIPO DE PAGAMENTO PADRÃO
$sql = $pdo->prepare("SELECT ValorParametro FROM parametrosgerais Where CodigoEmpresa = '-1' AND NomeParametro = 'FormaPagamentoPadraoOrcamento'");
$sql->execute();
$result = $sql->fetch();

if ($result != false) {
   $_SESSION['parametros']['tipoPagamentoPadrao'] = $result['ValorParametro'];
}

else {
   $_SESSION['parametros']['tipoPagamentoPadrao'] = 0;
}

// VERIFICA O BANCO DE PAGAMENTO PADRÃO
$sql = $pdo->prepare("SELECT BancoOrcamentoPadrao FROM parametros");
$sql->execute();

$result = $sql->fetch();

if (isset($result['BancoOrcamentoPadrao']) && !empty($result['BancoOrcamentoPadrao']) && $result['BancoOrcamentoPadrao'] != null) {
   $_SESSION['parametros']['bancoPagamentoPadrao'] = $result['BancoOrcamentoPadrao'];
}

else {
   $_SESSION['parametros']['bancoPagamentoPadrao'] = 0;
}

// VERIFICA O PRAZO DE PAGAMENTO PADRÃO
$sql = $pdo->prepare("SELECT PrazoPadrao FROM parametros");
$sql->execute();

$result = $sql->fetch();

if (isset($result['PrazoPadrao']) && !empty($result['PrazoPadrao']) && $result['PrazoPadrao'] != null) {
   $_SESSION['parametros']['prazoPagamentoPadrao'] = $result['PrazoPadrao'];
}

else {
   $_SESSION['parametros']['prazoPagamentoPadrao'] = 0;
}

// VERIFICA SE O USUÁRIO PODE VER O LUCRO
$sql = $pdo->prepare("SELECT IdUsuario FROM direitos_dados Where IdUsuario = :usuario AND OpcoesPermitidas = '300925'");
$sql->bindValue(":usuario", $info['Id']);
$sql->execute();

if ($sql->fetch() != false) {
   $_SESSION['parametros']['verLucro'] = 'S';
}

else {
   $_SESSION['parametros']['verLucro'] = 'N';
}

// VERIFICA SE O USUÁRIO PODE VER OUTRAS VENDAS
$sql = $pdo->prepare("SELECT IdUsuario FROM Direitos_Dados WHERE IdUsuario = :usuario AND OpcoesPermitidas = '013010'");
$sql->bindValue(":usuario", $info['Id']);
$sql->execute();

if ($sql->fetch() != false) {
   $_SESSION['parametros']['verSomenteSuasVendas'] = 'S';
}

else {
   $_SESSION['parametros']['verSomenteSuasVendas'] = 'N';
}

// VERIFICA SE A EMPRESA USA LOTE E LOCAL
$sql = $pdo->prepare("SELECT ValorParametro FROM parametrosgerais WHERE nomeparametro = 'UsarLoteMaterial' OR nomeparametro = 'UsarLocalPorUsuario'");
$sql->execute();
$parametrosGerais = $sql->fetchAll();

if ($parametrosGerais[0]['ValorParametro'] == '1') {
   $_SESSION['parametros']['usaLoteMaterial'] = 'S';
}

else {
   $_SESSION['parametros']['usaLoteMaterial'] = 'N';
}

if ($parametrosGerais[1]['ValorParametro'] == '1') {
   $_SESSION['parametros']['usaLocalPorUsuario'] = 'S';
}

else {
   $_SESSION['parametros']['usaLocalPorUsuario'] = 'N';
}

// VERIFICA SE A EMPRESA USA O CONTROLE DE EXPEDIÇÃO
if ($_SESSION['database'] == 'CONSTRUMONTE') {
    $_SESSION['parametros']['usaExpedicao'] = 'S';
}

// NOME DO USUÁRIO

$primeironome = $info['Usuario'];

$pag = '';

if (!empty($_GET['pag'])) {
	$pag = $_GET['pag'];
}

// SESSIONS

if (!isset($_SESSION['recarregarModal'])) {
$_SESSION['recarregarModal'] = false;
}

// MODAL

if (!empty($_GET['id_acerto_estoque'])) {
	$get_id_acerto_estoque = $_GET['id_acerto_estoque'];
	$sql = $pdo->prepare("SELECT * FROM acertoestoque WHERE id = :id");
	$sql->bindValue(':id', $get_id_acerto_estoque);
	$sql->execute();
	if ($sql->rowCount() > 0) {
		$linhaAcertoEstoque = $sql->fetchAll();
		$linhasAcertoEstoque = $sql->rowCount();
	}
}

if (!empty($_GET['id_produto_lotelocal'])) {
	$get_id_produto_lotelocal = $_GET['id_produto_lotelocal'];
	$sql = $pdo->prepare("SELECT * FROM acertoestoque WHERE id = :id");
	$sql->bindValue(':id', $get_id_produto_lotelocal);
	$sql->execute();
	if ($sql->rowCount() > 0) {
		$linhaAcertoEstoque = $sql->fetchAll();
		$linhasAcertoEstoque = $sql->rowCount();
	}
}

?>