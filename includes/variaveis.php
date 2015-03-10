<?php
	$pagina = $_REQUEST["p"];
	$p = explode("-", $_REQUEST["p"]);
	// if(count($p) > 1){
	$pagina = $p[0];
	$id = $p[1];
	$acao = $p[2];
	// }
	// $area = $_REQUEST["a"];
	// $id = $_REQUEST["id"];
	if(empty($pagina))
		$pagina = "ultimas_noticias";
?>