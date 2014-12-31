<?php
	$grupos_profissoes = array(
		1 => "Coleta",
		2 => "Fabricação"
	);
	$profissoes = array(
		"Ferreiro" => array(
			"caracteristica" => "Os ferreiros são capazes de produzir armamentos e armaduras a partir de minérios.",
			"grupo" => array(1, 2),
		),
		"Alfaiate" => array(
			"caracteristica" => "Os alfaiates são capazes de produzir roupas a partir de tecidos.",
			"grupo" => array(1, 2),
		),
		"Alquimista" => array(
			"caracteristica" => "Os alquimistas são capazes de coletar ervas, fazer poções e encantar itens.",
			"grupo" => array(1, 2),
		),
		"Cozinheiro" => array(
			"caracteristica" => "Os cozinheiros são capazes de produzir comidas.",
			"grupo" => array(1, 2),
		)
	);
	$itens = array(
		"ferreiro" => array(
			"mesa_trabalho" => array(
				2555, //Anvil
			),
			"ferramentas" => array(
				2556, //Wooden Hammer
				2557, //Hammer
				2422, //Iron Hammer
				2421, //Thunder Hammer
				7758, //Fiery War Hammer
				7777, //Icy War Hammer
				7868, //Earth War Hammer
				7883, //Energy War Hammer
				2417, //Battle Hammer
				2434, //Dragon Hammer
				2444, //Hammer of Wrath
				7422, //Jade Hammer
				7437, //Sapphire Hammer
				7450, //Hammer of Prophecy
				14334, //Giant Smithhammer
				19956, //Trunkhammer
				19793, //Can of Oil (ID?)
				5468, //Fire Bug
				9930, //Flask of Rusty Remover
			),
			"ingredientes" => array(
				5892, //Huge Chunk of Crude Iron
				5880, //Iron Ore
				5889, //Piece of Draconian Steel
				5888, //Piece of Hell Steel
				5887, //Piece of Royal Steel
				8300, //Flawless Ice Crystal
				2177, //Life Crystal
				15565, //Rough Red Gem
				2147, //Small Ruby
				2146, //Small Sapphire
				2149, //Small Emerald
				2150, //Small Amethyst
				2145, //Small Diamond
				9970, //Small Topaz
				2157, //Gold Nugget
				2151, //Talon
				2143, //White Pearl
				2144, //Black Pearl
				2153, //Violet Gem
				2154, //Yellow Gem
				2155, //Green Gem
				2156, //Red Gem
				13866, //Heavy Stone
				8310, //Neutral Matter
				12505, //Old Iron
				21401, //Small Dragon Tear
				21585, //Smoking Coal
				13213, //Strange Red Powder
				13214, //Strange Yellow Powder
				13215, //Strange Blue Powder
				2336, //Gem Holder
				15515, //Bar of Gold
				18413, //Blue Crystal Shard
				18418, //Blue Crystal Splinter
				18417, //Brown Crystal Splinter
				18419, //Cyan Crystal Fragment
				7632, //Giant Shimmering Pearl
				9971, //Gold Ingot
				18421, //Green Crystal Fragment
				18415, //Green Crystal Shard
				18416, //Green Crystal Splinter
				18420, //Green Crystal Splinter
				2134, //Silver Brooch
				12662, //Stone of Wisdom
				5022, //Orichalcum Pearl
				15431, //The Heart of the Sea
				18414, //Violet Crystal Shard
				10155, //Shadow Orb
				13757, //Coal
				10033, //Wooden Ties
				18427, //Pulverized Ore
				11227, //Shiny Stone
				5944, //Soul Orb
				11325, //Spiked Iron Ball
				11232, //Sulphurous Stone
				18429, //Vein of Ore
				10571, //War Crystal
				8306, //Pure Energy
				10531, //Midnight Shard
			),
			"produtos" => array(),
			"receitas" => array(
				2400 => array( //Magic Sword
					array(2656, 2),
				),
			)
		),
		"alfaiate" => array(
			"mesa_trabalho" => array(
				9911, //Suspicious Cauldron
			),
			"ferramentas" => array(
				5908, //Blessed Wooden Stake
			),
			"ingredientes" => array(
				5909, //White Piece of Cloth
				5910, //Green Piece of Cloth
				5911, //Red Piece of Cloth
				5912, //Blue Piece of Cloth
				5913, //Brown Piece of Cloth
				5914, //Yellow Piece of Cloth
				5876, //Lizard Leather
				5881, //Lizard Scale
				5948, //Red Dragon Leather
				5882, //Red Dragon Scale
				5878, //Minotaur Leather
				13541, //Dubious Piece of Cloth
				13540, //Ominous Piece of Cloth
				13542, //Voluminous Piece of Cloth
				13543, //Obvious Piece of Cloth
				13544, //Ludicrous Piece of Cloth
				13545, //Luminous Piece of Cloth
				6126, //Peg Leg
				9678, //Piece of Royal Satin
				13879, //War Wolf Skin
				12435, //Orc Leather
				11196, //Piece of Archer Armor
				12438, //Piece of Warrior Armor
				20135, //Red Hair Dye
				11208, //Rotten Piece of Cloth
				12629, //Scale of Corruption
				11209, //Silky Fur
				10611, //Snake Skin
				5879, //Spider Silk
				11210, //Striped Fur
				11235, //Warwolf Fur
				11234, //Werewolf Fur
				13534, //White Deer Skin
				11212, //Winter Wolf Fur
				11236, //Wool
				10582, //Wyrm Scale
				5883, //Ape Fur
				11224, //Thick Fur
			),
			"produtos" => array(),
			"receitas" => array(
				2656 => array( //Blue Robe
					array(2656, 2),
				),
			)
		),
		"alquimista" => array(
			"mesa_trabalho" => array(
				9909, //Alchemical Apparatus
				9910, //Alchemical Apparatus
			),
			"ferramentas" => array(
				5908, //Blessed Wooden Stake
			),
			"ingredientes" => array(
				5909, //White Piece of Cloth
			),
			"produtos" => array(),
			"receitas" => array(
				7439 => array( //Berserk Potion
					array(2656, 2),
					array(2656, 2),
				),
			)
		),
		"cozinheiro" => array(
			"mesa_trabalho" => array(
				10001, //Northern Fishburger
			),
			"ferramentas" => array(
				10001, //Northern Fishburger
			),
			"ingredientes" => array(
				10001, //Northern Fishburger
			),
			"produtos" => array(),
			"receitas" => array(
				10001 => array( //Northern Fishburger
					array(2656, 2),
				),
			)
		)
	);
	/*
	Cozinheiro - Comidas diversas
	Ferreiro - Armamentos
	Alfaiate - Armaduras, Calças
	Alquimista - Poções, Encantamento
	*/
	$carregarItens = array();
	$categoriasPrincipais = array("mesa_trabalho" => "Mesa de Trabalho", "ferramentas" => "Ferramentas", "ingredientes" => "Ingredientes", "produtos" => "Produtos");
	foreach($itens as $profissao_id => $profissao)
			foreach($profissao["receitas"] as $produto_id => $receita)
				$itens[$profissao_id]["produtos"][] = $produto_id;
	foreach($itens as $profissao)
		foreach($categoriasPrincipais as $c => $v)
			foreach($profissao[$c] as $item)
				if(!in_array($item, $carregarItens))
					$carregarItens[] = $item;
	include("includes/classes/ClassItems.php");
	$ClassItems = new Items();
	$itensCarregados = $ClassItems->getItemInfo($carregarItens);
	// echo'<pre>';
	// print_r($itensCarregados);
	// echo'</pre>';
	function exibirItens($itens, $itensCarregados){
		$exibicao = "";
		foreach($itens as $item_id)
			$exibicao .= '
				<tr class="item">
					<td width="50" align="center">
						'.$itensCarregados[$item_id]["imagem"].'
					</td>
					<td>
						'.$itensCarregados[$item_id]["nome"].' (ID: '.$item_id.')
					</td>
				</tr>
			';
		return $exibicao;
	}
	function exibirReceitas($receitas, $itensCarregados){
		$exibicao = "";
		foreach($receitas as $itemProduzido => $receita){
			$exibicao .= '
				<tr class="item">
					<td colspan="2" align="center">
						'.$itensCarregados[$itemProduzido]["imagem"].' = 
						';
						$receitaItens = array();
						foreach($receita as $receitaItem)
							$receitaItens[] = '('.$receitaItem[1].') '.$itensCarregados[$receitaItem[0]]["imagem"];
						$exibicao .= '
						'.implode(" + ", $receitaItens).'
					</td>
				</tr>
			';
		}
		return $exibicao;
	}
	$exibirProfissoes = "";
	foreach($profissoes as $profissaoNome => $profissao){
		$profissaoItens = $itens[strtolower($profissaoNome)];
		$exibirProfissoes .= '
			<div class="box_frame" carregar_box="1">
				'.$profissaoNome.'
			</div>
			<div class="box_frame_conteudo_principal" carregar_box="1">
				<div class="box_frame_conteudo">
					';
					foreach($profissaoItens as $categoria => $itensCategoria){
						if($categoria != "produtos"){
							if($categoria == "receitas"){
								$exibirItens = exibirReceitas($itensCategoria, $itensCarregados);
								$cabecalho = "Receitas";
							}
							else{
								$exibirItens = exibirItens($itensCategoria, $itensCarregados);
								$cabecalho = $categoriasPrincipais[$categoria];
							}
							$exibirProfissoes .= '
								<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
									<tr class="cabecalho">
										<td colspan="2">
											'.$cabecalho.'
										</td>
									</tr>
									'.$exibirItens.'
								</table>
							';
						}
					}
					$exibirProfissoes .= '
				</div>
			</div>
			<br>
		';
	}
	$conteudo_pagina = '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="">
			<div class="conteudo_box pagina">
				<div class="box_frame" carregar_box="1">
					Tarefas Gerais
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="1">
					<div class="box_frame_conteudo">
						<ul class="tarefas">
							<li class="sucesso">Criar Tabela dos Níveis 1 a 100</li>
							<li>Criar Lista de Itens que podem ser feitos</li>
							<li>Criar Lista de Ingredientes</li>
							<li>Definir a EXP que os Itens feitos dão</li>
							<li class="sucesso">A mesma poção, quando feita pelo alquimista, possui valores aleatórios de recuperação</li>
							<li>
								Influências do Nível
								<ul>
									<li>Quantidade de material produzida</li>
									<li class="sucesso">Chance de sucesso</li>
									<li class="sucesso">Tipos de Itens que podem ser feitos</li>
								</ul>
							</li>
							<li>Coletar itens dá EXP para a profissão</li>
							<li class="sucesso">Fazer itens dá EXP para a profissão (mesmo que falhe)</li>
							<li>Definir níveis de coleta (Ex.: Lenhador: não precisa ser profissão, basta apenas atribuir níveis para que ele colete maiores quantidades no futuro)</li>
						</ul>
					</div>
				</div>
				<div class="box_frame" carregar_box="1">
					Estruturação do Script de Crafting
				</div>
				<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
					<tr class="cabecalho">
						<td colspan="3">
							Profissões
						</td>
					</tr>
					<tr class="item bold">
						<td>
							Descrição
						</td>
						<td>
							Característica
						</td>
						<td>
							Grupo
						</td>
					</tr>
				</table>
				<br>
				'.$exibirProfissoes.'
			</div>
		</div>
	';
?>