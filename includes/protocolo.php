<?php
	$referencia = $_SERVER['HTTP_REFERER'];
	$server_name = $_SERVER['SERVER_NAME'];
	$uri = $_SERVER ['REQUEST_URI'];
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$ip = $_SERVER["REMOTE_ADDR"];
	$pagina_atual = "http://$server_name$uri";
?>