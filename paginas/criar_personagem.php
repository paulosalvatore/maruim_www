<?php
	include("includes/classes/ClassPersonagem.php");
	$ClassPersonagem = new Personagem();
	$listaPersonagens = $ClassPersonagem->getListaPersonagens($accountId);
	if(count($listaPersonagens) >= $config["players"]["maxPersonagens"])
		$conteudo_criacao_personagem = $conteudo_nao_encontrado;
	else{
		include("includes/config_criar_personagem.php");
		$exibicao_formulario_criacao_personagem = "";
		foreach($formulario_criacao_personagem as $bloco){
			$exibicao_formulario_criacao_personagem .= '
				<div class="box_frame_conteudo" carregar_box="1">
					<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
						<tr class="conteudo dark">
							<td>
								<table width="100%" cellpadding="0" cellspacing="0">
									';
									foreach($bloco as $id_campo => $valor_campo){
										$exibicao_campo = $valor_campo["exibicao"];
										$tipo_campo = $valor_campo["tipo"];
										if($tipo_campo == "texto"){
											$variaveis = array();
											$size = $valor_campo["size"];
											$maxlength = $valor_campo["maxlength"];
											$igual = $valor_campo["igual"];
											$sugestao = $valor_campo["sugestao"];
											$variaveis[] = 'name="'.$id_campo.'"';
											$variaveis[] = 'id="'.$id_campo.'"';
											if(strpos($id_campo, "senha") !== false)
												$variaveis[] = 'type="password"';
											else
												$variaveis[] = 'type="text"';
											if($size > 0)
												$variaveis[] = 'size="'.$size.'"';
											else
												$variaveis[] = 'size="25"';
											if($maxlength > 0)
												$variaveis[] = 'maxlength="'.$maxlength.'"';
											if(!empty($igual))
												$variaveis[] = 'igual="'.$igual.'" onBlur="$(\'#'.$igual.'\').blur();"';
											$variaveis = implode(" ", $variaveis);
											$input = '<input '.$variaveis.'>';
											$adicionais = '<div class="imagem certo_errado errado"></div>';
											if($sugestao)
												$adicionais .= '<br>[<a href="#" id="sugerir_nome">Sugerir Nome</a>]';
										}
										elseif($tipo_campo == "opcao_radio"){
											$adicionais = '';
											$input = '<input type="hidden" id="'.$id_campo.'">';
											$opcoes = $valor_campo["opcoes"];
											$opcao_ativa = $valor_campo["opcao_ativa"];
											foreach($opcoes as $opcao){
												$exibicao_opcao = $opcao["exibicao"];
												$valor_opcao = $opcao["valor"];
												$id_opcao = $id_campo.'_'.$valor_opcao;
												$variaveis_opcao = array();
												$variaveis_opcao[] = 'name="'.$id_campo.'"';
												$variaveis_opcao[] = 'id="'.$id_opcao.'"';
												$variaveis_opcao[] = 'value="'.$valor_opcao.'"';
												if($valor_opcao == $opcao_ativa)
													$variaveis_opcao[] = 'checked="'.$checked.'"';
												$variaveis_opcao = implode(" ", $variaveis_opcao);
												$input .= '
													<input type="radio"'.$variaveis_opcao.'>
													<label for="'.$id_opcao.'">
														'.$exibicao_opcao.'
													</label>
												';
											}
										}
										elseif($tipo_campo == "lista"){
											$adicionais = '';
											$input = "";
											$input .= '<select id="'.$id_campo.'" name="'.$id_campo.'">';
											$opcoes = $valor_campo["opcoes"];
											$opcao_ativa = $valor_campo["opcao_ativa"];
											foreach($opcoes as $opcao){
												$exibicao_opcao = $opcao["exibicao"];
												$valor_opcao = $opcao["valor"];
												$id_opcao = $id_campo.'_'.$valor_opcao;
												$variaveis_opcao = array();
												$variaveis_opcao[] = 'id="'.$id_opcao.'"';
												if($valor_opcao == $opcao_ativa)
													$variaveis_opcao[] = 'checked="'.$checked.'"';
												$variaveis_opcao = implode(" ", $variaveis_opcao);
												$input .= '
													<option value="'.$valor_opcao.'" '.$variaveis_opcao.'>'.$exibicao_opcao.'</option>
												';
											}
											$input .= '</select>';
										}
										else
											$input = "";
										$exibicao_formulario_criacao_personagem .= '
											<tr valign="top">
												<td width="120" align="left">
													<b class="exibicao_bloco">'.$exibicao_campo.':</b>
												</td>
												<td width="220" align="left">
													'.$input.'
													'.$adicionais.'
													<div class="mensagem_erro"></div>
												</td>
											</tr>
										';
									}
									$exibicao_formulario_criacao_personagem .= '
								</table>
							</td>
						</tr>
					</table>
				</div>
			';
			$conteudo_criacao_personagem = '
				<form id="formulario_criacao_personagem" align="center">
					'.$exibicao_formulario_criacao_personagem.'
					<br>
					<div align="center">
						<div class="botao_azul1">
							<input type="submit" class="botao_azul" value="criar_personagem" />
						</div>
						<div class="botao_azul2">
							<input type="button" class="botao_azul" value="voltar" onClick="document.location = \'?p=minha_conta\'" />
						</div>
					</div>
				</form>
				<br>
			';
		}
	}
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				<div class="box_frame" carregar_box="1">
					Criar Novo Personagem
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					'.$conteudo_criacao_personagem.'
				</div>
			</div>
		</div>
	';
?>