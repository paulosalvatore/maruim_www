<?php
	if($usuario_encontrado != 1){
		$conteudo_minha_conta = '
			Seja bem-vindo � p�gina de recupera��o de conta!<br>
			<br>
			Se voc� perdeu o acesso a sua conta, essa p�gina poder� ajud�-lo. Claro, voc� precisa provar que a conta � sua. Digite os dados solicitados e siga atentamente as instru��es. Esteja ciente de que n�o h� outra maneira de recuperar sua conta sem ser atrav�s desse sistema. Duas outras op��es para alterar os dados da conta est�o dispon�veis se voc� tiver uma conta registrada.<br>
			<br>
			Utilizando o Sistema de Recupera��o de Conta voc� pode:<br>
			<br>
			<ul class="lista">
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
						<b>Personagem ou Conta:</b>
						<input type="text" id="personagem_conta">
						<input type="button" class="botao" value="Enviar" />
					</td>
				</tr>
			</table>
		';
	}
	else{
		$conteudo_minha_conta = '
			P�gina da conta
		';
	}
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				'.$conteudo_minha_conta.'
			</div>
		</div>
	';
?>