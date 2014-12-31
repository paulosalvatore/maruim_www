<?php
	if($usuario_encontrado != 1){
		$conteudo_minha_conta = '
			Welcome to the Lost Account Interface!<br>
			<br>
			If you have lost access to your account, this interface can help you. Of course, you need to prove that your claim to the account is justified. Enter the requested data and follow the instructions carefully. Please understand there is no way to get access to your lost account if the interface cannot help you. Two further options to change account data are available if you have a registered account.
			<br>
			By using the Lost Account Interface you can
			<br>
			<ul>
				<li>
					get a new password if you have lost the current password,
				</li>
				<li>
					receive your account name if you do not know it anymore,
				</li>
				<li>
					get your account back if it has been hacked,
				</li>
				<li>
					change the email address of your account instantly (only available to registered accounts),
				</li>
				<li>
					request a new recovery key (only available to registered accounts).
				</li>
			</ul>
			As a first step to use the Lost Account Interface please enter the name of a character on the lost account and click on "Submit".<br>
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
						<input type="text">
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