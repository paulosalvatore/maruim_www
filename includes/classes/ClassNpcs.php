<?php
	class Npcs {
		public function pegarInfoNpc($npcId){
			$npc = array();
			$queryNpc = mysql_query("SELECT * FROM z_npcs WHERE (id LIKE '$npcId')");
			while($resultadoNpc = mysql_fetch_assoc($queryNpc))
				$npc = $resultadoNpc;
			if(count($npc) > 0)
				$npc["imagem"] = $this->pegarImagemNpc($npc);
			return $npc;
		}
		public function exibirItensNpc($npcId){
			include("includes/classes/ClassItens.php");
			$ClassItens = new Itens();
			$itens = array("c" => array(), "v" => array());
			$queryItensNpc = mysql_query("SELECT * FROM z_npcs_itens WHERE (npc LIKE '$npcId')");
			while($resultadoItensNpc = mysql_fetch_assoc($queryItensNpc)){
				$itens[$resultadoItensNpc["acao"]][] = array(
					"item" => $resultadoItensNpc["item"],
					"valor" => $resultadoItensNpc["valor"]
				);
			}
			if((count($itens["c"]) == 0) and (count($itens["v"]) == 0))
				return false;
			$buscarItens = array();
			foreach(array_merge($itens["c"], $itens["v"]) as $item)
				if(!in_array($item, $buscarItens))
					$buscarItens[] = $item["item"];
			$itensInfo = $ClassItens->getItemInfoSQL($buscarItens);
			$exibirItensCompra = '';
			$exibirItensVenda = '';
			$exibirItensNada = '
					<tr class="item" align="center">
						<td colspan="2" height="40">
							<b>Nada.</b>
						</td>
					</tr>
				';
			$cabecalhoNpc = '
				<tr class="cabecalho" align="center">
					<td>
						<b>Item</b>
					</td>
					<td>
						<b>Valor</b>
					</td>
				</tr>
			';
			if(count($itens["c"]) == 0)
				$exibirItensCompra .= $exibirItensNada;
			if(count($itens["v"]) == 0)
				$exibirItensVenda .= $exibirItensNada;
			$itensNome = array();
			foreach($itens["c"] as $c => $npcItem)
				$itensNome[$c] = $itensInfo[$npcItem["item"]]["nome"];
			asort($itensNome);
			foreach($itensNome as $c => $itemId)
				$exibirItensCompra .= $this->formatarItemNpc($itensInfo[$itens["c"][$c]["item"]], $itens["c"][$c]["valor"]);
			$itensNome = array();
			foreach($itens["v"] as $c => $npcItem)
				$itensNome[$c] = $itensInfo[$npcItem["item"]]["nome"];
			asort($itensNome);
			foreach($itensNome as $c => $itemId)
				$exibirItensVenda .= $this->formatarItemNpc($itensInfo[$itens["v"][$c]["item"]], $itens["v"][$c]["valor"]);
			return array($exibirItensCompra, $exibirItensVenda);
		}
		public function formatarItemNpc($item, $valor){
			return '
				<tr class="item" align="center">
					<td>
						<a href="'.$item["url"].'">'.$item["nome"].'</a>
					</td>
					<td>
						'.$valor.' gp
					</td>
				</tr>
			';
		}
		public function pegarLinkNpc($npcId, $npcNome = ""){
			if(empty($npcNome)){
				$npcNome = $this->pegarInfoNpc($npcId);
				$npcNome = $npcNome["nome"];
			}
			return "?p=npcs-".$npcId."-".urlencode($npcNome);
		}
		public function pegarImagemNpc($npc, $z = ""){
			$arquivoImagem = 'includes/classes/ClassOutfit.php?id='.$npc["lookType"].'&head='.$npc["lookHead"].'&body='.$npc["lookBody"].'&legs='.$npc["lookLegs"].'&feet='.$npc["lookFeet"].'&addons='.$npc["lookAddons"];
			if($npc["lookMount"] != 0)
				$arquivoImagem .= '&mount='.$npc["lookMount"].'&direction=2';
			$exibirZ = (!empty($z) ? ' style="position: relative; z-index: '.$z.';"' : '');
			return '
				<div class="imagemOutfit">
					<img src="'.$arquivoImagem.'" alt="'.$npc["nome"].'" title="'.$npc["nome"].'" border="0" class="imagemOutfit"'.$exibirZ.' />
				</div>
			';
		}
		public function pegarBuscaNpc($busca = ""){
			return '
				<form method="POST" action="?p=npcs-buscar">
				<table class="tabela dark" cellpadding="0" cellspacing="0" width="100%">
					<tr class="cabecalho">
						<td>
							Buscar NPCs
						</td>
					</tr>
					<tr class="item">
						<td>
							Nome do NPC: <input type="text" name="busca" id="buscar_npcs" value="'.$busca.'"> <input type="submit" class="botao" value="Procurar">
						</td>
					</tr>
				</table>
				</form>
				<br>
			';
		}
		public function exibirBuscaNpc($busca){
			$busca = addslashes($busca);
			$checarBuscaExata = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM z_npcs WHERE (nome LIKE '$busca')"));
			$checarBuscaExata = $checarBuscaExata["total"];
			$queryBusca = $busca;
			if($checarBuscaExata != 1)
				$queryBusca = "%$busca%";
			$npcs = array();
			$queryBuscaNpc = mysql_query("SELECT * FROM z_npcs WHERE (nome LIKE '$queryBusca')");
			while($resultadoBuscaNpc = mysql_fetch_assoc($queryBuscaNpc))
				$npcs[] = $resultadoBuscaNpc;
			if(count($npcs) == 1){
				header("Location: ".$this->pegarLinkNpc($npcs[0]["id"], $npcs[0]["nome"]));
				exit;
			}
			$ClassFuncao = new Funcao();
			$ClassFuncao->ordenarResultadosBusca($npcs, 'nome');
			$q = count($npcs);
			$exibirBusca .= '
				'.$this->pegarBuscaNpc($busca).'
				<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
					<tr class="cabecalho">
						<td colspan="2" style="z-index: '.($q+1).'; position: relative;">
							'.(empty($busca) ? "Lista de NPCs" : 'Resultados da Busca por "'.$busca.'"').'
						</td>
					</tr>
					';
					foreach($npcs as $npc){
						$linkNpc = $this->pegarLinkNpc($npc["id"], $npc["nome"]);
						$exibirBusca .= '
							<tr class="item">
								<td width="30" align="center">
									<a href="'.$linkNpc.'">'.$this->pegarImagemNpc($npc, $q--).'</a>
								</td>
								<td>
									<a href="'.$linkNpc.'">'.$npc["nome"].'</a>
								</td>
							</tr>
						';
					}
					if(count($npcs) == 0)
						$exibirBusca .= '
							<tr class="item">
								<td colspan="2" height="100" align="center">
									<b>Sua busca não encontrou nenhum resultado.</b>
								</td>
							</tr>
						';
					$exibirBusca .= '
				</table>
				<br>					
			';
			return $exibirBusca;
		}
	}
?>