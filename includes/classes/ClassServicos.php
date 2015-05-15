<?php
	class Servicos {
		public function getProdutos($servicoId){
			$listaProdutos = array();
			$queryServico = mysql_query("SELECT * FROM z_loja_produtos WHERE (categoria LIKE '$servicoId')");
			while($resultadoServico = mysql_fetch_assoc($queryServico)){
				if($resultadoServico["forma_pagamento"] == "ponto")
					$exibirPreco = ($resultadoServico["preco"] > 1 ? $resultadoServico["preco"]." pontos" : $resultadoServico["preco"]." ponto");
				elseif($resultadoServico["forma_pagamento"] == "real")
					$exibirPreco = "R$ ".number_format($resultadoServico["preco"], 2, ",", ".");
				$listaProdutos[] = array(
					"id" => $resultadoServico["id"],
					"nome" => $resultadoServico["nome"],
					"descricao" => $resultadoServico["descricao"],
					"tipo" => $resultadoServico["tipo"],
					"produto_id1" => $resultadoServico["produto_id1"],
					"quantidade1" => $resultadoServico["quantidade1"],
					"produto_id2" => $resultadoServico["produto_id2"],
					"quantidade2" => $resultadoServico["quantidade2"],
					"addon" => $resultadoServico["addon"],
					"preco" => $resultadoServico["preco"],
					"exibirPreco" => $exibirPreco,
					"categoria" => $resultadoServico["categoria"],
					"presente" => ($resultadoServico["presente"] == 1 ? true : false),
					"imagem" => (empty($resultadoServico["imagem"]) ? $this->getImagemServico($resultadoServico["tipo"], $resultadoServico["produto_id1"]) : $this->getImagemServico($resultadoServico["id"])),
					"fundoServico" => ($resultadoServico["tipo"] != "item" ? true : false),
					"forma_pagamento" => $resultadoServico["forma_pagamento"]
				);
			}
			return $listaProdutos;
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
	}
?>