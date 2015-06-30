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
							Anote a sua Chave de Recupera��o:<br>
							<h2>'.$chaveRecuperacao.'</h2>
							<br>
							<span class="vermelho">CASO PERCA A SUA CHAVE DE RECUPERA��O, VOC� FICAR� IMPOSSIBILITADO DE RECUPER�-LA OU DE DELETAR QUALQUER PERSONAGEM DE SUA CONTA.</span><br>
							<br>
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
					Solicita��o de Altera��o de E-mail Confirmada
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					<div class="box_frame_conteudo padding dark">
						Sua solicita��o de altera��o de e-mail foi confirmada com sucesso.<br>
						<br>
						Em '.$ClassConta->diasTrocarEmail.' dias seu e-mail ser� alterado.<br>
						<br>
						Para isso, quando a data chegar, voc� dever� ir at� sua conta e confirmar a troca do e-mail.<br>
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
				Usu�rio e/ou senha inv�lidos. Digite dados v�lidos.
			</div>
			<div class="box_frame" carregar_box="1">
				Entrar na Conta
			</div>
			<div class="box_frame_conteudo_principal borda2_padding" carregar_box="1">
				<div class="box_frame_conteudo" carregar_box="1">
					<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
						<tr class="conteudo dark">
							<td>
								<form id="form_login">
									<input type="hidden" name="url" value="'.$_POST["url"].'" />
									<table width="100%">
										<tr>
											<td width="100">
												<b>Conta:</b>
											</td>
											<td width="280">
												<input type="password" id="conta" name="conta" onClick="this.select();" style="width: 278px;">
											</td>
										</tr>
										<tr>
											<td>
												<b>Senha:</b>
											</td>
											<td>
												<input type="password" id="senha" name="senha" onClick="this.select();" style="width: 278px;">
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
							</td>
						</tr>
					</table>
				</div>
			</div>
		';
	}
	else{
		if(!empty($id)){
			if(!is_numeric($id)){
				if($id == "alterar_senha"){
					$conteudo_minha_conta = '
						<div class="small_box_frame erro" carregar_box="1">
							<b>Algum erro ocorreu.</b><br>
							Verifique as informa��es e tente novamente.
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
								<div class="botao_colorido2_1">
									<input type="submit" class="botao_azul" value="alterar_senha" />
								</div>
								<div class="botao_colorido2_2">
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
									Um e-mail com informa��es para o registro de sua conta foi enviado para voc�.<br>
									<br>
									Se voc� ainda n�o o recebeu aguarde alguns instantes.<br>
									<br>
									Caso queira enviar uma nova requisi��o <a href="?p=minha_conta-registrar">clique aqui</a>.<br>
									<b>OBS.:</b> Caso envie um novo e-mail, o anterior perder� sua funcionabilidade.<br>
									<br>
									<div align="center">
										<input type="button" class="botao_azul" value="Voltar" onClick="document.location = \'?p=minha_conta\';" />
									</div>
								</div>
							</div>
						';
					else
						$conteudo_minha_conta = '
							<div class="padding">
								<div id="barraProgresso" data-config="1" data-tipo="registrar"></div>
								<br>
								O Registro de sua Conta oferece muitas vantagens importantes:<br>
								<br>
								<ul class="padding">
									<li>Usu�rios Registrados recebem uma chave de recupera��o, que pode ser usada para recuperar a conta se eles perderam o acesso ao e-mail registrado.</li>
									<li>Usu�rios Registrados podem solicitar uma nova chave de recupera��o por uma pequena taxa.</li>
									<li>Servi�os Extras s� podem ser adquiridos por Usu�rios Registrados.</li>
									<li>Finalmente, somente usu�rios registrados podem se tornar tutores.</li>
								</ul>
								<br>
								<b>OBS.:</b> As informa��es fornecidas durante o processo de Registro ser�o usadas exclusivamente para levantamentos internos e ser�o tratadas de uma forma estritamente confidencial.<br>
								<br>
								Certifique-se de inserir seus dados completos e corretos para garantir que vamos providenciar para voc� o melhor suporte poss�vel. Acima de tudo, informe corretamente seu endere�o completo para garantir que nossas encomendas (cartas de recupera��o/pr�mios) ir�o chegar at� voc�. Note que todos os dados de registro poder�o ser editados no futuro.<br>
								<br>
							</div>
							<div class="small_box_frame erro" carregar_box="1">
								<b>Algum erro ocorreu.</b><br>
								Verifique as informa��es e tente novamente.
							</div>
							<div class="box_frame" carregar_box="1">
								Registrar Conta
							</div>
							<form id="registrar_conta">
								<div class="box_frame_conteudo_principal" carregar_box="1">
									<div class="box_frame_conteudo dark padding">
										<table width="100%" cellpadding="0" cellspacing="0">
											<tr>
												<td colspan="2">
													Para registrar sua conta voc� deve confirmar sua senha abaixo.<br>
													<br>
													Uma mensagem ser� enviada para o seu e-mail com as instru��es para prosseguir com o registro.<br>
													<br>
													Caso voc� queira alterar seu e-mail, dever� ir para a p�gina da sua conta e clicar em \'<i>Alterar E-mail</i>\', voc� ser� redirecionado para uma outra p�gina onde colocar� o novo e-mail. Lembre-se que voc� dever� esperar um certo prazo para que seu e-mail seja alterado com sucesso.<br>
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
													<b>Nome:</b>
												</td>
												<td width="220" align="left">
													<input type="text" id="nome" name="nome" />
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
									</div>
								</div>
								<div align="center" style="margin-top: 10px; margin-bottom: 10px;">
									<div class="botao_colorido2_1">
										<input type="submit" class="botao_azul" value="registrar" />
									</div>
									<div class="botao_colorido2_2">
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
									O novo e-mail registrado agora � <b>'.$informacoesConta["email_novo"].'</b>.<br>
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
										Reenviar Solicita��o para Altera��o de E-mail
									</div>
									<div class="box_frame_conteudo_principal" carregar_box="1">
										<div class="box_frame_conteudo padding dark">
											Voc� deve aguardar no m�nimo '.$ClassConta->delayReenvio.' segundos para reenviar uma solicita��o para altera��o de e-mail.<br>
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
										Solicita��o para Altera��o de E-mail '.$msg[0].'
									</div>
									<div class="box_frame_conteudo_principal" carregar_box="1">
										<div class="box_frame_conteudo padding dark">
											'.$msg[1].' mensagem para <b>'.$informacoesConta["proximo_email"].'</b> para confirmar a solicita��o da altera��o.<br>
											<br>
											Se voc� ainda n�o o recebeu aguarde alguns instantes.<br>
											<br>
											Caso queira envi�-la novamente <a href="?p=minha_conta-alterar_email-reenviar">clique aqui</a>.<br>
											<b>OBS.:</b> Caso envie uma nova mensagem, a anterior perder� sua funcionabilidade.<br>
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
										Detectamos que voc� j� possui uma solicita��o de altera��o de e-mail em andamento.<br>
										<br>
										Voc� deve esperar at� <b>'.$ClassFuncao->formatarData($informacoesConta["email_novo_tempo"]+$ClassFuncao->transformarDiasTempo($ClassConta->diasTrocarEmail)).'</b> para prosseguir com a altera��o do e-mail.
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
								Verifique as informa��es e tente novamente.<br>
								<br>
								<li> Certifique-se de que esse � um e-mail v�lido.
								<li> Certifique-se de que esse e-mail � diferente do que est� cadastrado em sua conta.
								<li> Esse e-mail pode estar sendo usado por outra pessoa.
								<li> Voc� pode ter digitado a senha incorretamente.
							</div>
							<div class="padding">
								Digite sua senha e o novo endere�o de e-mail. Certifique-se de que voc� digitou um endere�o de e-mail v�lido e que voc� tem acesso.<br>
								<br>
								<b>Por raz�es de seguran�a, a mudan�a real ser� finalizada ap�s um per�odo de espera de '.$ClassConta->diasTrocarEmail.' dias.</b><br>
								';
								if(!empty($informacoesConta["proximo_email"]))
									$conteudo_minha_conta .= '
										<br>
										<span class="vermelho">
											Notamos que voc� possui uma solicita��o de altera��o de e-mail em andamento.<br>
											<br>
											Voc� precisa apenas confirmar o e-mail para prosseguir com a solicita��o. Se n�o recebeu a mensagem voc� pode reenvi�-la <a href="?p=minha_conta-alterar_email-reenviar">clicando aqui</a>.<br>
											<br>
											Mesmo assim, voc� pode prosseguir com a nova solicita��o, basta preencher os campos abaixo e certificar-se de inserir um e-mail n�o utilizado em nenhuma solicita��o.<br>
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
									<div class="botao_colorido2_1">
										<input type="submit" class="botao_azul" value="alterar_email" />
									</div>
									<div class="botao_colorido2_2">
										<input type="button" class="botao_azul" value="voltar" onClick="document.location = \'?p=minha_conta\';" />
									</div>
								</div>
							</form>
						';
					}
				}
				elseif($id == "servicos"){
					include("includes/classes/ClassServicos.php");
					$ClassServicos = new Servicos();
					if(empty($acao)){
						$conteudo_abas = "";
						$exibicao_abas = "";
						foreach($config["servicos"] as $servicoId => $servico){
							$classeAba = "aba";
							$classeConteudo = "conteudo_aba";
							$imagem = "inativa";
							if((((!$_POST["servico"]) OR (!array_key_exists($_POST["servico"], $config["servicos"]))) AND ($servico["padrao"])) OR ($_POST["servico"] == $servicoId)){
								$classeAba .= " ativa";
								$classeConteudo .= " exibir";
								$imagem = "ativa";
							}
							$conteudo_abas .= '
								<div class="'.$classeAba.'" data-servico_id="'.$servicoId.'">
									<img src="imagens/corpo/fundo_aba_'.$imagem.'.png" />
									<div class="texto">'.$servico["nome"].'</div>
								</div>
							';
							$exibicao_abas .= '
								<div id="conteudo_aba_'.$servicoId.'" class="'.$classeConteudo.'">
									';
									foreach($ClassServicos->getProdutos($servicoId) as $produto){
										$exibirFundoServico = "";
										$exibirImagem = "";
										$desativarProduto = false;
										if($produto["fundoServico"])
											$exibirFundoServico = ' style="background: url('.$produto["imagem"].') no-repeat;"';
										if(($produto["tipo"] == "item") AND (!$produto["fundoServico"]))
											$exibirImagem = '<div class="servicoImagem" style="background: url('.$produto["imagem"].');"></div>';
										if((($produto["tipo"] == "nova_chave") OR ($servicoId == "servicos_extras")) AND (empty($informacoesConta["chave_recuperacao"])))
											$desativarProduto = true;
										if($desativarProduto)
											$desativarProduto = " exibir";
										else
											$desativarProduto = "";
										$exibicao_abas .= '
											<div class="servico" data-pagamento="'.$produto["forma_pagamento"].'" data-pontos="'.$produto["pontos"].'">
												<div class="fundo">
													<div class="fundoServico"'.$exibirFundoServico.'>
														'.$exibirImagem.'
															<div class="servicoEtiquetaBox">
																<div class="servicoTextoBox">
																	<input type="radio" id="servico_'.$produto["id"].'" name="produto" value="'.$produto["id"].'">
																	'.$produto["nome"].'
																</div>
															</div>
															<div class="servicoBoxPreco">
																'.$produto["exibirPreco"].'
															</div>
													</div>
												</div>
												<div class="fundoOver"></div>
												<div class="fundoSelecionado"></div>
												<div class="fundoDesativado'.$desativarProduto.'"></div>
											</div>
										';
									}
									$exibicao_abas .= '
								</div>
							';
						}
						$conteudo_minha_conta = '
							<div id="barraProgresso" data-config="1" data-tipo="servicos"></div>
							<br>
							<div class="small_box_frame erro" carregar_box="1">
								<b>Algum erro ocorreu.</b><br>
								Verifique as informa��es e tente novamente.
							</div>
							<form id="servicos" method="POST" action="?p=minha_conta-servicos-informacoes_pagamento">
								<div class="abas">'.$conteudo_abas.'</div>
								<div class="box_frame_conteudo" carregar_box="1">
									<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
										<tr class="conteudo dark">
											<td>
												'.$exibicao_abas.'
											</td>
										</tr>
									</table>
								</div>
								<br>
								<div class="box_frame_conteudo" carregar_box="1">
									<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
										<tr class="conteudo dark">
											<td>
												';
												foreach($ClassServicos->formasPagamento as $pagamentoId => $pagamento){
													$conteudo_minha_conta .= '
														<div class="formaPagamento" data-tipo="'.$pagamento["tipo"].'">
															<div class="fundo">
																<div class="fundoFormaPagamento">
																	<img src="imagens/servicos/pagamento_'.$pagamentoId.'.gif">
																	<input type="radio" id="pagamento_'.$pagamentoId.'" name="pagamento" value="'.$pagamentoId.'">
																	<div class="formaPagamentoNome">'.$pagamento["nome"].'</div>
																</div>
															</div>
															<div class="fundoOver"></div>
															<div class="fundoSelecionado"></div>
															<div class="fundoDesativado"></div>
														</div>
													';
												}
												$conteudo_minha_conta .= '
											</td>
										</tr>
									</table>
								</div>
								<br>
								<div id="pontosDisponiveis" data-pontos="'.$informacoesConta["pontos"].'"><b>Pontos dispon�veis:</b> <span>'.$informacoesConta["exibirPontos"].'</span></div>
								<div id="balancoRapido"><b>Pontos ap�s aquisi��o:</b> <span></span></div>
								<br>
								<div align="center" style="margin-top: 5px;">
									<div class="botao_colorido2_1">
										<input type="submit" class="botao_verde" value="proximo" onClick="" />
									</div>
									<div class="botao_colorido2_2">
										<input type="button" class="botao_vermelho" value="cancelar" onClick="document.location = \'?p=minha_conta\'" />
									</div>
								</div>
							</form>
						';
					}
					elseif($acao == "informacoes_pagamento"){
						$produto = $_POST["produto"];
						$pagamento = $_POST["pagamento"];
						$informacoesProduto = $ClassServicos->getInformacoesProduto($produto);
						$verificarCompraProduto = $ClassServicos->verificarCompraProduto($produto, $pagamento, $accountId, $informacoesProduto);
						if(!$verificarCompraProduto[0])
							$conteudo_minha_conta = $verificarCompraProduto[1];
						else{
							if(empty($_POST["email"]))
								$_POST["email"] = $informacoesConta["email"];
							$conteudo_minha_conta = '
								<div id="barraProgresso" data-config="2" data-tipo="servicos"></div>
								<br>
								<div class="small_box_frame erro" carregar_box="1">
									<b>Algum erro ocorreu.</b><br>
									Verifique as informa��es e tente novamente.
								</div>
								<div class="box_frame" carregar_box="1">
									Insira Informa��es do Pagamento
								</div>
								<form id="informacoesPagamento" method="POST" action="?p=minha_conta-servicos-confirmar">
									<input type="hidden" name="produto" value="'.$produto.'" />
									<input type="hidden" name="pagamento" value="'.$pagamento.'" />
									<div class="box_frame_conteudo_principal borda2_padding" carregar_box="1">
										<div class="box_frame_conteudo" carregar_box="1">
											<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
												<tr class="conteudo dark">
													<td>
														<table width="100%" cellpadding="0" cellspacing="0">
															<tr>
																<td width="150">
																	<b>Nome:</b>
																</td>
																<td>
																	<input type="text" name="nome" value="'.$_POST["nome"].'"/>
																</td>
															</tr>
															<tr>
																<td>
																	<b>Cidade:</b>
																</td>
																<td>
																	<input type="text" name="cidade" value="'.$_POST["cidade"].'"/>
																</td>
															</tr>
															<tr>
																<td>
																	<b>E-mail:</b>
																</td>
																<td>
																	<input type="text" name="email" value="'.$_POST["email"].'"/>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</div>
									</div>
									<br>
									<div align="center" style="margin-top: 5px;">
										<div class="botao_colorido2_1">
											<input type="submit" class="botao_verde" value="proximo" />
										</div>
										<div class="botao_colorido2_2">
											<input type="button" class="botao_azul" value="voltar" onClick="document.location = \'?p=minha_conta-servicos\'" />
										</div>
									</div>
								</form>
							';
						}
					}
					elseif($acao == "confirmar"){
						$produto = $_POST["produto"];
						$pagamento = $_POST["pagamento"];
						$nome = $_POST["nome"];
						$cidade = $_POST["cidade"];
						$email = $_POST["email"];
						$informacoesProduto = $ClassServicos->getInformacoesProduto($produto);
						$verificarCompraProduto = $ClassServicos->verificarCompraProduto($produto, $pagamento, $accountId, $informacoesProduto);
						$informacoesPagamento = $ClassServicos->getInformacoesPagamento($pagamento);
						if((empty($nome)) OR (empty($cidade)) OR (empty($email)) OR (!verificarEmail($email)))
							$conteudo_minha_conta = $ClassServicos->carregarMensagem("dados_invalidos");
						elseif(!$verificarCompraProduto[0])
							$conteudo_minha_conta = $verificarCompraProduto[1];
						else{
							$camposOcultos = '
								<input type="hidden" name="produto" value="'.$produto.'" />
								<input type="hidden" name="pagamento" value="'.$pagamento.'" />
								<input type="hidden" name="nome" value="'.$nome.'" />
								<input type="hidden" name="cidade" value="'.$cidade.'" />
								<input type="hidden" name="email" value="'.$email.'" />
							';
							$conteudo_minha_conta = '
								<div id="barraProgresso" data-config="3" data-tipo="servicos"></div>
								<br>
								<div class="small_box_frame erro" carregar_box="1">
									<b>Algum erro ocorreu.</b><br>
									Verifique as informa��es e tente novamente.
								</div>
								<div class="box_frame" carregar_box="1">
									Confirma��o
								</div>
								<form id="confirmarPagamento" method="POST" action="?p=minha_conta-servicos-finalizar">
									'.$camposOcultos.'
									<div class="box_frame_conteudo_principal borda2_padding" carregar_box="1">
										<div class="box_frame_conteudo" carregar_box="1">
											<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
												<tr class="conteudo dark">
													<td>
														<table width="100%" cellpadding="0" cellspacing="0">
															<tr>
																<td width="200">
																	<b>Produto:</b>
																</td>
																<td>
																	'.$informacoesProduto["nome"].'
																</td>
															</tr>
															<tr>
																<td>
																	<b>Pre�o:</b>
																</td>
																<td>
																	'.$informacoesProduto["exibirPreco"].'
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</div>
										<br>
										<div class="box_frame_conteudo" carregar_box="1">
											<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
												<tr class="conteudo dark">
													<td>
														<table width="100%" cellpadding="0" cellspacing="0">
															<tr>
																<td width="200">
																	<b>M�todo de Pagamento:</b>
																</td>
																<td>
																	'.$informacoesPagamento["nome"].'
																</td>
															</tr>
															<tr>
																<td>
																	<b>Nome:</b>
																</td>
																<td>
																	'.$nome.'
																</td>
															</tr>
															<tr>
																<td>
																	<b>Cidade:</b>
																</td>
																<td>
																	'.$cidade.'
																</td>
															</tr>
															<tr>
																<td>
																	<b>E-mail:</b>
																</td>
																<td>
																	'.$email.'
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</div>
										<br>
										<div class="box_frame_conteudo" carregar_box="1">
											<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
												<tr class="conteudo dark">
													<td>
														<table width="100%" cellpadding="0" cellspacing="0">
															<tr>
																<td width="20">
																	<input type="checkbox" id="aceitar_regras"/>
																</td>
																<td>
																	<label for="aceitar_regras">
																		Eu li e estou de acordo com as <a href="?p=regras" target="_nova">Regras do Servidor</a>.
																	</label>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</div>
									</div>
									<br>
									<div align="center" style="margin-top: 5px;">
										<div class="botao_colorido2_1">
											<input type="submit" class="botao_verde" value="adquirir_agora" />
										</div>
									</div>
								</form>
								<form method="POST" action="?p=minha_conta-servicos-informacoes_pagamento">
									'.$camposOcultos.'
									<div align="center">
										<div class="botao_colorido2_2">
											<input type="submit" class="botao_azul" value="voltar" />
										</div>
									</div>
								</form>
							';
						}
					}
					elseif($acao == "finalizar"){
						$informacoesProduto = $ClassServicos->getInformacoesProduto($_POST["produto"]);
						$informacoesPagamento = $ClassServicos->getInformacoesPagamento($_POST["pagamento"]);
						if	(($informacoesProduto["forma_pagamento"] != $informacoesPagamento["tipo"]) OR
							(($informacoesProduto["forma_pagamento"] == "ponto") AND ($informacoesConta["pontos"]-$informacoesProduto["preco"] < 0)))
								$conteudo_minha_conta = $ClassServicos->carregarMensagem("erro");
						elseif(($informacoesProduto["tipo"] == "nova_chave") AND (empty($informacoesConta["chave_recuperacao"])))
								$conteudo_minha_conta = $ClassServicos->carregarMensagem("erro");
						else{
							$pedido = array(
								"conta" => $accountId,
								"produto" => $_POST["produto"],
								"pagamento" => $_POST["pagamento"],
								"preco" => $informacoesProduto["preco"],
								"nome" => $_POST["nome"],
								"cidade" => $_POST["cidade"],
								"email" => $_POST["email"],
								"data" => time()
							);
							$ClassServicos->novoPedido($pedido);
							$exibirBotoesPagamento = '
								<div align="center">
									<input type="button" class="botao_azul" value="Voltar" onClick="document.location = \'?p=minha_conta\';">
								</div>
								<br>
							';
							$exibirDark = " dark";
							$mensagemSolicitacao = '
								'.ucfirst($informacoesProduto["exibirNome"]).' est� dispon�vel para que voc� escolha um personagem para receber.<br>
								<br>
								Para ativar, v� na p�gina de sua conta e verifique os produtos dispon�veis.
							';
							if($informacoesProduto["tipo"] == "trocar_conta")
								$mensagemSolicitacao = '
									A troca do nome da sua conta j� est� dispon�vel para ser realizada.<br>
									<br>
									Para ativ�-la, v� na p�gina de sua conta e verifique os produtos dispon�veis.
								';
							elseif($informacoesProduto["tipo"] == "nova_chave")
								$mensagemSolicitacao = '
									Uma nova chave de recupera��o j� est� dispon�vel para ser gerada.<br>
									<br>
									Para solicit�-la, v� na p�gina de sua conta e verifique os produtos dispon�veis.
								';
							elseif($_POST["pagamento"] == "pagseguro"){
								$mensagemSolicitacao = 'Ao clicar em "Pr�ximo" voc� ser� redirecionado para o PagSeguro para efetuar o pagamento.';
								$exibirBotoesPagamento = '
									<div align="center">
										<form>
											<div class="botao_colorido2_1">
												<input type="submit" class="botao_verde" value="proximo" onClick="alert(\'Redirecionar para PagSeguro\');">
											</div>
										</form>
										<div class="botao_colorido2_2">
											<input type="button" class="botao_azul" value="Voltar" onClick="document.location = \'?p=minha_conta\';">
										</div>
									</div>
								';
							}
							elseif($_POST["pagamento"] == "transferencia"){
								$exibirDark = "";
								$mensagemSolicitacao = '
									<div class="box_frame_conteudo" carregar_box="1">
										<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
											<tr class="conteudo dark">
												<td>
													<table width="100%" cellpadding="0" cellspacing="0">
														<tr>
															<td width="140">
																<b>Banco:</b>
															</td>
															<td>
																Bradesco
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</div>
									<br>
									<div class="box_frame_conteudo" carregar_box="1">
										<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
											<tr class="conteudo dark">
												<td>
													<table width="100%" cellpadding="0" cellspacing="0">
														<tr>
															<td width="140">
																<b>Ag�ncia:</b>
															</td>
															<td>
																1416-0
															</td>
														</tr>
														<tr>
															<td>
																<b>Conta Poupan�a:</b>
															</td>
															<td>
																1014707-7
															</td>
														</tr>
														<tr>
															<td>
																<b>Nome:</b>
															</td>
															<td>
																Paulo Henrique de Souza Salvatore MR
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</div>
									<br>
									<div class="box_frame_conteudo" carregar_box="1">
										<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
											<tr class="conteudo dark">
												<td>
													<table width="100%" cellpadding="0" cellspacing="0">
														<tr>
															<td width="140">
																<b>Observa��o:</b>
															</td>
															<td>
																Ap�s efetuar a transfer�ncia banc�ria, � necess�rio a confirma��o da mesma.<br>
																Para isso, v� at� seu hist�rico de pagamentos e clique em "Confirmar Transfer�ncia".
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</div>
								';
							}
							$conteudo_minha_conta = '
								'.$pagamento.'
								<div id="barraProgresso" data-config="4" data-tipo="servicos"></div>
								<br>
								<div class="box_frame" carregar_box="1">
									Pedido Finalizado
								</div>
								<div class="box_frame_conteudo_principal" carregar_box="1">
									<div class="box_frame_conteudo'.$exibirDark.' padding">
										Sua solicita��o foi efetuada com sucesso.<br>
										<br>
										'.$mensagemSolicitacao.'
									</div>
								</div>
								<br>
								'.$exibirBotoesPagamento.'
								
							';
						}
					}
					else{
						$ativarOverlay = false;
						$conteudo_minha_conta = $conteudo_nao_encontrado_full;
					}
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
								Verifique as informa��es e tente novamente.
							</div>
							<div class="box_frame" carregar_box="1">
								Editar Informa��es do Personagem
							</div>
							<div class="box_frame_conteudo" carregar_box="1">
								<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
									<tr class="conteudo dark">
										<td>
											<form id="informacoesPersonagem" personagem="'.$id.'">
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
															<input type="checkbox" id="ocultar_conta" name="ocultar_conta"'.$check_ocultar_conta.'><label for="ocultar_conta">Marque para esconder as informa��es de sua conta.</label>
														</td>
													</tr>
													<tr valign="top">
														<td align="left">
															<b class="exibicao_bloco">Coment�rio:</b>
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
							Informa��es do Personagem Editadas
						</div>
						<div class="box_frame_conteudo_principal" carregar_box="1">
							<div class="box_frame_conteudo padding dark">
								As informa��es do personagem foram editadas com sucesso.
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
								Verifique as informa��es e tente novamente.
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
															<b class="exibicao_bloco">Digite a Chave de Recupera��o:</b>
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
									A solicita��o para deletar seu personagem foi registrada com sucesso.<br>
									<br>
									Seu personagem ser� deletado em '.$ClassPersonagem->diasDeletarPersonagem.' dias.<br>
									<br>
									Caso queira, voc� pode desfazer a solicita��o na p�gina da sua conta at� o dia <b>'.$ClassPersonagem->formatarData(time()+$ClassPersonagem->transformarDiasTempo($ClassPersonagem->diasDeletarPersonagem)).'</b>.
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
								Verifique as informa��es e tente novamente.
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
															<b class="exibicao_bloco">Digite a Chave de Recupera��o:</b>
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
									Fique tranquilo! Seu personagem n�o ser� mais deletado.
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
					<table width="100%" cellpadding="0" cellspacing="0" class="tabela dark">
						<tr>
							';
							include("includes/classes/ClassCriaturas.php");
							$ClassCriaturas = new Criaturas();
							foreach($ClassPersonagem->vocacoes as $vocacaoId => $vocacao){
								if($vocacao["disponivel"]){
									$informacoes = $vocacao["informacoes"];
									$exibirArmamento = '';
									$exibirElemento = '';
									foreach($informacoes["armamento"] as $armaId => $descricao)
										$exibirArmamento .= '<img src="imagens/itens/'.$armaId.'.gif" title="'.$descricao.'"/> ';
									foreach($informacoes["elemento"] as $elemento)
										$exibirElemento .= '<img src="imagens/icones/'.$elemento.'_icone.gif" title="'.$ClassCriaturas->formatarNomeIcone($elemento).'"/> ';
									$ganhos = $informacoes["ganhos"];
									$conteudo_minha_conta .= '
										<td style="padding: 0px;" width="25%" valign="top">
											<table width="100%" cellpadding="0" cellspacing="0" class="tabela">
												<tr class="cabecalho">
													<td>
														'.$vocacao["exibicao"].'
													</td>
												</tr>
												<tr height="250" class="item">
													<td align="center">
														<img src="imagens/vocacoes/'.$vocacao["campo"].'_full.png" width="144" alt="" title="'.$vocacao["exibicao"].'" /><br>
													</td>
												</tr>
												<tr class="cabecalho">
													<td>
														Armamento'.(count($informacoes["armamento"]) > 1 ? "s" : "").'
													</td>
												</tr>
												<tr class="item">
													<td>
														'.$exibirArmamento.'
													</td>
												</tr>
												<tr class="cabecalho">
													<td>
														Tipo
													</td>
												</tr>
												<tr class="item">
													<td>
														'.$informacoes["tipo"].'
													</td>
												</tr>
												<tr class="cabecalho">
													<td>
														Elemento'.(count($informacoes["elemento"]) > 1 ? "s" : "").'
													</td>
												</tr>
												<tr class="item">
													<td>
														'.$exibirElemento.'
													</td>
												</tr>
												<tr class="cabecalho">
													<td>
														Promo��o
													</td>
												</tr>
												<tr class="item">
													<td>
														'.$informacoes["promocao"].'
													</td>
												</tr>
												<tr class="cabecalho">
													<td>
														Ganhos por N�vel
													</td>
												</tr>
												<tr class="item">
													<td>
														'.$ganhos[0].' oz de capacidade<br>
														'.$ganhos[1].' pontos de vida<br>
														'.$ganhos[2].' pontos de mana
													</td>
												</tr>
												<tr class="item" align="center">
													<td>
														<input type="button" class="botao mudar_vocacao_personagem" value="Criar '.$vocacao["exibicao"].'" vocacao="'.$vocacaoId.'" />
													</td>
												</tr>
											</table>
										</td>
									';
								}
							}
							$conteudo_minha_conta .= '
						</tr>
					</table>
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
						Informa��es Gerais
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
											$exibirValor = "Conta N�o Registrada. Clique no bot�o abaixo para Registr�-la.";
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
										$mensagemAlteracaoEmail = 'Confirme seu novo e-mail. <a href="?p=minha_conta-alterar_email-reenviar">Reenviar Confirma��o</a>';
									elseif($informacoesConta["email_novo_tempo"]+$ClassFuncao->transformarDiasTempo($ClassConta->diasTrocarEmail) > time())
										$mensagemAlteracaoEmail = 'Poder� ser alterado em '.$ClassConta->formatarData($informacoesConta["email_novo_tempo"]+$ClassFuncao->transformarDiasTempo($ClassConta->diasTrocarEmail)).'.';
									else
										$mensagemAlteracaoEmail = 'Voc� pode alterar seu e-mail <a href="?p=minha_conta-alterar_email">clicando aqui</a>.';
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
									<div class="botao_colorido3_1">
										<input type="submit" class="botao_azul" value="alterar_senha" onClick="document.location = \'?p=minha_conta-alterar_senha\'" />
									</div>
									<div class="botao_colorido3_2">
										<input type="button" class="botao_azul" value="registrar" onClick="document.location = \'?p=minha_conta-registrar\'" />
									</div>
									<div class="botao_colorido3_3">
										<input type="button" class="botao_azul" value="alterar_email" onClick="document.location = \'?p=minha_conta-alterar_email\'" />
									</div>
								</div>
							';
						else
							$conteudo_minha_conta .= '
								<div align="center" style="margin-top: 5px;">
									<div class="botao_colorido2_1">
										<input type="submit" class="botao_azul" value="alterar_senha" onClick="document.location = \'?p=minha_conta-alterar_senha\'" />
									</div>
									<div class="botao_colorido2_2">
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
									Informa��es
								</td>
								<td width="20%" align="center">
									Status
								</td>
								<td width="20%" align="center">
									Op��es
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
						Servi�os Dispon�veis
					</div>
					<div class="box_frame_conteudo_principal borda2_padding" carregar_box="1">
						<div class="box_frame_conteudo" carregar_box="1">
							<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
								';
								foreach($config["servicos"] as $categoriaId => $categoria)
									$conteudo_minha_conta .= '
										<tr class="conteudo dark">
											<td>
												<form method="POST" action="?p=minha_conta-servicos">
													<input type="hidden" name="servico" value="'.$categoriaId.'" />
													<div style="float: right;">
														<input type="submit" class="botao_verde" value="adquirir" />
													</div>
												</form>
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