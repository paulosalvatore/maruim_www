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
	// if($acesso_pagina != 1)
		// exit;
	foreach($_REQUEST as $c => $v)
		$$c = $v;
	$tabela = "reports";
	if($acesso_pagina == 1){
		if($acao == "deletar")
			mysql_query($ClassFuncao->loadSQLQueryDelete($tabela, "id", $registro_id));
		elseif($acao == "concluir")
			mysql_query($ClassFuncao->loadSQLQueryUpdate($tabela, array("consertado", "data_consertado"), array(1, time()), "id", $registro_id));
	}
	if($acao == "adicionar"){
		$formulario = $ClassFuncao->separarForm($formulario, true);
		if(strlen($formulario["mensagem"]) < 8)
			exit;
		$categorias = array(
			"site" => "Site",
			"mapa" => "Mapa",
			"digitacao" => "Digitação",
			"tecnico" => "Técnico",
			"outro" => "Outro"
		);
		$categoria = $categorias[(array_key_exists($formulario["categoria"], $categorias) ? $formulario["categoria"] : "outro")];
		$sql = array(
			"categoria" => $categoria,
			"mensagem" => $formulario["mensagem"],
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
		echo 1;
	}
?>