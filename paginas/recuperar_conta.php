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
					$mensagemErro = "Digite o nome da conta perdida. Se a sua conta n�o possui nome, crie uma nova conta.";
				elseif(count($contaInfo) == 0)
					$mensagemErro = "A conta <b>$conta</b> n�o existe.<br><br>Certifique-se de que digitou o nome da conta corretamente.<br><br>Note que algumas contas podem ser deletadas automaticamente caso n�o tenham sido usadas ap�s um longo per�odo de tempo.";
				else{
					$contaId = $contaInfo["id"];
					$cabecalho = "Nome da conta: '$conta'";
				}
			}
			elseif($tipo == 2){
				$exibirTipo = array("personagem", $personagem);
				$personagemInfo = $ClassPersonagem->getInformacoesPersonagem($personagem);
				if(empty($personagem))
					$mensagemErro = "Digite o nome de um personagem da conta perdida. Se a sua conta n�o possui nenhum personagem, crie uma nova conta.";
				elseif(count($personagemInfo) == 0)
					$mensagemErro = "O personagem <b>$personagem</b> n�o existe.<br><br>Certifique-se de que digitou o nome do personagem corretamente.<br><br>Note que alguns personagens podem ser deletados automaticamente caso n�o tenham sido usados ap�s um longo per�odo de tempo.";
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
						"email" => "Eu n�o sei o e-mail da conta",
						"conta_senha" => "Eu tamb�m esquece a senha da minha conta"
					);
					$conteudo_recuperar_conta .= '
						Siga as instru��es abaixo para receber o nome de sua conta por e-mail.<br>
						<ol class="margem" type="1">
							<li>Escolha "Sim, envie por e-mail" se voc� possui acesso ao e-mail cadastrado na conta.</li>
							<li>Insira o e-mail cadastrado na conta no campo "E-mail da conta".</li>
							<li>Digite a senha de sua conta no campo "Senha".</li>
							<li>Clique em "Enviar".</li>
							<li>Ap�s um curto per�odo de tempo voc� receber� o nome da sua conta no seu e-mail.</li>
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
						"email" => "Quero trocar o e-mail da minha conta instant�neamente",
						"key" => "Preciso de uma nova Chave de Recupera��o"
					);
					$conteudo_recuperar_conta .= '
						O Sistema de Recupera��o de Conta pode ajud�-lo a resolver todos os problemas listados abaixo. Selecione o seu problema e clique em "Enviar".<br>
						<br>
						Se o seu problema n�o est� listado abaixo, voc� pode procurar a resposta em nosso site. Repostas para as perguntas mais frequentes podem ser encontradas na p�gina <a href="?p=faq">FAQ</a>. Voc� tamb�m pode consultar o <a href="?p=manual">manual</a>. Se voc� tiver d�vidas sobre a seguran�a da sua conta, por favor, d� uma olhada nas <a href="?p=dicas_seguranca">dicas de seguran�a</a>.<br>
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
				<span class="grande negrito">Seja bem-vindo � p�gina de recupera��o de conta!</span><br>
				<br>
				Se voc� perdeu o acesso a sua conta, essa p�gina poder� ajud�-lo. Claro, voc� precisa provar que a conta � sua. Digite os dados solicitados e siga atentamente as instru��es. Esteja ciente de que n�o h� outra maneira de recuperar sua conta sem ser atrav�s desse sistema. Duas outras op��es para alterar os dados da conta est�o dispon�veis se voc� tiver uma conta registrada.<br>
				<br>
				Utilizando o Sistema de Recupera��o de Conta voc� pode:<br>
				<ul class="lista margem">
					<li>
						Gerar uma nova senha, caso tenha perdido a atual;
					</li>
					<li>
						Receber o nome da sua conta, caso voc� n�o se lembre mais;
					</li>
					<li>
						Recuperar sua conta de volta caso tenha sido invadida;
					</li>
					<li>
						Trocar o e-mail de sua conta instantaneamente (somente dispon�vel para contas registradas);
					</li>
					<li>
						Gerar uma nova Chave de Seguran�a (somente dispon�vel para contas registradas).
					</li>
				</ul>
				<br>
				O primeiro passo para usar o Sistema de Recupera��o de Conta � digitar o nome da conta ou o nome de um personagem da conta perdida e clicar no bot�o "Enviar".<br>
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
					Voc� n�o pode utilizar o sistema de recupera��o de contas enquanto voc� estiver conectado em uma conta.<br>
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