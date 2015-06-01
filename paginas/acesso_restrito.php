<?php
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
			<div class="conteudo_box pagina">
				<div class="box_frame" carregar_box="1">
					Acesso Restrito
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					<div class="box_frame_conteudo dark padding">
						O acesso a essa página é restrito e você não está autorizado a visualizar seu conteúdo.<br>
						<br>
						<form method="POST" action="?p=minha_conta">
							<input type="hidden" name="url" value="'.$pagina_atual.'" />
							<div align="center">
								<input type="submit" class="botao_azul" value="entrar">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	';
?>