<?php
	include("includes/classes/ClassCriaturas.php");
	include("includes/classes/ClassItens.php");
	$ClassCriaturas = new Criaturas();
	$ClassItens = new Itens();
	$areas = array("gerarMonsterXML", "atualizarListaCriaturas", "inserirItensSQL", "inserirItensCategoria");
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="">
			<div class="conteudo_box pagina">
				<div class="box_frame" carregar_box="1">
					Desenvolvedor - Gerenciamento
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					<div class="box_frame_conteudo">
						';
						if(empty($id))
							$conteudo_pagina .= '
								<a href="?p=desenvolvedor_gerenciamento-gerarMonsterXML">Gerar monster.xml</a><br>
								<a href="?p=desenvolvedor_gerenciamento-atualizarListaCriaturas">Atualizar Criaturas</a><br>
								<a href="?p=desenvolvedor_gerenciamento-inserirItensSQL">Inserir Itens SQL</a><br>
								<a href="?p=desenvolvedor_gerenciamento-inserirItensCategoria">Inserir Itens Categoria</a><br>
							';
						elseif(in_array($id, $areas)){
							if($id == "gerarMonsterXML")
								$conteudo_pagina .= $ClassCriaturas->gerarMonsterXML();
							elseif($id == "atualizarListaCriaturas")
								$conteudo_pagina .= $ClassCriaturas->atualizarListaCriaturas();
							elseif($id == "inserirItensSQL")
								$conteudo_pagina .= $ClassItens->inserirItensSQL($ClassItens->pegarTodosItens());
							elseif($id == "inserirItensCategoria")
								$conteudo_pagina .= $ClassItens->inserirItensCategoria();
						}
						$conteudo_pagina .= '
					</div>
				</div>
			</div>
		</div>
	';
?>