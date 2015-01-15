<?php
	include("includes/classes/ClassCriaturas.php");
	include("includes/classes/ClassItens.php");
	$ClassCriaturas = new Criaturas();
	$ClassItens = new Itens();
	if(empty($id)){
		$listaCriaturas = $ClassCriaturas->getListaCriaturas();
		$conteudo_pagina .= '
			<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
				<div class="conteudo_box pagina">
					<table class="tabela dark" cellpadding="0" cellspacing="0" width="100%">
						<tr class="cabecalho">
							<td>
								Buscar Criaturas
							</td>
						</tr>
						<tr class="item">
							<td>
								Criatura: <input type="text" id="buscar_criaturas"> <input type="button" class="botao" value="Procurar">
							</td>
						</tr>
					</table>
					<div style="padding: 5px;" align="right">
						<table cellpadding="0" cellspacing="0" id="refinar_busca">
							<tr>
								<td class="lista">
									<img src="imagens/corpo/tabela_lista.png" id="lista" title="Lista" class="exibicao">
								</td>
								<td class="galeria">
									<img src="imagens/corpo/tabela_galeria.png" id="galeria" title="Galeria" class="exibicao">
								</td>
							</tr>
						</table>
					</div>
					<div class="tabela odd lista"  id="criaturas" align="center" cellpadding="0" cellspacing="0" ordenar_ativo="0" ordenar="" ordenar_por="">
						<div class="cabecalho">
							<div class="coluna">
								Imagem
							</div>
							<div class="coluna nome" ordenar="nome">
								Nome
							</div>
							<div class="coluna experiencia" ordenar="experiencia">
								Exp.
							</div>
							<div class="coluna vida" ordenar="vida">
								Vida
							</div>
							<div class="coluna sumonar">
								Summonar
							</div>
							<div class="coluna convencer">
								Convencer
							</div>
						</div>
						';
						if($listaCriaturas){
							foreach($listaCriaturas as $key => $row){
								$nome[$key] = $row["nome"];
								$experiencia[$key] = $row["experiencia"];
								$vida[$key] = $row["vida"];
							}
							array_multisort($nome, SORT_ASC, $listaCriaturas);
							foreach($listaCriaturas as $criatura){
								$atributos = array("id", "nome", "imagem", "link", "experiencia", "vida", "sumonar", "convencer");
								$exibirAtributos = "";
								foreach($atributos as $atributo)
									$exibirAtributos .= ' '.$atributo.'="'.$criatura[$atributo].'"';
								$conteudo_pagina .= '
									<div class="item criatura exibir"'.$exibirAtributos.'>
									</div>
								';
							}
						}
						$conteudo_pagina .= '
					</div>
					<div id="vazio">
						<br>
						<br>
						Não foi encontrada nenhuma criatura na base de dados.<br>
						<br>
						<br>
					</div>
				</div>
			</div>
		';
	}
	else{
		$criatura = $ClassCriaturas->getInfoCriatura($id);
		$danoMaximoCriatura = $ClassCriaturas->calcularDanoMaximoCriatura($criatura["ataques"]);
		$navegacaoCriatura = $ClassCriaturas->getNavegacaoCriatura($criatura["id"]);
		$conteudo_pagina .= '
			<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
				<div class="conteudo_box pagina">
					<div class="setas">
						<div class="seta voltar">
							<a href="?p=criaturas"><img src="imagens/corpo/arrow_up.gif" /> voltar</a>
						</div>
						';
						if(isset($navegacaoCriatura[0]))
							$conteudo_pagina .= '
								<div class="seta anterior">
									<a href="?p=criaturas&id='.$navegacaoCriatura[0].'"><img src="imagens/corpo/arrow_left.gif" /> anterior</a>
								</div>
							';
						if(isset($navegacaoCriatura[1]))
							$conteudo_pagina .= '
								<div class="seta proxima">
									<a href="?p=criaturas&id='.$navegacaoCriatura[1].'"><img src="imagens/corpo/arrow_right.gif" /> próxima</a>
								</div>
							';
						$conteudo_pagina .= '
					</div>
					<div class="box_frame" carregar_box="1">
						'.$criatura["nome"].'
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
								<img src="'.$criatura["imagem"].'">
							</td>
							<td>
								<b>'.$criatura["nome"].'</b><br>
								<b>'.$criatura["vida"].'</b> hit points<br>
								<b>'.$criatura["experiencia"].'</b> pontos de experiência por morte<br>
								';
								if($criatura["experiencia"] > 0)
									$conteudo_pagina .= '
										<span style="font-size: 11px;">(<span style="color: green;">'.($criatura["experiencia"]*1.5).'</span> com bônus | <span style="color: red;">'.($criatura["experiencia"]*0.5).'</span> com stamina abaixo de 14h)</span>
									';
								$conteudo_pagina .= '
							</td>
						</tr>
						<tr class="item">
							<td>
								<b>Sumonar/Convencer:</b>
							</td>
							<td>
								'.$criatura["sumonar"].'/'.$criatura["convencer"].'
							</td>
						</tr>
						<tr class="item">
							<td>
								<b>Pode ser puxado:</b>
							</td>
							<td>
								'.$criatura["puxado"].'
							</td>
						</tr>
						<tr class="item">
							<td>
								<b>Empurra objetos:</b>
							</td>
							<td>
								'.$criatura["empurra"].'
							</td>
						</tr>
						';
						if(!empty($criatura["vozes"]))
							$conteudo_pagina .= '
								<tr class="item">
									<td>
										<b>Sons:</b>
									</td>
									<td style="color: #D14703; font-weight: bold;">
										'.$criatura["vozes"].'
									</td>
								</tr>
							';
						if((!empty($criatura["imunidades"])) OR (!empty($criatura["forte"])) OR (!empty($criatura["fraco"]))){
							if(!empty($criatura["imunidades"]))
								$conteudo_pagina .= '
									<tr class="item">
										<td>
											<b>Imune contra:</b>
										</td>
										<td>
											'.$criatura["imunidades"].'
										</td>
									</tr>
								';
							if(!empty($criatura["forte"]))
								$conteudo_pagina .= '
									<tr class="item">
										<td>
											<b>Forte contra:</b>
										</td>
										<td>
											'.$criatura["forte"].'
										</td>
									</tr>
								';
							if(!empty($criatura["fraco"]))
								$conteudo_pagina .= '
									<tr class="item">
										<td>
											<b>Fraco contra:</b>
										</td>
										<td>
											'.$criatura["fraco"].'
										</td>
									</tr>
								';
							}
						else
							$conteudo_pagina .= '
								<tr class="item">
									<td>
										<b>Neutro contra:</b>
									</td>
									<td>
										'.$ClassCriaturas->getIconesElementos().'
									</td>
								</tr>
							';
						$conteudo_pagina .= '
						<tr class="item">
							<td>
								<b>Dano máximo por turno:</b>
							</td>
							<td>
								'.$danoMaximoCriatura.'
							</td>
						</tr>
						';
						if(count($criatura["summons"]) > 0){
							$conteudo_pagina .= '
								<tr class="item">
									<td>
										<b>Dano máximo por turno:<br>(com Summons)</b>
									</td>
									<td>
										'.($danoMaximoCriatura+$ClassCriaturas->calcularDanoMaximoCriaturaSummons($criatura)).'
									</td>
								</tr>
							';
						}
						$conteudo_pagina .= '
					</table>
					';
					if($criatura["maxSummons"] > 0){
						$conteudo_pagina .= '
							<br>
							<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
								<tr class="cabecalho">
									<td colspan="2">
										Summons
									</td>
								</tr>
								<tr class="item">
									<td width="180">
										<b>Quantidade máxima:</b>
									</td>
									<td>
										'.$criatura["maxSummons"].'
									</td>
								</tr>
								';
								if(count($criatura["summons"]) > 0)
									foreach($criatura["summons"] as $summon)
										$conteudo_pagina .= '
											<tr class="item">
												<td colspan="2">
													<table>
														<tr>
															<td width="64" align="center">
																<img src="'.$summon["imagem"].'" title="'.$summon["nome"].'"/>
															</td>
															<td>
																<a href="?p=criaturas&id='.urlencode($summon["nome"]).'">'.$summon["nome"].'</a>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										';
								$conteudo_pagina .= '
							</table>
						';
					}
					$conteudo_pagina .= '
					<br>
					<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
						<tr class="cabecalho">
							<td>
								Habilidades
							</td>
						</tr>
						';
						if((count($criatura["ataques"]) > 0) OR (count($criatura["defesas"]) > 0)){
							if(count($criatura["ataques"]) > 0)
								foreach($criatura["ataques"] as $ataque)
									$conteudo_pagina .= '
										<tr class="item">
											<td>
												'.$ClassCriaturas->exibirHabilidade($ataque, "ataque").'
											</td>
										</tr>
									';
							if(count($criatura["defesas"]) > 0)
								foreach($criatura["defesas"] as $defesa)
									$conteudo_pagina .= '
										<tr class="item">
											<td>
												'.$ClassCriaturas->exibirHabilidade($defesa, "defesa").'
											</td>
										</tr>
									';
						}
						else
							$conteudo_pagina .= '
								<tr class="item">
									<td>
										Essa criatura não possui nenhuma habilidade.
									</td>
								</tr>
							';
						$conteudo_pagina .= '
					</table>
					<br>
					<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
						<tr class="cabecalho">
							<td colspan="2">
								Loot
							</td>
						</tr>
						';
						if(count($criatura["loot"]) > 0)
							$conteudo_pagina .= $ClassItens->exibirLoot($criatura["loot"]);
						else
							$conteudo_pagina .= '
								<tr class="item">
									<td colspan="2">
										Essa criatura não possui <i>loot</i>.
									</td>
								</tr>
							';
						$conteudo_pagina .= '
					</table>
				</div>
			</div>
		';
	}
?>