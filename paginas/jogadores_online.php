<?php
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				<div class="box_frame" carregar_box="1">
					Informações do Servidor
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					<table width="100%" cellpadding="0" cellspacing="0" class="tabela odd">
						<tr class="item">
							<td width="230" class="negrito">
								Status:
							</td>
							<td>
								'.$ClassServidor->statusServidor().'
							</td>
						</tr>
						'.$ClassServidor->exibirTempoOnline().'
						<tr class="item">
							<td class="negrito">
								Jogadores Online:
							</td>
							<td>
								'.$ClassServidor->pegarNumeroJogadoresOnline().'
							</td>
						</tr>
						<tr class="item">
							<td class="negrito">
								Récorde de Jogadores Online:
							</td>
							<td>
								'.$ClassServidor->pegarRecordeOnline().'
							</td>
						</tr>
						<tr class="item">
							<td class="negrito">
								Modo de PvP:
							</td>
							<td>
								Aberto
							</td>
						</tr>
						<tr class="item">
							<td class="negrito">
								Versão:
							</td>
							<td>
								'.$config["versao"]["exibicao"].'
							</td>
						</tr>
					</table>
				</div>
				<br>
				<div class="box_frame" carregar_box="1">
					Informações do Servidor
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					'.$ClassServidor->exibirJogadoresOnline().'
				</div>
			</div>
		</div>
	';
?>