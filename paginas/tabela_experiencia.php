<?php
	$niveisSelecao = array(200, 400, 600, 800, 1000);
	$imagemTitulo = $incluir_arquivo;
	if(!empty($id) and $id == "profissao"){
		$niveisSelecao = array(40, 50, 70, 80, 90, 100);
		$imagemTitulo = "tabela_experiencia_profissao";
	}
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$imagemTitulo.'">
			<div class="conteudo_box pagina padding">
				Esta � uma lista dos pontos de experi�ncia que s�o necess�rios para avan�ar para os v�rios n�veis. Lembre-se que voc� tamb�m pode verificar '.($id != "profissao" ? "a respectiva barra de habilidade na sua janela de habilidade do cliente" : "a janela de informa��es da profiss�o desejada").' para verificar o seu progresso em dire��o ao pr�ximo n�vel.<br>
				<br>
				'.($exibirProfissoes ? 'Voc� tamb�m pode visualizar a '.($id != "profissao" ? '<a href="?p=tabela_experiencia-profissao">tabela de experi�ncia de profiss�o</a>' : '<a href="?p=tabela_experiencia">tabela de experi�ncia comum</a>').'.<br>' : "").'
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
				<div id="tabelaExperiencia" data-nivel="0" data-id="'.$id.'"></div>
			</div>
		</div>
	';
?>