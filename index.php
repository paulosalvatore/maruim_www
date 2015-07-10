<?php
	session_start();
	header("Content-Type: text/html; charset=ISO-8859-1", true);
	require_once("conexao/conexao.php");
	include("includes/classes/ClassConta.php");
	include("includes/classes/ClassFuncao.php");
	include("includes/classes/ClassPersonagem.php");
	include("includes/classes/ClassServidor.php");
	$ClassConta = new Conta();
	$ClassFuncao = new Funcao();
	$ClassServidor = new Servidor();
	$ClassPersonagem = new Personagem();
	include("includes/variaveis.php");
	include("includes/protocolo.php");
	include("includes/data.php");
	include("includes/funcoes.php");
	include("includes/config.php");
	include("includes/conteudo_nao_encontrado.php");
	$login = $_SESSION["login"];
	$senha = $_SESSION["senha"];
	$usuarioEncontrado = false;
	$ativarOverlay = false;
	if(!empty($login) OR (!empty($senha))){
		if($ClassConta->validarConta($login, $senha)){
			$informacoesConta = $ClassConta->getInformacoesConta($login);
			if(count($informacoesConta) > 0){
				$usuarioEncontrado = true;
				$accountId = $informacoesConta["id"];
				if($informacoesConta["ultimo_acesso"] > 0)
					$ClassConta->registrarUltimoAcesso($accountId);
			}
		}
		else
			session_unset();
	}
	if((in_array($pagina, $config["login_obrigatorio"])) AND (!$usuarioEncontrado)){
		$incluir_arquivo = "login_necessario";
		session_unset();
	}
	elseif((in_array($pagina, $config["acesso_restrito"])) AND ($informacoesConta["acesso_pagina"] != 1))
		$incluir_arquivo = "acesso_restrito";
	include("corpo.php");
	$nomesPaginas = array(
		"ultimas_noticias" => "Últimas Notícias",
		"arquivo_noticias" => "Arquivo de Notícias",
		"registro_mudancas" => "Registro de Mudanças",
		"caracteristicas" => "Características",
		"informacoes_servidor" => "Informações do Servidor",
		"profissoes" => "Profissões",
		"npcs" => "NPCs",
		"tabela_experiencia" => "Tabela de Experiência",
		"ultimas_mortes" => "Últimas Mortes",
		"reportacoes" => "Reportações"
	);
	$nomePagina = ($nomesPaginas[$incluir_arquivo] ? $nomesPaginas[$incluir_arquivo] : formatarNomePagina($incluir_arquivo));
	echo'
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
		<html>
			<head>
				<title>'.$nomePagina.' - MaruimOT</title>
				<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
				<link rel="stylesheet" type="text/css" href="css/style.css">
				<script type="text/javascript" src="js/lib/jquery.js"></script>
				<script type="text/javascript" src="js/lib/jquery-ui.js"></script>
				<script type="text/javascript" src="js/lib/jquery-ui.datepicker-pt-BR.js"></script>
				<script type="text/javascript" src="js/lib/jquery.maskInput.js"></script>
				<script type="text/javascript" src="js/lib/jquery.tinysort.js"></script>
				<script type="text/javascript" src="js/lib/jquery.donetyping.js"></script>
				<script type="text/javascript" src="js/lib/jquery.zeroclipboard.js"></script>
				<script type="text/javascript" src="js/funcoes.js"></script>
				<script type="text/javascript" src="js/carregar_box.js"></script>
				';
				if(file_exists("js/paginas/".$pagina.".js"))
					echo'
						<script type="text/javascript" src="js/paginas/'.$pagina.'.js"></script>
					';
				echo'
			</head>
			<body>
				'.$conteudo.'
			</body>
		</html>
	';
	if($ativarOverlay == true)
		echo'
			<script>
				$(function(){
					ativarOverlay();
				});
			</script>
		';
?>