<?php
	include("barra_esquerda.php");
	include("barra_direita.php");
	if(empty($incluir_arquivo)){
		$incluir_arquivo = $pagina;
		if(!file_exists("paginas/".$pagina.".php"))
			$incluir_arquivo = "nao_encontrado";
	}
	include("paginas/".$incluir_arquivo.".php");
	include("rodape.php");
	$conteudo .= '
		<div id="background" align="center">
			<div id="conteudo" pagina="'.$pagina.'">
				<table class="principal" cellpadding="0" cellspacing="0">
					<tr valign="top">
						<td id="barra_esquerda">
							'.$conteudo_barra_esquerda.'
						</td>
						<td id="corpo">	
							'.$conteudo_pagina.'
							'.$conteudo_rodape.'
						</td>
						<td id="barra_direita">	
							'.$conteudo_barra_direita.'
						</td>
					</tr>
				</table>
			</div>
		</div>
	';
?>