<?php
	class Items {
		public function loadXML(){
			return simplexml_load_file("../arquivos/itens/items.xml");
		}
		public function formatItemName($name){
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
			return $this->getItemInfo($ids);
		}
		public function getItemInfo($ids){
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
				if(!empty($item_name))
					$resultado_item["nome"] = $this->formatItemName($item_name);
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
						$resultado_item_final["imagem"] = '<img src="'.$item_imagem.'" title="'.$item_id.'"/>';
					$resultado_itens[$item_id] = $resultado_item_final;
				}
			}
			if(count($ids) != count($resultado_itens)){
				foreach($ids as $id){
					if(!array_key_exists($id, $resultado_itens)){
						$item_imagem = "imagens/itens/$id.gif";
						if(is_file($item_imagem)){
							$item_imagem = '<img src="'.$item_imagem.'" title="'.$item_id.'"/>';
							$resultado_item = array(
								"id" => $id,
								"nome" => "Item sem nome",
								"imagem" => $item_imagem
							);
							$resultado_itens[$id] = $resultado_item;
						}
						else
							$resultado_itens[$id] = "Item não encontrado";
					}
				}
			}
			ksort($resultado_itens);
			return $resultado_itens;
		}
		public function comparar(){
			$xml1 = simplexml_load_file("itens/items1.xml");
			$xml2 = simplexml_load_file("itens/items2.xml");
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
	}
?>