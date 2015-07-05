<?php
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="">
			<div class="conteudo_box pagina">
				<table width="100%" cellpadding="0" cellspacing="0" class="tabela">
					<tr class="cabecalho">
						<td>
							Gerar Chave de Acesso
						</td>
					</tr>
					<tr class="item">
						<td>
							<textarea id="chave_acesso" onClick="this.select();"></textarea><br>
							<br>
							<div align="center">
								<input type="button" id="gerar_chave_acesso" data-asd="" class="botao" value="Gerar" />
								<input type="reset" class="botao" value="Limpar" />
							</div>
							<br>
						</td>
					</tr>
				</table>
			</div>
		</div>
	';
?>