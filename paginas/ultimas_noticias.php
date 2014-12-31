<?php
	$exibicao_noticias_rapidas = array();
	$exibicao_noticias = array();
	$sql = "SELECT * FROM z_noticias_rapidas ORDER BY data DESC";
	$query = mysql_query($sql);
	while ($resultado = mysql_fetch_assoc($query)) {
		$noticia_rapida_id = $resultado["id"];
		$noticia_rapida_imagem = $resultado["imagem"];
		$noticia_rapida_conteudo = $resultado["conteudo"];
		$noticia_rapida_data = formatarData($resultado["data"]);
		$noticia_rapida_deletado = $resultado["deletado"];
		if(($noticia_rapida_deletado == 0) AND (count($exibicao_noticias_rapidas) < $limite_noticias_rapidas))
			$exibicao_noticias_rapidas[] = '
				<div class="item">
					<div class="imagem">
						<div style="background-position: -'.($noticia_rapida_imagem*16).'px;"></div>
					</div>
					<div class="data">
						'.$noticia_rapida_data.'
					</div>
					<div class="conteudo">
						<div class="texto_breve">
							'.$noticia_rapida_conteudo.'
						</div>
						<div class="texto_completo">
							'.$noticia_rapida_conteudo.'
						</div>
					</div>
					<div class="exibir_ocultar">
						<div></div>
					</div>
					<div class="ellipsis">
						...
					</div>
				</div>
			';
	}
	$sql = "SELECT * FROM z_noticias ORDER BY data DESC";
	$query = mysql_query($sql);
	while ($resultado = mysql_fetch_assoc($query)) {
		$noticia_id = $resultado["id"];
		$noticia_imagem = $resultado["imagem"];
		$noticia_titulo = $resultado["titulo"];
		$noticia_conteudo = $resultado["conteudo"];
		$letra_inicial = limpaString($noticia_conteudo[0]);
		$noticia_conteudo[0] = "";
		$noticia_conteudo = '<img src="imagens/letras/letter_martel_'.$letra_inicial.'.gif">'.$noticia_conteudo;
		$noticia_data = formatarData($resultado["data"]);
		$noticia_deletado = $resultado["deletado"];
		if(($noticia_deletado == 0) AND (count($exibicao_noticias) < $limite_noticias))
			$exibicao_noticias[] = '
				<div class="item">
					<div class="titulo vermelho">
						<div class="imagem">
							<div style="background-position: -'.($noticia_imagem*32).'px;"></div>
						</div>
						<div class="data">
							'.$noticia_data.'
						</div>
						<div class="texto">
							'.$noticia_titulo.'
						</div>
					</div>
					<div class="conteudo_noticia">
						'.$noticia_conteudo.'
					</div>
				</div>
			';
	}
	if(count($exibicao_noticias_rapidas) == 0)
		$exibicao_noticias_rapidas = "Não há nenhuma notícia rápida para ser exibida.";
	else
		$exibicao_noticias_rapidas = implode("", $exibicao_noticias_rapidas);
	if(count($exibicao_noticias) == 0)
		$exibicao_noticias = "Não há nenhuma notícia para ser exibida.";
	else
		$exibicao_noticias = implode("", $exibicao_noticias);
	$conteudo_pagina .= '
		<script>
			$(function(){
				$(".noticias_rapidas .item .exibir_ocultar").click(function(event){
					var item = $(this).closest(".item");
					if(item.hasClass("ativo"))
						item.removeClass("ativo");
					else
						item.addClass("ativo");
				});
			});
		</script>
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="noticias_rapidas">
			<div class="conteudo_box">
				<div class="noticias_rapidas">
					'.$exibicao_noticias_rapidas.'
				</div>
			</div>
		</div>
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="noticias">
			<div class="conteudo_box noticias">
				'.$exibicao_noticias.'
			</div>
		</div>
	';
?>