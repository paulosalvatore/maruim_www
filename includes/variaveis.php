<?php
	$pagina = $_REQUEST["p"];
	$p = explode("-", $_REQUEST["p"]);
	$pagina = $p[0];
	$id = $p[1];
	$acao = $p[2];
	if(empty($pagina))
		$pagina = "ultimas_noticias";
?>