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
	$tabela = "z_ids_utilizadas";
	include("../../includes/classes/ClassFuncao.php");
	$ClassFuncao = new Funcao();
	function checarRange($min, $max, $checar, $valor1, $valor2){
		return (($valor1 == $valor2) AND ($checar >= $min AND $checar <= $max));
	}
	function verificarIDUtilizada($min, $max, $valor, $categoria){
		$liberarID = true;
		$queryVerificar = mysql_query("SELECT * FROM z_ids_utilizadas WHERE (categoria LIKE '$categoria')");
		while ($resultadoVerificar = mysql_fetch_assoc($queryVerificar)){
			if(($max == 0) OR ($max == $min)){
				if(checarRange($resultadoVerificar["min"], $resultadoVerificar["max"], $min, $resultadoVerificar["valor"], $valor)){
					$liberarID = false;
					break;
				}
			}
			else{
				for($i=$min;$i<=$max;$i++){
					if(checarRange($resultadoVerificar["min"], $resultadoVerificar["max"], $i, $resultadoVerificar["valor"], $valor)){
						$liberarID = false;
						break;
					}
				}
			}
		}
		return $liberarID;
	}
	if($acao == "adicionar"){
		$formulario = $ClassFuncao->separarForm($formulario, true);
		if($formulario["max"] < $formulario["min"])
			$formulario["max"] = $formulario["min"];
		if(verificarIDUtilizada($formulario["min"], $formulario["max"], $formulario["valor"], $formulario["categoria"])){
			$sql = array(
				"categoria" => $formulario["categoria"],
				"min" => $formulario["min"],
				"max" => $formulario["max"],
				"valor" => $formulario["valor"],
				"tipo_valor" => $formulario["tipo_valor"],
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
			echo 1;
		}
		else
			echo 0;
	}
?>