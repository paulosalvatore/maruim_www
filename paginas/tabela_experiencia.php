<?php
	$niveisSelecao = array(200, 400, 600, 800, 1000);
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
			<div class="conteudo_box pagina padding">
				Esta � uma lista dos pontos de experi�ncia que s�o necess�rios para avan�ar para os v�rios n�veis. Lembre-se que voc� tamb�m pode verificar a respectiva barra de habilidade na sua janela de habilidade do cliente para verificar o seu progresso em dire��o ao pr�ximo n�vel.<br>
				<br>
				<b>Selecione o n�vel m�ximo da tabela:</b><br>
				<select class="nivelMaximo" style="width: 120px; margin: 3px 0 3px 0;">
					';
					foreach($niveisSelecao as $nivel)
						$conteudo_pagina .= '<option value="'.$nivel.'">N�vel '.$nivel.'</option>';
					$conteudo_pagina .= '
				</select><br>
				<input type="text" class="nivelMaximo" style="width: 116px; margin-bottom: 3px;"><br>
				<input type="button" class="botao nivelMaximo" value="Aplicar" style="margin-bottom: 3px;">
				<br>
				<div id="tabelaExperiencia" data-nivel="0"></div>
			</div>
		</div>
	';
?>