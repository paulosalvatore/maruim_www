<?php
	session_start();
	require_once("../../conexao/conexao.php");
	include("../../includes/funcoes.php");
	check_is_ajax(__FILE__);
	include("../../includes/classes/ClassFuncao.php");
	check_if_logged(__FILE__);
	include("../../includes/config.php");
	include("../../includes/protocolo.php");
	$ClassConta = new Conta();
	$informacoesConta = $ClassConta->getInformacoesConta($_SESSION["login"]);
	$acesso_pagina = $informacoesConta["acesso_pagina"];
	if($acesso_pagina != 1)
		exit;
	$chaveAcesso = sha1(time().microtime());
	mysql_query("INSERT INTO z_chaves_acesso (chave) VALUES ('$chaveAcesso')");
	echo $chaveAcesso;
?>