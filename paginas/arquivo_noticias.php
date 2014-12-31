<?php
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				<table class="tabela dark" cellpadding="0" cellspacing="0" width="100%">
					<tr class="cabecalho">
						<td colspan="3">
							Buscar no Arquivo de Notícias
						</td>
					</tr>
					<tr class="item bold center">
						<td width="40%">
							Período de Tempo
						</td>
						<td width="27%">
							Tipo
						</td>
						<td width="33%">
							Categoria
						</td>
					</tr>
					<tr class="item">
						<td align="center">
							A Partir de:<br>
							<input type="text" class="input data de" value="'.$data_min.'" data-min="'.$data_min.'" data-max="'.$data.'" style="width: 70px; margin-left: 5px;">
							<br>
							Até:<br>
							<input type="text" class="input data para" value="'.$data.'" style="width: 70px;">
						</td>
						<td>
							<input type="checkbox" id="tipo_0" checked="checked" name="tipos" value="0"><label for="tipo_0">Notícias Rápidas</label><br>
							<input type="checkbox" id="tipo_1" checked="checked" name="tipos" value="1"><label for="tipo_1">Notícias</label>
						</td>
						<td>
							';
							foreach($categorias_noticias_rapidas as $chave => $categoria)
								$conteudo_pagina .= '
									<input type="checkbox" id="categoria_'.$chave.'" name="categorias" value="'.$chave.'" checked="checked">
									<label for="categoria_'.$chave.'" style="margin-left: 16px;">
										'.$categoria.'
										<div class="imagem_noticia_rapida" style="background-position: -'.($chave*16).'px;"></div>
									</label>
									<br>
								';
							$conteudo_pagina .= '
						</td>
					</tr>
				</table>
				<br>
				<div align="center">
					<input type="submit" class="botao" value="Procurar">
				</div>
			</div>
		</div>
	';
?>