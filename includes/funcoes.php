<?php
	function check_is_ajax($script){
		$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
		strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
		if(!$isAjax)
			trigger_error('Acesso negado. ('.$script.')', E_USER_ERROR);
	}
	function check_if_logged($script){
		session_start();
		$usuarioEncontrado = false;
		$login = $_SESSION["login"];
		$senha = $_SESSION["senha"];
		include("classes/ClassConta.php");
		$ClassConta = new Conta();
		if(!empty($login) OR (!empty($senha)))
			if($ClassConta->validarConta($login, $senha))
				if(count($ClassConta->getInformacoesConta($login)) > 0)
					$usuarioEncontrado = true;
		if(!$usuarioEncontrado)
			trigger_error('Acesso negado. ('.$script.')', E_USER_ERROR);
	}
	function verificarEmail($email){
		if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $email))
			return false;
		return true;
	}
	function limpaString($string){
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ‗אבגדהוזחטיךכלםמןנסעףפץצרשתû‎‎‏ÿRr';
		$b = 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYBSaaaaaaaceeeeiiiidnoooooouuuyybyRr';
		$string = $string;
		$string = strtr($string, $a, $b);
		return $string;
	}
	function formatarData($data, $exibirMes = 0){
		$mes = ucfirst(strftime("%B", $data));
		if($exibirMes == 1)
			return strftime("%d ".$mes." %Y", $data);
		return strftime("%d/%m/%Y", $data);
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