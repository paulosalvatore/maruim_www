<?php
	session_start();
	header("Content-Type: text/html; charset=ISO-8859-1", true);
	require_once("conexao.php");
	include("includes/variaveis.php");
	include("includes/data.php");
	include("includes/funcoes.php");
	include("includes/config.php");
	$login = $_SESSION["login"];
	$usuario_encontrado = false;
	$sql = "SELECT * FROM accounts WHERE (name LIKE '$login')";
	$query = mysql_query($sql);
	while ($resultado = mysql_fetch_assoc($query)){
		// $id_usuario = $resultado['id'];
		$usuario_encontrado = true;
	}
	if((!isset($login)) OR (!$usuario_encontrado))
		session_unset();
	if((in_array($pagina, $config["login_obrigatorio"])) AND (!$usuario_encontrado)){
		$incluir_arquivo = "login_necessario";
		session_unset();
	}
	include("corpo.php");
	echo'
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
		<html>
			<head>
				<title>Site - OpenTibia</title>
				<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
				<link rel="stylesheet" type="text/css" href="css/style.css">
				<script type="text/javascript" src="js/lib/jquery.js"></script>
				<script type="text/javascript" src="js/lib/jquery-ui.js"></script>
				<script type="text/javascript" src="js/lib/jquery-ui.datepicker-pt-BR.js"></script>
				<script type="text/javascript" src="js/lib/jquery.maskInput.js"></script>
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
?>