<?php
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
			<div class="conteudo_box pagina">
				<div class="box_frame" carregar_box="1">
					Últimas Mortes
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					<div class="box_frame_conteudo">
						<table width="100%" cellpadding="0" cellspacing="0" class="tabela odd">
							<tr class="cabecalho">
								<td width="20" align="center">
									#
								</td>
								<td width="30%">
									Jogador
								</td>
								<td>
									Detalhes da Morte
								</td>
							</tr>
							'.$ClassFuncao->exibirUltimasMortes().'
						</table>
					</div>
				</div>
			</div>
		</div>
	';
?>