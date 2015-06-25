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
											<span class="grande negrito">Introdu��o</span><br>
											<br>
											O crafting � um sistema que permite ao jogador fabricar diversos itens e equipamentos atrav�s de receitas espec�ficas que ser�o produzidas em uma mesa de trabalho.<br>
											<br>
											Voc� pode evoluir dentro de cada profiss�o, basta produzir as receitas.<br>
											Conforme sua evolu��o, isso habilitar� uma quantidade maior de receitas e far� com que a produ��o delas se torne cada vez mais f�cil.<br>
											<br>
											<hr>
											<br>
											<span class="grande negrito">Profiss�es</span><br>
											<br>
											Atualmente o sistema est� divido entre quatro profiss�es, s�o elas:<br>
											<a href="?p=profissoes-ferreiro">Ferreiro</a>, <a href="?p=profissoes-alfaiate">Alfaiate</a>, <a href="?p=profissoes-alquimista">Alquimista</a> e <a href="?p=profissoes-cozinheiro">Cozinheiro</a>.<br>
											<br>
											Cada profiss�o possui uma <a href="#mesa_trabalho">mesa de trabalho</a> espec�fica, que � onde o jogador ter� acesso a todas as informa��es espec�ficas.<br>
											<br>
											Al�m disso, possui diversas receitas que poder�o ser fabricadas caso o jogador tenha todos os <a href="#requisito_necessarios">requisitos necess�rios</a>.<br>
											<br>
											Existem tamb�m os ingredientes de melhoria das profiss�es, que aumentam a chance de sucesso de qualquer receita.<br>
											<br>
											<hr>
											<br>
											<a name="mesa_trabalho"></a><span class="grande negrito">Mesas de Trabalho</span><br>
											<br>
											A mesa de trabalho � o lugar onde voc� poder� fabricar <a href="#receitas">receitas</a> e visualizar as <a href="#janelas">janelas</a> do sistema.<br>
											<br>
											Para ativ�-la voc� deve clicar com o bot�o direito em cima.<br>
											Caso uma janela apare�a, selecione a op��o "<i>Use</i>", conforme mostra a imagem abaixo.<br>
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
											<a name="requisito_necessarios"></a>Para produzir uma receita voc� dever� observar os seguintes requisitos:<br>
											<ul>
												<li><b>Profiss�o;</b></li>
												<li><b>N�vel de Profiss�o;</b></li>
												<li><b>N�vel de Jogador;</b></li>
												<li><b>Ferramenta;</b>
													<ul>
														<li>Para adquirir as ferramentas das receitas procure os <a href="#npcs_profissoes">NPCs de cada profiss�o</a>.</li>
													</ul>
												</li>
												<li><b>Material;</b>
													<ul>
														<li>Alguns materiais podem ser obtidos atrav�s da <a href="#coleta">coleta</a> em diversos locais no <a href="?p=mapa">mapa</a>.</li>
													</ul>
												</li>
												<li><b>Conhecimento.</b>
													<ul>
														<li>Voc� pode precisar aprender determinada receita para produz�-la.</li>
													</ul>
												</li>
											</ul>
											<br>
											Note que cada receita tamb�m possuir� outras informa��es:<br>
											<ul>
												<li><b>Tempo de Fabrica��o;</b>
													<ul>
														<li>Pode ser instant�neo ou demorar alguns segundos.</li>
													</ul>
												</li>
												<li><b>Chance de Sucesso M�xima;</b>
													<ul>
														<li>Mesmo que use itens de melhoria, a chance de sucesso n�o passar� desse valor.</li>
													</ul>
												</li>
												<li><b>Fabricar em Quantidade;</b>
													<ul>
														<li>A produ��o em quantidade de uma receita nem sempre estar� dispon�vel.</li>
													</ul>
												</li>
												<li><b>Experi�ncia de Profiss�o;</b>
													<ul>
														<li>Ao tentar produzir uma receita, voc� receber� uma quantidade de experi�ncia de profiss�o (mesmo que a receita falhe).</li>
													</ul>
												</li>
												<li><b>Pontos de Profiss�o;</b>
													<ul>
														<li>Ao produzir uma receita com sucesso, voc� receber� uma quantidade de pontos de profiss�o.</li>
													</ul>
												</li>
											</ul>
											Algumas receitas tamb�m possuem ingrediente secreto, que aumentam a chance de sucesso.<br>
											<br>
											<hr>
											<br>
											<a name="janelas"></a><span class="grande negrito">Janelas</span><br>
											<br>
											O sistema de crafting possui diversas janelas que exibem todo o conte�do dispon�vel para cada profiss�o.<br>
											Atualmente existem as seguintes janelas:<br>
											<br>
											<ul>
												';
												$janelas = array(
													"janela_principal" => array(
														"nome" => "Janela Principal",
														"indicadores" => array(
															"Nome da Profiss�o" => '',
															"N�vel e Porcentagem de Experi�ncia" => '',
															"Fabrica��o da �ltima Receita" => '
																Essa op��o s� aparecer� caso voc� tenha os ingredientes para a �ltima receita que fabricada.<br>
																<span class="pequeno">*Mesmo que a receita possibilite a fabrica��o em quantidade, essa op��o fabricar� apenas uma vez.</span>
															',
															"Informa��es da Profiss�o" => '
																Ao selecionar essa op��o, uma janela abrir� contendo as suas informa��es da profiss�o.<br>
																<span class="pequeno">*<a href="#janela_profissao">Clique aqui</a> para ver os detalhes dessa janela.</span>
															',
															"Lista de Receitas - Prontas para Fabrica��o" => '
																Ao selecionar essa op��o, uma janela abrir� contendo uma lista com todas as receitas que voc� possui os requisitos para fabrica��o.
															',
															"Lista de Receitas - Conhecidas" => '
																Ao selecionar essa op��o, uma janela abrir� contendo uma lista com todas as receitas que voc� conhece.<br>
																<span class="pequeno">*Voc� pode fabricar direto dessa janela caso tenha os materiais necess�rios.</span>
															',
															"Lista de Receitas - Geral" => '
																Ao selecionar essa op��o, uma janela abrir� contendo uma lista com todas as receitas da profiss�o.<br>
																<span class="pequeno">*Voc� pode fabricar direto dessa janela caso tenha os requisitos necess�rios.</span>
															'
														)
													),
													"janela_profissao" => array(
														"nome" => "Janela da Profiss�o",
														"indicadores" => array(
															"Pontos de Profiss�o" => '
																Voc� receber� pontos de profiss�o a cada receita fabricada ou quando evoluir um n�vel de profiss�o.<br>
																Voc� poder� utilizar seus pontos para comprar diversos itens, basta falar com o NPC da profiss�o.
															',
															"B�nus Adicional" => '
																A cada 20 n�veis de profiss�o, seus equipamentos produzidos que tiverem atributos de Armadura, Ataque ou Defesa receber�o esse aumento fixo <span class="pequeno">(somado aos valores da receita, se houver)</span>.
															',
															"Chance de Sucesso Adicional" => '
																A cada n�vel de profiss�o voc� receber� 0.2% de chance de sucesso adicional em suas receitas.<br>
																<span class="pequeno">Esse valor n�o ultrapassa a chance de sucesso m�xima de uma receita.</span>
															'
														)
													),
													"janela_lista" => array(
														"nome" => "Janela da Lista de Receitas",
														"indicadores" => array(
															"Receitas" => '
																As receitas da lista que voc� escolheu na janela principal ser�o exibidas aqui.
															',
															"Criar" => '
																Ao clicar nesse bot�o, caso tenha todos os requisitos da receita selecionada, o processo de fabrica��o iniciar�.
															',
															"Info" => '
																Ao clicar nesse bot�o, uma janela com as informa��es da receita selecionada ser� exibido.
															'
														)
													),
													"janela_informacoes_receita" => array(
														"nome" => "Janela com as Informa��es da Receita"
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
											Alguns materiais necess�rios para a produ��o de diversas receitas podem ser obtidos coletando-os em diversas �reas do mapa.<br>
											<br>
											<hr>
											<br>
											<a name="npcs_profissoes"></a><span class="grande negrito">NPCs das Profiss�es</span><br>
											<br>
											Existem NPCs que trabalham especificamente com cada profiss�o.<br>
											Neles voc� poder� vender e/ou comprar diversos itens especificos de cada profiss�o.<br>
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