<?php
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				';
				$diretorio_arquivos = "arquivos/desenvolvedor/";
				$diretorio_imagens = "imagens/desenvolvedor/";
				$downloads_itens = array(
					"clientes" => array(
						"exibicao" => "Tibia Clients e afins",
						"itens" => array(
							"1041" => array(
								"nome" => "Tibia Client 10.41",
								"imagem" => "download_tibia_client.png",
								"arquivo" => "tibia1041.exe",
								"link_externo" => "http://clients.tibiaking.com/client/windows/1041",
								"exibir_ultima_atualizacao" => false,
								"descricao" => "Instalação do Tibia Client 10.41, versão utilizada para jogar.",
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