<?php
	set_time_limit(3600);
	class Xml {
		private $diretorio = "arquivos/xml/";
		public function loadXML($arquivo){
			return simplexml_load_file($this->diretorio.$arquivo);
		}
		public function atualizarRegistros($arquivo, $tabela){
			require("conexao/conexao.php");
			$xml = $this->loadXML($arquivo."s.xml");
			$childrens = json_decode(json_encode($xml->children()), true);
			$lista = $childrens[$arquivo];
			$ClassFuncao = new Funcao();
			$resultado = array();
			mysql_query("TRUNCATE TABLE $tabela");
			foreach($lista as $id => $info){
				$info = $info["@attributes"];
				$colunas = array();
				$valores = array();
				foreach($info as $c => $v){
					$colunas[] = $c;
					$valores[] = ($c == "premium" ? ($v == "no" or $v == 0 ? 0 : 1) : $v);
				}
				$resultado[] = '<b>'.$info["name"].'</b> -> adicionado ao banco de dados.';
				mysql_query($ClassFuncao->loadSQLQuery($tabela, $colunas, $valores));
			}
			return implode("<br>", $resultado);
		}
	}
?>