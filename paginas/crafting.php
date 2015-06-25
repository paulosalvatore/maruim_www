<?php
	include("includes/classes/ClassItens.php");
	$ClassItens = new Itens();
	$conteudo_pagina = '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
			<div class="box_frame" carregar_box="1">
				Crafting
			</div>
			<div class="box_frame_conteudo_principal borda2_padding" carregar_box="1">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<div class="box_frame_conteudo" carregar_box="1">
								<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
									<tr class="conteudo_box">
										<td class="padding">
											<span class="grande negrito">Introdução</span><br>
											<br>
											O crafting é um sistema que permite ao jogador fabricar diversos itens e equipamentos através de receitas específicas que serão produzidas em uma mesa de trabalho.<br>
											<br>
											Você pode evoluir dentro de cada profissão, basta produzir as receitas.<br>
											Conforme sua evolução, isso habilitará uma quantidade maior de receitas e fará com que a produção delas se torne cada vez mais fácil.<br>
											<br>
											<hr>
											<br>
											<span class="grande negrito">Profissões</span><br>
											<br>
											Atualmente o sistema está divido entre quatro profissões, são elas:<br>
											<a href="?p=profissoes-ferreiro">Ferreiro</a>, <a href="?p=profissoes-alfaiate">Alfaiate</a>, <a href="?p=profissoes-alquimista">Alquimista</a> e <a href="?p=profissoes-cozinheiro">Cozinheiro</a>.<br>
											<br>
											Cada profissão possui uma <a href="#mesa_trabalho">mesa de trabalho</a> específica, que é onde o jogador terá acesso a todas as informações específicas.<br>
											<br>
											Além disso, possui diversas receitas que poderão ser fabricadas caso o jogador tenha todos os <a href="#requisito_necessarios">requisitos necessários</a>.<br>
											<br>
											Existem também os ingredientes de melhoria das profissões, que aumentam a chance de sucesso de qualquer receita.<br>
											<br>
											<hr>
											<br>
											<a name="mesa_trabalho"></a><span class="grande negrito">Mesas de Trabalho</span><br>
											<br>
											A mesa de trabalho é o lugar onde você poderá fabricar <a href="#receitas">receitas</a> e visualizar as <a href="#janelas">janelas</a> do sistema.<br>
											<br>
											Para ativá-la você deve clicar com o botão direito em cima.<br>
											Caso uma janela apareça, selecione a opção "<i>Use</i>", conforme mostra a imagem abaixo.<br>
											<img src="imagens/guias/crafting/usar_mesa_trabalho.png" alt="Usar Mesa de Trabalho" alt="Usar Mesa de Trabalho" class="margem" /><br>
											<br>
											<br>
											<table width="250" cellpadding="0" cellspacing="0" class="tabela">
												';
												$profissoes = array(2555 => "Ferreiro", 9909 => "Alfaiate", 9896 => "Alquimista", 1786 => "Cozinheiro");
												foreach($profissoes as $mesaTrabalho => $profissaoNome)
													$conteudo_pagina .= '
														<tr class="item">
															<td width="60" align="center" style="background: #F1E0C6;">
																'.$ClassItens->exibirImagem($mesaTrabalho, $profissaoNome).'
															</td>
															<td class="negrito" align="center" style="background: #F1E0C6;">
																<a href="?p=profissoes-'.strtolower($profissaoNome).'">'.$profissaoNome.'</a>
															</td>
														</tr>
													';
												$conteudo_pagina .= '
											</table>
											<br>
											<hr>
											<br>
											<a name="receitas"></a><span class="grande negrito">Receitas</span><br>
											<br>
											<a name="requisito_necessarios"></a>Para produzir uma receita você deverá observar os seguintes requisitos:<br>
											<ul>
												<li><b>Profissão;</b></li>
												<li><b>Nível de Profissão;</b></li>
												<li><b>Nível de Jogador;</b></li>
												<li><b>Ferramenta;</b>
													<ul>
														<li>Para adquirir as ferramentas das receitas procure os <a href="#npcs_profissoes">NPCs de cada profissão</a>.</li>
													</ul>
												</li>
												<li><b>Material;</b>
													<ul>
														<li>Alguns materiais podem ser obtidos através da <a href="#coleta">coleta</a> em diversos locais no <a href="?p=mapa">mapa</a>.</li>
													</ul>
												</li>
												<li><b>Conhecimento.</b>
													<ul>
														<li>Você pode precisar aprender determinada receita para produzí-la.</li>
													</ul>
												</li>
											</ul>
											<br>
											Note que cada receita também possuirá outras informações:<br>
											<ul>
												<li><b>Tempo de Fabricação;</b>
													<ul>
														<li>Pode ser instantâneo ou demorar alguns segundos.</li>
													</ul>
												</li>
												<li><b>Chance de Sucesso Máxima;</b>
													<ul>
														<li>Mesmo que use itens de melhoria, a chance de sucesso não passará desse valor.</li>
													</ul>
												</li>
												<li><b>Fabricar em Quantidade;</b>
													<ul>
														<li>A produção em quantidade de uma receita nem sempre estará disponível.</li>
													</ul>
												</li>
												<li><b>Experiência de Profissão;</b>
													<ul>
														<li>Ao tentar produzir uma receita, você receberá uma quantidade de experiência de profissão (mesmo que a receita falhe).</li>
													</ul>
												</li>
												<li><b>Pontos de Profissão;</b>
													<ul>
														<li>Ao produzir uma receita com sucesso, você receberá uma quantidade de pontos de profissão.</li>
													</ul>
												</li>
											</ul>
											Algumas receitas também possuem ingrediente secreto, que aumentam a chance de sucesso.<br>
											<br>
											<hr>
											<br>
											<a name="janelas"></a><span class="grande negrito">Janelas</span><br>
											<br>
											O sistema de crafting possui diversas janelas que exibem todo o conteúdo disponível para cada profissão.<br>
											Atualmente existem as seguintes janelas:<br>
											<br>
											<ul>
												';
												$janelas = array(
													"janela_principal" => array(
														"nome" => "Janela Principal",
														"indicadores" => array(
															"Nome da Profissão" => '',
															"Nível e Porcentagem de Experiência" => '',
															"Fabricação da Última Receita" => '
																Essa opção só aparecerá caso você tenha os ingredientes para a última receita que fabricada.<br>
																<span class="pequeno">*Mesmo que a receita possibilite a fabricação em quantidade, essa opção fabricará apenas uma vez.</span>
															',
															"Informações da Profissão" => '
																Ao selecionar essa opção, uma janela abrirá contendo as suas informações da profissão.<br>
																<span class="pequeno">*<a href="#janela_profissao">Clique aqui</a> para ver os detalhes dessa janela.</span>
															',
															"Lista de Receitas - Prontas para Fabricação" => '
																Ao selecionar essa opção, uma janela abrirá contendo uma lista com todas as receitas que você possui os requisitos para fabricação.
															',
															"Lista de Receitas - Conhecidas" => '
																Ao selecionar essa opção, uma janela abrirá contendo uma lista com todas as receitas que você conhece.<br>
																<span class="pequeno">*Você pode fabricar direto dessa janela caso tenha os materiais necessários.</span>
															',
															"Lista de Receitas - Geral" => '
																Ao selecionar essa opção, uma janela abrirá contendo uma lista com todas as receitas da profissão.<br>
																<span class="pequeno">*Você pode fabricar direto dessa janela caso tenha os requisitos necessários.</span>
															'
														)
													),
													"janela_profissao" => array(
														"nome" => "Janela da Profissão",
														"indicadores" => array(
															"Pontos de Profissão" => '
																Você receberá pontos de profissão a cada receita fabricada ou quando evoluir um nível de profissão.<br>
																Você poderá utilizar seus pontos para comprar diversos itens, basta falar com o NPC da profissão.
															',
															"Bônus Adicional" => '
																A cada 20 níveis de profissão, seus equipamentos produzidos que tiverem atributos de Armadura, Ataque ou Defesa receberão esse aumento fixo <span class="pequeno">(somado aos valores da receita, se houver)</span>.
															',
															"Chance de Sucesso Adicional" => '
																A cada nível de profissão você receberá 0.2% de chance de sucesso adicional em suas receitas.<br>
																<span class="pequeno">Esse valor não ultrapassa a chance de sucesso máxima de uma receita.</span>
															'
														)
													),
													"janela_lista" => array(
														"nome" => "Janela da Lista de Receitas",
														"indicadores" => array(
															"Receitas" => '
																As receitas da lista que você escolheu na janela principal serão exibidas aqui.
															',
															"Criar" => '
																Ao clicar nesse botão, caso tenha todos os requisitos da receita selecionada, o processo de fabricação iniciará.
															',
															"Info" => '
																Ao clicar nesse botão, uma janela com as informações da receita selecionada será exibido.
															'
														)
													),
													"janela_informacoes_receita" => array(
														"nome" => "Janela com as Informações da Receita"
													)
												);
												foreach($janelas as $janela => $janelaInfo){
													$conteudo_pagina .= '
														<li>
															<a name="'.$janela.'"></a><b>'.$janelaInfo["nome"].'</b><br>
															<img src="imagens/guias/crafting/'.$janela.'.png" alt="'.$janelaInfo["nome"].'" title="'.$janelaInfo["nome"].'" class="margem" /><br>
															<br>
															<table cellpadding="0" cellspacing="0">
																';
																$c = 1;
																if(is_array($janelaInfo["indicadores"])){
																	foreach($janelaInfo["indicadores"] as $indicador => $descricao){
																		$conteudo_pagina .= '
																			<tr>
																				<td width="17" style="padding: 0px;">
																					<img src="imagens/guias/circulo'.($c++).'.png">
																				</td>
																				<td>
																					<b>'.$indicador.'</b>
																				</td>
																			</tr>
																		';
																		if(!empty($descricao))
																			$conteudo_pagina .= '
																				<tr>
																					<td colspan="2">
																						'.$descricao.'
																					</td>
																				</tr>
																			';
																	}
																}
																$conteudo_pagina .= '
															</table>
															<br>
														</li>
													';
												}
												$conteudo_pagina .= '
											</ul>
											<hr>
											<br>
											<a name="coleta"></a><span class="grande negrito">Coleta</span><br>
											<br>
											Alguns materiais necessários para a produção de diversas receitas podem ser obtidos coletando-os em diversas áreas do mapa.<br>
											<br>
											<hr>
											<br>
											<a name="npcs_profissoes"></a><span class="grande negrito">NPCs das Profissões</span><br>
											<br>
											Existem NPCs que trabalham especificamente com cada profissão.<br>
											Neles você poderá vender e/ou comprar diversos itens especificos de cada profissão.<br>
											<br>
											<table width="250" cellpadding="0" cellspacing="0" class="tabela odd">
												';
												$npcs_profissoes = array(
													"Ferreiro" => array("Rimi", "Mylo"),
													"Alfaiate" => array("Arcus Arataron"),
													"Alquimista" => array("Fron")
												);
												foreach($npcs_profissoes as $profissaoNome => $npcs){
													$exibirNPCs = "";
													foreach($npcs as $npc)
														$exibirNPCs .= '<a href="?p=npcs-'.$npc.'">'.$npc.'</a><br>';
													$conteudo_pagina .= '
														<tr class="item">
															<td width="60" align="center" class="negrito top">
																'.$profissaoNome.'
															</td>
															<td class="negrito">
																'.$exibirNPCs.'
															</td>
														</tr>
													';
												}
												$conteudo_pagina .= '
											</table>
											<br>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	';
?>