<?php
	$categorias = array(
		"action",
		"unique",
		"storage"
	);
	$tiposValores = array(
		1 => "Número Inteiro",
		2 => "Milissegundos"
	);
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
			<div class="conteudo_box pagina">
				<div class="box_frame" carregar_box="1">
					Adicionar ID(s) Utilizada(s)
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					<div class="box_frame_conteudo dark padding">
						<form id="adicionarIDUtilizada">
							<table width="100%">
								<tr>
									<td width="150">
										<b>Categoria:</b>
									</td>
									<td>
										<select name="categoria">
											';
											foreach($categorias as $categoria)
												$conteudo_pagina .= '<option value="'.$categoria.'">'.ucfirst($categoria).'</option>';
											$conteudo_pagina .= '
										</select>
									</td>
								</tr>
								<tr>
									<td>
										<b>ID:</b>
									</td>
									<td>
										<input type="text" name="min" placeholder="Mínimo" size="4" maxlength="6" />
										<input type="text" name="max" placeholder="Máximo" size="4" maxlength="6" />
									</td>
								</tr>
								<tr id="valor" style="display: none;">
									<td>
										<b>Valor:</b>
									</td>
									<td>
										<input type="text" name="valor" placeholder="Valor" size="4" maxlength="6" />
									</td>
								</tr>
								<tr id="tipo_valor" style="display: none;">
									<td>
										<b>Tipo de Valor:</b>
									</td>
									<td>
										<select name="tipo_valor">
											';
											foreach($tiposValores as $tipoValor => $exibirTipoValor)
												$conteudo_pagina .= '<option value="'.$tipoValor.'">'.$exibirTipoValor.'</option>';
											$conteudo_pagina .= '
										</select>
									</td>
								</tr>
								<tr valign="top">
									<td>
										<b>Descrição:</b>
									</td>
									<td>
										<textarea name="descricao" style="width: 100%;"></textarea><br>
										<span class="pequeno italico">Se estiver no campo "descrição", pressione ctrl+enter para adicionar.</span>
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
				';
				foreach($categorias as $categoria){
					$quantidadeIDsUtilizadas = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM z_ids_utilizadas WHERE (categoria LIKE '$categoria')"));
					$quantidadeIDsUtilizadas = $quantidadeIDsUtilizadas["total"];
					$exibirQuantidadeIDsUtilizadas = "possui ".$quantidadeIDsUtilizadas." ".ucfirst($categoria).($quantidadeIDsUtilizadas == 1 ? " ID utilizada" : " IDs utilizadas");
					$exibirQuantidadeIDsUtilizadas = ($quantidadeIDsUtilizadas == 0 ? "não possui ".ucfirst($categoria)." IDs utilizadas" : $exibirQuantidadeIDsUtilizadas);
					$conteudo_pagina .= '
						<hr>
						<br>
						<table cellpadding="0" cellspacing="0" class="tabela dark" width="100%">
							<tr class="cabecalho">
								<td>
									'.ucfirst($categoria).' IDs
								</td>
							</tr>
							<tr class="item" height="40">
								<td>
									Atualmente o sistema '.$exibirQuantidadeIDsUtilizadas.'.
								</td>
							</tr>
						</table>
						<br>
					';
					if($quantidadeIDsUtilizadas > 0){
						$conteudo_pagina .= '
							<div class="box_frame" carregar_box="1">
								Lista de '.ucfirst($categoria).' IDs Utilizadas
							</div>
							<div class="box_frame_conteudo_principal" carregar_box="0">
								<div class="box_frame_conteudo">
									<table class="tabela odd center" cellpadding="0" cellspacing="0" width="100%">
										<tr class="cabecalho">
											<td width="150">
												ID
											</td>
											';
											if($categoria == "storage")
												$conteudo_pagina .= '
													<td width="70">
														Valor
													</td>
													<td width="150">
														Tipo de Valor
													</td>
												';
											$conteudo_pagina .= '
											<td>
												Descrição
											</td>
										</tr>
										';
										$queryIDsUtilizadas = mysql_query("SELECT * FROM z_ids_utilizadas WHERE (categoria LIKE '$categoria') ORDER BY min ASC");
										while ($resultadoIDsUtilizadas = mysql_fetch_assoc($queryIDsUtilizadas)){
											$exibirID = $resultadoIDsUtilizadas["min"].(($resultadoIDsUtilizadas["max"] > 0 AND $resultadoIDsUtilizadas["max"] != $resultadoIDsUtilizadas["min"]) ? " - ".$resultadoIDsUtilizadas["max"] : "");
											$conteudo_pagina .= '
												<tr class="item">
													<td>
														<b>'.$exibirID.'</b>
													</td>
													';
													if($categoria == "storage")
														$conteudo_pagina .= '
															<td>
																'.$resultadoIDsUtilizadas["valor"].'
															</td>
															<td>
																'.$tiposValores[$resultadoIDsUtilizadas["tipo_valor"]].'
															</td>
														';
													$conteudo_pagina .= '
													<td>
														'.$resultadoIDsUtilizadas["descricao"].'
													</td>
												</tr>
											';
										}
										$conteudo_pagina .= '
									</table>
								</div>
							</div>
							<br>
						';
					}
				}
				$conteudo_pagina .= '
			</div>
		</div>
	';
?>