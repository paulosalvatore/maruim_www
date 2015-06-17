<?php
	set_time_limit(60*60);
	include("includes/classes/ClassCriaturas.php");
	include("includes/classes/ClassItens.php");
	$ClassCriaturas = new Criaturas();
	$ClassItens = new Itens();
	// $ClassItens->inserirItensSQL($ClassItens->pegarTodosItens());
	// exit;
	$area = $id;
	$id = $acao;
	if(is_numeric($area)){
		$id = $area;
		$item = $ClassItens->getItemInfoSQL($id)[$id];
		$conteudo_pagina .= '
			<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
				<div class="conteudo_box pagina">
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
								<span class="verde">
								';
								if($item["atributos"]["range"] > 0)
									$conteudo_pagina .= '
										(Range: '.$item["atributos"]["range"].').<br>
									';
								if($item["atributos"]["weight"] > 0)
									$conteudo_pagina .= '
										Peso: '.number_format($item["atributos"]["weight"]/100, 2, ".", "").' oz.<br>
									';
								$conteudo_pagina .= '
								</span>
							</td>
						</tr>
						';
						$atributosItem = $ClassItens->pegarAtributosItem($item["atributos"]);
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
		// echo'<pre>';
		// print_r($item);
		// echo'</pre>';
	}
	// elseif($area == "menu"){
		// $conteudo_pagina .= '
			// <div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
				// <div class="conteudo_box pagina">
					// Exibir Menu de Itens
				// </div>
			// </div>
		// ';
	// }
	// elseif($area == "categorias"){
		// $conteudo_pagina .= '
			// <div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
				// <div class="conteudo_box pagina">
					// Exibir Categorias de Itens
				// </div>
			// </div>
		// ';
	// }
	// else
		// $conteudo_pagina .= $conteudo_nao_encontrado_full;
?>