<?php
	if($usuario_encontrado != 1){
		$conteudo_minha_conta = '
			Seja bem-vindo à página de recuperação de conta!<br>
			<br>
			Se você perdeu o acesso a sua conta, essa página poderá ajudá-lo. Claro, você precisa provar que a conta é sua. Digite os dados solicitados e siga atentamente as instruções. Esteja ciente de que não há outra maneira de recuperar sua conta sem ser através desse sistema. Duas outras opções para alterar os dados da conta estão disponíveis se você tiver uma conta registrada.<br>
			<br>
			Utilizando o Sistema de Recuperação de Conta você pode:<br>
			<br>
			<ul class="lista">
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
			Página da conta
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