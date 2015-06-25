<?php
	include("includes/classes/ClassItens.php");
	$ClassItens = new Itens();
	if(empty($id)){
		$conteudo_pagina = '
			<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
				<div class="conteudo_box pagina">
					<div class="box_frame" carregar_box="1">
						Profissões
					</div>
					<div class="box_frame_conteudo_principal" carregar_box="1">
						<div class="box_frame_conteudo dark padding">
							Atualmente possuímos quatro profissões diferentes.<br>
							<br>
							Essas profissões fazem parte do sistema de <a href="?p=crafting">crafting</a>, que permite ao jogador fabricar diversos itens e equipamentos.<br>
							<br>
							Cada uma possui um nível de progesso individual e você pode visualizar a <a href="?p=tabela_experiencia-profissao">tabela de experiência de profissão</a> para saber a quantidade de experiência que é necessária para avançar pelos vários níveis.<br>
							<br>
							Escolha abaixo qual profissão deseja visualizar mais detalhes.
						</div>
					</div>
					<br>
					<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
						<tr class="cabecalho">
							<td colspan="2">
								Lista de Profissões
							</td>
						</tr>
						';
						$queryCategorias = mysql_query("SELECT * FROM z_itens_categorias WHERE (menu LIKE '3') ORDER BY ordem ASC");
						while($resultadoCategorias = mysql_fetch_assoc($queryCategorias)){
							$profissaoNome = $resultadoCategorias["nome"];
							$profissaoId = $ClassItens->pegarProfissaoId($profissaoNome);
							$linkCategoria = '?p=profissoes-'.strtolower($profissaoNome);
							$imagemCategoria = "imagens/itens/".$resultadoCategorias["item_imagem"].".gif";
							if(!is_file($imagemCategoria))
								$imagemCategoria = 'imagens/itens/item_nao_encontrado.png';
							$imagemCategoria = '<img src="'.$imagemCategoria.'" title="'.$profissaoNome.'" />';
							$conteudo_pagina .= '
								<tr class="item">
									<td width="50" align="center">
										<a href="'.$linkCategoria.'">'.$imagemCategoria.'</a>
									</td>
									<td>
										<a href="'.$linkCategoria.'">'.$profissaoNome.'</a>
									</td>
								</tr>
							';
						}
						$conteudo_pagina .= '
					</table>
				</div>
			</div>
		';
	}
	else{
		$profissao = $ClassItens->pegarProfissaoInfoByName($id);
		$profissaoId = $profissao["id"];
		$profissaoNome = ucfirst($id);
		if($profissaoId > 0){
			$conteudo_pagina = '
				<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
					<div class="conteudo_box pagina">
						<div class="setas">
							<div class="seta voltar">
								<a href="?p=profissoes"><img src="imagens/corpo/arrow_up.gif" /> voltar</a>
							</div>
						</div>
						<div class="box_frame" carregar_box="1">
							'.$profissaoNome.'
						</div>
						<div class="box_frame_conteudo_principal" carregar_box="1">
							<div class="box_frame_conteudo dark padding">
								'.$profissao["mensagem"].'
							</div>
						</div>
						<br>
						'.$ClassItens->pegarExibicaoMesaTrabalho($profissao["mesaTrabalho"]).'
						<br>
						'.$ClassItens->pegarExibicaoProfissao($profissaoNome).'
					</div>
				</div>
			';
		}
		else
			$conteudo_pagina = $conteudo_nao_encontrado_full;
	}
?>