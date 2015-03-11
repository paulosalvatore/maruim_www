<?php
	include("includes/classes/ClassPersonagem.php");
	$ClassPersonagem = new Personagem();
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
			<div class="conteudo_box pagina">
				<div class="box_frame" carregar_box="1">
					Informações do Servidor
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					<div class="box_frame_conteudo dark padding">
						<b>Limite de Personagens por Conta:</b> '.$config["players"]["maxPersonagens"].'<br>
						<b>Limite de Jogadores do Rank:</b> '.$ClassPersonagem->limiteRank.'<br>
					</div>
				</div>
			</div>
		</div>
	';
?>