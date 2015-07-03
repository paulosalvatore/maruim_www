<?php
	$conteudo_busca_personagens .= '
		<div id="resultadoBusca" style="margin-bottom: 30px; display: none;">
			<table cellpadding="0" cellspacing="0" class="tabela dark" width="100%">
				<tr class="cabecalho">
					<td>
						Personagem N�o Encontrado
					</td>
				</tr>
				<tr class="item" height="40">
					<td>
						O personagem <b id="exibirNomePersonagem"></b> n�o existe.
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
					"exibicao" => "G�nero",
					"valor" => $informacoesPersonagem["exibirGenero"]
				),
				"vocacao" => array(
					"exibicao" => "Voca��o",
					"valor" => $informacoesPersonagem["vocacao"]
				),
				"nivel" => array(
					"exibicao" => "N�vel",
					"valor" => $informacoesPersonagem["nivel"]
				),
				"residencia" => array(
					"exibicao" => "Resid�ncia",
					"valor" => $informacoesPersonagem["residencia"]
				),
				"exibirDataCriacao" => array(
					"exibicao" => "Criado em",
					"valor" => $informacoesPersonagem["exibirDataCriacao"],
					"ocultar_vazio" => true
				),
				"ultimoLogin" => array(
					"exibicao" => "�ltimo Login",
					"valor" => $informacoesPersonagem["ultimoLogin"]
				),
				"idadeTibia" => array(
					"exibicao" => "Idade no Tibia",
					"valor" => $informacoesPersonagem["idadeTibia"],
					"ocultar_vazio" => true
				),
				"tempoOnline" => array(
					"exibicao" => "Tempo Online",
					"valor" => $informacoesPersonagem["tempoOnline"],
					"ocultar_vazio" => true
				),
				"comentario" => array(
					"exibicao" => "Coment�rio",
					"valor" => $informacoesPersonagem["exibirComentario"],
					"ocultar_vazio" => true
				)
			);
			$conteudo_personagens = '
				<div style="margin-bottom: 30px;">
					<table cellpadding="0" cellspacing="0" class="tabela odd" width="100%">
						<tr class="cabecalho">
							<td colspan="2">
								Informa��es do Personagem
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
									Informa��es da Conta
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
									<b>Data de Cria��o:</b>
								</td>
								<td>
									'.$informacoesContaPersonagem["exibirDataCriacao"].'
								</td>
							</tr>
						</table>
					</div>
				';
				$listaPersonagens = $ClassPersonagem->getListaPersonagens($contaPersonagemId);
				$exibirListaPersonagens = $ClassPersonagem->exibirListaPersonagens($listaPersonagens, 0, $informacoesPersonagem["id"]);
				if(!empty($exibirListaPersonagens))
					$conteudo_personagens .= '
						<div style="margin-bottom: 30px;">
							<table cellpadding="0" cellspacing="0" class="tabela odd" width="100%">
								<tr class="cabecalho">
									<td colspan="4">
										Personagens
									</td>
								</tr>
								'.$exibirListaPersonagens.'
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