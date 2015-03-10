<?php
	session_start();
	require_once("../../conexao/conexao.php");
	include("../../includes/funcoes.php");
	check_is_ajax(__FILE__);
	check_if_logged(__FILE__);
	include("../../includes/config.php");
	include("../../includes/protocolo.php");
	// include("../../includes/classes/ClassConta.php");
	$ClassConta = new Conta();
	$informacoesConta = $ClassConta->getInformacoesConta($_SESSION["login"]);
	$acesso_pagina = $informacoesConta["acesso_pagina"];
	if($acesso_pagina != 1)
		exit;
	foreach($_REQUEST as $c => $v)
		$$c = $v;
	if($acao == "deletar")
		mysql_query("DELETE FROM z_registro_mudancas WHERE (id LIKE '$registro_id')");
	elseif($acao == "adicionar"){
		parse_str(addslashes($formulario), $formulario);
		$sql_queries = array(
			"z_registro_mudancas" => array(
				"local_mudanca" => $formulario["local_mudanca"],
				"descricao" => nl2br($formulario["descricao"]),
				"data" => time(),
				"account_id" => $informacoesConta["id"]
			)
		);
		foreach($sql_queries as $tabela => $query){
			$sql_query = "INSERT INTO $tabela (";
			for($i=0;$i<2;$i++){
				$j = 0;
				foreach($query as $coluna => $valor){
					if($j > 0)
						$sql_query .= ", ";
					if($i == 0)
						$sql_query .= "$coluna";
					else{
						if($coluna == "account_id")
							$valor = $accountId;
						$sql_query .= "'$valor'";
					}
					$j++;
				}
				if($i == 0)
					$sql_query .= ") VALUES (";
				else{
					$sql_query .= ");";
				}
			}
		}
		mysql_query($sql_query);
	}
?>