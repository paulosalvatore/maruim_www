<?php
	if($id == "pelo_jogo")
		$conteudo_pagina = '
			<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="reportacoes_pelo_jogo">
				<div class="conteudo_box pagina">
					<div class="setas">
						<div class="seta voltar">
							<a href="?p=reportacoes"><img src="imagens/corpo/arrow_up.gif" /> voltar</a>
						</div>
					</div>
					<div class="box_frame" carregar_box="1">
						Reportando pelo Jogo
					</div>
					<div class="box_frame_conteudo_principal borda2_padding" carregar_box="1">
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<div class="box_frame_conteudo" carregar_box="1">
										<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
											<tr class="conteudo_box">
												<td class="padding">
													Além de poder reportar erros pelo site, você também pode fazer isso direto pelo jogo.<br>
													<br>
													Para isso, você deve estar conectado em algum personagem de sua conta e apertar as teclas "<i>Ctrl + Z</i>".<br>
													Você também pode clicar com o botão direito do mouse e clicar na opção "<i>Report Coordinate</i>".
													<img src="imagens/guias/reportacoes/report_coordinate.png" alt="" title="Report Coordinate" /><br>
													<span class="pequeno">Caso a opção "<i>Tibia Classic Control</i>" esteja ativa, você deve manter pressionada a tecla "<i>Ctrl</i>" antes de clicar com o botão direito do mouse.</span><br>
													<br>
													A seguinte janela irá aparecer:<br>
													<br>
													<img src="imagens/guias/reportacoes/janela_reportar.png" alt="" title="Janela para Reportar" /><br>
													<br>
													<table cellpadding="0" cellspacing="0">
														<tr>
															<td width="17" style="padding: 0px;">
																<img src="imagens/guias/circulo1.png">
															</td>
															<td>
																<b>Categoria</b>
															</td>
														</tr>
														<tr>
															<td colspan="2">
																Selecione em qual categoria a reportação se classifica.<br>
																<span class="pequeno">Caso você tenha clicado em "<i>Report Coordinate</i>" e selecionado a opção "<i>Map</i>", a posição onde você clicou será gravada. Do contrário, a posição do seu personagem será gravada.</span>
															</td>
														</tr>
														<tr>
															<td width="17" style="padding: 0px;">
																<img src="imagens/guias/circulo2.png">
															</td>
															<td>
																<b>Descrição</b>
															</td>
														</tr>
														<tr>
															<td colspan="2">
																Use esse campo para escrever uma breve descrição sobre o problema reportado.
															</td>
														</tr>
													</table>
													<br>
													Todas as reportações serão registradas no sistema e você pode acessar <a href="?p=reportacoes">essa página</a> para visualizar todos os registros de sua conta.<br>
													<br>
													<b>Atenção:</b> Utilize esse sistema apenas para reportar erros.
												</td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		';
	else{
		$reportacoes = array();
		$quantidadeReportacoesConcluidas = 0;
		$quantidadeReportacoesPendentes = 0;
		$buscarConta = ($informacoesConta["acesso_pagina"] != 1 ? "WHERE (conta LIKE '$accountId')" : "");
		$queryReportacoes = mysql_query("SELECT * FROM reports $buscarConta ORDER BY data DESC");
		while ($resultadoReportacoes = mysql_fetch_assoc($queryReportacoes)){
			$reportacoes[] = $resultadoReportacoes;
			if($resultadoReportacoes["consertado"] == 1)
				$quantidadeReportacoesConcluidas++;
			else
				$quantidadeReportacoesPendentes++;
		}
		$quantidadeReportacoes = count($reportacoes);
		$conteudo_pagina = '
			<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
				<div class="conteudo_box pagina">
					';
					if($informacoesConta["acesso_pagina"] != 1)
						$conteudo_pagina .= '
							<br>
							<div class="small_box_frame atencao" style="display: block;" carregar_box="1">
								<b>Você também pode reportar direto pelo jogo!</b><br>
								<a href="?p=reportacoes-pelo_jogo">Clique aqui</a> para saber como.
							</div>
							<div class="box_frame" carregar_box="1">
								Reportar
							</div>
							<div class="box_frame_conteudo_principal" carregar_box="1">
								<div class="box_frame_conteudo dark padding">
									<form id="adicionarReportacao">
										<table width="100%">
											<tr>
												<td width="150">
													<b>Categoria:</b>
												</td>
												<td>
													<select name="categoria">
														<option value="">Selecione uma opção</option>
														<option value="site">Site</option>
														<option value="mapa">Mapa</option>
														<option value="digitacao">Digitação</option>
														<option value="tecnico">Técnico</option>
														<option value="outro">Outro</option>
													</select>
												</td>
											</tr>
											<tr valign="top">
												<td width="100">
													<b>Mensagem:</b>
												</td>
												<td>
													<textarea name="mensagem" maxlength="255" style="width: 100%;"></textarea><br>
													<span class="pequeno italico">
														Caracteres restantes: <span id="caracteresRestantes"></span><br>
														Pressione ctrl+enter para reportar.
													</span>
												</td>
											</tr>
											<tr align="center">
												<td colspan="2" style="padding-top: 10px;">
													<input type="submit" class="botao" value="Reportar" />
												</td>
											</tr>
										</table>
									</form>
								</div>
							</div>
							<br>
							<br>
						';
					$conteudo_pagina .= '
					<table cellpadding="0" cellspacing="0" class="tabela dark" width="100%">
						<tr class="cabecalho">
							<td>
								Quantidade de Reportações
							</td>
						</tr>
						<tr class="item" height="40">
							<td>
								'.($informacoesConta["acesso_pagina"] != 1 ? 'Você '.($quantidadeReportacoes > 0 ? "reportou $quantidadeReportacoes vez".($quantidadeReportacoes > 1 ? "es" : "")." até agora" : "não reportou nenhuma vez até agora") : "Atualmente o sistema ".($quantidadeReportacoes > 0 ? "possui $quantidadeReportacoes reportaç".($quantidadeReportacoes > 1 ? "ões registradas" : "ão registrada") : "não possui nenhuma reportação registrada")).'.
							</td>
						</tr>
					</table>
					';
					if($quantidadeReportacoes > 0){
						$conteudo_pagina .= '
							<br>
							<br>
							<table cellpadding="0" cellspacing="0" class="tabela dark" width="100%">
								<tr class="cabecalho">
									<td>
										Status das Reportações
									</td>
								</tr>
								<tr class="item" height="40">
									<td>
										<span class="verde">'.$quantidadeReportacoesConcluidas." ".($quantidadeReportacoesConcluidas > 1 ? "reportações resolvidas" : "reportação resolvida").'</span><span id="statusConcluidas"> (exibindo)</span><br>
										<span class="vermelho">'.$quantidadeReportacoesPendentes." ".($quantidadeReportacoesPendentes > 1 ? "reportações aguardando resolução" : "reportação aguardando resolução").'</span><span id="statusPendentes"> (exibindo)</span><br>
									</td>
								</tr>
							</table>
							<br>
							<br>
							<input type="button" class="botao" id="mostrarTodas" value="Mostrar Todas" />
							<input type="button" class="botao" id="mostrarPendentes" value="Mostrar Pendentes" />
							<input type="button" class="botao" id="mostrarConcluidas" value="Mostrar Concluídas" /><br>
							<br>
							<table id="reportacoes" cellpadding="0" cellspacing="0" class="tabela odd" width="100%">
								<tr class="cabecalho" align="center">
									<td width="100">
										Resolvida em
									</td>
									<td width="40">
										Categoria
									</td>
									<td width="80">
										Data
									</td>
									<td>
										Descrição
									</td>
									';
									if($informacoesConta["acesso_pagina"] == 1)
										$conteudo_pagina .= '
											<td width="70">
												Opções
											</td>
										';
									$conteudo_pagina .= '
								</tr>
								<tr class="item vazio ocultar">
									<td colspan="5">
										Nenhuma reportação para exibir.
									</td>
								</tr>
								';
								foreach($reportacoes as $reportacao){
									$classeStatusReportacao = 'concluida ocultar';
									if($reportacao["consertado"] == 0)
										$classeStatusReportacao = 'pendente exibir';
									$statusReportacao = ($reportacao["consertado"] == 0 ? '<img src="imagens/geral/excluir.png" title="Reportação Aguardando" />' : formatarData($reportacao["data_consertado"]));
									$conteudo_pagina .= '
										<tr class="item '.$classeStatusReportacao.'">
											<td align="center" class="top">
												'.$statusReportacao.'
											</td>
											<td align="center" class="top">
												'.ucfirst($reportacao["categoria"]).'
											</td>
											<td align="center" class="top">
												'.formatarData($reportacao["data"]).'
											</td>
											<td style="word-break: break-word; text-align: justify;" class="top">
												'.($informacoesConta["acesso_pagina"] == 1 ? 'Reportado por: <b>"'.$ClassConta->exibirNomeConta($reportacao["conta"], $reportacao["jogador"]).'"</b><br>' : '').'
												'.utf8_decode(stripslashes(preg_replace('/\n/', '<br>', htmlspecialchars(utf8_encode($reportacao["mensagem"])), 4))).'
											</td>
											';
											if($informacoesConta["acesso_pagina"] == 1){
												$conteudo_pagina .= '
													<td align="center" class="top">
														'.($reportacao["consertado"] == 0 ? '
															<input type="button" class="botao copiarPosicaoReportacoes" data-posicao="/goto '.$reportacao["posicao_x"].','.$reportacao["posicao_y"].','.$reportacao["posicao_z"].'" value="Copiar Posição" style="margin-bottom: 3px;" /><br>
															<input type="button" class="botao concluirReportacao" registro_id="'.$reportacao["id"].'" value="Corrigido" style="margin-bottom: 3px;" /><br>
														' : "").'
														<input type="button" class="botao deletarReportacao" registro_id="'.$reportacao["id"].'" value="Deletar" />
													</td>
												';
											}
											$conteudo_pagina .= '
										</tr>
									';
								}
								$conteudo_pagina .= '
							</table>
							<br>
						';
					}
					$conteudo_pagina .= '
				</div>
			</div>
		';
	}
?>