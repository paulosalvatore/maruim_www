<?php
	set_time_limit(36000);
	class Itens {
		public function loadXML(){
			$arquivo = "arquivos/itens/items.xml";
			if(!is_file($arquivo))
				$arquivo = "../".$arquivo;
			return simplexml_load_file($arquivo);
		}
		public function pegarUrlItem($itemId, $itemNome){
			$url = "?p=itens-item-$itemId";
			if(!empty($itemNome))
				$url .= "-".urlencode($itemNome);
			return $url;
		}
		public function exibirItem($loot, $item){
			$itemId = $item["id"];
			$exibirNome = $item["nome"];
			if(empty($exibirNome))
				$exibirNome = "Item sem nome";
			$urlItem = $this->pegarUrlItem($itemId, $item["nome"]);
			$itemQuantidade = $loot["quantidade"];
			$itemChance = number_format($loot["chance"]/1000, 2, ".", "").'%';
			$exibirQuantidade = "";
			if($itemQuantidade > 1)
				$exibirQuantidade = " (1-$itemQuantidade)";
			$exibirImagem = $item["imagem"];
			if(empty($exibirImagem))
				$exibirImagem = '<img src="imagens/itens/item_nao_encontrado.png" title="Imagem de Item não encontrada" border="0" />';
			return '
				<tr class="item">
					<td width="35" align="center">
						<a href="'.$urlItem.'">'.$exibirImagem.'</a>
					</td>
					<td>
						<a href="'.$urlItem.'">'.$exibirNome.'</a>'.$exibirQuantidade.'
					</td>
					<td>
						'.$itemChance.'
					</td>
				</tr>
			';
		}
		public function exibirLootXml($loot){
			$lootItens = array();
			foreach($loot as $item)
				$lootItens[] = $item["item_id"];
			$listaItens = $this->getItemInfoXml($lootItens);
			$exibirItens = "";
			foreach($loot as $item)
				$exibirItens .= $this->exibirItem($item, $listaItens[$item["item_id"]]);
			return $exibirItens;
		}
		public function exibirLoot($loot){
			$lootItens = array();
			foreach($loot as $item)
				$lootItens[] = $item["item_id"];
			$listaItens = $this->getItemInfoSQL($lootItens);
			$exibirItens = "";
			foreach($loot as $item)
				$exibirItens .= $this->exibirItem($item, $listaItens[$item["item_id"]]);
			return $exibirItens;
		}
		public function exibirDropItem($drop){
			$exibirDrop = "";
			if(count($drop) > 0){
				$ClassCriaturas = new Criaturas();
				foreach($drop as $dropInfo){
					$criaturaInfo = $ClassCriaturas->getInfoCriatura($dropInfo["monstro_id"], true);
					$exibirQuantidade = "";
					if($dropInfo["quantidade"] > 1)
						$exibirQuantidade = " (1-".$dropInfo["quantidade"].") - ";
					$exibirDrop .= '
						<tr class="item">
							<td width="150" align="center">
								<a href="'.$criaturaInfo["url"].'">
									'.$criaturaInfo["imagemTag"].'<br>
									<b>'.$criaturaInfo["nome"].'</b>
								</a>
							</td>
							<td>
								'.$exibirQuantidade.number_format($dropInfo["chance"]/1000, 2, ".", "").'%
							</td>
						</tr>
					';
				}
			}
			return $exibirDrop;
		}
		public function formatarNomeItem($name){
			$name = ucwords($name);
			$a = array(
				array("Of", "of")
			);
			foreach($a as $b)
				$name = str_replace($b[0], $b[1], $name);
			return $name;
		}
		public function getItemInfoByName($names){
			if(!is_array($names))
				return false;
			$xml = $this->loadXML();
			$ids = array();
			foreach($xml->children() as $item){
				$item_atributos = $item->attributes();
				$item_nome = (string)$item_atributos["name"];
				if(!in_array($item_nome, $names))
					continue;
				$item_id = (string)$item_atributos["id"];
				$item_fromid = (string)$item_atributos["fromid"];
				if(!empty($item_fromid))
					$itemid = $item_from_id;
				$ids[] = $item_id;
			}
			return $this->getItemInfoXml($ids);
		}
		public function getItemInfoXml($ids){
			if(!is_array($ids))
				return false;
			$xml = $this->loadXML();
			$min_id = min($ids);
			$max_id = max($ids);
			$resultado_itens = array();
			foreach($xml->children() as $item){
				$item_atributos = array();
				$item_id = "";
				$itens_id = array();
				$item_fromid = "";
				$item_toid = "";
				$item_article = "";
				$item_plural = "";
				foreach($item->attributes() as $chave => $valor){
					$chave = "item_".(string)$chave;
					$$chave = (string)$valor;
				}
				if((!empty($item_id)) AND ((!in_array($item_id, $ids)) OR (($item_id < $min_id) OR ($item_id > $max_id))))
					continue;
				elseif((!empty($item_fromid)) AND (!empty($item_toid))){
					for($i=0;$i<=$item_toid-$item_fromid;$i++){
						if(in_array($item_toid - $i, $ids))
							$itens_id[] = $item_toid - $i;
					}
				}
				if((empty($item_id)) AND (count($itens_id) == 0))
					continue;
				for($i=0;$i<count($item);$i++){
					$atributo = $item->attribute[$i];
					$chave_atributo = (string)$atributo["key"];
					$valor_atributo = (string)$atributo["value"];
					if(count($atributo) > 0){
						$item_atributos[$chave_atributo]["value"] = $valor_atributo;
						for($j=0;$j<count($atributo);$j++){
							$atributo_interno = $atributo->attribute[$j];
							$chave_atributo_interno = (string)$atributo_interno["key"];
							$valor_atributo_interno = (string)$atributo_interno["value"];
							$item_atributos[$chave_atributo][$chave_atributo_interno] = $valor_atributo_interno;
						}
					}
					else
						$item_atributos[$chave_atributo] = $valor_atributo;
				}
				$resultado_item = array();
				if(!empty($item_name)){
					$item_name = $this->formatarNomeItem($item_name);
					$resultado_item["nome"] = $item_name;
				}
				if(count($item_atributos) > 0)
					$resultado_item["atributos"] = $item_atributos;
				if(!empty($item_article))
					$resultado_item["artigo"] = $item_article;
				if(!empty($item_plural))
					$resultado_item["plural"] = $item_plural;
				if(!empty($item_id))
					$itens_id[] = $item_id;
				foreach($itens_id as $item_id){
					$resultado_item_final = $resultado_item;
					$resultado_item_final["id"] = $item_id;
					$item_imagem = "imagens/itens/$item_id.gif";
					if(is_file($item_imagem))
						$resultado_item_final["imagem"] = '<img src="'.$item_imagem.'" title="'.$item_name.'"/>';
					$resultado_itens[$item_id] = $resultado_item_final;
				}
			}
			if(count($ids) != count($resultado_itens)){
				foreach($ids as $id){
					if(!array_key_exists($id, $resultado_itens)){
						$item_imagem = "imagens/itens/$id.gif";
						if(is_file($item_imagem))
							$item_imagem = '<img src="'.$item_imagem.'"/>';
						else
							$item_imagem = "";
						$resultado_item = array(
							"id" => $id,
							"nome" => $id." Item sem nome",
							"imagem" => $item_imagem
						);
						$resultado_itens[$id] = $resultado_item;
					}
				}
			}
			ksort($resultado_itens);
			return $resultado_itens;
		}
		public function comparar(){
			$xml1 = simplexml_load_file("items1.xml");
			$xml2 = simplexml_load_file("items2.xml");
			$itens1 = array();
			$itens2 = array();
			foreach($xml1->children() as $item){
				$item_atributos = $item->attributes();
				$item_id = (string)$item_atributos["id"] or "";
				$item_fromid = (string)$item_atributos["fromid"] or "";
				$item_toid = (string)$item_atributos["toid"] or "";
				$item_nome = (string)$item_atributos["name"] or "";
				if(empty($item_id))
					for($i=0;$i<$itemtoid-$itemfromid;$i++)
						$itens1[$itemtoid-$i] = $item_nome;
				else
					$itens1[$item_id] = $item_nome;
			}
			foreach($xml2->children() as $item){
				$item_atributos = $item->attributes();
				$item_id = (string)$item_atributos["id"];
				$item_fromid = (string)$item_atributos["fromid"];
				$item_toid = (string)$item_atributos["toid"];
				$item_nome = (string)$item_atributos["name"];
				if(empty($item_id))
					for($i=0;$i<$itemtoid-$itemfromid;$i++)
						$itens2[$itemtoid-$i] = $item_nome;
				else
					$itens2[$item_id] = $item_nome;
			}
			echo"Itens que estão nos itens 1 e não estão nos itens 2:<br>";
			foreach($itens1 as $item_id => $item_nome){
				if(!array_key_exists($item_id, $itens2))
					echo $item_id." - ".$item_nome."<br>";
			}
			echo"<br>Itens que estão nos itens 2 e não estão nos itens 1:<br>";
			foreach($itens2 as $item_id => $item_nome){
				if(!array_key_exists($item_id, $itens1))
					echo $item_id." - ".$item_nome."<br>";
			}
		}
		public function salvarImagens(){
			$xml = simplexml_load_file("arquivos/itens/items.xml");
			foreach($xml->children() as $item){
				$item_atributos = $item->attributes();
				$item_id = (string)$item_atributos["id"] or "";
				$item_fromid = (string)$item_atributos["fromid"];
				$item_toid = (string)$item_atributos["toid"];
				$verificar_itens = array();
				if(!empty($item_id))
					$verificar_itens[] = $item_id;
				else
					for($i=$item_fromid;$i<$item_toid;$i++)
						$verificar_itens[] = $i;
				foreach($verificar_itens as $item_id){
					$destino = "imagens/itens_copiados/$item_id.gif";
					if(!is_file($destino)){
						$link = "http://www.noxiousot.com/images/items/";
						$arquivo = "$link$item_id.gif";
						$arquivo_interno = "imagens/itens/$item_id.gif";
						$ch = curl_init($arquivo);
						curl_setopt($ch, CURLOPT_NOBODY, true);
						curl_exec($ch);
						$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
						curl_close($ch);
						if($retcode == 200)
							copy($arquivo, $destino);
						else
							copy($arquivo_interno, $destino);
					}
				}
			}
		}
		public function copiarDiretorio(){
			for($i=12649;$i<20000;$i++){
				$link = "http://www.noxiousot.com/images/items/";
				$arquivo = "$link$i.gif";
				$destino = "imagens/diretorio_copiado/$i.gif";
				$ch = curl_init($arquivo);
				curl_setopt($ch, CURLOPT_NOBODY, true);
				curl_exec($ch);
				$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				if($retcode == 200)
					copy($arquivo, $destino);
			}
		}
		public function pegarAtaqueElemento($atributos){
			$ataqueElemento = 0;
			if(is_array($atributos)){
				foreach($atributos as $c => $v){
					if(strpos($c, "element") !== false){
						$ataqueElemento = array(strtolower(str_replace("element", "", $c)), $v);
						break;
					}
				}
			}
			return $ataqueElemento;
		}
		public function pegarAtributosItem($item){
			$atributos = $item["atributos"];
			$exibirAtributos = array();
			if($item["agrupavel"] == 1)
				$exibirAtributos[] = "Agrupável";
			if($item["carrega_liquido"] == 1)
				$exibirAtributos[] = "Carrega Líquido";
			if(is_array($atributos)){
				foreach($atributos as $atributo => $v){
					if($atributo == "slotType"){
						if($v == "one-handed")
							$exibirAtributos[] = "Arma de uma mão";
						elseif($v == "two-handed")
							$exibirAtributos[] = "Arma de duas mãos";
					}
					elseif($atributo == "weaponType"){
						if(empty($atributos["slotType"]))
							$exibirAtributos[] = "Arma de uma mão";
					}
				}
			}
			if(count($exibirAtributos) == 0)
				$exibirAtributos[] = "Nenhum";
			return implode("; ", $exibirAtributos).".";
		}
		public function pegarExibicaoAtributosDescricaoItem($atributos){
			$tiposAtributos = array(
				"defense" => array(
					"exibicao" => "Def"
				),
				"attack" => array(
					"exibicao" => "Atq"
				),
			);
			if($atributos["attack"] > 0){
				$descricaoAtributos .= '(Atq: '.$atributos["attack"];
				$ataqueElemento = $this->pegarAtaqueElemento($atributos);
				if(is_array($ataqueElemento))
					$descricaoAtributos .= ' + '.$ataqueElemento[1].' '.$ataqueElemento[0];
				if(!$atributos["defense"])
					$descricaoAtributos .= ')<br>';
				else
					$descricaoAtributos .= ', ';
			}
			if($atributos["defense"] > 0){
				if(!$atributos["attack"])
					$descricaoAtributos .= '(';
				$descricaoAtributos .= 'Def: '.$atributos["defense"];
				if($atributos["extradef"] > 0)
					$descricaoAtributos .= ' +'.$atributos["extradef"];
				$descricaoAtributos .= ').<br>';
			}
			if($atributos["armor"] > 0)
				$descricaoAtributos .= '
					(Arm: '.$atributos["armor"].')<br>
				';
			if($atributos["range"] > 0)
				$descricaoAtributos .= '
					(Range: '.$atributos["range"].')<br>
				';
			if($atributos["weight"] > 0)
				$descricaoAtributos .= '
					Peso: '.number_format($atributos["weight"]/100, 2, ".", "").' oz.<br>
				';
			return '<span class="verde">'.$descricaoAtributos.'</span>';
		}
		public function getItemInfoSQL($ids){
			if(!is_array($ids)){
				if(is_numeric($ids))
					$ids = array($ids);
				else
					return false;
			}
			$itens = array();
			foreach($ids as $id){
				$itemInfo = array();
				$queryItem = mysql_query("SELECT * FROM z_itens WHERE (id LIKE '$id')");
				while($resultadoItem = mysql_fetch_assoc($queryItem))
					foreach($resultadoItem as $c => $v)
						$itemInfo[$c] = $v;
				$atributos = array();
				$drop = array();
				$queryAtributos = mysql_query("SELECT * FROM z_itens_atributos WHERE (item LIKE '$id')");
				while($resultadoAtributos = mysql_fetch_assoc($queryAtributos))
					$atributos[$resultadoAtributos["atributo"]] = $resultadoAtributos["valor"];
				$queryDrop = mysql_query("SELECT * FROM z_monstros_loot WHERE (item_id LIKE '$id')");
				while($resultadoDrop = mysql_fetch_assoc($queryDrop))
					$drop[] = array(
						"monstro_id" => $resultadoDrop["monstro_id"],
						"quantidade" => $resultadoDrop["quantidade"],
						"chance" => $resultadoDrop["chance"]
					);
				$categoria = $this->pegarCategoriaItem($id);
				$categoriaId = $categoria;
				if(is_array($categoria))
					$categoriaId = $categoria[0];
				$categoriaVoltar = 0;
				$urlAnterior = parse_url($_SERVER['HTTP_REFERER']);
				if($urlAnterior["query"]){
					parse_str($urlAnterior["query"], $queryUrlAnterior);
					if($queryUrlAnterior["p"]){
						$queryUrlAnterior = explode("-", $queryUrlAnterior["p"]);
						if(count($queryUrlAnterior) == 3)
							if(($queryUrlAnterior[0] == "itens") and ($queryUrlAnterior[1] == "categorias") and (is_numeric($queryUrlAnterior[2])))
								if((is_array($categoria)) and (in_array($queryUrlAnterior[2], $categoria)))
									$categoriaVoltar = $queryUrlAnterior[2];
					}
				}
				$itens[$id] = array(
					"id" => $id,
					"nome" => (!empty($itemInfo["nome"]) ? $itemInfo["nome"] : "Item sem nome"),
					"imagem" => '<img src="'.(is_file("imagens/itens/$id.gif") ? 'imagens/itens/'.$id.'.gif" title="'.$resultadoItem["nome"].'"' : 'imagens/itens/item_nao_encontrado.png" title="Imagem de Item não encontrada"').'" border="0" />',
					"url" => $this->pegarUrlItem($id, $itemInfo["nome"]),
					"exibirAtributos" => $this->pegarExibicaoAtributosDescricaoItem($atributos),
					"agrupavel" => $itemInfo["agrupavel"],
					"carrega_liquido" => $itemInfo["carrega_liquido"],
					"atributos" => $atributos,
					"categoria" => $categoriaId,
					"urlVoltar" => "?p=itens".($categoriaId > 0 ? "-categorias-".($categoriaVoltar > 0 ? $categoriaVoltar : $categoriaId) : "-menus"),
					"drop" => $drop
				);
			}
			return $itens;
		}
		public function inserirItensSQL($itens){
			$itensInfo = $this->getItemInfoXml($itens);
			require("conexao/conexao.php");
			mysql_query("TRUNCATE TABLE z_itens");
			mysql_query("TRUNCATE TABLE z_itens_atributos");
			mysql_query("TRUNCATE TABLE z_itens_atributos_atributos");
			foreach($itensInfo as $item){
				mysql_query("INSERT INTO z_itens (id, nome) VALUES ('".$item["id"]."', '".addslashes($item["nome"])."')");
				if($item["atributos"] and is_array($item["atributos"])){
					foreach($item["atributos"] as $atributo => $valor){
						if(!is_array($valor))
							mysql_query("INSERT INTO z_itens_atributos (item, atributo, valor) VALUES ('".$item["id"]."', '$atributo', '$valor')");
						else{
							mysql_query("INSERT INTO z_itens_atributos (item, atributo) VALUES ('".$item["id"]."', '$atributo')");
							$atributo_id = mysql_insert_id();
							foreach($valor as $atributo2 => $valor2)
								mysql_query("INSERT INTO z_itens_atributos_atributos (atributo_id, atributo, valor) VALUES ('$atributo_id', '$atributo2', '$valor2')");
						}
					}
				}
			}
		}
		public function getInfoReceita($receita, $material = false){
			$exibirReceita = array();
			$itens = array($receita["item"]);
			$exibirMateriais = "";
			$materiaisNecessarios = array();
			if($material){
				foreach($receita as $c => $v){
					if($c == "materiais"){
						$materiais = explode(";", $v);
						foreach($materiais as $materialInfo){
							if(!empty($materialInfo)){
								$materialInfo = explode(",", $materialInfo);
								$materiaisNecessarios[$materialInfo[0]] = $materialInfo[1];
								$itens[] = $materialInfo[0];
							}
						}
					}
				}
				if($receita["ingredienteSecreto"]){
					$ingredienteSecreto = explode(",", $receita["ingredienteSecreto"]);
					$itens[] = $ingredienteSecreto[0];
				}
			}
			$itens[] = $receita["ferramenta"];
			$itensInfo = $this->getItemInfoSQL($itens);
			if(count($materiaisNecessarios) > 0){
				$exibirMateriais .= '
					<table cellpadding="0" cellspacing="0">
						';
						foreach($materiaisNecessarios as $materialId => $materialQuantidade){
							$materialInfo = $itensInfo[$materialId];
							$exibirMateriais .= '
								<tr>
									<td>
										<a href="'.$materialInfo["url"].'">
											'.$materialInfo["imagem"].'
										</a>
									</td>
									<td>
										<b>'.$materialQuantidade.' -</b>
										<a href="'.$materialInfo["url"].'">
											'.$materialInfo["nome"].'
										</a>
										
									</td>
								</tr>
							';
						}
						$exibirMateriais .= '
					</table>
				';
			}
			$ferramentaInfo = $itensInfo[$receita["ferramenta"]];
			$exibirFerramenta = '
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<a href="'.$ferramentaInfo["url"].'">
								'.$ferramentaInfo["imagem"].'
							</a>
						</td>
						<td>
							<a href="'.$ferramentaInfo["url"].'">'.$ferramentaInfo["nome"].'</a>
						</td>
					</tr>
				</table>
			';
			if($receita["ingredienteSecreto"]){
				$ingredienteSecretoInfo = $itensInfo[$ingredienteSecreto[0]];
				$ingredienteSecreto = '
					<table cellpadding="0" cellspacing="0">
						<tr>
							<td>
								<a href="'.$ingredienteSecretoInfo["url"].'">
									'.$ingredienteSecretoInfo["imagem"].'
								</a>
							</td>
							<td>
								<a href="'.$ingredienteSecretoInfo["url"].'">'.$ingredienteSecreto[1].' - '.$ingredienteSecretoInfo["nome"].'</a> - <b>Chance Adicional:</b> '.number_format($ingredienteSecreto[2]/100, 2, ".", "").'%
							</td>
						</tr>
					</table>
				';
			}
			else
				$ingredienteSecreto = '
					Essa receita não possui ingrediente secreto.
				';
			$itemInfo = $itensInfo[$receita["item"]];
			$nomeReceita = $receita["nome"];
			if(empty($nomeReceita))
				$nomeReceita = $itemInfo["nome"];
			if(is_array($itemInfo))
				$exibirReceita = array(
					"profissao" => $receita["profissao"],
					"item" => $receita["item"],
					"nome" => $nomeReceita,
					"quantidade" => $receita["quantidade"],
					"nivel" => $receita["nivel"],
					"nivelJogador" => $receita["nivelJogador"],
					"ferramenta" => $exibirFerramenta,
					"fabricarQuantidade" => ($receita["fabricarQuantidade"] == 1 ? "Sim" : "Não"),
					"ingredienteSecreto" => $ingredienteSecreto,
					"tempo" => ($receita["tempo"] == 0 ? "Instantâneo" : $receita["tempo"]." segundo".($receita["tempo"] == 1 ? "" : "s")),
					"experiencia" => $receita["experiencia"],
					"pontos" => $receita["pontos"]." ponto".($receita["pontos"] == 1 ? "" : "s"),
					"chanceSucesso" => number_format($receita["chanceSucesso"]/100, 2, ".", "").'%',
					"maxChanceSucesso" => number_format(($receita["maxChanceSucesso"] > 0 ? $receita["maxChanceSucesso"] : 10000)/100, 2, ".", "").'%',
					"aprender" => ($receita["aprender"] == 1 ? "Sim" : "Não"),
					"imagem" => $itemInfo["imagem"],
					"url" => $itemInfo["url"],
					"exibirMateriais" => $exibirMateriais,
					"material" => $material
				);
			return $exibirReceita;
		}
		public function pegarReceitasItem($item, $tipo){
			$receitas = array();
			if($tipo == "fabricacao"){
				$queryReceitas = mysql_query("SELECT * FROM z_receitas WHERE (item LIKE '$item')");
				while($resultadoReceitas = mysql_fetch_assoc($queryReceitas))
					$receitas[] = $this->getInfoReceita($resultadoReceitas, true);
			}
			elseif($tipo == "ferramenta"){
				$queryReceitas = mysql_query("SELECT * FROM z_receitas WHERE (ferramenta LIKE '$item')");
				while($resultadoReceitas = mysql_fetch_assoc($queryReceitas))
					$receitas[] = $this->getInfoReceita($resultadoReceitas);
			}
			elseif($tipo == "materiais"){
				$queryReceitas = mysql_query("SELECT * FROM z_receitas WHERE (materiais LIKE '%$item%')");
				while($resultadoReceitas = mysql_fetch_assoc($queryReceitas)){
					$inserir = false;
					$materiais = explode(";", $resultadoReceitas["materiais"]);
					foreach($materiais as $material){
						if(!$inserir){
							$material = explode(",", $material);
							if($material[0] == $item)
								$inserir = true;
						}
					}
					if($inserir)
						$receitas[] = $this->getInfoReceita($resultadoReceitas);
				}
			}
			$exibirReceita = "";
			if(count($receitas) > 0){
				foreach($receitas as $receitaInfo){
					$exibirNome = "";
					if($receitaInfo["material"]){
						if(count($receitas) > 1)
							$exibirReceita .= '
								<tr class="cabecalho">
									<td colspan="2">
										<b>'.$receitaInfo["quantidade"].' '.$receitaInfo["nome"].'</b>
									</td>
								</tr>
							';
						$exibirReceita .= '
							<tr class="item">
								<td width="250" align="center">
									<b>Profissão:</b>
								</td>
								<td>
									<a href="?p=profissao-'.$receitaInfo["profissao"].'">'.$receitaInfo["profissao"].'</a>
								</td>
							</tr>
							<tr class="item">
								<td align="center">
									<b>Quantidade Produzida:</b>
								</td>
								<td>
									'.$receitaInfo["quantidade"].'
								</td>
							</tr>
							<tr class="item">
								<td align="center">
									<b>Nível de Profissão:</b>
								</td>
								<td>
									'.$receitaInfo["nivel"].'
								</td>
							</tr>
							<tr class="item">
								<td align="center">
									<b>Nível de Jogador:</b>
								</td>
								<td>
									'.$receitaInfo["nivelJogador"].'
								</td>
							</tr>
							<tr class="item">
								<td align="center">
									<b>Tempo de Fabricação:</b>
								</td>
								<td>
									'.$receitaInfo["tempo"].'
								</td>
							</tr>
							<tr class="item">
								<td align="center">
									<b>Experiência (Profissão):</b>
								</td>
								<td>
									'.$receitaInfo["experiencia"].'
								</td>
							</tr>
							<tr class="item">
								<td align="center">
									<b>Pontos (Profissão):</b>
								</td>
								<td>
									'.$receitaInfo["pontos"].'
								</td>
							</tr>
							<tr class="item">
								<td align="center">
									<b>Chance de Sucesso:</b>
								</td>
								<td>
									'.$receitaInfo["chanceSucesso"].'
								</td>
							</tr>
							<tr class="item">
								<td align="center">
									<b>Chance de Sucesso Máxima:</b>
								</td>
								<td>
									'.$receitaInfo["maxChanceSucesso"].'
								</td>
							</tr>
							<tr class="item">
								<td align="center">
									<b>Ferramenta:</b>
								</td>
								<td>
									'.$receitaInfo["ferramenta"].'
								</td>
							</tr>
							<tr class="item">
								<td align="center">
									<b>Materiais:</b>
								</td>
								<td>
									'.$receitaInfo["exibirMateriais"].'
								</td>
							</tr>
							<tr class="item">
								<td align="center">
									<b>Pode Fabricar em Quantidade?</b>
								</td>
								<td>
									'.$receitaInfo["fabricarQuantidade"].'
								</td>
							</tr>
						';
						if($receitaInfo["ingredienteSecreto"])
							$exibirReceita .= '
								<tr class="item">
									<td align="center">
										<b>Ingrediente Secreto:</b>
									</td>
									<td>
										'.$receitaInfo["ingredienteSecreto"].'
									</td>
								</tr>
							';
						$exibirReceita .= '
							<tr class="item">
								<td align="center">
									<b>Necessário Aprender?</b>
								</td>
								<td>
									'.$receitaInfo["aprender"].'
								</td>
							</tr>
						';
					}
					else{
						if(count($receitaInfo) > 0)
							$exibirReceita .= '
								<tr class="item">
									<td width="50" align="center">
										<a href="'.$receitaInfo["url"].'">'.$receitaInfo["imagem"].'</a>
									</td>
									<td>
										<a href="'.$receitaInfo["url"].'">'.$receitaInfo["nome"].'</a>
									</td>
								</tr>
							';
					}
				}
			}
			return $exibirReceita;
		}
		public function pegarTodosItensReceitas(){
			$itens = array();
			$queryReceitas = mysql_query("SELECT * FROM z_receitas");
			while($resultadoReceitas = mysql_fetch_assoc($queryReceitas)){
				if(!in_array($resultadoReceitas["item"], $itens))
					$itens[] = $resultadoReceitas["item"];
				if(!in_array($resultadoReceitas["ferramenta"], $itens))
					$itens[] = $resultadoReceitas["ferramenta"];
				$materiais = explode(";", $resultadoReceitas["materiais"]);
				foreach($materiais as $material){
					$material = explode(",", $material);
					if((!empty($material[0])) and (!in_array($material[0], $itens)))
						$itens[] = $material[0];
				}
				$ingredienteSecretoInfo = explode(";", $resultadoReceitas["ingredienteSecreto"]);
				foreach($ingredienteSecretoInfo as $ingredienteSecreto){
					$ingredienteSecreto = explode(",", $ingredienteSecreto);
					if((!empty($ingredienteSecreto[0])) and (!in_array($ingredienteSecreto[0], $itens)))
						$itens[] = $ingredienteSecreto[0];
				}
			}
			return $itens;
		}
		public function pegarTodosItensCriaturas(){
			$itens = array();
			$queryMonstrosLoot = mysql_query("SELECT * FROM z_monstros_loot");
			while($resultadoMonstrosLoot = mysql_fetch_assoc($queryMonstrosLoot)){
				if(!in_array($resultadoMonstrosLoot["item_id"], $itens))
					$itens[] = $resultadoMonstrosLoot["item_id"];
			}
			return $itens;
		}
		public function pegarTodosItensNpcs(){
			$itens = array();
			$queryNpcs = mysql_query("SELECT * FROM z_npcs_itens");
			while($resultadoNpcs = mysql_fetch_assoc($queryNpcs)){
				if(!in_array($resultadoNpcs["item"], $itens))
					$itens[] = $resultadoNpcs["item"];
			}
			return $itens;
		}
		public function pegarTodosItens(){
			return array_merge(
				$this->pegarTodosItensReceitas(),
				$this->pegarTodosItensCriaturas(),
				$this->pegarTodosItensNpcs()
			);
		}
		public function pegarNpcsInfo($npcs){
			$npcsInfo = array();
			$localizarNpcs = " WHERE ";
			foreach($npcs as $c => $npcId){
				if($c > 0)
					$localizarNpcs .= " or ";
				$localizarNpcs .= "(id LIKE '$npcId')";
			}
			$queryNpcs = mysql_query("SELECT * FROM z_npcs$localizarNpcs");
			while($resultadoNpcs = mysql_fetch_assoc($queryNpcs))
				$npcsInfo[$resultadoNpcs["id"]] = $resultadoNpcs["nome"];
			return $npcsInfo;
		}
		public function formatarNpcItem($item, $npcs){
			return '
				<tr class="item" align="center">
					<td>
						<a href="'.$item["link"].'">'.$npcs[$item["npc"]].'</a>
					</td>
					<td>
						'.$item["valor"].' gp
					</td>
				</tr>
			';
		}
		public function exibirNpcsItem($item){
			$npcsCompram = array();
			$npcsVendem = array();
			$npcs = array();
			$queryNpcsItem = mysql_query("SELECT * FROM z_npcs_itens WHERE (item LIKE '$item')");
			while($resultadoNpcsItem = mysql_fetch_assoc($queryNpcsItem)){
				$npcItem = array(
					"npc" => $resultadoNpcsItem["npc"],
					"valor" => $resultadoNpcsItem["valor"],
					"link" => '?p=npcs-'.$resultadoNpcsItem["npc"]
				);
				$npcs[] = $resultadoNpcsItem["npc"];
				if($resultadoNpcsItem["acao"] == "c")
					$npcsCompram[] = $npcItem;
				elseif($resultadoNpcsItem["acao"] == "v")
					$npcsVendem[] = $npcItem;
			}
			if((count($npcs) > 0))
				$npcs = $this->pegarNpcsInfo($npcs);
			$exibirCompradores = "Jogadores".(count($npcsCompram) > 0 ? " e NPCs listados" : "").".";
			$exibirVendedores = "Jogadores".(count($npcsVendem) > 0 ? " e NPCs listados" : "").".";
			$exibirNpcsCompram = '
				<tr class="item" align="center">
					<td colspan="2" height="40">
						<b>'.$exibirCompradores.'</b>
					</td>
				</tr>
			';
			$exibirNpcsVendem = '
				<tr class="item" align="center">
					<td colspan="2" height="40">
						<b>'.$exibirVendedores.'</b>
					</td>
				</tr>
			';
			$cabecalhoNpcs = '
				<tr class="cabecalho" align="center">
					<td>
						<b>NPC</b>
					</td>
					<td>
						<b>Valor</b>
					</td>
				</tr>
			';
			$exibirNpcsCompram .= (count($npcsCompram) > 0 ? $cabecalhoNpcs : "");
			$exibirNpcsVendem .= (count($npcsVendem) > 0 ? $cabecalhoNpcs : "");
			foreach($npcsCompram as $npcItem)
				$exibirNpcsCompram .= $this->formatarNpcItem($npcItem, $npcs);
			foreach($npcsVendem as $npcItem)
				$exibirNpcsVendem .= $this->formatarNpcItem($npcItem, $npcs);
			return array($exibirNpcsCompram, $exibirNpcsVendem);
		}
		public function pegarExibicaoMenus($id = ""){
			$exibirMenus = "";
			if((!empty($id)) and (is_numeric($id)))
				$queryMenus = mysql_query("SELECT * FROM z_itens_menus WHERE (id LIKE '$id')");
			else
				$queryMenus = mysql_query("SELECT * FROM z_itens_menus ORDER BY ordem ASC");
			while($resultadoMenus = mysql_fetch_assoc($queryMenus)){
				$exibirMenus .= '
					<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
						<tr class="cabecalho">
							<td colspan="2">
								'.$resultadoMenus["nome"].'
							</td>
						</tr>
						';
						$queryCategorias = mysql_query("SELECT * FROM z_itens_categorias WHERE (menu LIKE '".$resultadoMenus["id"]."') ORDER BY ordem ASC");
						while($resultadoCategorias = mysql_fetch_assoc($queryCategorias)){
							$nomeCategoria = $resultadoCategorias["nome"];
							$linkCategoria = '?p=itens-categorias-'.$resultadoCategorias["id"];
							$imagemCategoria = "imagens/itens/".$resultadoCategorias["item_imagem"].".gif";
							if(!is_file($imagemCategoria))
								$imagemCategoria = 'imagens/itens/item_nao_encontrado.png';
							$imagemCategoria = '<img src="'.$imagemCategoria.'" title="'.$nomeCategoria.'" />';
							$exibirMenus .= '
								<tr class="item">
									<td width="50" align="center">
										<a href="'.$linkCategoria.'">'.$imagemCategoria.'</a>
									</td>
									<td>
										<a href="'.$linkCategoria.'">'.$nomeCategoria.'</a>
									</td>
								</tr>
							';
						}
						$exibirMenus .= '
					</table>
					<br>					
				';
			}
			if(empty($exibirMenus))
				$exibirMenus = $ClassFuncao->pegarConteudoNaoEncontrado();
			else{
				$setaVoltar = '';
				if(!empty($id))
					$setaVoltar = '
						<div class="setas">
							<div class="seta voltar">
								<a href="?p=itens"><img src="imagens/corpo/arrow_up.gif" /> voltar</a>
							</div>
						</div>
					';
				$exibirMenus = '
					'.$setaVoltar.'
					'.$this->pegarBuscaItem().'
					'.$exibirMenus.'
				';
			}
			return $exibirMenus;
		}
		public function pegarExibicaoCategoria($id){
			$exibirCategoria = "";
			$queryCategoria = mysql_query("SELECT * FROM z_itens_categorias WHERE (id LIKE '$id')");
			while($resultadoCategoria = mysql_fetch_assoc($queryCategoria)){
				$menuId = $resultadoCategoria["menu"];
				$exibirCategoria .= '
					<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
						<tr class="cabecalho">
							<td colspan="2">
								'.$resultadoCategoria["nome"].'
							</td>
						</tr>
						';
						$itens = array();
						$queryCategoriaItens = mysql_query("SELECT * FROM z_itens_categorias_itens WHERE (categoria LIKE '$id')");
						while($resultadoCategoriaItens = mysql_fetch_assoc($queryCategoriaItens)){
							$itens[] = $resultadoCategoriaItens["item"];
						}
						$itensInfo = $this->getItemInfoSQL($itens);
						foreach($itens as $item){
							$itemInfo = $itensInfo[$item];
							$exibirCategoria .= '
								<tr class="item">
									<td width="30" align="center">
										<a href="'.$itemInfo["url"].'">'.$itemInfo["imagem"].'</a>
									</td>
									<td>
										<a href="'.$itemInfo["url"].'">'.$itemInfo["nome"].'</a>
									</td>
								</tr>
							';
						}
						if(count($itens) == 0)
							$exibirCategoria .= '
								<tr class="item">
									<td colspan="2" height="100" align="center">
										<b>Essa categoria está vazia.</b>
									</td>
								</tr>
							';
						$exibirCategoria .= '
					</table>
					<br>					
				';
			}
			if(empty($exibirCategoria))
				$exibirCategoria = $ClassFuncao->pegarConteudoNaoEncontrado();
			else
				$exibirCategoria = '
					<div class="setas">
						<div class="seta voltar">
							<a href="?p=itens-menus-'.$menuId.'"><img src="imagens/corpo/arrow_up.gif" /> voltar</a>
						</div>
					</div>
					'.$this->pegarBuscaItem().'
					'.$exibirCategoria.'
				';
			return $exibirCategoria;
		}
		public function inserirItensCategoria(){
			$categoriasSlotType = array(
				1 => "head",
				2 => "body",
				4 => "legs",
				6 => "feet"
			);
			$categoriasWeaponType = array(
				3 => "shield",
				5 => "spellbook",
				7 => "axe",
				8 => "club",
				9 => "sword",
				10 => "rod",
				11 => "wand",
				12 => "distance",
				13 => "ammunition"
			);
			$categoriasProfissoes = array(
				14 => "ferreiro",
				15 => "alfaiate",
				16 => "alquimista",
				17 => "cozinheiro",
			);
			mysql_query("TRUNCATE TABLE z_itens_categorias_itens");
			foreach($categoriasSlotType as $categoriaId => $slotType){
				$queryItensCategoria = mysql_query("SELECT * FROM z_itens_atributos WHERE ((atributo LIKE 'slotType') AND (valor LIKE '$slotType'))");
				while($resultadoItensCategoria = mysql_fetch_assoc($queryItensCategoria))
					mysql_query("INSERT INTO z_itens_categorias_itens (categoria, item) VALUES ('$categoriaId', '".$resultadoItensCategoria["item"]."')");
			}
			foreach($categoriasWeaponType as $categoriaId => $weaponType){
				$checkWeaponType = $weaponType;
				if($weaponType == "spellbook")
					$checkWeaponType = "shield";
				elseif($weaponType == "rod")
					$checkWeaponType = "wand";
				$queryItensCategoria = mysql_query("SELECT * FROM z_itens_atributos WHERE ((atributo LIKE 'weaponType') AND (valor LIKE '$checkWeaponType'))");
				while($resultadoItensCategoria = mysql_fetch_assoc($queryItensCategoria)){
					$itemId = $resultadoItensCategoria["item"];
					if($checkWeaponType == "shield"){
						$checarML = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM z_itens_atributos WHERE ((item LIKE '$itemId') AND (atributo LIKE 'magiclevelpoints'))"));
						$checarML = $checarML["total"];
						$itemInfo = $this->getItemInfoSQL($itemId);
						$itemNome = $itemInfo[$itemId]["nome"];
						if((strpos(strtolower($itemNome), "spellbook") !== false) or ($checarML > 0))
							$realWeaponType = "spellbook";
						else
							$realWeaponType = "shield";
					}
					elseif($checkWeaponType == "wand"){
						$itemInfo = $this->getItemInfoSQL($itemId);
						$itemNome = $itemInfo[$itemId]["nome"];
						if(strpos(strtolower($itemNome), "rod") !== false)
							$realWeaponType = "rod";
						else
							$realWeaponType = "wand";
					}
					if	((($weaponType == "shield") and ($realWeaponType == "shield")) or
						(($weaponType == "spellbook") and ($realWeaponType == "spellbook")) or
						(($weaponType == "rod") and ($realWeaponType == "rod")) or
						(($weaponType == "wand") and ($realWeaponType == "wand")) or
						(($checkWeaponType != "shield") and ($checkWeaponType != "wand")))
						mysql_query("INSERT INTO z_itens_categorias_itens (categoria, item) VALUES ('$categoriaId', '$itemId')");
				}
			}
			foreach($categoriasProfissoes as $categoriaId => $profissao){
				$queryItensCategoria = mysql_query("SELECT * FROM z_receitas WHERE (profissao LIKE '".ucfirst($profissao)."')");
				while($resultadoItensCategoria = mysql_fetch_assoc($queryItensCategoria)){
					$itemId = $resultadoItensCategoria["item"];
					$checarReceita = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM z_itens_categorias_itens WHERE ((categoria LIKE '$categoriaId') AND (item LIKE '$itemId'))"));
					$checarReceita = $checarReceita["total"];
					if($checarReceita == 0)
						mysql_query("INSERT INTO z_itens_categorias_itens (categoria, item) VALUES ('$categoriaId', '$itemId')");
				}
			}
		}
		public function pegarCategoriaItem($id){
			$categoria = array();
			$queryCategoria = mysql_query("SELECT * FROM z_itens_categorias_itens WHERE (item LIKE '$id')");
			while($resultadoCategoria = mysql_fetch_assoc($queryCategoria))
				$categoria[] = $resultadoCategoria["categoria"];
			$quantidadeCategoria = count($categoria);
			if($quantidadeCategoria == 0)
				return 0;
			elseif($quantidadeCategoria == 1)
				return $categoria[0];
			else
				return $categoria;
		}
		public function pegarBuscaItem($busca = ""){
			return '
				<form method="POST" action="?p=itens-buscar">
				<table class="tabela dark" cellpadding="0" cellspacing="0" width="100%">
					<tr class="cabecalho">
						<td>
							Buscar Itens
						</td>
					</tr>
					<tr class="item">
						<td>
							Item: <input type="text" name="busca" id="buscar_itens" value="'.$busca.'"> <input type="submit" class="botao" value="Procurar">
						</td>
					</tr>
				</table>
				</form>
				<br>
			';
		}
		public function exibirBuscaItem($busca){
			$checarBuscaExata = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM z_itens WHERE (nome LIKE '$busca')"));
			$checarBuscaExata = $checarBuscaExata["total"];
			$queryBusca = $busca;
			if($checarBuscaExata != 1)
				$queryBusca = "%$busca%";
			$itens = array();
			$queryBuscaItem = mysql_query("SELECT * FROM z_itens WHERE (nome LIKE '$queryBusca')");
			while($resultadoBuscaItem = mysql_fetch_assoc($queryBuscaItem))
				$itens[] = $resultadoBuscaItem["id"];
			$itensInfo = $this->getItemInfoSQL($itens);
			if(count($itens) == 1){
				header("Location: ".$itensInfo[$itens[0]]["url"]);
				exit;
			}
			$exibirBusca .= '
				'.$this->pegarBuscaItem($busca).'
				<table class="tabela odd" cellpadding="0" cellspacing="0" width="100%">
					<tr class="cabecalho">
						<td colspan="2">
							Resultados da Busca por "'.$busca.'"
						</td>
					</tr>
					';
					foreach($itens as $itemId){
						$itemInfo = $itensInfo[$itemId];
						$exibirBusca .= '
							<tr class="item">
								<td width="30" align="center">
									<a href="'.$itemInfo["url"].'">'.$itemInfo["imagem"].'</a>
								</td>
								<td>
									<a href="'.$itemInfo["url"].'">'.$itemInfo["nome"].'</a>
								</td>
							</tr>
						';
					}
					if(count($itens) == 0)
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
		public function exibirImagem($itemId, $titulo){
			return '<img src="imagens/itens/'.$itemId.'.gif" alt="" title="'.$titulo.'" />';
		}
	}
?>