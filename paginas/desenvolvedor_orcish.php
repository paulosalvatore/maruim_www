<?php
	if($id == "adicionar_palavra"){
		mysql_query("UPDATE z_orcish SET portugues = '".utf8_decode($_REQUEST["palavra"])."' WHERE id = '".$_REQUEST["palavraId"]."'");
		exit;
	}
	$conteudo_pagina .= '
		<style>
			input[type=text]{
				height: 15px;
			}
			.item:hover .editar {
				display: block;
			}
			.editar {
				right: 15px;
				position: absolute;
				display: none;
				margin-top: -16px;
			}
			.ocultar {
				display: none;
			}
		</style>
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
					<tr class="cabecalho">
						<td colspan="3">
							Tradução de Palavras - Orcish - Português (Brasil)
						</td>
					</tr>
					<tr class="cabecalho" align="center">
						<td>
							Orcish
						</td>
						<td>
							Inglês
						</td>
						<td>
							Português
						</td>
					</tr>
					';
					$queryOrcish = mysql_query("SELECT * FROM z_orcish ORDER BY orcish ASC");
					while ($resultadoOrcish = mysql_fetch_assoc($queryOrcish)){
						$palavraId = $resultadoOrcish["id"];
						$palavraOrcish = $resultadoOrcish["orcish"];
						$palavraIngles = $resultadoOrcish["ingles"];
						$palavraPortugues = $resultadoOrcish["portugues"];
						$exibicaoInput = "";
						$botaoAdicionar = "";
						$botaoEditar = "";
						if(empty($palavraPortugues))
							$botaoAdicionar = '<input type="button" value="Adicionar" class="botao adicionar">';
						else{
							$exibicaoInput = "ocultar";
							$botaoEditar = '<span>'.$palavraPortugues.'</span><input type="button" value="Editar" class="botao editar">';
						}
						$input = '<input type="text" size="10" data-palavra_id="'.$palavraId.'" class="'.$exibicaoInput.'" value="'.$palavraPortugues.'"> ';
						$exibirPalavraPortugues = $botaoEditar.$input.$botaoAdicionar;
						$conteudo_pagina .= '
							<tr class="item" height="29" align="center">
								<td width="25%">
									'.$palavraOrcish.'
								</td>
								<td width="25%">
									'.$palavraIngles.'
								</td>
								<td width="50%">
									'.$exibirPalavraPortugues.'
								</td>
							</tr>
						';
					}
					$conteudo_pagina .= '
				</table>
			</div>
		</div>
	';
?>