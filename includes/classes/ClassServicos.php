<?php
	class Servicos {
		public $formasPagamento = array(
			"pagseguro" => array(
				"nome" => "PagSeguro",
				"tipo" => "real"
			),
			"transferencia" => array(
				"nome" => "Transferência Bancária",
				"tipo" => "real"
			),
			"pontos" => array(
				"nome" => "Pontos",
				"tipo" => "ponto"
			)
		);
		public function getProdutos($servicoId){
			$listaProdutos = array();
			$queryServico = mysql_query("SELECT * FROM z_loja_produtos WHERE (categoria LIKE '$servicoId')");
			while($resultadoServico = mysql_fetch_assoc($queryServico))
				$listaProdutos[] = $this->formatarInformacaoProduto($resultadoServico);
			return $listaProdutos;
		}
		public function getInformacoesProduto($produtoId){
			$informacoesProduto = array();
			$queryProduto = mysql_query("SELECT * FROM z_loja_produtos WHERE (id LIKE '$produtoId')");
			while($resultadoProduto = mysql_fetch_assoc($queryProduto))
				$informacoesProduto = $this->formatarInformacaoProduto($resultadoProduto);
			return $informacoesProduto;
		}
		public function formatarInformacaoProduto($informacaoProduto){
			$informacaoProdutoFormatada = array();
			foreach($informacaoProduto as $c => $v)
				$informacaoProdutoFormatada[$c] = $v;
			if($informacaoProduto["forma_pagamento"] == "ponto")
				$exibirPreco = ($informacaoProduto["preco"] > 1 ? $informacaoProduto["preco"]." pontos" : $informacaoProduto["preco"]." ponto");
			elseif($informacaoProduto["forma_pagamento"] == "real")
				$exibirPreco = "R$ ".number_format($informacaoProduto["preco"], 2, ",", ".");
			if($informacaoProduto["tipo"] == "item")
				$exibirNome = 'o item';
			elseif($informacaoProduto["tipo"] == "nova_chave")
				$exibirNome = 'uma nova';
			elseif($informacaoProduto["tipo"] == "pontos")
				$exibirNome = '';
			else
				$exibirNome = 'o serviço';
			$exibirNome .= ' "<b>'.$informacaoProduto["nome"].'</b>"';
			$informacaoProdutoFormatada["exibirPreco"] = $exibirPreco;
			$informacaoProdutoFormatada["exibirNome"] = $exibirNome;
			$informacaoProdutoFormatada["presente"] = ($informacaoProduto["presente"] == 1 ? true : false);
			$informacaoProdutoFormatada["imagem"] = ($informacaoProduto["imagem"] == 0 ? $this->getImagemServico($informacaoProduto["tipo"], $informacaoProduto["produto_id1"]) : $this->getImagemServico($informacaoProduto["id"]));
			$informacaoProdutoFormatada["fundoServico"] = ((($informacaoProduto["tipo"] != "item") OR ($informacaoProduto["imagem"] == 1)) ? true : false);
			return $informacaoProdutoFormatada;
		}
		public function getImagemServico($tipo, $produtoId = ""){
			$diretorioImagens = "imagens/";
			$diretorioImagensItens = $diretorioImagens."itens/";
			$diretorioImagensServicos = $diretorioImagens."servicos/";
			$diretorioImagensServicosOutros = $diretorioImagensServicos."outros/";
			$diretorioImagensOutfits = $diretorioImagensServicos."outfits/";
			$diretorioImagensMontarias = $diretorioImagensServicos."montarias/";
			if($tipo == "item"){
				$imagem = $diretorioImagensItens.$produtoId.".gif";
			}
			else if($tipo == "outfit"){
				$imagem = $diretorioImagensOutfits.$produtoId.".gif";
			}
			else if($tipo == "montaria"){
				$imagem = $diretorioImagensMontarias.$produtoId.".gif";
			}
			else if(is_numeric($tipo)){
				$imagem = $diretorioImagensServicosOutros.$tipo.".gif";
			}
			else{
				$imagem = $diretorioImagensServicos.$tipo.".png";
			}
			return $imagem;
		}
		public function verificarCompraProduto($produtoId, $pagamentoId, $contaId, $informacoesProduto = array()){
			$verificarCompraProduto = array(false, "");
			if(count($informacoesProduto) == 0)
				$informacoesProduto = $this->getInformacoesProduto($produtoId);
			$ClassConta = new Conta();
			$informacoesConta = $ClassConta->getInformacoesConta($contaId, true);
			$pontosDisponiveis = $informacoesConta["pontos"];
			if(($informacoesProduto["forma_pagamento"] == "ponto") AND ($informacoesProduto["preco"] > $pontosDisponiveis)){
				$verificarCompraProduto[1] = '
					<div class="box_frame" carregar_box="1">
						Pontos Insuficientes
					</div>
					<div class="box_frame_conteudo_principal" carregar_box="1">
						<div class="box_frame_conteudo dark padding">
							Você precisa de pelo menos <b>'.$informacoesProduto["exibirPreco"].'</b> para adquirir '.$informacoesProduto["exibirNome"].'.
						</div>
					</div>
					<br>
					<div align="center">
						<input type="button" class="botao_azul" value="Voltar" onClick="document.location = \'?p=minha_conta-servicos\';">
					</div>
				';
			}
			else
				$verificarCompraProduto[0] = true;
			return $verificarCompraProduto;
		}
		public function getInformacoesPagamento($pagamentoId){
			return $this->formasPagamento[$pagamentoId];
		}
	}
?>