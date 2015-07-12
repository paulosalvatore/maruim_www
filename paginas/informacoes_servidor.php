<?php
	$informacoes = $config["info"];
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
			<div class="conteudo_box pagina">
				<div class="box_frame" carregar_box="1">
					Informações do Servidor
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					<div class="box_frame_conteudo">
						<table width="100%" cellpadding="0" cellspacing="0" class="tabela odd">
							<tr class="item">
								<td width="260">
									<b>IP:</b>
								</td>
								<td>
									'.$config["info"]["ip"].'
								</td>
							</tr>
							<tr class="item">
								<td width="260">
									<b>Limite de Personagens por Conta:</b>
								</td>
								<td>
									'.$config["players"]["maxPersonagens"].'
								</td>
							</tr>
							<tr class="item">
								<td>
									<b>Limite de Jogadores do Rank:</b>
								</td>
								<td>
									'.$ClassPersonagem->limiteRank.'
								</td>
							</tr>
							';
							if($informacoes["protecao"] > 1)
								$conteudo_pagina .= '
									<tr class="item">
										<td>
											<b>Proteção de PvP:</b>
										</td>
										<td>
											Nível 1 ao '.$informacoes["protecao"].'<br>
											<br>
											Você não pode ser morto por outros jogadores até atingir o nível '.($informacoes["protecao"]+1).'.
										</td>
									</tr>
								';
							$conteudo_pagina .= '
							<tr class="item">
								<td>
									<b>Experiência:</b>
								</td>
								<td>
									';
									foreach($informacoes["taxas"]["experiencia"] as $nivelAtual => $taxa){
										$proximoEstagio = key($informacoes["taxas"]["experiencia"]);
										$exibirEstagio = $nivelAtual;
										if(empty($proximoEstagio))
											$exibirEstagio .= "+";
										else
											$exibirEstagio .= " até o ".($proximoEstagio-1);
										$conteudo_pagina .= '
											'.$exibirEstagio.' - '.$taxa.'x<br>
										';
										next($informacoes["taxas"]["experiencia"]);
									}
									$conteudo_pagina .= '
								</td>
							</tr>
							<tr class="item">
								<td>
									<b>Skill:</b>
								</td>
								<td>
									'.$informacoes["taxas"]["skill"].'x
								</td>
							</tr>
							<tr class="item">
								<td>
									<b>Magic:</b>
								</td>
								<td>
									'.$informacoes["taxas"]["magic"].'x
								</td>
							</tr>
							<tr class="item">
								<td>
									<b>Loot:</b>
								</td>
								<td>
									'.$informacoes["taxas"]["loot"].'
								</td>
							</tr>
							<tr class="item">
								<td>
									<b>PvP - Caveiras:</b>
								</td>
								<td>
									<b>Red:</b> '.$informacoes["red"].' abates não justificados.<br>
									<b>Black:</b> '.$informacoes["black"].' abates não justificados.<br>
									<br>
									<b>Tempo de cada abate não justificado:</b> '.$informacoes["tempo_frag"].'.
								</td>
							</tr>
							<tr class="item">
								<td>
									<b>Casas:</b>
								</td>
								<td>
									<b>Preço:</b> '.$informacoes["casas"]["sqm"].'gp/sqm<br>
									<b>Aluguel:</b> '.$informacoes["casas"]["aluguel"][0].'/'.$informacoes["casas"]["aluguel"][1].'<br>
									<br>
									<b>Quantidade de Casas:</b> 0.<br>
									<b>Casas Vazias:</b> 0.<br>
									<br>
									Você precisa ter nível '.$informacoes["casas"]["nivel"].' para comprar uma casa.<br>
									<br>
									<b>Atenção:</b> Você perderá sua casa se você não se conectar em seu personagem pelo menos uma vez a cada '.$informacoes["casas"]["tempo"].'.
								</td>
							</tr>
							<tr class="item">
								<td>
									<b>Comandos:</b>
								</td>
								<td>
									<a href="?p=informacoes_servidor-comandos">Clique aqui</a> para verificar a lista de comandos disponíveis.
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	';
?>