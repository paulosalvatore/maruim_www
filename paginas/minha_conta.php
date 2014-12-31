<?php
	if(!$usuario_encontrado){
		$conteudo_minha_conta = '
			<div class="small_box_frame erro" carregar_box="1">
				<b>Os seguintes erros ocorerram:</b><br>
				Usu�rio e/ou senha inv�lidos. Digite dados v�lidos.
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
									<input type="submit" value="Entrar">
								</td>
							</tr>
							<tr>
								<td colspan="2" align="right">
									<input type="button" value="Perdeu sua Conta?">
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<br>
			Tarefas para essa p�gina:
			<ul class="tarefas">
				<li>
					Criar Formul�rio de Login
				</li>
				<li>
					Criar Formul�rio de "Perdeu sua Conta?"
				</li>
				<li>
					Criar Sistema de Login/Cria��o de Conta com Facebook
				</li>
			</ul>
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