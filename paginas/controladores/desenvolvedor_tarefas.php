<?php
	session_start();
	require_once("../../conexao/conexao.php");
	include("../../includes/funcoes.php");
	check_is_ajax(__FILE__);
	include("../../includes/classes/ClassFuncao.php");
	check_if_logged(__FILE__);
	include("../../includes/config.php");
	include("../../includes/protocolo.php");
	$ClassFuncao = new Funcao();
	$ClassConta = new Conta();
	$informacoesConta = $ClassConta->getInformacoesConta($_SESSION["login"]);
	$acesso_pagina = $informacoesConta["acesso_pagina"];
	if($acesso_pagina != 1)
		exit;
	foreach($_REQUEST as $c => $v)
		$$c = $v;
	$tabela = "z_tarefas";
	if($acao == "deletar")
		mysql_query($ClassFuncao->loadSQLQueryDelete($tabela, "id", $registro_id));
	elseif($acao == "concluir")
		mysql_query($ClassFuncao->loadSQLQueryUpdate($tabela, "concluida", 1, "id", $registro_id));
	elseif($acao == "adicionar"){
		$formulario = $ClassFuncao->separarForm($formulario, true);
		$sql = array(
			"categoria" => $formulario["categoria"],
			"descricao" => nl2br($formulario["descricao"]),
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