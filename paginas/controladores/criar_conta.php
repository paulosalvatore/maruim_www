<?php
	session_start();
	require_once("../../conexao/conexao.php");
	include("../../includes/funcoes.php");
	check_is_ajax(__FILE__);
	check_if_logged(__FILE__);
	include("../../includes/config.php");
	include("../../includes/config_criar_conta.php");
	include("../../includes/protocolo.php");
	foreach($_REQUEST as $c => $v)
		$$c = $v;
	parse_str(addslashes($formulario), $formulario);
	if(!empty($campo))
		$formulario = array($campo => $valor);
	$erros = array();
	$existe_erro = false;
	foreach($formulario as $id_campo => $valor_campo){
		$erros[$id_campo] = array();
		$chave_array = procurarChave($id_campo, $formulario_criacao_conta);
		$config_campo = $formulario_criacao_conta[$chave_array][$id_campo];
		foreach($config_campo as $chave => $valor)
			$$chave = $valor;
		if($tipo == "texto"){
			if($obrigatorio){
				if(strlen($valor_campo) == 0)
					$erros[$id_campo][] = "O preenchimento desse campo é obrigatório.";
			}
			if(count($erros[$id_campo]) == 0){
				if($minlength > 0)
					if(strlen($valor_campo) < $minlength)
						$erros[$id_campo][] = "Esse campo precisa ter no mínimo $minlength caracteres.";
			}
			if(count($erros[$id_campo]) == 0){
				if($maxlength > 0)
					if(strlen($valor_campo) > $maxlength)
						$erros[$id_campo][] = "Esse campo pode ter no máximo $maxlength caracteres.";
			}
			if(count($erros[$id_campo]) == 0){
				if($tipo_dados_obrigatorio["numeros"])
					if(!preg_match('/[0-9]+/', $valor_campo))
						$erros[$id_campo][] = "Esse campo precisa ter números.";
			}
			if(count($erros[$id_campo]) == 0){
				if($tipo_dados_obrigatorio["letras"])
					if(!preg_match('/[A-Za-z]+/', $valor_campo))
						$erros[$id_campo][] = "Esse campo precisa ter letras.";
			}
			if(count($erros[$id_campo]) == 0){
				if(!$tipo_dados["numeros"])
					if(preg_match('/[0-9]+/', $valor_campo))
						$erros[$id_campo][] = "Esse campo não pode ter números.";
			}
			if(count($erros[$id_campo]) == 0){
				if(!$tipo_dados["letras"])
					if(preg_match('/[A-Za-z]+/', $valor_campo))
						$erros[$id_campo][] = "Esse campo não pode ter letras.";
			}
			if(count($erros[$id_campo]) == 0){
				if(!$tipo_dados["simbolos"])
					if(!preg_match('/^[a-z0-9 .\-]+$/i', $valor_campo))
						$erros[$id_campo][] = "Esse campo deve conter apenas letras (a-z, A-Z) e números (0-9).";
			}
			if(count($erros[$id_campo]) == 0){
				if($tipo_dados_obrigatorio["email"])
					if(!verificarEmail($valor_campo))
						$erros[$id_campo][] = "Esse e-mail é inválido.";
			}
			if(count($erros[$id_campo]) == 0){
				if($id_campo == "nome_personagem"){
					if($valor_campo[0] == " ")
						$erros[$id_campo][] = "Remova os espaços do começo.";
					elseif($valor_campo[strlen($valor_campo)-1] == " ")
						$erros[$id_campo][] = "Remova os espaços do final.";
					elseif(!preg_match('/[A-Z]+/', $valor_campo[0]))
						$erros[$id_campo][] = "A primeira letra deve ser maiúscula.";
				}
			}
			if(count($erros[$id_campo]) == 0){
				if(!empty($igual)){
					if(!array_key_exists("senha", $formulario)){
						if(empty($campo_igual))
							$erros[$id_campo][] = $msg_igual_vazio;
						elseif($campo_igual != $valor_campo)
							$erros[$id_campo][] = $msg_igual;
					}
					else{
						if(empty($formulario["senha"]))
							$erros[$id_campo][] = $msg_igual_vazio;
						elseif($formulario["senha"] != $valor_campo)
							$erros[$id_campo][] = $msg_igual;
					}
				}
			}
			if(count($erros[$id_campo]) == 0){
				if($unico){
					$checar_campo = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM $tabela_verificacao WHERE ($campo_verificacao LIKE '$valor_campo')"));
					$checar_campo = $checar_campo["total"];
					if($checar_campo > 0)
						$erros[$id_campo][] = $msg_unico;
				}
			}
		}
		elseif($tipo == "opcao_radio"){
			if($obrigatorio){
				if(strlen($valor_campo) == 0)
					$erros[$id_campo][] = "O preenchimento desse campo é obrigatório.";
			}
			if(count($erros[$id_campo]) == 0){
				if(!procurarValor($valor_campo, $opcoes))
					$erros[$id_campo][] = $msg_opcao_inexistente;
			}
		}
		if(count($erros[$id_campo]) > 0)
			$existe_erro = true;
	}
	foreach($erros as $chave => $mensagem)
		$erros[$chave][0] = utf8_encode($mensagem[0]);
	echo json_encode($erros);
	if((!$existe_erro) AND (empty($campo))){
		$sql_queries = array(
			"accounts" => array(
				"name" => $formulario["conta"],
				"password" => sha1($formulario["senha"]),
				"email" => $formulario["email"],
				"creation" => time(),
				"ip_registro" => $ip
			),
			"players" => array(
				"name" => $formulario["nome_personagem"],
				"account_id" => "",
				"vocation" => 0,
				"lookbody" => $config["players"]["lookbody"],
				"lookfeet" => $config["players"]["lookfeet"],
				"lookhead" => $config["players"]["lookhead"],
				"looklegs" => $config["players"]["looklegs"],
				"looktype" => $config["players"]["looktype"],
				"town_id" => $config["players"]["town_id"],
				"posx" => $config["players"]["posx"],
				"posy" => $config["players"]["posy"],
				"posz" => $config["players"]["posz"],
				"cap" => $config["players"]["cap"],
				"sex" => $formulario["sexo_personagem"],
				"ip_registro" => $ip,
				"data_registro" => time()
			)
		);
		foreach($sql_queries as $tabela => $query){
			$sql_query = "INSERT INTO $tabela (";
			for($i=0;$i<2;$i++){
				$j = 0;
				foreach($query as $coluna => $valor){
					if($j > 0)
						$sql_query .= ", ";
					if($i == 0)
						$sql_query .= "$coluna";
					else{
						if($coluna == "account_id"){
							$t = mysql_query("SELECT * FROM accounts WHERE (name LIKE '".$formulario["conta"]."')");
							while($s = mysql_fetch_assoc($t))
								$valor = $s["id"];
						}
						$sql_query .= "'$valor'";
					}
					$j++;
				}
				if($i == 0)
					$sql_query .= ") VALUES (";
				else{
					$sql_query .= ");";
					if($formulario["conta"] != ""){
						mysql_query($sql_query);
						$_SESSION["login"] = $formulario["conta"];
					}
				}
			}
		}
	}
?>