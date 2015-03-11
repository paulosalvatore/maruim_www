<?php
	$ranks = array(
		"level" => "Nível",
		"skill_fist" => "Fist",
		"skill_club" => "Club",
		"skill_sword" => "Sword",
		"skill_axe" => "Axe",
		"skill_dist" => "Distance",
		"skill_shielding" => "Shielding",
		"skill_fishing" => "Fishing",
	);
	$rank = $id;
	if(!array_key_exists($rank, $ranks)){
		reset($ranks);
		$rank = key($ranks);
	}
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
			<div class="conteudo_box pagina padding">
				<table class="tabela" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td class="top">
							<h2 align="center">Ranking de '.$ranks[$rank].'</h2>
							<br>
							<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
								<tr class="cabecalho" align="center">
									<td width="10%">
										Rank
									</td>
									<td width="50%">
										Nome
									</td>
									<td width="10%">
										Nível
									</td>
									';
									if($rank == "level")
										$conteudo_pagina .= '
											<td width="30%">
												Experiência
											</td>
										';
									$conteudo_pagina .= '
								</tr>
								';
								include("includes/classes/ClassPersonagem.php");
								$ClassPersonagem = new Personagem();
								$rankPersonagens = $ClassPersonagem->getListaPersonagens("", $rank);
								foreach($rankPersonagens as $c => $v){
									$conteudo_pagina .= '
										<tr class="item">
											<td align="center">
												'.$v["rank"].'
											</td>
											<td>
												<a href="'.$v["link"].'">'.$v["nome"].'</a>
											</td>
											<td align="center">
												'.$v[$rank].'
											</td>
											';
											if($rank == "level")
												$conteudo_pagina .= '
													<td width="30%">
														'.$v["experience"].'
													</td>
												';
											$conteudo_pagina .= '
										</tr>
									';
								}
								$conteudo_pagina .= '
							</table>
						</td>
						<td align="right" class="top" width="120">
							<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
								<tr class="cabecalho">
									<td>
										Escolha o Rank
									</td>
								</tr>
								';
								foreach($ranks as $tabela => $exibicao)
									$conteudo_pagina .= '
										<tr class="item">
											<td>
												<a href="?p=rank-'.$tabela.'">'.$exibicao.'</a>
											</td>
										</tr>
									';
								$conteudo_pagina .= '
							</table>
						</td>
					</tr>
				</table>
			</div>
		</div>
	';
?>