<?php
	include("includes/classes/ClassCriaturas.php");
	$ClassCriaturas = new Criaturas();
	$areas = array("atualizarListaCriaturas");
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
								<a href="?p=desenvolvedor_gerenciamento-atualizarListaCriaturas">Atualizar Criaturas</a>
							';
						elseif(in_array($id, $areas)){
							if($id == "atualizarListaCriaturas")
								$conteudo_pagina .= $ClassCriaturas->atualizarListaCriaturas();
						}
						$conteudo_pagina .= '
					</div>
				</div>
			</div>
		</div>
	';
?>