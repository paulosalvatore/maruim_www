<?php
	include("includes/classes/ClassCriaturas.php");
	include("includes/classes/ClassItens.php");
	include("includes/classes/ClassXml.php");
	$ClassCriaturas = new Criaturas();
	$ClassItens = new Itens();
	$ClassXml = new Xml();
	$areas = array("atualizarOutfits", "atualizarMontarias", "gerarMonsterXML", "atualizarListaCriaturas", "inserirItensSQL", "inserirItensCategoria");
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="">
			<div class="conteudo_box pagina">
				';
				if(!empty($id))
					$conteudo_pagina .= '
						<div class="setas">
							<div class="seta voltar">
								<a href="?p=desenvolvedor_gerenciamento"><img src="imagens/corpo/arrow_up.gif" /> voltar</a>
							</div>
						</div>
					';
				$conteudo_pagina .= '
				<div class="box_frame" carregar_box="1">
					Desenvolvedor - Gerenciamento
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					<div class="box_frame_conteudo padding dark">
						';
						if(empty($id))
							$conteudo_pagina .= '
								<ul>
									<li>
										<a href="?p=desenvolvedor_gerenciamento-atualizarOutfits">Atualizar Outfits</a>
									</li>
									<li>
										<a href="?p=desenvolvedor_gerenciamento-atualizarMontarias">Atualizar Montarias</a>
									</li>
									<li>
										<a href="?p=desenvolvedor_gerenciamento-gerarMonsterXML">Gerar monster.xml</a>
									</li>
									<li>
										<a href="?p=desenvolvedor_gerenciamento-atualizarListaCriaturas">Atualizar Criaturas</a>
									</li>
									<li>
										<a href="?p=desenvolvedor_gerenciamento-inserirItensSQL">Inserir Itens SQL</a>
									</li>
									<li>
										<a href="?p=desenvolvedor_gerenciamento-inserirItensCategoria">Inserir Itens Categoria</a>
									</li>
								</ul>
							';
						elseif(in_array($id, $areas)){
							if($id == "atualizarOutfits")
								$conteudo_pagina .= $ClassXml->atualizarRegistros("outfit", "z_outfits");
							elseif($id == "atualizarMontarias")
								$conteudo_pagina .= $ClassXml->atualizarRegistros("mount", "z_montarias");
							elseif($id == "gerarMonsterXML")
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