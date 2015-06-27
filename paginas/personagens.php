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
		$informacoesPersonagem = $ClassPersonagem->getInformacoesPersonagem($id);
		if(count($informacoesPersonagem) > 0){
			$exibirInformacoesPersonagem = array(
				"nome" => array(
					"exibicao" => "Nome",
					"valor" => '
						<table style="margin: 15px 0 0 10px;">
							<tr>
								<td>
									'.$ClassPersonagem->pegarImagemPersonagem($informacoesPersonagem).'
								</td>
								<td>
									'.$informacoesPersonagem["nome"].'
								</td>
							</tr>
						</table>
					'
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
				"idade_tibia" => array(
					"exibicao" => "Idade no Tibia",
					"valor" => $informacoesPersonagem["idade_tibia"],
					"ocultar_vazio" => true
				),
				"comentario" => array(
					"exibicao" => "Comentário",
					"valor" => $informacoesPersonagem["exibirComentario"],
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
				'.$ClassPersonagem->exibirUltimasMortesPersonagem($informacoesPersonagem["id"]).'
			';
			if($informacoesPersonagem["ocultar_conta"] == 0){
				$contaPersonagemId = $informacoesPersonagem["contaId"];
				$informacoesContaPersonagem = $ClassConta->getInformacoesConta($contaPersonagemId, true);
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
									'.$ClassConta->getStatusConta($informacoesContaPersonagem["premdays"]).'
								</td>
							</tr>
							<tr class="item">
								<td width="120">
									<b>Data de Criação:</b>
								</td>
								<td>
									'.$informacoesContaPersonagem["exibirDataCriacao"].'
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
							$listaPersonagens = $ClassPersonagem->getListaPersonagens($contaPersonagemId);
							$exibirListaPersonagens = $ClassPersonagem->exibirListaPersonagens($listaPersonagens, 0, $informacoesPersonagem["id"]);
							$conteudo_personagens .= $exibirListaPersonagens;
							$conteudo_personagens .= '
						</table>
					</div>
				';
			}
			if(!empty($conteudo_personagens))
				$conteudo_personagens = '<div id="exibirPersonagem">'.$conteudo_personagens.'</div>';
		}
		else
			$conteudo_personagens = '
				<script>
					$(function(){
						$("#buscarPersonagem").click();
					});
				</script>
			';
	}
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				'.$conteudo_personagens.'
				'.$conteudo_busca_personagens.'
			</div>
		</div>
	';
?>