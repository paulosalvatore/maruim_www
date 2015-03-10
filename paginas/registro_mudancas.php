<?php
	$quantidadeMudancasRegistradas = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM z_registro_mudancas"));
	$quantidadeMudancasRegistradas = $quantidadeMudancasRegistradas["total"];
	$exibirQuantidadeMudancasRegistradas = "possui ".$quantidadeMudancasRegistradas.($quantidadeMudancasRegistradas == 1 ? " mudança registrada" : " mudanças registradas");
	$exibirQuantidadeMudancasRegistradas = ($quantidadeMudancasRegistradas == 0 ? "não possui mudanças registradas" : $exibirQuantidadeMudancasRegistradas);
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				';
				if($informacoesConta["acesso_pagina"] == 1)
					$conteudo_pagina .= '
						<div class="box_frame" carregar_box="1">
							Adicionar Registro de Mudanças
						</div>
						<div class="box_frame_conteudo_principal" carregar_box="1">
							<div class="box_frame_conteudo dark padding">
								<form id="adicionarRegistroMudanca">
									<table width="100%">
										<tr>
											<td width="150">
												<b>Local da Mudança:</b>
											</td>
											<td>
												<select name="local_mudanca">
													<option value="servidor">Servidor</option>
													<option value="site">Site</option>
												</select>
											</td>
										</tr>
										<tr valign="top">
											<td>
												<b>Descrição:</b>
											</td>
											<td>
												<textarea name="descricao" style="width: 100%;"></textarea>
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
					';
				$conteudo_pagina .= '
					<table cellpadding="0" cellspacing="0" class="tabela dark" width="100%">
						<tr class="cabecalho">
							<td>
								Registro de Mudanças
							</td>
						</tr>
						<tr class="item" height="40">
							<td>
								Atualmente o sistema '.$exibirQuantidadeMudancasRegistradas.'.
							</td>
						</tr>
					</table>
				';
				if($quantidadeMudancasRegistradas > 0){
					$conteudo_pagina .= '
						<br>
						<br>
						<table cellpadding="0" cellspacing="0" class="tabela odd" width="100%">
							<tr class="cabecalho" align="center">
								<td width="40">
									Local
								</td>
								<td width="50">
									Data
								</td>
								<td>
									Descrição
								</td>
								';
								if($informacoesConta["acesso_pagina"] == 1)
									$conteudo_pagina .= '
										<td width="70">
											Deletar
										</td>
									';
								$conteudo_pagina .= '
							</tr>
							';
							$queryRegistroMudancas = mysql_query("SELECT * FROM z_registro_mudancas ORDER BY data DESC");
							while ($resultadoRegistroMudancas = mysql_fetch_assoc($queryRegistroMudancas)){
								$conteudo_pagina .= '
									<tr class="item">
										<td align="center" class="top">
											'.ucfirst($resultadoRegistroMudancas["local_mudanca"]).'
										</td>
										<td align="center" class="top">
											'.formatarData($resultadoRegistroMudancas["data"]).'
										</td>
										<td style="word-break: break-all;">
											'.$resultadoRegistroMudancas["descricao"].'
										</td>
										';
										if($informacoesConta["acesso_pagina"] == 1)
											$conteudo_pagina .= '
												<td align="center" class="top">
													<input type="button" class="botao deletarRegistroMudanca" registro_id="'.$resultadoRegistroMudancas["id"].'" value="Deletar" />
												</td>
											';
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
?>