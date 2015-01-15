<?php
	set_time_limit(3600);
	class Criaturas {
		private $diretorio = "arquivos/monster/";
		private $formatar = array(
			"fire" => array("Fogo", "elemento"),
			"ice" => array("Gelo", "elemento"),
			"energy" => array("Energia", "elemento"),
			"earth" => array("Terra", "elemento"),
			"death" => array("Morte", "elemento"),
			"holy" => array("Sagrado", "elemento"),
			"physical" => array("Físico", "elemento"),
			"paralyze" => array("Paralisia", "imunidade"),
			"invisible" => array("Invisível", "imunidade"),
			"drunk" => array("Bêbado", "imunidade"),
			"bleeding" => array("Sangramento", "imunidade")
		);
		public function loadXML($arquivo = "monsters.xml"){
			return simplexml_load_file($this->diretorio.$arquivo);
		}
		public function loadSQLQuery($tabela, $colunas, $valores){
			foreach($valores as $c => $v)
				$valores[$c] = "'".addslashes($v)."'";
			return "INSERT INTO `$tabela` (".implode(",", $colunas).") VALUES (".implode(",", $valores).");";
		}
		public function getIconesElementos(){
			$icones = array();
			foreach($this->formatar as $c => $icone){
				if($icone[1] == "elemento")
					$icones[] = '<img src="imagens/icones/'.$c.'_icone.gif" title="'.$icone[0].'" alt="" />';
			}
			return implode(" ", $icones);
		}
		public function formatarNomeIcone($nome){
			if(isset($this->formatar[$nome]))
				return $this->formatar[$nome][0];
			return ucwords($nome);
		}
		public function formatarNomeHabilidade($nome, $tipo){
			$formatar = array(
				"melee" => "Corpo-a-corpo",
				"manadrain" => "Mana Drain",
				"speed ataque" => "Paralisia",
				"speed defesa" => "Speed Up",
				"healing" => "Cura",
			);
			if(isset($formatar[$nome]))
				return $formatar[$nome];
			if(isset($formatar[$nome.' '.$tipo]))
				return $formatar[$nome.' '.$tipo];
			return ucwords($nome);
		}
		public function calcularDanoHabilidade($habilidade){
			$danoMin = 0;
			$danoMax = 0;
			if(isset($habilidade["min"]))
				$danoMin = abs($habilidade["min"]);
			if(isset($habilidade["max"]))
				$danoMax = abs($habilidade["max"]);
			if((isset($habilidade["skill"])) AND (isset($habilidade["attack"])))
				$danoMax = ($habilidade["skill"]*($habilidade["attack"]*0.05))+($habilidade["attack"]*0.5);
			return array("min" => $danoMin, "max" => $danoMax);
		}
		public function calcularDanoMaximoCriatura($habilidades){
			$danoMaxCriatura = 0;
			foreach($habilidades as $habilidade)
				$danoMaxCriatura = $danoMaxCriatura+$this->calcularDanoHabilidade($habilidade)["max"];
			return $danoMaxCriatura;
		}
		public function calcularDanoMaximoCriaturaSummons($criatura){
			$danoMaxCriatura = 0;
			foreach($criatura["summons"] as $summon)
				$danoMaxCriatura += $this->calcularDanoMaximoCriatura($this->getCriaturaAtaques($summon["id"]));
			return $danoMaxCriatura;
		}
		public function getCriaturaAtaques($criaturaId){
			$ataques = array();
			$queryAtaques = mysql_query("SELECT * FROM z_monstros_ataques WHERE (monstro_id LIKE '$criaturaId')");
			while($resultadoAtaques = mysql_fetch_assoc($queryAtaques)){
				$ataqueId = $resultadoAtaques["id"];
				$ataques[$ataqueId] = array();
				$queryAtaquesAtributos = mysql_query("SELECT * FROM z_monstros_ataques_atributos WHERE (ataque_id LIKE '$ataqueId')");
				while($resultadoAtaquesAtributos = mysql_fetch_assoc($queryAtaquesAtributos))
					$ataques[$ataqueId][$resultadoAtaquesAtributos["atributo"]] = $resultadoAtaquesAtributos["valor"];
			}
			return $ataques;
		}
		public function getCriaturaDefesas($criaturaId){
			$defesas = array();
			$queryDefesas = mysql_query("SELECT * FROM z_monstros_defesas WHERE (monstro_id LIKE '$criaturaId')");
			while($resultadoDefesas = mysql_fetch_assoc($queryDefesas)){
				$defesaId = $resultadoDefesas["id"];
				$defesas[$defesaId] = array();
				$queryDefesasAtributos = mysql_query("SELECT * FROM z_monstros_defesas_atributos WHERE (defesa_id LIKE '$defesaId')");
				while($resultadoDefesasAtributos = mysql_fetch_assoc($queryDefesasAtributos))
					$defesas[$defesaId][$resultadoDefesasAtributos["atributo"]] = $resultadoDefesasAtributos["valor"];
			}
			return $defesas;
		}
		public function exibirHabilidade($habilidade, $tipo){
			$nomeHabilidade = $this->formatarNomeHabilidade($habilidade["name"], $tipo);
			$danoHabilidade = $this->calcularDanoHabilidade($habilidade);
			$danoMin = $danoHabilidade["min"];
			$danoMax = $danoHabilidade["max"];
			$exibirDano = "";
			if(($danoMin >= 0) AND ($danoMax > 0))
				$exibirDano = " ($danoMin-$danoMax)";
			return "<b>$nomeHabilidade</b>".$exibirDano;
		}
		public function exibirItem($item){
			$itemId = $item["item_id"];
			$itemQuantidade = $item["quantidade"];
			$itemChance = $item["chance"];
			$exibirQuantidade = "";
			if($itemQuantidade > 1)
				$exibirQuantidade = " (1-$itemQuantidade)";
			return "<b>$itemId</b>".$exibirQuantidade;
		}
		public function getImagemCriatura($criatura){
			$resultadoCriatura = $criatura;
			$imagemPadrao = "includes/classes/ClassOutfit.php?id=130&head=0&body=0&legs=0&feet=0";
			$arquivo = 'imagens/criaturas/'.str_replace(" ", "_", $criatura["name"]).'.gif';
			if(!is_file($arquivo)){
				if(!is_array($criatura)){
					$queryCriatura = mysql_query("SELECT * FROM z_monstros WHERE (monstro_id LIKE '$criatura')");
					$resultadoCriatura = mysql_fetch_assoc($queryCriatura);
					if(($resultadoCriatura["lookType"] == 0) OR (!is_dir("arquivos/outfits/".$resultadoCriatura["lookType"])))
						$arquivo = $imagemPadrao;
					else
						$arquivo = "includes/classes/ClassOutfit.php?id=".$resultadoCriatura["lookType"]."&head=".$resultadoCriatura["lookHead"]."&body=".$resultadoCriatura["lookBody"]."&legs=".$resultadoCriatura["lookLegs"]."&feet=".$resultadoCriatura["lookFeet"];
				}
				else{
					if(($criatura["lookType"] == 0) OR (!is_dir("arquivos/outfits/".$criatura["lookType"])))
						$arquivo = $imagemPadrao;
					else
						$arquivo = "includes/classes/ClassOutfit.php?id=".$criatura["lookType"]."&head=0&body=0&legs=0&feet=0";
				}
			}
			return $arquivo;
		}
		public function getNavegacaoCriatura($criaturaId){
			$listaCriaturas = array();
			$criaturaAnteriorNome = "";
			$proximaCriaturaNome = "";
			$colunas = array(
				"nome" => "name",
				"experiencia" => "experience",
				"vida" => "health"
			);
			$chaves = array("asc", "desc");
			$ultimaOrdem = (isset($_COOKIE["ultimaOrdem"]) ? $_COOKIE["ultimaOrdem"] : "nome-asc");
			$ultimaOrdem = explode("-", $ultimaOrdem);
			$ordenar = (isset($colunas[$ultimaOrdem[0]]) ? $colunas[$ultimaOrdem[0]] : "name");
			$ordenarPor = (in_array($ultimaOrdem[1], $chaves) ? $ultimaOrdem[1] : "asc");
			$queryCriaturas = mysql_query("SELECT * FROM z_monstros ORDER BY $ordenar $ordenarPor");
			while($resultadoCriaturas = mysql_fetch_assoc($queryCriaturas)){
				if($resultadoCriaturas["id"] == $criaturaId)
					$chaveCriatura = count($listaCriaturas);
				$listaCriaturas[] = urlencode($resultadoCriaturas["fileName"]);
			}
			if(isset($listaCriaturas[$chaveCriatura-1]))
				$criaturaAnterior = $listaCriaturas[$chaveCriatura-1];
			if(isset($listaCriaturas[$chaveCriatura+1]))
				$proximaCriatura = $listaCriaturas[$chaveCriatura+1];
			return array($criaturaAnterior, $proximaCriatura);
		}
		public function atualizarListaCriaturas(){
			require("conexao/conexao.php");
			$resultado = "";
			$tabelas = array(
				"z_monstros" => array(
					"id" => array("tipo" => "bigint", "tamanho" => 20, "primary" => 1, "auto_increment" => 1),
					"name" => array("tipo" => "varchar", "tamanho" => 255),
					"fileName" => array("tipo" => "varchar", "tamanho" => 255),
					"experience" => array("tipo" => "int", "tamanho" => 11),
					"speed" => array("tipo" => "int", "tamanho" => 11),
					"manaCost" => array("tipo" => "int", "tamanho" => 11),
					"health" => array("tipo" => "int", "tamanho" => 11),
					"lookType" => array("tipo" => "int", "tamanho" => 11),
					"lookHead" => array("tipo" => "int", "tamanho" => 11),
					"lookBody" => array("tipo" => "int", "tamanho" => 11),
					"lookLegs" => array("tipo" => "int", "tamanho" => 11),
					"lookFeet" => array("tipo" => "int", "tamanho" => 11),
					"maxSummons" => array("tipo" => "int", "tamanho" => 11),
					"ocultarCriatura" => array("tipo" => "int", "tamanho" => 1)
				),
				"z_monstros_flags" => array(
					"id" => array("tipo" => "bigint", "tamanho" => 20, "primary" => 1, "auto_increment" => 1),
					"monstro_id" => array("tipo" => "bigint", "tamanho" => 20),
					"atributo" => array("tipo" => "varchar", "tamanho" => 255),
					"valor" => array("tipo" => "int", "tamanho" => 11)
				),
				"z_monstros_ataques" => array(
					"id" => array("tipo" => "bigint", "tamanho" => 20, "primary" => 1, "auto_increment" => 1),
					"monstro_id" => array("tipo" => "bigint", "tamanho" => 20)
				),
				"z_monstros_ataques_atributos" => array(
					"id" => array("tipo" => "bigint", "tamanho" => 20, "primary" => 1, "auto_increment" => 1),
					"ataque_id" => array("tipo" => "bigint", "tamanho" => 20),
					"atributo" => array("tipo" => "varchar", "tamanho" => 255),
					"valor" => array("tipo" => "varchar", "tamanho" => 255)
				),
				"z_monstros_defesas" => array(
					"id" => array("tipo" => "bigint", "tamanho" => 20, "primary" => 1, "auto_increment" => 1),
					"monstro_id" => array("tipo" => "bigint", "tamanho" => 20)
				),
				"z_monstros_defesas_atributos" => array(
					"id" => array("tipo" => "bigint", "tamanho" => 20, "primary" => 1, "auto_increment" => 1),
					"defesa_id" => array("tipo" => "bigint", "tamanho" => 20),
					"atributo" => array("tipo" => "varchar", "tamanho" => 255),
					"valor" => array("tipo" => "varchar", "tamanho" => 255)
				),
				"z_monstros_elementos" => array(
					"id" => array("tipo" => "bigint", "tamanho" => 20, "primary" => 1, "auto_increment" => 1),
					"monstro_id" => array("tipo" => "bigint", "tamanho" => 20),
					"elemento" => array("tipo" => "varchar", "tamanho" => 255),
					"valor" => array("tipo" => "decimal", "tamanho" => 11)
				),
				"z_monstros_imunidades" => array(
					"id" => array("tipo" => "bigint", "tamanho" => 20, "primary" => 1, "auto_increment" => 1),
					"monstro_id" => array("tipo" => "bigint", "tamanho" => 20),
					"valor" => array("tipo" => "varchar", "tamanho" => 255)
				),
				"z_monstros_summons" => array(
					"id" => array("tipo" => "bigint", "tamanho" => 20, "primary" => 1, "auto_increment" => 1),
					"monstro_id" => array("tipo" => "bigint", "tamanho" => 20),
					"summon" => array("tipo" => "varchar", "tamanho" => 255),
					"max" => array("tipo" => "int", "tamanho" => 11)
				),
				"z_monstros_vozes" => array(
					"id" => array("tipo" => "bigint", "tamanho" => 20, "primary" => 1, "auto_increment" => 1),
					"monstro_id" => array("tipo" => "bigint", "tamanho" => 20),
					"valor" => array("tipo" => "varchar", "tamanho" => 255)
				),
				"z_monstros_loot" => array(
					"id" => array("tipo" => "bigint", "tamanho" => 20, "primary" => 1, "auto_increment" => 1),
					"monstro_id" => array("tipo" => "bigint", "tamanho" => 20),
					"item_id" => array("tipo" => "bigint", "tamanho" => 20),
					"quantidade" => array("tipo" => "int", "tamanho" => 11, "default" => 1),
					"chance" => array("tipo" => "int", "tamanho" => 11)
				)
			);
			foreach($tabelas as $nomeTabela => $coluna){
				$primaryKey = "";
				if((mysql_num_rows(mysql_query("SHOW TABLES LIKE '$nomeTabela'")) == 1)  AND (mysql_query("DROP TABLE IF EXISTS `$nomeTabela`")))
					$resultado .= 'Tabela antiga "<i>'.$nomeTabela.'</i>" removida.<br>';
				$sql = "CREATE TABLE IF NOT EXISTS `$nomeTabela` (";
				foreach($coluna as $colunaNome => $colunaInfo){
					$tipo = $colunaInfo["tipo"];
					$tamanho = $colunaInfo["tamanho"];
					$primary = $colunaInfo["primary"];
					$default = (!empty($colunaInfo["default"]) ? "default '".$colunaInfo["default"]."'" : "");
					$default = ($colunaInfo["auto_increment"] == 1 ? "auto_increment" : $default);
					$unsigned = "";
					if(($tipo == "int") OR ($tipo == "bigint") OR (!empty($colunaInfo["default"])) OR ($colunaInfo["auto_increment"] == 1))
						$unsigned = "unsigned";
					$sql .= "`$colunaNome` $tipo($tamanho) $unsigned NOT NULL $default,";
					if($primary == 1)
						$primaryKey = "PRIMARY KEY (`$colunaNome`)";
				}
				$sql .= $primaryKey;
				$sql .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8";
				if(mysql_query($sql))
					$resultado .= 'Tabela "<i>'.$nomeTabela.'</i>" criada com sucesso.<br>';
				else
					return 'Erro ao criar a tabela "<i>'.$nomeTabela.'</i>". - '.mysql_error().'<br>';
			}
			$listaCriaturas = $this->carregarListaCriaturas();
			if(count($listaCriaturas) > 0){
				foreach($listaCriaturas as $criatura){
					$tabela = "z_monstros";
					$colunas = array();
					$valores = array();
					foreach($tabelas[$tabela] as $colunaNome => $colunaInfo){
						if(empty($colunaInfo["auto_increment"])){
							$colunas[] = $colunaNome;
							$valores[] = $criatura[$colunaNome];
						}
					}
					$sql = $this->loadSQLQuery($tabela, $colunas, $valores);
					if(mysql_query($sql))
						$resultado .= 'Monstro "<b>'.$criatura["name"].'</b>" adicionado com sucesso na tabela "<i>'.$tabela.'</i>".<br>';
					else
						return 'Ocorreu um erro ao adicionar o monstro "<b>'.$criatura["name"].'</b>" na tabela "<i>'.$tabela.'</i>" - '.mysql_error().'.<br>';
					$monstro_id = mysql_insert_id();
					$resultado .= 'Monstro ID: '.$monstro_id.'<br>';
					$flags = $criatura["flags"];
					$tabela = "z_monstros_flags";
					if(is_array($flags)){
						foreach($flags as $a => $b){
							$colunas = array("monstro_id", "atributo", "valor");
							$valores = array($monstro_id, $a, $b);
							$sql = $this->loadSQLQuery($tabela, $colunas, $valores);
							if(mysql_query($sql))
								$resultado .= 'Flag "<i>'.$a.'</i>" adicionada com sucesso na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.'.<br>';
							else
								return 'Ocorreu um erro ao adicionar a flag "<i>'.$a.'</i>" na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.' - '.mysql_error().'.<br>';
						}
					}
					$ataques = $criatura["ataques"];
					$tabela = "z_monstros_ataques";
					$tabela_atributos = $tabela."_atributos";
					if(is_array($ataques)){
						foreach($ataques as $a => $b){
							$colunas = array("monstro_id");
							$valores = array($monstro_id);
							$sql = $this->loadSQLQuery($tabela, $colunas, $valores);
							if(mysql_query($sql)){
								if((!empty($ataques["name"])) AND ($a != "name"))
									continue;
								elseif(!empty($ataques["name"]))
									$b = $ataques;
								$resultado .= 'Ataque "<i>'.$b["name"].'</i>" adicionado com sucesso na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.'.<br>';
								$ataque_id = mysql_insert_id();
								foreach($b as $c => $d){
									$colunas = array("ataque_id", "atributo", "valor");
									$valores = array($ataque_id, $c, $d);
									$sql = $this->loadSQLQuery($tabela_atributos, $colunas, $valores);
									if(mysql_query($sql))
										$resultado .= 'Atributo "<i>'.$c.'</i>" adicionado com sucesso na tabela "<i>'.$tabela_atributos.'</i>" para o ataque "<i>'.$b["name"].'</i>".<br>';
									else
										return 'Ocorreu um erro ao adicionar o atributo "<i>'.$c.'</i>" na tabela "<i>'.$tabela_atributos.'</i>" para o ataque '.$b["name"].' - '.mysql_error().'.<br>';
								}
							}
							else
								return 'Ocorreu um erro ao adicionar o ataque "<i>'.$b["name"].'</i>" na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.' - '.mysql_error().'.<br>';
						}
					}
					$defesas = $criatura["defesas"];
					$tabela = "z_monstros_defesas";
					$tabela_atributos = $tabela."_atributos";
					if(is_array($defesas)){
						foreach($defesas as $a => $b){
							$colunas = array("monstro_id");
							$valores = array($monstro_id);
							$sql = $this->loadSQLQuery($tabela, $colunas, $valores);
							if(mysql_query($sql)){
								if((!empty($defesas["name"])) AND ($a != "name"))
									continue;
								elseif(!empty($defesas["name"]))
									$b = $defesas;
								$resultado .= 'Defesa "<i>'.$b["name"].'</i>" adicionada com sucesso na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.'.<br>';
								$defesa_id = mysql_insert_id();
								foreach($b as $c => $d){
									$colunas = array("defesa_id", "atributo", "valor");
									$valores = array($defesa_id, $c, $d);
									$sql = $this->loadSQLQuery($tabela_atributos, $colunas, $valores);
									if(mysql_query($sql))
										$resultado .= 'Atributo "<i>'.$c.'</i>" adicionado com sucesso na tabela "<i>'.$tabela_atributos.'</i>" para a defesa "<i>'.$b["name"].'</i>".<br>';
										// $resultado["defesas"][count($resultado["defesas"])-1]["atributos"][] = 'Atributo "<i>'.$c.'</i>" adicionado com sucesso na tabela "<i>'.$tabela_atributos.'</i>" para a defesa "<i>'.$b["name"].'</i>".<br>';
									else
										return 'Ocorreu um erro ao adicionar o atributo "<i>'.$c.'</i>" na tabela "<i>'.$tabela_atributos.'</i>" para a defesa '.$b["name"].' - '.mysql_error().'.<br>';
								}
							}
							else
								return 'Ocorreu um erro ao adicionar a defesa "<i>'.$b["name"].'</i>" na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.' - '.mysql_error().'.<br>';
						}
					}
					$elementos = $criatura["elementos"];
					$tabela = "z_monstros_elementos";
					if(is_array($elementos)){
						foreach($elementos as $a => $b){
							$colunas = array("monstro_id", "elemento", "valor");
							$valores = array($monstro_id, $a, $b);
							$sql = $this->loadSQLQuery($tabela, $colunas, $valores);
							if(mysql_query($sql))
								$resultado .= 'Elemento "<i>'.$a.'</i>" adicionado com sucesso na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.'.<br>';
							else
								return 'Ocorreu um erro ao adicionar o elemento "<i>'.$a.'</i>" na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.' - '.mysql_error().'.<br>';
						}
					}
					$imunidades = $criatura["imunidades"];
					$tabela = "z_monstros_imunidades";
					if(is_array($imunidades)){
						foreach($imunidades as $a => $b){
							$colunas = array("monstro_id", "valor");
							$valores = array($monstro_id, $a);
							$sql = $this->loadSQLQuery($tabela, $colunas, $valores);
							if(mysql_query($sql))
								$resultado .= 'Imunidade "<i>'.$a.'</i>" adicionada com sucesso na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.'.<br>';
							else
								return 'Ocorreu um erro ao adicionar a imunidade "<i>'.$a.'</i>" na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.' - '.mysql_error().'.<br>';
						}
					}
					$summons = $criatura["summons"];
					$tabela = "z_monstros_summons";
					if(is_array($summons)){
						$colunas = array();
						$valores = array();
						foreach($summons as $a => $b){
							if((!empty($summons["name"])) AND ($a != "name"))
								continue;
							elseif(!empty($summons["name"]))
								$b = $summons;
							$summonName = $b["name"];
							$summonMax = ($b["max"] > 1 ? $b["max"] : 1);
							$colunas = array("monstro_id", "summon", "max");
							$valores = array($monstro_id, $summonName, $summonMax);
							$sql = $this->loadSQLQuery($tabela, $colunas, $valores);
							if(mysql_query($sql))
								$resultado .= 'Summon "<i>'.$summonName.'</i>" adicionado com sucesso na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.'.<br>';
							else
								return 'Ocorreu um erro ao adicionar o summon "<i>'.$summonName.'</i>" na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.' - '.mysql_error().'.<br>';
						}
					}
					$vozes = $criatura["vozes"];
					$tabela = "z_monstros_vozes";
					if(is_array($vozes)){
						foreach($vozes as $a => $b){
							if((!empty($vozes["sentence"])) AND ($a != "sentence"))
								continue;
							elseif(!empty($vozes["sentence"]))
								$b = $vozes;
							$voz = htmlentities((string)$b["sentence"]);
							$colunas = array("monstro_id", "valor");
							$valores = array($monstro_id, $voz);
							$sql = $this->loadSQLQuery($tabela, $colunas, $valores);
							if(mysql_query($sql))
								$resultado .= 'Voz "<i>'.$voz.'</i>" adicionada com sucesso na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.'.<br>';
							else
								return 'Ocorreu um erro ao adicionar a voz "<i>'.$voz.'</i>" na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.' - '.mysql_error().'.<br>';
						}
					}
					$loot = $criatura["loot"];
					$tabela = "z_monstros_loot";
					if(is_array($loot)){
						foreach($loot as $a => $b){
							$item_id = $b["id"];
							$quantidade = (isset($b["quantidade"]) ? $b["quantidade"] : 1);
							$chance = $b["chance"];
							$colunas = array("monstro_id", "item_id", "quantidade", "chance");
							$valores = array($monstro_id, $item_id, $quantidade, $chance);
							$sql = $this->loadSQLQuery($tabela, $colunas, $valores);
							if(mysql_query($sql))
								$resultado .= 'Loot "<i>'.$b["id"].'</i>" adicionado com sucesso na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.'.<br>';
							else
								return 'Ocorreu um erro ao adicionar o loot "<i>'.$b["id"].'</i>" na tabela "<i>'.$tabela.'</i>" para o monstro '.$monstro_id.' - '.mysql_error().'.<br>';
						}
					}
				}
			}
			return $resultado;
		}
		public function carregarListaCriaturas(){
			$resultado = "";
			$xml = $this->loadXML();
			$listaCriaturas = array();
			foreach($xml->children() as $criatura){
				$criaturaAtributos = json_decode(json_encode($criatura->attributes()), true)["@attributes"];
				foreach($criaturaAtributos as $c => $v)
					$$c = $v;
				// $resultado .= 'Carregando monstro "<b>'.$name.'</b>". Arquivo: "<i>'.$file.'</i>"... ';
				$carregarCriatura = $this->carregarCriatura($file, $name);
				if($carregarCriatura){
					// $resultado .= '<b style="color: green;">Arquivo carregado com sucesso.</b><br>';
					$listaCriaturas[] = $carregarCriatura;
				}
				// else
					// $resultado .= '<b style="color: red;">Arquivo não foi carregado.</b><br>';
			}
			return $listaCriaturas;
		}
		public function carregarCriatura($arquivo, $nomeArquivo){
			if(!file_exists($this->diretorio.$arquivo))
				return false;
			$xml = $this->loadXML($arquivo);
			$getCriaturaChildrens = json_decode(json_encode($xml->children()), true);
			$getCriaturaAtributos = json_decode(json_encode($xml->attributes()), true)["@attributes"];
			$criaturaAtributos = array();
			foreach($getCriaturaAtributos as $chave => $valor)
				$criaturaAtributos[$chave] = $valor;
			$criatura = array();
			foreach($getCriaturaChildrens as $chave => $valor){
				if((empty($valor["@attributes"])) OR (count($valor) > 1)){
					foreach($valor as $a => $b){
						if($a == "comment")
							continue;
						foreach($b as $c => $d){
							if(is_array($d)){
								if(($c == "@attributes") AND (count($b) == 1))
									$criatura[$chave][$a] = $d;
								else{
									if((!empty($d["@attributes"])) AND (empty($b["@attributes"]))){
										$criatura[$chave][$a][] = array();
										$g = count($criatura[$chave][$a])-1;
										foreach($d["@attributes"] as $e => $f)
											$criatura[$chave][$a][$g][$e] = $f;
									}
									elseif(!empty($b["@attributes"])){
										if($c == "@attributes")
											$criatura[$chave][$a][] = $b["@attributes"];
									}
									else
										$criatura[$chave][$a][$c] = $d;
								}
							}
							else
								$criatura[$chave]["atributos"][$c] = $d;
						}
					}
				}
				else
					$criatura[$chave] = $valor["@attributes"];
			}
			$criaturaInformacoes = array(
				"name" => $criaturaAtributos["name"],
				"fileName" => $nomeArquivo,
				"experience" => $criaturaAtributos["experience"],
				"speed" => $criaturaAtributos["speed"],
				"manaCost" => $criaturaAtributos["manacost"],
				"health" => $criatura["health"]["max"],
				"lookType" => $criatura["look"]["type"],
				"lookHead" => (isset($criatura["look"]["head"]) ? $criatura["look"]["head"] : 0),
				"lookBody" => (isset($criatura["look"]["body"]) ? $criatura["look"]["body"] : 0),
				"lookLegs" => (isset($criatura["look"]["legs"]) ? $criatura["look"]["legs"] : 0),
				"lookFeet" => (isset($criatura["look"]["feet"]) ? $criatura["look"]["feet"] : 0),
				"maxSummons" => (isset($criatura["summons"]["atributos"]["maxSummons"]) ? $criatura["summons"]["atributos"]["maxSummons"] : 0)
			);
			$flags = $criatura["flags"]["flag"];
			if(is_array($flags))
				foreach($flags as $a => $b)
					foreach($b as $key => $value)
						$criaturaInformacoes["flags"][$key] = $value;
			$ataques = $criatura["attacks"]["attack"];
			if(is_array($ataques)){
				foreach($ataques as $a => $b){
					if(is_array($b)){
						foreach($b as $key => $value)
							$criaturaInformacoes["ataques"][$a][$key] = $value;
					}
					else
						$criaturaInformacoes["ataques"][0][$a] = $b;
				}
			}
			$defesas = $criatura["defenses"]["defense"];
			if(is_array($defesas)){
				foreach($defesas as $a => $b){
					if(is_array($b)){
						foreach($b as $key => $value)
							$criaturaInformacoes["defesas"][$a][$key] = $value;
					}
					else
						$criaturaInformacoes["defesas"][0][$a] = $b;
				}
			}
			$elementos = $criatura["elements"]["element"];
			if(is_array($elementos)){
				foreach($elementos as $a => $b){
					if(is_array($b)){
						foreach($b as $key => $value){
							$key = str_replace("Percent", "", $key);
							if($value == 100)
								$criaturaInformacoes["imunidades"][$key] = 1;
							else
								$criaturaInformacoes["elementos"][$key] = $value;
						}
					}
					else{
						$key = str_replace("Percent", "", $a);
						if($b == 100)
							$criaturaInformacoes["imunidades"][$key] = 1;
						else
							$criaturaInformacoes["elementos"][$key] = $b;
					}
				}
			}
			$imunidades = $criatura["immunities"]["immunity"];
			if(is_array($imunidades)){
				foreach($imunidades as $a => $b){
					if(is_array($b)){
						foreach($b as $key => $value)
							$criaturaInformacoes["imunidades"][$key] = $value;
					}
					else
						$criaturaInformacoes["imunidades"][$a] = $b;
				}
			}
			$summons = $criatura["summons"]["summon"];
			if(is_array($summons))
				foreach($summons as $a => $b)
					$criaturaInformacoes["summons"][$a] = $b;
			$vozes = $criatura["voices"]["voice"];
			if(is_array($vozes))
				foreach($vozes as $a => $b)
					$criaturaInformacoes["vozes"][$a] = $b;
			$loot = $criatura["loot"]["item"];
			if(is_array($loot)){
				foreach($loot as $a => $b){
					if(is_array($b)){
						foreach($b as $key => $value)
							$criaturaInformacoes["loot"][$a][str_replace("countmax", "quantidade", $key)] = $value;
					}
					else
						$criaturaInformacoes["loot"][0][str_replace("countmax", "quantidade", $a)] = $b;
				}
			}
			if(is_array($criaturaInformacoes))
				return $criaturaInformacoes;
			return false;
		}
		public function getListaCriaturas(){
			$listaCriaturas = array();
			$criaturasFlags = array();
			$queryListaCriaturasFlags = mysql_query("SELECT * FROM z_monstros_flags WHERE ((atributo LIKE 'summonable') OR (atributo LIKE 'convinceable'))");
			while($resultadoListaCriaturasFlags = mysql_fetch_assoc($queryListaCriaturasFlags))
				if($resultadoListaCriaturasFlags["valor"] > 0)
					$criaturasFlags[$resultadoListaCriaturasFlags["monstro_id"]][$resultadoListaCriaturasFlags["atributo"]] = $resultadoListaCriaturasFlags["valor"];
			$queryListaCriaturas = mysql_query("SELECT * FROM z_monstros WHERE (ocultarCriatura LIKE '0')");
			while($resultadoListaCriaturas = mysql_fetch_assoc($queryListaCriaturas)){
				$listaCriaturas[] = array(
					"imagem" => $this->getImagemCriatura($resultadoListaCriaturas),
					"nome" => $resultadoListaCriaturas["fileName"],
					"link" => "?p=criaturas&id=".urlencode($resultadoListaCriaturas["fileName"]),
					"experiencia" => $resultadoListaCriaturas["experience"],
					"vida" => $resultadoListaCriaturas["health"],
					"custoMana" => $resultadoListaCriaturas["manaCost"],
					"sumonar" => (isset($criaturasFlags[$resultadoListaCriaturas["id"]]["summonable"]) ? $resultadoListaCriaturas["manaCost"] : "--"),
					"convencer" => (isset($criaturasFlags[$resultadoListaCriaturas["id"]]["convinceable"]) ? $resultadoListaCriaturas["manaCost"] : "--")
				);
			}
			if(count($listaCriaturas) > 0)
				return $listaCriaturas;
			return false;
		}
		public function getInfoCriatura($criaturaNome){
			$criaturaNome = urldecode($criaturaNome);
			$queryCriatura = mysql_query("SELECT * FROM z_monstros WHERE ((fileName LIKE '$criaturaNome') AND (ocultarCriatura LIKE '0'))");
			while($resultadoCriatura = mysql_fetch_assoc($queryCriatura)){
				$criaturaId = $resultadoCriatura["id"];
				$summonable = 0;
				$convinceable = 0;
				$pushable = 0;
				$canpushitems = 0;
				$vozes = array();
				$imunidades = array();
				$forte = array();
				$fraco = array();
				$summons = array();
				$loot = array();
				$queryFlags = mysql_query("SELECT * FROM z_monstros_flags WHERE (monstro_id LIKE '$criaturaId')");
				while($resultadoFlags = mysql_fetch_assoc($queryFlags))
					$$resultadoFlags["atributo"] = $resultadoFlags["valor"];
				$queryVozes = mysql_query("SELECT * FROM z_monstros_vozes WHERE (monstro_id LIKE '$criaturaId')");
				while($resultadoVozes = mysql_fetch_assoc($queryVozes))
					$vozes[] = '"'.$resultadoVozes["valor"].'"';
				$vozes = (count($vozes) > 0 ? implode("; ", $vozes)."." : "");
				$queryImunidades = mysql_query("SELECT * FROM z_monstros_imunidades WHERE (monstro_id LIKE '$criaturaId')");
				while($resultadoImunidades = mysql_fetch_assoc($queryImunidades))
					if(is_file('imagens/icones/'.$resultadoImunidades["valor"].'_icone.gif'))
						$imunidades[] = '<img src="imagens/icones/'.$resultadoImunidades["valor"].'_icone.gif" title="'.$this->formatarNomeIcone($resultadoImunidades["valor"]).'" alt="" />';
				$queryElementos = mysql_query("SELECT * FROM z_monstros_elementos WHERE (monstro_id LIKE '$criaturaId')");
				while($resultadoElementos = mysql_fetch_assoc($queryElementos)){
					$iconeArquivo = 'imagens/icones/'.$resultadoElementos["elemento"].'_icone.gif';
					$tituloImagem = $this->formatarNomeIcone($resultadoElementos["elemento"]);
					if($resultadoElementos["valor"] > 0)
						$forte[] = '<img src="'.$iconeArquivo.'" title="'.$tituloImagem.'" alt="" />';
					else
						$fraco[] = '<img src="'.$iconeArquivo.'" title="'.$tituloImagem.'" alt="" />';
				}
				$querySummons = mysql_query("SELECT * FROM z_monstros_summons WHERE (monstro_id LIKE '$criaturaId')");
				while($resultadoSummons = mysql_fetch_assoc($querySummons)){
					$summons[]["nome"] = $resultadoSummons["summon"];
				}
				foreach($summons as $c => $v){
					$querySummons = mysql_query("SELECT * FROM z_monstros WHERE (name LIKE '".$v["nome"]."')");
					while($resultadoSummons = mysql_fetch_assoc($querySummons)){
						$summons[$c]["id"] = $resultadoSummons["id"];
						$summons[$c]["imagem"] = $this->getImagemCriatura($resultadoSummons);
					}
				}
				$ataques = $this->getCriaturaAtaques($criaturaId);
				$defesas = $this->getCriaturaDefesas($criaturaId);
				$queryLoot = mysql_query("SELECT * FROM z_monstros_loot WHERE (monstro_id LIKE '$criaturaId')");
				while($resultadoLoot = mysql_fetch_assoc($queryLoot)){
					$loot[] = array("item_id" => $resultadoLoot["item_id"], "quantidade" => $resultadoLoot["quantidade"], "chance" => $resultadoLoot["chance"]);
				}
				$criatura = array(
					"id" => $resultadoCriatura["id"],
					"imagem" => $this->getImagemCriatura($resultadoCriatura),
					"nome" => $resultadoCriatura["fileName"],
					"experiencia" => $resultadoCriatura["experience"],
					"velocidade" => $resultadoCriatura["speed"],
					"vida" => $resultadoCriatura["health"],
					"maxSummons" => $resultadoCriatura["maxSummons"],
					"sumonar" => ($summonable == 1 ? $resultadoCriatura["manaCost"] : "--"),
					"convencer" => ($convinceable == 1 ? $resultadoCriatura["manaCost"] : "--"),
					"puxado" => ($pushable == 1 ? "Sim" : "Não"),
					"empurra" => ($canpushitems == 1 ? "Sim" : "Não"),
					"vozes" => $vozes,
					"imunidades" => implode(" ", $imunidades),
					"forte" => implode(" ", $forte),
					"fraco" => implode(" ", $fraco),
					"summons" => $summons,
					"ataques" => $ataques,
					"defesas" => $defesas,
					"loot" => $loot
				);
			}
			if(is_array($criatura))
				return $criatura;
			return false;
		}
	}
?>