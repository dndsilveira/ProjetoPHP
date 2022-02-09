<?php

date_default_timezone_set('America/Sao_Paulo');

try {

	$_SESSION['database'] = "CONSTRUMONTE";

	$pdo = new PDO ("mysql:dbname=".$_SESSION['database'].";host=192.168.0.5;charset=utf8", "root", "");

   // COMENTAR QUANDO EM TESTE
   // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
   // DESCOMENTAR QUANDO EM PRODUÇÃO

}

catch (PDOException $e) {

	$_SESSION['openErrorModal'] = 'Ocorreu um erro ao acessar o banco de dados.';
	header("Location: errobanco");

}

?>