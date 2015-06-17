<?php
	$area = $_REQUEST["area"];
	$itens = $_REQUEST["itens"];
	$itensValores = $_REQUEST["itensValores"];
	$tipo = $_REQUEST["tipo"];
	if($area == "carregar_itens"){
		header("Content-Type: text/html; charset=ISO-8859-1", true);
		include("../includes/classes/ClassItens.php");
		$ClassItens = new Itens();
		if(count($itens) > 0){
			foreach($itens as $c => $v)
				if(empty($v))
					unset($itens[$c]);
			$itensCarregados = $ClassItens->getItemInfoXml($itens);
			$stringXml = "";
			if(count($itensCarregados) > 0){
				foreach($itensCarregados as $itemId => $itemInfo){
					if(isset($itemInfo["nome"])){
						$nome = strtolower($itemInfo["nome"]);
						$stringXml .= "$nome,$itemId,".$itensValores[array_search($itemId, $itens)].";";
					}
				}
				if(!empty($stringXml)){
					$exibirTipo = ($tipo == "vender" ? "shop_sellable" : "shop_buyable");
					echo'<parameter key="'.$exibirTipo.'" value="'.$stringXml.'"/>';
					exit;
				}
			}
		}
		echo 0;
		exit;
	}
	elseif(empty($area)){
		$conteudo_pagina .= '
			'.$estilos.'
			<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
				<div class="conteudo_box pagina">
					<div class="box_frame" carregar_box="1">
						Criar NPC
					</div>
					<div id="criar_npc" class="box_frame_conteudo_principal" carregar_box="1">
						<div class="small_box_frame erro" carregar_box="1">
							<b>Os seguintes erros ocorerram:</b><br>
							Usuário e/ou senha inválidos. Digite dados válidos.
						</div>
						<div class="box_frame_conteudo" carregar_box="1">
							<table width="100%" cellpadding="0" cellspacing="0" class="tabela dark">
								<tr class="cabecalho" align="center">
									<td width="50%">
										ID do Item
									</td>
									<td width="50%">
										Valor do Item
									</td>
								</tr>
								<tr class="item" align="center">
									<td>
										<input type="text" id="item_id">
									</td>
									<td>
										<input type="text" id="valor">
									</td>
								</tr>
								<tr class="item" align="center">
									<td colspan="2">
										<input type="button" class="botao" id="incluir" value="Incluir">
									</td>
								</tr>
							</table>
						</div>
						<br>
						<div class="box_frame_conteudo" carregar_box="1">
							<table width="100%" cellpadding="0" cellspacing="0" class="tabela dark">
								<tr class="cabecalho" align="center">
									<td width="50%">
										ID do Item
									</td>
									<td width="50%">
										Valor do Item
									</td>
								</tr>
								<tr class="item vazio" align="center">
									<td colspan="2">
										Nenhum item adicionado
									</td>
								</tr>
								<tr class="item" align="center">
									<td colspan="2">
										<b>
											<input type="radio" id="vender" name="tipo" value="vender" checked="checked"><label for="vender">Vender</label>
											<input type="radio" id="comprar" name="tipo" value="comprar"><label for="comprar">Comprar</label>
										</b>
									</td>
								</tr>
								<tr class="item xml" align="center">
									<td colspan="2">
										<input type="button" class="botao" id="remover_itens" value="Remover Itens">
										<input type="button" class="botao" id="gerar_xml" value="Gerar XML">
									</td>
								</tr>
							</table>
						</div>
						<br>
						<div class="box_frame_conteudo" carregar_box="1">
							<table width="100%" cellpadding="0" cellspacing="0" class="tabela dark">
								<tr class="cabecalho" align="center">
									<td>
										<b>Resultado XML:</b>
									</td>
								</tr>
								<tr class="item">
									<td>
										<textarea id="resultado"></textarea><br>
									</td>
								</tr>
								<tr class="item" align="right">
									<td>
										<input type="button" class="botao" id="selecionar_codigo" value="Selecionar Código" />
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		';
	}
?>