<?php
	$mensagemErro = "";
	if(!$usuarioEncontrado){
		foreach($ClassFuncao->separarForm($_POST) as $c => $v)
			$$c = $v;
		if($tipo == 1 || $tipo == 2){
			$contaId = 0;
			if($tipo == 1){
				$exibirTipo = array("conta", $conta);
				$contaInfo = $ClassConta->getInformacoesConta($conta);
				if(empty($conta))
					$mensagemErro = "Digite o nome da conta perdida. Se a sua conta não possui nome, crie uma nova conta.";
				elseif(count($contaInfo) == 0)
					$mensagemErro = "A conta <b>$conta</b> não existe.<br><br>Certifique-se de que digitou o nome da conta corretamente.<br><br>Note que algumas contas podem ser deletadas automaticamente caso não tenham sido usadas após um longo período de tempo.";
				else{
					$contaId = $contaInfo["id"];
					$cabecalho = "Nome da conta: '$conta'";
				}
			}
			elseif($tipo == 2){
				$exibirTipo = array("personagem", $personagem);
				$personagemInfo = $ClassPersonagem->getInformacoesPersonagem($personagem);
				if(empty($personagem))
					$mensagemErro = "Digite o nome de um personagem da conta perdida. Se a sua conta não possui nenhum personagem, crie uma nova conta.";
				elseif(count($personagemInfo) == 0)
					$mensagemErro = "O personagem <b>$personagem</b> não existe.<br><br>Certifique-se de que digitou o nome do personagem corretamente.<br><br>Note que alguns personagens podem ser deletados automaticamente caso não tenham sido usados após um longo período de tempo.";
				else{
					$contaId = $personagemInfo["contaId"];
					$cabecalho = "Nome do Personagem: '$personagem'";
				}
			}
			if($contaId > 0){
				$conteudo_recuperar_conta = '
					<h2 align="center">'.$cabecalho.'</h2>
				';
				if($problema == "conta"){
					$listaProblemas = array(
						"enviar_email" => "Sim, envie por e-mail",
						"email" => "Eu perdi acesso ao e-mail da conta",
						"email" => "Eu não sei o e-mail da conta",
						"conta_senha" => "Eu também esquece a senha da minha conta"
					);
					$conteudo_recuperar_conta .= '
						Siga as instruções abaixo para receber o nome de sua conta por e-mail.<br>
						<ol class="margem" type="1">
							<li>Escolha "Sim, envie por e-mail" se você possui acesso ao e-mail cadastrado na conta.</li>
							<li>Insira o e-mail cadastrado na conta no campo "E-mail da conta".</li>
							<li>Digite a senha de sua conta no campo "Senha".</li>
							<li>Clique em "Enviar".</li>
							<li>Após um curto período de tempo você receberá o nome da sua conta no seu e-mail.</li>
						</ol>
						<br>
						'.$ClassConta->exibirProblemas("Recuperar Nome da Conta", $listaProblemas).'
					';
				}
				elseif($problema == "senha"){
					$conteudo_recuperar_conta .= '
						Recuperar Senha
					';
				}
				else{
					$listaProblemas = array(
						"conta" => "Esqueci minha conta",
						"senha" => "Esqueci minha senha",
						"conta_senha" => "Esqueci minha conta e minha senha",
						"invasao" => "Minha conta foi invadida",
						"email" => "Quero trocar o e-mail da minha conta instantâneamente",
						"key" => "Preciso de uma nova Chave de Recuperação"
					);
					$conteudo_recuperar_conta .= '
						O Sistema de Recuperação de Conta pode ajudá-lo a resolver todos os problemas listados abaixo. Selecione o seu problema e clique em "Enviar".<br>
						<br>
						Se o seu problema não está listado abaixo, você pode procurar a resposta em nosso site. Repostas para as perguntas mais frequentes podem ser encontradas na página <a href="?p=faq">FAQ</a>. Você também pode consultar o <a href="?p=manual">manual</a>. Se você tiver dúvidas sobre a segurança da sua conta, por favor, dê uma olhada nas <a href="?p=dicas_seguranca">dicas de segurança</a>.<br>
						<br>
						<form method="POST">
							<input type="hidden" name="tipo" value="'.$tipo.'">
							<input type="hidden" name="'.$exibirTipo[0].'" value="'.$exibirTipo[1].'">
							'.$ClassConta->exibirProblemas("Especifique seu Problema", $listaProblemas).'
							<br>
							<div align="center">
								<input type="submit" class="botao" value="Enviar" />
							</div>
						</form>
					';
				}
			}
		}
		else{
			$conteudo_recuperar_conta = '
				<br>
				<span class="grande negrito">Seja bem-vindo à página de recuperação de conta!</span><br>
				<br>
				Se você perdeu o acesso a sua conta, essa página poderá ajudá-lo. Claro, você precisa provar que a conta é sua. Digite os dados solicitados e siga atentamente as instruções. Esteja ciente de que não há outra maneira de recuperar sua conta sem ser através desse sistema. Duas outras opções para alterar os dados da conta estão disponíveis se você tiver uma conta registrada.<br>
				<br>
				Utilizando o Sistema de Recuperação de Conta você pode:<br>
				<ul class="lista margem">
					<li>
						Gerar uma nova senha, caso tenha perdido a atual;
					</li>
					<li>
						Receber o nome da sua conta, caso você não se lembre mais;
					</li>
					<li>
						Recuperar sua conta de volta caso tenha sido invadida;
					</li>
					<li>
						Trocar o e-mail de sua conta instantaneamente (somente disponível para contas registradas);
					</li>
					<li>
						Gerar uma nova Chave de Segurança (somente disponível para contas registradas).
					</li>
				</ul>
				<br>
				O primeiro passo para usar o Sistema de Recuperação de Conta é digitar o nome da conta ou o nome de um personagem da conta perdida e clicar no botão "Enviar".<br>
				<br>
				<table class="tabela dark" cellpadding="0" cellspacing="0" width="100%">
					<tr class="cabecalho">
						<td>
							Digite o personagem ou a conta
						</td>
					</tr>
					<tr class="item">
						<td>
							<form method="POST">
								<input type="hidden" name="tipo" value="1">
								<table cellpadding="0" cellspacing="0">
									<tr>
										<td width="100">
											<b>Conta:</b>
										</td>
										<td>
											<input type="text" id="conta" name="conta">
										</td>
										<td>
											<input type="submit" class="botao" value="Enviar" />
										</td>
									</tr>
								</table>
							</form>
							<form method="POST">
								<input type="hidden" name="tipo" value="2">
								<table cellpadding="0" cellspacing="0">
									<tr>
										<td width="100">
											<b>Personagem:</b>
										</td>
										<td>
											<input type="text" id="personagem" name="personagem">
										</td>
										<td>
											<input type="submit" class="botao" value="Enviar" />
										</td>
									</tr>
								</table>
							</form>
						</td>
					</tr>
				</table>
			';
		}
	}
	else{
		$conteudo_recuperar_conta = '
			<div class="box_frame" carregar_box="1">
				Perdeu sua Conta?
			</div>
			<div class="box_frame_conteudo_principal" carregar_box="1">
				<div class="box_frame_conteudo padding dark">
					Você não pode utilizar o sistema de recuperação de contas enquanto você estiver conectado em uma conta.<br>
				</div>
			</div>
			<br>
			<div align="center">
				<input type="button" class="botao_vermelho" value="desconectar_se" onClick="document.location = \'includes/logout.php\';"/>
			</div>
		';
	}
	if(!empty($mensagemErro))
		$conteudo_recuperar_conta = '
			<div class="box_frame" carregar_box="1">
				Algum erro ocorreu
			</div>
			<div class="box_frame_conteudo_principal" carregar_box="1">
				<div class="box_frame_conteudo padding dark">
					'.$mensagemErro.'
				</div>
			</div>
			<br>
			<div align="center">
				<input type="button" class="botao_azul" value="voltar" onClick="document.location = \'?p=recuperar_conta\';"/>
			</div>
		';
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina padding">
				'.$conteudo_recuperar_conta.'
			</div>
		</div>
	';
?>