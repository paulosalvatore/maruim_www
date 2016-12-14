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
			if($informacaoProduto["tipo"] == "item")
				$exibirNome = 'o item';
			elseif($informacaoProduto["tipo"] == "nova_chave")
				$exibirNome = 'uma nova';
			elseif($informacaoProduto["tipo"] == "pontos")
				$exibirNome = '';
			else
				$exibirNome = 'o serviço';
			$exibirNome .= ' "<b>'.$informacaoProduto["nome"].'</b>"';
			$informacaoProdutoFormatada["exibirNome"] = $exibirNome;
			if($informacaoProduto["forma_pagamento"] == "ponto"){
				$exibirPreco = ($informacaoProduto["preco"] > 1 ? $informacaoProduto["preco"]." pontos" : $informacaoProduto["preco"]." ponto");
				$pontos = $informacaoProduto["preco"];
			}
			elseif($informacaoProduto["forma_pagamento"] == "real"){
				$exibirPreco = "R$ ".number_format($informacaoProduto["preco"], 2, ",", ".");
				$pontos = $informacaoProduto["quantidade1"];
			}
			$informacaoProdutoFormatada["exibirPreco"] = $exibirPreco;
			$informacaoProdutoFormatada["pontos"] = $pontos;
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
			if((count($informacoesProduto) == 0) AND ($this->getInformacoesPagamento($pagamentoId)))
				$verificarCompraProduto[1] = $this->carregarMensagem("dados_invalidos");
			elseif(($informacoesProduto["categoria"] == "servicos_extras") AND (empty($informacoesConta["chave_recuperacao"])))
				$verificarCompraProduto[1] = $this->carregarMensagem("registro_necessario");
			elseif(($informacoesProduto["forma_pagamento"] == "ponto") AND ($informacoesProduto["preco"] > $pontosDisponiveis))
				$verificarCompraProduto[1] = $this->carregarMensagem("pontos_insuficientes", array($informacoesProduto["exibirPreco"], $informacoesProduto["exibirNome"]));
			else
				$verificarCompraProduto[0] = true;
			return $verificarCompraProduto;
		}
		public function getInformacoesPagamento($pagamentoId){
			if($this->formasPagamento[$pagamentoId])
				return $this->formasPagamento[$pagamentoId];
			return false;
		}
		public function novoPedido($pedido){
			$colunasPedido = array();
			$valoresPedido = array();
			foreach($pedido as $c => $v){
				$colunasPedido[] = $c;
				$valoresPedido[] = $v;
			}
			if((count($colunasPedido) > 0) AND (count($valoresPedido) > 0)){
				$informacoesProduto = $this->getInformacoesProduto($pedido["produto"]);
				$informacoesPagamento = $this->getInformacoesPagamento($pedido["pagamento"]);
				$ClassFuncao = new Funcao();
				if($informacoesPagamento["tipo"] == "ponto"){
					$ClassConta = new Conta();
					$informacoesConta = $ClassConta->getInformacoesConta($pedido["conta"], true);
					$sqlPontos = $ClassFuncao->loadSQLQueryUpdate("accounts", "pontos", $informacoesConta["pontos"]-$informacoesProduto["preco"], "id", $pedido["conta"]);
					mysql_query($sqlPontos);
					$colunasPedido[] = "status";
					$valoresPedido[] = 2;
				}
				$sqlHistorico = $ClassFuncao->loadSQLQuery("z_loja_historico", $colunasPedido, $valoresPedido);
				mysql_query($sqlHistorico);
			}
		}
		public function carregarMensagem($tipoMensagem, $informacaoAdicional = ""){
			$mensagem = "";
			if($tipoMensagem == "pontos_insuficientes")
				$mensagem = '
					<div class="box_frame" carregar_box="1">
						Pontos Insuficientes
					</div>
					<div class="box_frame_conteudo_principal" carregar_box="1">
						<div class="box_frame_conteudo dark padding">
							Você precisa de pelo menos <b>'.$informacaoAdicional[0].'</b> para adquirir '.$informacaoAdicional[1].'.
						</div>
					</div>
					<br>
					<div align="center">
						<input type="button" class="botao_azul" value="Voltar" onClick="document.location = \'?p=minha_conta-servicos\';">
					</div>
				';
			elseif($tipoMensagem == "erro")
				$mensagem = '
					<div class="box_frame" carregar_box="1">
						Um Erro Ocorreu
					</div>
					<div class="box_frame_conteudo_principal" carregar_box="1">
						<div class="box_frame_conteudo dark padding">
							Algum erro grave ocorreu.<br>
							<br>
							Tente novamente, caso o erro persista entre em contato com o suporte.
						</div>
					</div>
					<br>
					<div align="center">
						<input type="button" class="botao_azul" value="Voltar" onClick="document.location = \'?p=minha_conta-servicos\';">
					</div>
				';
			elseif($tipoMensagem == "dados_invalidos")
				$mensagem = '
					<div class="box_frame" carregar_box="1">
						Dados Inválidos
					</div>
					<div class="box_frame_conteudo_principal" carregar_box="1">
						<div class="box_frame_conteudo dark padding">
							Algum erro ocorreu ou você inseriu dados inválidos.
						</div>
					</div>
					<br>
					<div align="center">
						<input type="button" class="botao_azul" value="Voltar" onClick="document.location = \'?p=minha_conta-servicos\';">
					</div>
				';
			elseif($tipoMensagem == "registro_necessario")
				$mensagem = '
					<div class="box_frame" carregar_box="1">
						Registro Necessário
					</div>
					<div class="box_frame_conteudo_principal" carregar_box="1">
						<div class="box_frame_conteudo dark padding">
							Você precisa registrar sua conta para adquirir esse produto.
						</div>
					</div>
					<br>
					<div align="center">
						<input type="button" class="botao_azul" value="Voltar" onClick="document.location = \'?p=minha_conta-servicos\';">
					</div>
				';
			return $mensagem;
		}
		public function pegarHistoricoPagamentos($contaId){
			$historicoPagamentos = array();
			$queryHistoricoPagamentos = mysql_query("SELECT * FROM z_loja_historico WHERE (conta LIKE '$contaId' AND (pagamento LIKE 'transferencia' OR pagamento LIKE 'pagseguro'))");
			while($resultadoHistoricoPagamentos = mysql_fetch_assoc($queryHistoricoPagamentos))
				$historicoPagamentos[] = $resultadoHistoricoPagamentos;
			return $historicoPagamentos;
		}
		public function pegarHistoricoPagamento($historicoPagamentoId){
			$queryHistoricoPagamento = mysql_query("SELECT * FROM z_loja_historico WHERE (id LIKE '$historicoPagamentoId')");
			while($resultadoHistoricoPagamento = mysql_fetch_assoc($queryHistoricoPagamento))
				return $resultadoHistoricoPagamento;
			return false;
		}
		public function validarConfirmarTransferencia($historicoPagamentoId){
			$historicoPagamento = $this->pegarHistoricoPagamento($historicoPagamentoId);
			if ($historicoPagamento["status"] == 1 AND $historicoPagamento["pagamento"] == "transferencia")
				return true;
			return false;
		}
	}
?>