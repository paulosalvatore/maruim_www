<?php
	if((!empty($id)) AND ($acao == "registrar")){
		if($ClassConta->validarCodigoEmail($id, "email_codigo") > 0){
			$chaveRecuperacao = $ClassConta->gerarChaveRecuperacao($accountId);
			if($ClassConta->registrarConta($accountId, $chaveRecuperacao))
				$conteudo_minha_conta = '
					<div class="box_frame" carregar_box="1">
						Conta Registrada com Sucesso
					</div>
					<div class="box_frame_conteudo_principal" carregar_box="1">
						<div class="box_frame_conteudo padding dark">
							Sua conta foi registrada com sucesso.<br>
							<br>
							Anote a sua Chave de Recuperação:<br>
							<h2>'.$chaveRecuperacao.'</h2>
							<br>
							<span class="vermelho">CASO PERCA A SUA CHAVE DE RECUPERAÇÃO, VOCÊ FICARÁ IMPOSSIBILITADO DE DELETAR QUALQUER PERSONAGEM DE SUA CONTA.</span><br>
							<div align="center">
								<input type="button" class="botao_azul" value="voltar" onClick="document.location = \'?p=minha_conta\';"/>
							</div>
						</div>
					</div>
				';
			else
				$conteudo_minha_conta = $conteudo_nao_encontrado_full;
		}
		else{
			header("Location: ?p=minha_conta");
			exit;
		}
	}
	elseif((!empty($id)) AND ($acao == "alterar_email")){
		if($ClassConta->validarCodigoEmail($id, "proximo_email_codigo") > 0){
			$ClassConta->iniciarAlteracaoEmail($informacoesConta);
			$conteudo_minha_conta = '
				<div class="box_frame" carregar_box="1">
					Solicitação de Alteração de E-mail Confirmada
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					<div class="box_frame_conteudo padding dark">
						Sua solicitação de alteração de e-mail foi confirmada com sucesso.<br>
						<br>
						Em '.$ClassConta->diasTrocarEmail.' dias seu e-mail será alterado.<br>
						<br>
						Para isso, quando a data chegar, você deverá ir até sua conta e confirmar a troca do e-mail.<br>
						<br>
						<div align="center">
							<input type="button" class="botao_azul" value="voltar" onClick="document.location = \'?p=minha_conta\';"/>
						</div>
					</div>
				</div>
			';
		}
		else{
			header("Location: ?p=minha_conta");
			exit;
		}
	}
	elseif(($id == "alterar_senha") AND ($acao == "senha_alterada")){
		$conteudo_minha_conta = '
			<div class="box_frame" carregar_box="1">
				Senha Alterada com Sucesso
			</div>
			<div class="box_frame_conteudo_principal" carregar_box="1">
				<div class="box_frame_conteudo padding dark">
					Sua senha foi alterada com sucesso.<br>
					<br>
					Para se conectar com sua nova senha, <a href="?p=minha_conta">clique aqui</a>.
				</div>
			</div>
		';
	}
	elseif(!$usuarioEncontrado){
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
									<input type="password" id="conta" name="conta" style="width: 278px;">
								</td>
							</tr>
							<tr>
								<td>
									<b>Senha:</b>
								</td>
								<td>
									<input type="password" id="senha" name="senha" style="width: 278px;">
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
			if(!is_numeric($id)){
				if($id == "alterar_senha"){
					$conteudo_minha_conta = '
						<div class="small_box_frame erro" carregar_box="1">
							<b>Algum erro ocorreu.</b><br>
							Verifique as informações e tente novamente.
						</div>
						<div class="box_frame" carregar_box="1">
							Alterar Senha da Conta
						</div>
						<form id="alterar_senha">
							<div class="box_frame_conteudo_principal ocultar_borda3" carregar_box="1">
								<div class="box_frame_conteudo" carregar_box="1">
									<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
										<tr class="conteudo dark">
											<td>
												<table width="100%" cellpadding="0" cellspacing="0">
													<tr>
														<td width="100" align="left">
															<b>Senha Atual:</b>
														</td>
														<td width="220" align="left">
															<input type="password" id="senha_atual" name="senha_atual" />
														</td>
													</tr>
													<tr>
														<td align="left">
															<b>Nova Senha:</b>
														</td>
														<td align="left">
															<input type="password" id="nova_senha" name="nova_senha" />
														</td>
													</tr>
													<tr>
														<td align="left">
															<b>Confirme a Nova Senha:</b>
														</td>
														<td align="left">
															<input type="password" id="confirmar_nova_senha" name="confirmar_nova_senha" />
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</div>
							</div>
							<div align="center" style="margin-top: 10px; margin-bottom: 10px;">
								<div class="botao_azul2_1">
									<input type="submit" class="botao_azul" value="alterar_senha" />
								</div>
								<div class="botao_azul2_2">
									<input type="button" class="botao_azul" value="voltar" onClick="document.location = \'?p=minha_conta\';" />
								</div>
							</div>
						</form>
					';
				}
				elseif($id == "registrar"){
					if($acao == "email_enviado")
						$conteudo_minha_conta = '
							<div class="box_frame" carregar_box="1">
								E-mail para Registro Enviado
							</div>
							<div class="box_frame_conteudo_principal" carregar_box="1">
								<div class="box_frame_conteudo padding dark">
									Um e-mail com informações para o registro de sua conta foi enviado para você.<br>
									<br>
									Se você ainda não o recebeu aguarde alguns instantes.<br>
									<br>
									Caso queira enviar uma nova requisição <a href="?p=minha_conta-registrar">clique aqui</a>.<br>
									<b>OBS.:</b> Caso envie um novo e-mail, o anterior perderá sua funcionabilidade.<br>
									<br>
									<div align="center">
										<input type="button" class="botao_azul" value="Voltar" onClick="document.location = \'?p=minha_conta\';" />
									</div>
								</div>
							</div>
						';
					else
						$conteudo_minha_conta = '
							<div class="small_box_frame erro" carregar_box="1">
								<b>Algum erro ocorreu.</b><br>
								Verifique as informações e tente novamente.
							</div>
							<div class="box_frame" carregar_box="1">
								Registrar Conta
							</div>
							<form id="registrar_conta">
								<div class="box_frame_conteudo" carregar_box="1">
									<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
										<tr class="conteudo dark">
											<td>
												<table width="100%" cellpadding="0" cellspacing="0">
													<tr>
														<td colspan="2">
															Para registrar sua conta você deve confirmar sua senha abaixo.<br>
															<br>
															Uma mensagem será enviada para o seu e-mail com as instruções para prosseguir com o registro.<br>
															<br>
															Caso você queira alterar seu e-mail, deverá ir para a página da sua conta e clicar em \'<i>Alterar E-mail</i>\', você será redirecionado para uma outra página onde colocará o novo e-mail. Lembre-se que você deverá esperar um certo prazo para que seu e-mail seja alterado com sucesso.<br>
															<br>
														</td>
													</tr>
													<tr>
														<td width="80" align="left">
															<b>E-mail cadastrado:</b>
														</td>
														<td width="220" align="left">
															<i>'.$informacoesConta["email"].'</i>
														</td>
													</tr>
													<tr>
														<td width="80" align="left">
															<b>Confirme sua Senha:</b>
														</td>
														<td width="220" align="left">
															<input type="password" id="confirmar_senha" name="confirmar_senha" />
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</div>
								<div align="center" style="margin-top: 10px; margin-bottom: 10px;">
									<div class="botao_azul2_1">
										<input type="submit" class="botao_azul" value="registrar" />
									</div>
									<div class="botao_azul2_2">
										<input type="button" class="botao_azul" value="voltar" onClick="document.location = \'?p=minha_conta\';" />
									</div>
								</div>
							</form>
						';
				}
				elseif($id == "alterar_email"){
					if((!empty($informacoesConta["email_novo"])) AND ($informacoesConta["email_novo_tempo"]+$ClassFuncao->transformarDiasTempo($ClassConta->diasTrocarEmail) < time())){
						$ClassConta->alterarEmail($informacoesConta);
						$conteudo_minha_conta = '
							<div class="box_frame" carregar_box="1">
								E-mail Alterado
							</div>
							<div class="box_frame_conteudo_principal" carregar_box="1">
								<div class="box_frame_conteudo padding dark">
									Seu e-mail foi alterado com sucesso.<br>
									<br>
									O novo e-mail registrado agora é <b>'.$informacoesConta["email_novo"].'</b>.<br>
									<br>
									<div align="center">
										<input type="button" class="botao_azul" value="Voltar" onClick="document.location = \'?p=minha_conta\';" />
									</div>
								</div>
							</div>
						';
					}
					elseif(($acao == "email_enviado") OR ($acao == "reenviar")){
						if(!empty($informacoesConta["proximo_email"])){
							$exibirMensagemDelay = false;
							if($acao == "email_enviado")
								$msg = array(
									"Enviada",
									"Enviamos uma"
								);
							elseif($acao == "reenviar"){
								$msg = array(
									"Reenviada",
									"Reenviamos a"
								);
								$proximo_email_reenvio = $ClassConta->getResultado["proximo_email_envio"];
								if($informacoesConta["proximo_email_envio"]+$ClassConta->delayReenvio < time())
									$ClassConta->solicitarAlteracaoEmail($informacoesConta, $informacoesConta["proximo_email"]);
								else
									$exibirMensagemDelay = true;
							}
							if($exibirMensagemDelay)
								$conteudo_minha_conta = '
									<div class="box_frame" carregar_box="1">
										Reenviar Solicitação para Alteração de E-mail
									</div>
									<div class="box_frame_conteudo_principal" carregar_box="1">
										<div class="box_frame_conteudo padding dark">
											Você deve aguardar no mínimo '.$ClassConta->delayReenvio.' segundos para reenviar uma solicitação para alteração de e-mail.<br>
											<br>
											Caso queira tentar novamente <a href="?p=minha_conta-alterar_email-reenviar">clique aqui</a><br>
											<br>
											<div align="center">
												<input type="button" class="botao_azul" value="Voltar" onClick="document.location = \'?p=minha_conta\';" />
											</div>
										</div>
									</div>
								';
							else
								$conteudo_minha_conta = '
									<div class="box_frame" carregar_box="1">
										Solicitação para Alteração de E-mail '.$msg[0].'
									</div>
									<div class="box_frame_conteudo_principal" carregar_box="1">
										<div class="box_frame_conteudo padding dark">
											'.$msg[1].' mensagem para <b>'.$informacoesConta["proximo_email"].'</b> para confirmar a solicitação da alteração.<br>
											<br>
											Se você ainda não o recebeu aguarde alguns instantes.<br>
											<br>
											Caso queira enviá-la novamente <a href="?p=minha_conta-alterar_email-reenviar">clique aqui</a>.<br>
											<b>OBS.:</b> Caso envie uma nova mensagem, a anterior perderá sua funcionabilidade.<br>
											<br>
											<div align="center">
												<input type="button" class="botao_azul" value="Voltar" onClick="document.location = \'?p=minha_conta\';" />
											</div>
										</div>
									</div>
								';
						}
						else
							$conteudo_minha_conta = $conteudo_nao_encontrado_full;
					}
					elseif(!empty($informacoesConta["email_novo"])){
						$conteudo_minha_conta = '
							<div class="box_frame" carregar_box="1">
								Alterar E-mail da Conta
							</div>
							<form id="alterar_email">
								<div class="box_frame_conteudo_principal" carregar_box="1">
									<div class="box_frame_conteudo padding dark">
										Detectamos que você já possui uma solicitação de alteração de e-mail em andamento.<br>
										<br>
										Você deve esperar até <b>'.$ClassFuncao->formatarData($informacoesConta["email_novo_tempo"]+$ClassFuncao->transformarDiasTempo($ClassConta->diasTrocarEmail)).'</b> para prosseguir com a alteração do e-mail.
									</div>
								</div>
								<div align="center" style="margin-top: 10px; margin-bottom: 10px;">
									<input type="button" class="botao_azul" value="voltar" onClick="document.location = \'?p=minha_conta\';" />
								</div>
						';
					}
					else{
						$conteudo_minha_conta = '
							<div class="small_box_frame erro" carregar_box="1">
								<b>Algum erro ocorreu.</b><br>
								Verifique as informações e tente novamente.<br>
								<br>
								<li> Certifique-se de que esse é um e-mail válido.
								<li> Certifique-se de que esse e-mail é diferente do que está cadastrado em sua conta.
								<li> Esse e-mail pode estar sendo usado por outra pessoa.
								<li> Você pode ter digitado a senha incorretamente.
							</div>
							<div class="padding">
								Digite sua senha e o novo endereço de e-mail. Certifique-se de que você digitou um endereço de e-mail válido e que você tem acesso.<br>
								<br>
								<b>Por razões de segurança, a mudança real será finalizada após um período de espera de '.$ClassConta->diasTrocarEmail.' dias.</b><br>
								';
								if(!empty($informacoesConta["proximo_email"]))
									$conteudo_minha_conta .= '
										<br>
										<span class="vermelho">
											Notamos que você possui uma solicitação de alteração de e-mail em andamento.<br>
											<br>
											Você precisa apenas confirmar o e-mail para prosseguir com a solicitação. Se não recebeu a mensagem você pode reenviá-la <a href="?p=minha_conta-alterar_email-reenviar">clicando aqui</a>.<br>
											<br>
											Mesmo assim, você pode prosseguir com a nova solicitação, basta preencher os campos abaixo e certificar-se de inserir um e-mail não utilizado em nenhuma solicitação.<br>
										</span>
									';
								$conteudo_minha_conta .= '
							</div>
							<br>
							<div class="box_frame" carregar_box="1">
								Alterar E-mail da Conta
							</div>
							<form id="alterar_email">
								<div class="box_frame_conteudo_principal ocultar_borda3" carregar_box="1">
									<div class="box_frame_conteudo" carregar_box="1">
										<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
											<tr class="conteudo dark">
												<td>
													<table width="100%" cellpadding="0" cellspacing="0">
														<tr>
															<td align="left">
																<b>Novo E-mail:</b>
															</td>
															<td align="left">
																<input type="text" id="novo_email" name="novo_email" />
															</td>
														</tr>
														<tr>
															<td align="left">
																<b>Senha:</b>
															</td>
															<td align="left">
																<input type="password" id="confirmar_senha" name="confirmar_senha" />
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</div>
								</div>
								<div align="center" style="margin-top: 10px; margin-bottom: 10px;">
									<div class="botao_azul2_1">
										<input type="submit" class="botao_azul" value="alterar_email" />
									</div>
									<div class="botao_azul2_2">
										<input type="button" class="botao_azul" value="voltar" onClick="document.location = \'?p=minha_conta\';" />
									</div>
								</div>
							</form>
						';
					}
				}
				elseif($id == "servicos"){
					$ativarOverlay = true;
					$conteudo_minha_conta = '
						<div id="barraProgresso" data-config="1"></div>
					';
				}
				else
					$conteudo_minha_conta = $conteudo_nao_encontrado_full;
			}
			else{
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
					if	(($ClassPersonagem->validarPersonagemConta($id, $accountId)) AND
						($ClassPersonagem->verificarDeletarPersonagem($ClassPersonagem->getListaPersonagens($accountId), $accountId))){
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
					<div class="box_frame_conteudo_principal borda2_padding" carregar_box="1">
						<div class="box_frame_conteudo" carregar_box="1">
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
									elseif($c == "registro_conta"){
										if(empty($valor)){
											$classes = "vermelho";
											$exibirValor = "Conta Não Registrada. Clique no botão abaixo para Registrá-la.";
										}
										else{
											$classes = "verde";
											$exibirValor = "Conta Registrada!";
										}
									}
									if((!empty($v["mensagem_valor_vazio"])) AND (($valor == 0) OR (empty($valor))))
										$exibirValor = $v["mensagem_valor_vazio"];
									$conteudo_minha_conta .= '
										<tr class="item">
											<td width="145">
												<b class="exibicao_bloco">'.$v["nome"].':</b>
											</td>
											<td>
												<span class="valor '.$classes.'" valor="'.$valor.'" exibir_valor="'.$exibirValor.'">'.$exibirValor.'</span>'.$adicionais.'
											</td>
										</tr>
									';
								}
								if((!empty($informacoesConta["proximo_email"])) OR (!empty($informacoesConta["email_novo"]))){
									if(!empty($informacoesConta["proximo_email"]))
										$mensagemAlteracaoEmail = 'Confirme seu novo e-mail. <a href="?p=minha_conta-alterar_email-reenviar">Reenviar Confirmação</a>';
									elseif($informacoesConta["email_novo_tempo"]+$ClassFuncao->transformarDiasTempo($ClassConta->diasTrocarEmail) > time())
										$mensagemAlteracaoEmail = 'Poderá ser alterado em '.$ClassConta->formatarData($informacoesConta["email_novo_tempo"]+$ClassFuncao->transformarDiasTempo($ClassConta->diasTrocarEmail)).'.';
									else
										$mensagemAlteracaoEmail = 'Você pode alterar seu e-mail <a href="?p=minha_conta-alterar_email">clicando aqui</a>.';
									$conteudo_minha_conta .= '
										<tr class="item">
											<td>
												<b>Novo E-mail:</b>
											</td>
											<td>
												'.$mensagemAlteracaoEmail.'
											</td>
										</tr>
									';
								}
								$conteudo_minha_conta .= '
							</table>
						</div>
						';
						if(empty($informacoesConta["chave_recuperacao"]))
							$conteudo_minha_conta .= '
								<div align="center" style="margin-top: 5px;">
									<div class="botao_azul3_1">
										<input type="submit" class="botao_azul" value="alterar_senha" onClick="document.location = \'?p=minha_conta-alterar_senha\'" />
									</div>
									<div class="botao_azul3_2">
										<input type="button" class="botao_azul" value="registrar" onClick="document.location = \'?p=minha_conta-registrar\'" />
									</div>
									<div class="botao_azul3_3">
										<input type="button" class="botao_azul" value="alterar_email" onClick="document.location = \'?p=minha_conta-alterar_email\'" />
									</div>
								</div>
							';
						else
							$conteudo_minha_conta .= '
								<div align="center" style="margin-top: 5px;">
									<div class="botao_azul2_1">
										<input type="submit" class="botao_azul" value="alterar_senha" onClick="document.location = \'?p=minha_conta-alterar_senha\'" />
									</div>
									<div class="botao_azul2_2">
										<input type="button" class="botao_azul" value="alterar_email" onClick="document.location = \'?p=minha_conta-alterar_email\'" />
									</div>
								</div>
							';
						$conteudo_minha_conta .= '
					</div>
					<br>
					<div class="box_frame" carregar_box="1">
						Personagens
					</div>
					<div class="box_frame_conteudo_principal" carregar_box="1">
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
							$exibirListaPersonagens = $ClassPersonagem->exibirListaPersonagens($listaPersonagens, $accountId);
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
					<br>
					<div class="box_frame" carregar_box="1">
						Serviços Disponíveis
					</div>
					<div class="box_frame_conteudo_principal borda2_padding" carregar_box="1">
						<div class="box_frame_conteudo" carregar_box="1">
							<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
								';
								foreach($config["servicos"] as $categoria)
									$conteudo_minha_conta .= '
										<tr class="conteudo dark">
											<td>
												<div style="float: right;">
													<input type="button" class="botao_verde" value="adquirir" onClick="document.location = \'?p=minha_conta-servicos\';" />
												</div>
												<b>'.$categoria["nome"].'</b><br>
												'.$categoria["descricao"].'
											</td>
										</tr>
									';
								$conteudo_minha_conta .= '
							</table>
						</div>
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