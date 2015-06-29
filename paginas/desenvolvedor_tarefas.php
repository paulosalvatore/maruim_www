<?php
	$quantidadeTarefasRegistradas = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM z_tarefas"));
	$quantidadeTarefasRegistradas = $quantidadeTarefasRegistradas["total"];
	$exibirQuantidadeTarefasRegistradas = "possui ".$quantidadeTarefasRegistradas.($quantidadeTarefasRegistradas == 1 ? " tarefa registrada" : " tarefas registradas");
	$exibirQuantidadeTarefasRegistradas = ($quantidadeTarefasRegistradas == 0 ? "não possui tarefas registradas" : $exibirQuantidadeTarefasRegistradas);
	$quantidadeTarefasPendentes = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM z_tarefas WHERE (concluida LIKE '0')"));
	$quantidadeTarefasPendentes = $quantidadeTarefasPendentes["total"];
	$quantidadeTarefasConcluidas = $quantidadeTarefasRegistradas-$quantidadeTarefasPendentes;
	$exibirQuantidadeTarefasPendentes = $quantidadeTarefasPendentes.($quantidadeTarefasPendentes == 1 ? " tarefa pendente" : " tarefas pendentes");
	$exibirQuantidadeTarefasConcluidas = $quantidadeTarefasConcluidas.($quantidadeTarefasConcluidas == 1 ? " tarefa concluída" : " tarefas concluídas");
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				<div class="box_frame" carregar_box="1">
					Adicionar Tarefas
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					<div class="box_frame_conteudo dark padding">
						<form id="adicionarTarefa">
							<table width="100%">
								<tr>
									<td width="150">
										<b>Categoria:</b>
									</td>
									<td>
										<select name="categoria">
											<option value="site">Site</option>
											<option value="jogo">Jogo</option>
											<option value="mapa">Mapa</option>
										</select>
									</td>
								</tr>
								<tr valign="top">
									<td>
										<b>Descrição:</b>
									</td>
									<td>
										<textarea name="descricao" style="width: 100%;"></textarea><br>
										<span class="pequeno italico">Pressione ctrl+enter para adicionar.</span>
									</td>
								</tr>
								<tr align="center">
									<td colspan="2" style="padding-top: 10px;">
										<input type="submit" class="botao" value="Adicionar" />
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
				<br>
				<br>
				<table cellpadding="0" cellspacing="0" class="tabela dark" width="100%">
					<tr class="cabecalho">
						<td>
							Tarefas
						</td>
					</tr>
					<tr class="item" height="40">
						<td>
							Atualmente o sistema '.$exibirQuantidadeTarefasRegistradas.'.
						</td>
					</tr>
				</table>
				';
				if($quantidadeTarefasRegistradas > 0){
					$conteudo_pagina .= '
						<br>
						<br>
						<table cellpadding="0" cellspacing="0" class="tabela dark" width="100%">
							<tr class="cabecalho">
								<td>
									Tarefas Pendentes/Concluídas
								</td>
							</tr>
							<tr class="item" height="40">
								<td>
									<span class="verde">'.$exibirQuantidadeTarefasConcluidas.'</span><span id="statusConcluidas"> (exibindo)</span><br>
									<span class="vermelho">'.$exibirQuantidadeTarefasPendentes.'</span><span id="statusPendentes"> (exibindo)</span><br>
								</td>
							</tr>
						</table>
						<br>
						<br>
						<input type="button" class="botao" id="mostrarTodas" value="Mostrar Todas" />
						<input type="button" class="botao" id="mostrarPendentes" value="Mostrar Pendentes" />
						<input type="button" class="botao" id="mostrarConcluidas" value="Mostrar Concluídas" /><br>
						<br>
						<table id="tarefas" cellpadding="0" cellspacing="0" class="tabela odd" width="100%">
							<tr class="cabecalho" align="center">
								<td width="20">
									Concluída
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
								<td width="70">
									Opções
								</td>
							</tr>
							<tr class="item vazio ocultar">
								<td colspan="5">
									Nenhuma tarefa para exibir.
								</td>
							</tr>
							';
							$queryTarefas = mysql_query("SELECT * FROM z_tarefas ORDER BY data DESC");
							while ($resultadoTarefas = mysql_fetch_assoc($queryTarefas)){
								$tituloStatusTarefa = 'Tarefa Concluída';
								$imagemStatusTarefa = 'sucesso';
								$classeStatusTarefa = 'concluida ocultar';
								if($resultadoTarefas["concluida"] == 0){
									$tituloStatusTarefa = 'Tarefa Pendente';
									$imagemStatusTarefa = 'excluir';
									$classeStatusTarefa = 'pendente exibir';
								}
								$conteudo_pagina .= '
									<tr class="item '.$classeStatusTarefa.'">
										<td align="center" class="top">
											<img src="imagens/geral/'.$imagemStatusTarefa.'.png" title="'.$tituloStatusTarefa.'" />
										</td>
										<td align="center" class="top">
											'.ucfirst($resultadoTarefas["categoria"]).'
										</td>
										<td align="center" class="top">
											'.formatarData($resultadoTarefas["data"]).'
										</td>
										<td style="word-break: break-word; text-align: justify;" class="top">
											'.stripslashes($resultadoTarefas["descricao"]).'
										</td>
										<td align="center" class="top">
											<input type="button" class="botao concluirTarefa" registro_id="'.$resultadoTarefas["id"].'" value="Concluir" /><br>
											<input type="button" class="botao deletarTarefa" registro_id="'.$resultadoTarefas["id"].'" value="Deletar" style="margin-top: 2px;" />
										</td>
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
?>