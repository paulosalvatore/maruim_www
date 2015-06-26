<?php
	include("includes/classes/ClassNpcs.php");
	$ClassNpcs = new Npcs();
	$exibirBuscaNpc = $ClassNpcs->pegarBuscaNpc();
	if($id == "buscar"){
		$conteudo_pagina .= '
			<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="npcs_buscar">
				<div class="conteudo_box pagina">
					'.$ClassNpcs->exibirBuscaNpc($_POST["busca"]).'
				</div>
			</div>
		';
	}
	elseif(is_numeric($id)){
		$npc = $ClassNpcs->pegarInfoNpc($id);
		if(count($npc) > 0){
			$conteudo_pagina .= '
				<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
					<div class="conteudo_box pagina">
						<div class="setas">
							<div class="seta voltar">
								<a href="?p=npcs"><img src="imagens/corpo/arrow_up.gif" /> voltar</a>
							</div>
						</div>
						'.$exibirBuscaNpc.'
						<div class="box_frame" carregar_box="1">
							'.$npc["nome"].'
						</div>
						<br>
						<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
							<tr class="cabecalho">
								<td colspan="2">
									Informações gerais
								</td>
							</tr>
							<tr class="item">
								<td width="100" align="right">
									'.$npc["imagem"].'
								</td>
								<td>
									<b>'.$npc["nome"].'</b>
								</td>
							</tr>
							<tr class="item">
								<td width="100" align="right">
									<b>Localização</b>
								</td>
								<td>
									<a href="?p=mapa&x='.$npc["posx"].'&y='.$npc["posy"].'&z='.$npc["posz"].'&zoom=5">Clique aqui para visualizar</a>
								</td>
							</tr>
						</table>
						<br>
						';
						$exibirItensNpc = $ClassNpcs->exibirItensNpc($id);
						$exibirItensCompra = $exibirItensNpc[0];
						$exibirItensVenda = $exibirItensNpc[1];
						$conteudo_pagina .= '
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td width="50%" valign="top">
									<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
										<tr class="cabecalho" align="center">
											<td colspan="2">
												Vende:
											</td>
										</tr>
										'.$exibirItensCompra.'
									</table>
								</td>
								<td width="50%" valign="top">
									<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
										<tr class="cabecalho" align="center">
											<td colspan="2">
												Compra:
											</td>
										</tr>
										'.$exibirItensVenda.'
									</table>
								</td>
							</tr>
						</table>
					</div>
				</div>
			';
		}
		else
			$conteudo_pagina .= $conteudo_nao_encontrado_full;
	}
	else{
		$ClassNpcs-> exibirBuscaNpc($id, false);
		$conteudo_pagina .= '
			<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
				<div class="conteudo_box pagina">
					'.$exibirBuscaNpc.'
				</div>
			</div>
		';
	}
?>