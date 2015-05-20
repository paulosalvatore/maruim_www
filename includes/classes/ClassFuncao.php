<?php
	class Funcao {
		public function transformarDiasTempo($dias){
			return $dias*24*60*60;
		}
		public function formatarData($tempo){
			return date("d/m/Y, H\hi\ms\s", $tempo);
		}
		public function formatarLogin($tempo){
			if($tempo > 0)
				$formatarLogin = $this->formatarData($tempo);
			else
				$formatarLogin = "Nunca efetuou login.";
			return $formatarLogin;
		}
		public function loadSQLQuery($tabela, $colunas, $valores){
			foreach($valores as $c => $v)
				$valores[$c] = "'".addslashes($v)."'";
			return "INSERT INTO `$tabela` (".implode(",", $colunas).") VALUES (".implode(",", $valores).");";
		}
		public function loadSQLQueryDelete($tabela, $procurar, $valor){
			return "DELETE FROM $tabela WHERE ($procurar LIKE '$valor')";
		}
		public function loadSQLQueryUpdate($tabela, $colunas, $valores, $procurarColunas, $procurarValores){
			if(!is_array($colunas))
				$colunas = array($colunas);
			if(!is_array($valores))
				$valores = array($valores);
			if(!is_array($procurarColunas))
				$procurarColunas = array($procurarColunas);
			if(!is_array($procurarValores))
				$procurarValores = array($procurarValores);
			$editar = array();
			$procurar = array();
			foreach($colunas as $c => $v)
				$editar[] = "$v = '".addslashes($valores[$c])."'";
			foreach($procurarColunas as $c => $v)
				$procurar[] = "($v LIKE '".addslashes($procurarValores[$c])."')";
			return "UPDATE `$tabela` SET ".implode(",", $editar)." WHERE (".implode(" AND ", $procurar).");";
		}
	}
?>