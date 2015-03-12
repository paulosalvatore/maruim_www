<?php
	if(!$usuarioEncontrado){
		$conteudo_minha_conta = '
			<div class="small_box_frame erro" carregar_box="1">
				<b>Os seguintes erros ocorerram:</b><br>
				Usuário e/ou senha inválidos. Digite dados válidos.
			</div>
			<br>
			<div class="box_frame" carregar_box="1">
				Entrar na Conta
			</div>
			<div class="box_frame_conteudo_principal sombra" carregar_box="1">
				<div class="box_frame_conteudo dark">
					<form id="form_login">
						<table width="100%">
							<tr>
								<td width="100">
									<b>Conta:</b>
								</td>
								<td width="280">
									<input type="password" name="conta" style="width: 278px;">
								</td>
							</tr>
							<tr>
								<td>
									<b>Senha:</b>
								</td>
								<td>
									<input type="password" name="senha" style="width: 278px;">
								</td>
							</tr>
							<tr>
								<td colspan="2" align="right">
									<input type="submit" class="botao_azul" value="entrar">
								</td>
							</tr>
							<tr>
								<td colspan="2" align="right">
									<input type="button" class="botao_azul" value="perdeu_sua_conta">
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<br>
			Tarefas para essa página:
			<ul class="tarefas">
				<li>
					Criar Formulário de Login
				</li>
				<li>
					Criar Formulário de "Perdeu sua Conta?"
				</li>
				<li>
					Criar Sistema de Login/Criação de Conta com Facebook
				</li>
			</ul>
		';
	}
	else{
		include("includes/classes/ClassPersonagem.php");
		$ClassPersonagem = new Personagem();
		if(!empty($id)){
			if($acao == "editar"){
				if($ClassPersonagem->validarPersonagemConta($id, $accountId)){
					$informacoesPersonagem = $ClassPersonagem->getInformacoesPersonagem($id);
					$check_ocultar_conta = '';
					if($informacoesPersonagem["ocultar_conta"] == 1)
						$check_ocultar_conta = ' checked="checked"';
					$conteudo_minha_conta = '
						<div class="small_box_frame erro" carregar_box="1">
							<b>Algum erro ocorreu.</b><br>
							Verifique as informações e tente novamente.
						</div>
						<div class="box_frame" carregar_box="1">
							Editar Informações do Personagem
						</div>
						<div class="box_frame_conteudo" carregar_box="1">
							<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
								<tr class="conteudo dark">
									<td>
										<form id="informacoes_personagem" personagem="'.$id.'">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr valign="top">
													<td width="120" align="left">
														<b class="exibicao_bloco">Nome:</b>
													</td>
													<td align="left">
														'.$informacoesPersonagem["nome"].'
													</td>
												</tr>
												<tr valign="top">
													<td align="left">
														<b class="exibicao_bloco">Ocultar Conta:</b>
													</td>
													<td align="left">
														<input type="checkbox" id="ocultar_conta" name="ocultar_conta"'.$check_ocultar_conta.'><label for="ocultar_conta">Marque para esconder as informações de sua conta.</label>
													</td>
												</tr>
												<tr valign="top">
													<td align="left">
														<b class="exibicao_bloco">Comentário:</b>
													</td>
													<td align="left">
														<textarea maxlength="500" name="comentario">'.$informacoesPersonagem["comentario"].'</textarea>
													</td>
												</tr>
												<tr valign="top">
													<td colspan="2" align="center">
														<input type="submit" class="botao" value="Editar">
														<input type="button" class="botao" value="Voltar" onClick="document.location = \'?p=minha_conta\'">
													</td>
												</tr>
											</table>
										</form>
									</td>
								</tr>
							</table>
						</div>
					';
				}
				else
					$conteudo_minha_conta = $conteudo_nao_encontrado_full;
			}
			elseif($acao == "editado"){
				$conteudo_minha_conta = '
					<div class="box_frame" carregar_box="1">
						Informações do Personagem Editadas
					</div>
					<div class="box_frame_conteudo_principal" carregar_box="1">
						<div class="box_frame_conteudo padding dark">
							As informações do personagem foram editadas com sucesso.
						</div>
					</div>
					<br>
					<div align="center">
						<input type="button" class="botao_azul" value="voltar" onClick="document.location = \'?p=minha_conta\'"></a>
					</div>
				';
			}
			elseif($acao == "deletar"){
				if($ClassPersonagem->validarPersonagemConta($id, $accountId)){
					$informacoesPersonagem = $ClassPersonagem->getInformacoesPersonagem($id);
					$conteudo_minha_conta = '
						<div class="small_box_frame erro" carregar_box="1">
							<b>Algum erro ocorreu.</b><br>
							Verifique as informações e tente novamente.
						</div>
						<div class="box_frame" carregar_box="1">
							Deletar Personagem
						</div>
						<div class="box_frame_conteudo" carregar_box="1">
							<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
								<tr class="conteudo dark">
									<td>
										<form id="deletar_personagem" personagem="'.$id.'">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td width="230" align="left">
														<b class="exibicao_bloco">Nome:</b>
													</td>
													<td align="left">
														'.$informacoesPersonagem["nome"].'
													</td>
												</tr>
												<tr>
													<td align="left">
														<b class="exibicao_bloco">Confirme a Senha:</b>
													</td>
													<td align="left">
														<input type="password" id="confirmar_senha" name="confirmar_senha">
													</td>
												</tr>
												<tr>
													<td align="left">
														<b class="exibicao_bloco">Digite a Chave de Recuperação:</b>
													</td>
													<td align="left">
														<input type="text" id="chave_recuperacao" name="chave_recuperacao" style="width: 290px;">
													</td>
												</tr>
												<tr valign="top">
													<td colspan="2" align="center">
														<input type="submit" class="botao" value="Deletar">
														<input type="button" class="botao" value="Voltar" onClick="document.location = \'?p=minha_conta\'">
													</td>
												</tr>
											</table>
										</form>
									</td>
								</tr>
							</table>
						</div>
					';
				}
				else
					$conteudo_minha_conta = $conteudo_nao_encontrado_full;
			}
			elseif($acao == "deletado"){
				$informacoesPersonagem = $ClassPersonagem->getInformacoesPersonagem($id);
				if($informacoesPersonagem["deletar"] > 0)
					$conteudo_minha_conta = '
						<div class="box_frame" carregar_box="1">
							Personagem Deletado
						</div>
						<div class="box_frame_conteudo_principal" carregar_box="1">
							<div class="box_frame_conteudo padding dark">
								A solicitação para deletar seu personagem foi registrada com sucesso.<br>
								<br>
								Seu personagem será deletado em '.$ClassPersonagem->diasDeletarPersonagem.' dias.<br>
								<br>
								Caso queira, você pode desfazer a solicitação na página da sua conta até o dia <b>'.$ClassPersonagem->formatarData(time()+$ClassPersonagem->transformarDiasTempo($ClassPersonagem->diasDeletarPersonagem)).'</b>.
							</div>
						</div>
						<br>
						<div align="center">
							<input type="button" class="botao_azul" value="voltar" onClick="document.location = \'?p=minha_conta\'"></a>
						</div>
					';
				else
					$conteudo_minha_conta = $conteudo_nao_encontrado_full;
			}
			elseif($acao == "cancelar"){
				if($ClassPersonagem->validarPersonagemConta($id, $accountId)){
					$informacoesPersonagem = $ClassPersonagem->getInformacoesPersonagem($id);
					$conteudo_minha_conta = '
						<div class="small_box_frame erro" carregar_box="1">
							<b>Algum erro ocorreu.</b><br>
							Verifique as informações e tente novamente.
						</div>
						<div class="box_frame" carregar_box="1">
							Cancelar Deletar Personagem
						</div>
						<div class="box_frame_conteudo" carregar_box="1">
							<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
								<tr class="conteudo dark">
									<td>
										<form id="cancelar_deletar_personagem" personagem="'.$id.'">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td width="230" align="left">
														<b class="exibicao_bloco">Nome:</b>
													</td>
													<td align="left">
														'.$informacoesPersonagem["nome"].'
													</td>
												</tr>
												<tr>
													<td align="left">
														<b class="exibicao_bloco">Confirme a Senha:</b>
													</td>
													<td align="left">
														<input type="password" id="confirmar_senha" name="confirmar_senha">
													</td>
												</tr>
												<tr>
													<td align="left">
														<b class="exibicao_bloco">Digite a Chave de Recuperação:</b>
													</td>
													<td align="left">
														<input type="text" id="chave_recuperacao" name="chave_recuperacao" style="width: 290px;">
													</td>
												</tr>
												<tr valign="top">
													<td colspan="2" align="center">
														<input type="submit" class="botao" value="Deletar">
														<input type="button" class="botao" value="Voltar" onClick="document.location = \'?p=minha_conta\'">
													</td>
												</tr>
											</table>
										</form>
									</td>
								</tr>
							</table>
						</div>
					';
				}
				else
					$conteudo_minha_conta = $conteudo_nao_encontrado_full;
			}
			elseif($acao == "cancelado"){
				$informacoesPersonagem = $ClassPersonagem->getInformacoesPersonagem($id);
				if($informacoesPersonagem["deletar"] == 0)
					$conteudo_minha_conta = '
						<div class="box_frame" carregar_box="1">
							Deletar Personagem Cancelado
						</div>
						<div class="box_frame_conteudo_principal" carregar_box="1">
							<div class="box_frame_conteudo padding dark">
								Fique tranquilo! Seu personagem não será mais deletado.
							</div>
						</div>
						<br>
						<div align="center">
							<input type="button" class="botao_azul" value="voltar" onClick="document.location = \'?p=minha_conta\'"></a>
						</div>
					';
				else
					$conteudo_minha_conta = $conteudo_nao_encontrado_full;
			}
			else
				$conteudo_minha_conta = $conteudo_nao_encontrado_full;
		}
		else{
			if(($informacoesConta["ultimo_acesso"] == 0) || ($ClassPersonagem->checarPersonagemSemVocacao($accountId))){
				$conteudo_minha_conta = '
					Escolher Vocação do Personagem<br>
					<br>
					- Arqueiro<br>
					Os Arqueiros usam armas à distância. Podem virar Caçadores ou Lanceiros<br>
					<br>
					- Feiticeiro<br>
					Os Feiticeiros usam magias poderosas que causam dano e aplicam atributos negativos. Podem virar Arquimagos ou Arcanistas.<br>
					<br>
					- Clérigo<br>
					Os Clérigos podem curar o aliado e usar armas corpo-a-corpo. Podem virar Bispos ou Cruzados.<br>
					<br>
					- Cavaleiro<br>
					Os Cavaleiros são resistentes e usam armas corpo-a-corpo. Podem virar Guardiões ou Gladiadores.<br>
					<br>
					Caso tenha dúvida na vocação, <a href="?p=vocacoes" target="_new">clique aqui</a>. <span class="pequeno">(o link abrirá em uma nova página)</span><br>
					<br>
					<hr>
					<br>
					<b>Espaço para testes:</b><br>
					<br>
					<input type="button" class="mudar_vocacao_personagem" vocacao="1" value="Criar Arqueiro" />
					<input type="button" class="mudar_vocacao_personagem" vocacao="2" value="Criar Cavaleiro" />
					<input type="button" class="mudar_vocacao_personagem" vocacao="3" value="Criar Feiticeiro" />
					<input type="button" class="mudar_vocacao_personagem" vocacao="4" value="Criar Clérigo" />
				';
			}
			else{
				$mensagemBemVindo = 'Seja bem-vindo a sua conta';
				$conteudo_minha_conta = '
					<br>
					<div align="center">
						<table>
							<tr>
								<td>
									<img src="imagens/corpo/cabecalho_conta_esquerda.gif" alt="" />
								</td>
								<td class="grande">
									<b>'.$mensagemBemVindo.'!</b>
								</td>
								<td>
									<img src="imagens/corpo/cabecalho_conta_direita.gif" alt="" />
								</td>
							</tr>
						</table>
					</div>
					<br>
					<div class="box_frame" carregar_box="1">
						Informações Gerais
					</div>
					<div class="box_frame_conteudo_principal" carregar_box="1">
						<table cellpadding="0" cellspacing="0" class="tabela odd" width="100%">
							';
							foreach($config["minha_conta"] as $c => $v){
								$valor = $informacoesConta[$v["coluna"]];
								$exibirValor = $valor;
								$adicionais = "";
								if($v["ocultar_caracteres"]){
									$exibirValor = str_repeat("*", strlen($exibirValor));
									$adicionais = '<div class="ocultar_exibir_caracteres ocultar"></div>';
								}
								if($v["formatar"] == "data")
									$exibirValor = date("d/m/Y, H\hi\ms\s", $valor);
								if($c == "status_conta"){
									if($valor == 0){
										$classes = "vermelho";
										$exibirValor = "Conta Gratuita";
									}
									else{
										$classes = "verde";
										$exibirValor = "Conta Premium";
									}
								}
								if((!empty($v["mensagem_valor_vazio"])) AND (($valor == 0) OR (empty($valor))))
									$exibirValor = $v["mensagem_valor_vazio"];
								$conteudo_minha_conta .= '
									<tr class="item">
										<td width="130">
											<b class="exibicao_bloco">'.$v["nome"].':</b>
										</td>
										<td>
											<span class="valor '.$classes.'" valor="'.$valor.'" exibir_valor="'.$exibirValor.'">'.$exibirValor.'</span>'.$adicionais.'
										</td>
									</tr>
								';
							}
							$conteudo_minha_conta .= '
						</table>
					</div>
					<br>
					<div class="box_frame" carregar_box="1">
						Personagens
					</div>
					<div class="box_frame_conteudo_principal padding" carregar_box="1">
						<table cellpadding="0" cellspacing="0" class="tabela odd" width="100%">
							<tr class="cabecalho">
								<td width="60%" colspan="2" align="center">
									Informações
								</td>
								<td width="20%" align="center">
									Status
								</td>
								<td width="20%" align="center">
									Opções
								</td>
							</tr>
							';
							$listaPersonagens = $ClassPersonagem->getListaPersonagens($accountId);
							$exibirListaPersonagens = $ClassPersonagem->exibirListaPersonagens($listaPersonagens, 1);
							$conteudo_minha_conta .= $exibirListaPersonagens;
							$conteudo_minha_conta .= '
						</table>
						';
						if(count($listaPersonagens) < $config["players"]["maxPersonagens"])
							$conteudo_minha_conta .= '
								<div align="right" style="margin-top: 10px;">
									<input type="button" class="botao_azul" value="criar_personagem" onClick="document.location = \'?p=criar_personagem\'" \>
								</div>
							';
						$conteudo_minha_conta .= '
					</div>
				';
			}
		}
	}
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				'.$conteudo_minha_conta.'
			</div>
		</div>
	';
?>