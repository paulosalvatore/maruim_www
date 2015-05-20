<?php
	session_start();
	require_once("../../conexao/conexao.php");
	include("../../includes/funcoes.php");
	check_is_ajax(__FILE__);
	check_if_logged(__FILE__);
	include("../../includes/config.php");
	include("../../includes/protocolo.php");
	$ClassConta = new Conta();
	$informacoesConta = $ClassConta->getInformacoesConta($_SESSION["login"]);
	$acesso_pagina = $informacoesConta["acesso_pagina"];
	if($acesso_pagina != 1)
		exit;
	foreach($_REQUEST as $c => $v)
		$$c = $v;
	$tabela = "z_registro_mudancas";
	include("../../includes/classes/ClassFuncao.php");
	$ClassFuncao = new Funcao();
	if($acao == "deletar")
		mysql_query($ClassFuncao->loadSQLQuery($tabela, "id", $registro_id));
	elseif($acao == "adicionar"){
		parse_str(addslashes($formulario), $formulario);
		$sql = array(
			"local_mudanca" => $formulario["local_mudanca"],
			"descricao" => nl2br(utf8_decode($formulario["descricao"])),
			"data" => time(),
			"conta" => $informacoesConta["id"]
		);
		$colunas = array();
		$valores = array();
		foreach($sql as $c => $v){
			$colunas[] = $c;
			$valores[] = $v;
		}
		mysql_query($ClassFuncao->loadSQLQuery($tabela, $colunas, $valores));
	}
?>