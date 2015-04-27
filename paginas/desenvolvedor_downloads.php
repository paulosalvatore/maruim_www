<?php
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				';
				$diretorio_arquivos = "arquivos/desenvolvedor/";
				$diretorio_imagens = "imagens/desenvolvedor/";
				$downloads_itens = array(
					"mapa" => array(
						"exibicao" => "Mapa",
						"itens" => array(
							"ferramentas" => array(
								"nome" => "Ferramentas do Mapa",
								"imagem" => "RME_atualizacao.png",
								"arquivo" => "1076.rar",
								"link_externo" => "",
								"exibir_ultima_atualizacao" => true,
								"descricao" => "Atualização do map editor e de ferramentas úteis desenvolvidas por mim e pelo Murilo.",
							),
							"map_editor" => array(
								"nome" => "Remere's Map Editor (RME)",
								"imagem" => "RME.png",
								"arquivo" => "Remere's Map Editor rev 189.rar",
								"link_externo" => "https://mega.co.nz/#!PtdlVKQZ!GJsxOza35IbmVrcF9V6XGcihQqxTNdkT2jkDs9Rs2GY",
								"exibir_ultima_atualizacao" => false,
								"descricao" => "Programa utilizado para edição do mapa.",
							)
						)
					),
					"clientes" => array(
						"exibicao" => "Tibia Clients e afins",
						"itens" => array(
							"1035" => array(
								"nome" => "Tibia Client 10.76",
								"imagem" => "download_tibia_client.png",
								"arquivo" => "tibia1076.exe",
								"link_externo" => "http://clients.tibiaking.com/client/windows/1076",
								"exibir_ultima_atualizacao" => false,
								"descricao" => "Instalação do Tibia Client 10.76, necessário para o Map Editor e para jogar.",
							),
							"ipchanger" => array(
								"nome" => "IP Changer",
								"imagem" => "ipchanger.png",
								"arquivo" => "ipchanger.exe",
								"link_externo" => "http://static.otland.net/ipchanger.exe",
								"exibir_ultima_atualizacao" => false,
								"descricao" => "Programa para trocar o IP do jogo, funciona para todas as versões do Tibia.",
							)
						)
					),
					"compatibilidade" => array(
						"exibicao" => "Compatibilidade (DLLs, arquivos necessários para instalação, etc)",
						"itens" => array(
							"vbcredist" => array(
								"nome" => "Visual Basic Studio Redist AIO x86 x64",
								"imagem" => "vcbredist.png",
								"arquivo" => "VBCRedist_AIO_x86_x64.exe",
								"link_externo" => "http://ricktendo.info/Repack/VBCRedist_AIO_x86_x64.exe",
								"exibir_ultima_atualizacao" => false,
								"descricao" => "Arquivo do Microsoft Visual Studio que instala as DLLs e componentes que estão faltando no seu PC, necessário para rodar o Map Editor e diversos programas executáveis.",
							)
						)
					)
				);
				$conteudo_pagina .= '
				<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
					';
					foreach($downloads_itens as $categoria){
						$exibicao = $categoria["exibicao"];
						$itens = $categoria["itens"];
						$conteudo_pagina .= '
							<tr class="cabecalho">
								<td colspan="2">
									'.$exibicao.'
								</td>
							</tr>
						';
						foreach($itens as $item){
							$nome = $item["nome"];
							$imagem = $item["imagem"];
							$arquivo = $item["arquivo"];
							$caminho_arquivo = $diretorio_arquivos.$arquivo;
							$link_externo = $item["link_externo"];
							$exibir_ultima_atualizacao = $item["exibir_ultima_atualizacao"];
							$descricao = $item["descricao"];
							if(!empty($imagem))
								$imagem = '<a href="'.$caminho_arquivo.'"><img src="'.$diretorio_imagens.$imagem.'"></a>';
							else
								$imagem = '<a href="'.$caminho_arquivo.'">Baixar</a>';
							if(!empty($link_externo))
								$link_externo = ' <span class="link_externo">(<a href="'.$link_externo.'">Link Externo</a>)</span>';
							$ultima_atualizacao = "";
							if($exibir_ultima_atualizacao)
								$ultima_atualizacao = "<b>Última Atualização:</b> ".gmdate("d/m/Y \à\s H\hi\ms\s", (filemtime($caminho_arquivo)+$fuso_horario))."<br>";
							$conteudo_pagina .= '
								<tr class="item">
									<td width="50" align="center">
										'.$imagem.'
									</td>
									<td>
										<a href="'.$caminho_arquivo.'">'.$nome.'</a>'.$link_externo.'<br>
										'.$ultima_atualizacao.'
										<div class="descricao_arquivo">
											<b>Descrição do Arquivo:</b> '.$descricao.'
										</div>
									</td>
								</tr>
							';
						}
					}
					$conteudo_pagina .= '
				</table>
			</div>
		</div>
	';
?>