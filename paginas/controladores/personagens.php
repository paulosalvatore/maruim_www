<?php
	session_start();
	require_once("../../conexao/conexao.php");
	include("../../includes/funcoes.php");
	check_is_ajax(__FILE__);
	include("../../includes/classes/ClassFuncao.php");
	include("../../includes/classes/ClassPersonagem.php");
	$ClassPersonagem = new Personagem();
	foreach($_REQUEST as $c => $v)
		$$c = addslashes($v);
	if($acao == "buscar"){
		$informacoesPersonagem = $ClassPersonagem->getInformacoesPersonagem($personagem);
		if(count($informacoesPersonagem) == 0)
			return false;
		echo $informacoesPersonagem["nome"];
	}
?>