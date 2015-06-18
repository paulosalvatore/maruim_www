<?php
	include("includes/classes/ClassCriaturas.php");
	include("includes/classes/ClassItens.php");
	$ClassCriaturas = new Criaturas();
	$ClassItens = new Itens();
	$area = $id;
	$id = $acao;
	$exibirBuscaItem = $ClassItens->pegarBuscaItem();
	if(($area == "item") and (is_numeric($id))){
		$item = $ClassItens->getItemInfoSQL($id)[$id];
		$conteudo_pagina .= '
			<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
				<div class="conteudo_box pagina">
					<div class="setas">
						<div class="seta voltar">
							<a href="'.$item["urlVoltar"].'"><img src="imagens/corpo/arrow_up.gif" /> voltar</a>
						</div>
					</div>
					'.$exibirBuscaItem.'
					<div class="box_frame" carregar_box="1">
						'.$item["nome"].'
					</div>
					<br>
					<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
						<tr class="cabecalho">
							<td colspan="2">
								Informações gerais
							</td>
						</tr>
						<tr class="item">
							<td width="180" align="right">
								'.$item["imagem"].'
							</td>
							<td>
								<b>'.$item["nome"].'</b><br>
								'.$item["exibirAtributos"].'
							</td>
						</tr>
						';
						$atributosItem = $ClassItens->pegarAtributosItem($item);
						if(!empty($atributosItem))
							$conteudo_pagina .= '
								<tr class="item">
									<td align="right">
										<b>Atributos</b>
									</td>
									<td>
										'.$atributosItem.'
									</td>
								</tr>
							';
						$conteudo_pagina .= '
					</table>
					<br>
					';
					$exibirReceitas = $ClassItens->pegarReceitasItem($id, "fabricacao");
					if(!empty($exibirReceitas)){
						$conteudo_pagina .= '
							<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
								<tr class="cabecalho">
									<td colspan="2">
										Receita para fazer esse Item:
									</td>
								</tr>
								'.$exibirReceitas.'
							</table>
							<br>
						';
					}
					$exibirReceitas = $ClassItens->pegarReceitasItem($id, "ferramenta");
					if(!empty($exibirReceitas)){
						$conteudo_pagina .= '
							<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
								<tr class="cabecalho">
									<td colspan="2">
										Esse Item é utilizado como Ferramenta nas seguintes receitas:
									</td>
								</tr>
								'.$exibirReceitas.'
							</table>
							<br>
						';
					}
					$exibirReceitas = $ClassItens->pegarReceitasItem($id, "materiais");
					if(!empty($exibirReceitas)){
						$conteudo_pagina .= '
							<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
								<tr class="cabecalho">
									<td colspan="2">
										Receitas que utilizam esse Item:
									</td>
								</tr>
								'.$exibirReceitas.'
							</table>
							<br>
						';
					}
					$exibirDrop = $ClassItens->exibirDropItem($item["drop"]);
					if(!empty($exibirDrop)){
						$conteudo_pagina .= '
							<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
								<tr class="cabecalho">
									<td colspan="2">
										Loot de:
									</td>
								</tr>
								'.$exibirDrop.'
							</table>
							<br>
						';
					}
					$exibirNpcsItem = $ClassItens->exibirNpcsItem($id);
					$exibirNpcsCompram = $exibirNpcsItem[0];
					$exibirNpcsVendem = $exibirNpcsItem[1];
					$conteudo_pagina .= '
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td width="50%" valign="top">
								<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
									<tr class="cabecalho" align="center">
										<td colspan="2">
											Compra de:
										</td>
									</tr>
									'.$exibirNpcsCompram.'
								</table>
							</td>
							<td width="50%" valign="top">
								<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
									<tr class="cabecalho" align="center">
										<td colspan="2">
											Vende para:
										</td>
									</tr>
									'.$exibirNpcsVendem.'
								</table>
							</td>
						</tr>
					</table>
					<br>
				</div>
			</div>
		';
	}
	elseif((empty($area)) or ($area == "menus")){
		if((!empty($id)) and (is_numeric($id)))
			$conteudo_pagina .= '
				<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="itens_menus">
					<div class="conteudo_box pagina">
						'.$ClassItens->pegarExibicaoMenus($id).'
					</div>
				</div>
			';
		else
			$conteudo_pagina .= '
				<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="itens_menus">
					<div class="conteudo_box pagina">
						<div class="box_frame" carregar_box="1">
							Itens
						</div>
						<div class="box_frame_conteudo_principal" carregar_box="1">
							<div class="box_frame_conteudo padding dark">
								Diversos itens podem ser encontrados no mundo.<br>
								<br>
								Muitos deles podem ser comercializados por jogadores dentro do mercado encontrado nos <i>depots</i> das cidades.<br>
								<br>
								No mercado é possível ver os valores praticados de um determinado item, como também informaçôes sobre o peso, as descrições, os ataques e defesas de armas e escudos.<br>
								<br>
								Existem tantos itens catalogados com tantos propósitos diferentes que essa lista foi dividida em diferentes categorias.
							</div>
						</div>
						<br>
						'.$ClassItens->pegarExibicaoMenus().'
					</div>
				</div>
			';
	}
	elseif(($area == "categorias") and (is_numeric($id))){
		$conteudo_pagina .= '
			<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="itens_categorias">
				<div class="conteudo_box pagina">
					'.$ClassItens->pegarExibicaoCategoria($id).'
				</div>
			</div>
		';
	}
	elseif($area == "buscar"){
		$conteudo_pagina .= '
			<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="itens_buscar">
				<div class="conteudo_box pagina">
					'.$ClassItens->exibirBuscaItem($_POST["busca"]).'
				</div>
			</div>
		';
	}
	else
		$conteudo_pagina .= $conteudo_nao_encontrado_full;
?>