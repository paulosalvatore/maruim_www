<?php
	function limpaString($string){
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ‗אבגדהוזחטיךכלםמןנסעףפץצרשתû‎‎‏ÿRr';
		$b = 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYBSaaaaaaaceeeeiiiidnoooooouuuyybyRr';
		$string = $string;
		$string = strtr($string, $a, $b);
		return $string;
	}
	function formatarData($data){
		$mes = ucfirst(strftime("%B", $data));
		return strftime("%d ".$mes." %Y", $data);
	}
	function procurarChave($key, $main_array) {
		foreach($main_array as $chave_main_array => $array)
			foreach($array as $chave => $valor)
				if($chave === $key)
					return $chave_main_array;
		return null;
	}
	function procurarValor($valor, $main_array){
		foreach($main_array as $chave_main_array => $array)
			foreach($array as $chave => $value)
				if(($chave == "valor") AND ($value == $valor))
					return true;
		return false;
	}
?>