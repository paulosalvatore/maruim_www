<?php
	include("includes/config_criar_conta.php");
	$exibicao_formulario_criacao_conta = "";
	foreach($formulario_criacao_conta as $bloco){
		$exibicao_formulario_criacao_conta .= '
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
										$adicional = $valor_campo["adicional"];
										$variaveis[] = 'name="'.$id_campo.'"';
										$variaveis[] = 'id="'.$id_campo.'"';
										if(strpos($id_campo, "senha") !== false)
											$variaveis[] = 'type="password"';
										else
											$variaveis[] = 'type="text"';
										if($id_campo == "chave_acesso")
											$variaveis[] = 'value="'.$_REQUEST["chave_acesso"].'"';
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
										$input = "";
										$opcoes = $valor_campo["opcoes"];
										$opcao_ativa = $valor_campo["opcao_ativa"];
										$adicional = $valor_campo["adicional"];
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
									else
										$input = "";
									$exibicao_formulario_criacao_conta .= '
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
									if($adicional)
										$exibicao_formulario_criacao_conta .= '
											<tr valign="top">
												<td colspan="2" class="pequeno">
													'.$adicional.'
												</td>
											</tr>
										';
								}
								$exibicao_formulario_criacao_conta .= '
							</table>
						</td>
					</tr>
				</table>
			</div>
		';
	}
	$exibicao_formulario_criacao_conta .= '
		<div class="box_frame_conteudo" carregar_box="1">
			<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
				<tr class="conteudo dark">
					<td>
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr align="left">
								<td>
									<b>Por favor, marque a opção a seguir:</b><br>
									<br>
									<input id="acordo" type="checkbox"> Estou de acordo com o <a href="#">Acordo de Serviço</a>, as <a href="#">Regras</a> e a <a href="#">Política de Privacidade</a>.
									<div class="mensagem_erro"></div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	';
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				<div class="box_frame" carregar_box="1">
					Criar Nova Conta
				</div>
				<div class="box_frame_conteudo_principal borda2_padding" carregar_box="1">
					<form id="formulario_criacao_conta" align="center">
						'.$exibicao_formulario_criacao_conta.'
						<br>
						<input type="submit" class="botao" value="Criar Conta">
					</form>
					<br>
				</div>
			</div>
		</div>
	';
?>