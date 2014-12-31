<?php
	require("../conexao.php");
	include("data.php");
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	$formulario = $_REQUEST["formulario"];
	parse_str(addslashes($formulario), $formulario);
	$conta = $formulario["conta"];
	$senha = sha1($formulario["senha"]);
	$selecao = mysql_query("SELECT * FROM accounts WHERE ((name LIKE '$conta') AND (password LIKE '$senha'))"); 
	$row = mysql_fetch_array($selecao);
	if(empty($row))
		echo 0;
	else{
		session_start();
		$_SESSION["login"] = $conta;
		mysql_query("UPDATE accounts SET lastday = '$time' WHERE name = '$conta'");
		echo 1;
	}
?>