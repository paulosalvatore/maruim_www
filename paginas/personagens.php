<?php
	$conteudo_busca_personagens .= '
		<div id="resultadoBusca" style="margin-bottom: 30px; display: none;">
			<table cellpadding="0" cellspacing="0" class="tabela dark" width="100%">
				<tr class="cabecalho">
					<td>
						Personagem Não Encontrado
					</td>
				</tr>
				<tr class="item" height="40">
					<td>
						O personagem <b id="exibirNomePersonagem"></b> não existe.
					</td>
				</tr>
			</table>
		</div>
		<table cellpadding="0" cellspacing="0" class="tabela dark" width="100%">
			<tr class="cabecalho">
				<td>
					Buscar Personagem
				</td>
			</tr>
			<tr class="item" height="40">
				<td>
					Nome: <input type="text" id="nomePersonagem" value="'.$id.'"> <input type="button" id="buscarPersonagem" class="botao" value="Procurar" />
				</td>
			</tr>
		</table>
	';
	if(!empty($id)){
		include("includes/classes/ClassPersonagem.php");
		$ClassPersonagem = new Personagem();
		$informacoesPersonagem = $ClassPersonagem->getInformacoesPersonagem($id);
		$exibirInformacoesPersonagem = array(
			"nome" => array(
				"exibicao" => "Nome",
				"valor" => $informacoesPersonagem["nome"]
			),
			"genero" => array(
				"exibicao" => "Gênero",
				"valor" => $informacoesPersonagem["exibirGenero"]
			),
			"vocacao" => array(
				"exibicao" => "Vocação",
				"valor" => $informacoesPersonagem["vocacao"]
			),
			"nivel" => array(
				"exibicao" => "Nível",
				"valor" => $informacoesPersonagem["nivel"]
			),
			"residencia" => array(
				"exibicao" => "Residência",
				"valor" => $informacoesPersonagem["residencia"]
			),
			"ultimo_login" => array(
				"exibicao" => "Último Login",
				"valor" => $informacoesPersonagem["ultimo_login"]
			),
			"comentario" => array(
				"exibicao" => "Comentário",
				"valor" => $informacoesPersonagem["comentario"],
				"ocultar_vazio" => true
			)
		);
		$conteudo_personagens = '
			<div style="margin-bottom: 30px;">
				<table cellpadding="0" cellspacing="0" class="tabela odd" width="100%">
					<tr class="cabecalho">
						<td colspan="2">
							Informações do Personagem
						</td>
					</tr>
					';
					foreach($exibirInformacoesPersonagem as $c => $v){
						if((!$v["ocultar_vazio"]) OR (($v["ocultar_vazio"]) AND (!empty($v["valor"]))))
							$conteudo_personagens .= '
								<tr class="item">
									<td width="120">
										<b>'.$v["exibicao"].':</b>
									</td>
									<td style="word-break: break-all;">
										'.$v["valor"].'
									</td>
								</tr>
							';
					}
					$conteudo_personagens .= '
				</table>
			</div>
		';
		if($informacoesPersonagem["ocultar_conta"] == 0){
			$conteudo_personagens .= '
				<div style="margin-bottom: 30px;">
					<table cellpadding="0" cellspacing="0" class="tabela odd" width="100%">
						<tr class="cabecalho">
							<td colspan="2">
								Informações da Conta
							</td>
						</tr>
						<tr class="item">
							<td width="120">
								<b>Status da Conta:</b>
							</td>
							<td>
								'.$ClassConta->getStatusConta($informacoesConta["premdays"]).'
							</td>
						</tr>
						<tr class="item">
							<td width="120">
								<b>Data de Criação:</b>
							</td>
							<td>
								'.$informacoesConta["exibirDataCriacao"].'
							</td>
						</tr>
					</table>
				</div>
				<div style="margin-bottom: 30px;">
					<table cellpadding="0" cellspacing="0" class="tabela odd" width="100%">
						<tr class="cabecalho">
							<td colspan="4">
								Personagens
							</td>
						</tr>
						';
						$listaPersonagens = $ClassPersonagem->getListaPersonagens($accountId);
						$exibirListaPersonagens = $ClassPersonagem->exibirListaPersonagens($listaPersonagens, 0, $informacoesPersonagem["id"]);
						$conteudo_personagens .= $exibirListaPersonagens;
						$conteudo_personagens .= '
					</table>
				</div>
			';
		}
	}
	if(!empty($conteudo_personagens))
		$conteudo_personagens = '<div id="exibirPersonagem">'.$conteudo_personagens.'</div>';
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				'.$conteudo_personagens.'
				'.$conteudo_busca_personagens.'
			</div>
		</div>
	';
	// $itens_personagem = '
		
	// ';
	// $conteudo_pagina .= '
		// <div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			// <div class="conteudo_box pagina">
				// <b>Tarefas para essa página:</b><br>
				// <ul class="tarefas">
					// <li>**Idade no Jogo (1h RL = 24h Tibia)</li>
					// <li>Nome</li>
					// <li>Imagem do Outfit (Animar, se possível) - Arquivo .zip em Downloads (outfit-images)</li>
					// <li>Sexo</li>
					// <li>Profissão¹ (ou Classe/Vocação)</li>
					// <li>Level (Nível)</li>
					// <li>Pontos de Conquista (Verificar)</li>
					// <li>Residência (Residente de/Nome específico, tipo Civitaten - Civiten)</li>
					// <li>Extrato do Banco (Balance)</li>
					// <li>Último Login</li>
					// <li>Equipamentos</li>
					// <li>Vida</li>
					// <li>Mana</li>
					// <li>Nível (repetindo, talvez tirar)</li>
					// <li>EXP (Experiência)</li>
					// <li>Experência Necessária para o próximo nível</li>
					// <li>Skills (Verificar se irá usar as imagens do OTSite ou arrumar outras)</li>
					// <li>Conquistas (Verificar)</li>
					// <li>Quests (Verificar)</li>
					// <li>Gerador de Assinatura</li>
					// <li>Informações da Conta</li>
					// <li>Último Login (da conta)</li>
					// <li>Data de Criação</li>
					// <li>Status da Conta (Premium ou Não)</li>
					// <li>Lista de Personagens da conta</li>
					// <li>Número, Nome, Nível, Profissão¹, Status (ON/OFF) e botão para visualizar</li>
					// <li>Campo para busca de outro personagem</li>
				// </ul>
				// '.$itens_personagem.'
			// </div>
		// </div>
	// ';
?>