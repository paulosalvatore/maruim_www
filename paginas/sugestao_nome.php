<?php
	// set_time_limit(60*60);
	require_once("../conexao.php");
	$vogais = array("a", "e", "i", "o", "u");
	$consoantes = array("b", "c", "d", "f", "g", "h", "j", "k", "l", "m", "n", "p", "r", "s", "t", "v", "w", "x", "y", "z");
	$iniciais = array("lh", "ch", "th", "kr", "vr", "tr", "st", "yn");
	$letras_dobradas = array("nh", "nd", "lh", "ch", "qu", "rr", "ss", "th", "kr", "vr", "sh", "tr", "st", "yn", "ll");
	$palavras_proibidas = array(
		"bunda",
		"peito",
		"pinto",
		"penis",
		"caralho",
		"puta",
		"fuder",
		"foder",
		"foda",
		"fuck",
		"comer",
		"buceta",
		"xana",
		"roludo",
		"delicia",
		"tesao",
		"porra",
		"chupar",
		"pereba",
		"jacinto",
		"latejando",
		"cocada",
		"maconha",
		"cocaina",
		"craque",
		"whisky",
		"curral",
		"anus",
		"piroca",
		"jiromba",
		"giromba",
		"vagina"
	);
	function checarPalavra($palavra){
		global $palavras_proibidas;
		foreach($palavras_proibidas as $palavra_proibida){
			if(strpos($palavra, $palavra_proibida) !== false)
				return true;
		}
		return false;
	}
	$nome = array();
	$qtde_nomes = 1;
	for($a=0;$a<$qtde_nomes;$a++){
		$nomes[$a] = array();
		for($i=0;$i<2;$i++){
			$nome[$i] = array();
			$rand_caracteres = rand(0, 1000);
			if($rand_caracteres >= 750)		//25%
				$caracteres = 4;
			elseif($rand_caracteres >= 550)	//20%
				$caracteres = 5;
			elseif($rand_caracteres >= 400)	//15%
				$caracteres = 6;
			elseif($rand_caracteres >= 250)	//15%
				$caracteres = 7;
			elseif($rand_caracteres >= 150)	//10%
				$caracteres = 8;
			elseif($rand_caracteres >= 100)	//10%
				$caracteres = 9;
			else							//5%
				$caracteres = 10;
			for($j=0;$j<$caracteres;$j++){
				$letra = "";
				while($letra == ""){
					shuffle($vogais);
					shuffle($consoantes);
					shuffle($letras_dobradas);
					shuffle($iniciais);
					$vogal = $vogais[rand(0, count($vogais)-1)];
					$consoante = $consoantes[rand(0, count($consoantes)-1)];
					$letra_dobrada = $letras_dobradas[rand(0, count($letras_dobradas)-1)];
					$inicial = $letra_dobrada;
					while($inicial == $letra_dobrada)
						$inicial = $iniciais[rand(0, count($iniciais)-1)];
					if($j == 0){
						$rand_letra = rand(1,100);
						if($rand_letra > 55)
							$letra = $consoante;
						elseif($rand_letra > 10)
							$letra = $vogal;
						else{
							$letra = $inicial;
							$j++;
						}
					}
					elseif($j == 1){
						if(in_array($nome[$i][$j-1], $vogais))
							$letra = $consoante;
						else
							$letra = $vogal;
					}
					else{
						if(in_array($nome[$i][$j-1], $consoantes))
							$letra = $vogal;
						else{
							if(in_array($nome[$i][$j-2], $vogais)){
								if(rand(1,10) <= 3)
									$letra = $consoante;
								else{
									$letra = $letra_dobrada;
									$j++;
								}
							}
							else{
								if(rand(1,10) <= 3)
									$letra = $vogal;
								else{
									if(rand(1,10) <= 3)
										$letra = $consoante;
									else{
										$letra = $letra_dobrada;
										$j++;
									}
								}
							}
						}
					}
					if((in_array($letra, $vogais)) AND ($nome[$i][$j-1] == $letra))
						$letra = "";
					else{
						$y = array($letra);
						$x = $nome[$i];
						if(count(array_intersect($x, $y)) > 1)
							$letra = "";
					}
				}
				if(($letra == $letra_dobrada) OR ($letra == $inicial)){
					$nome[$i][$j-1] = $letra[0];
					$nome[$i][$j] = $letra[1];
				}
				else
					$nome[$i][$j] = $letra;
			}
			$checar_palavra = checarPalavra(implode("", $nome[$i]));
			if($checar_palavra){
				$nome[$i] = array();
				$i--;
			}
		}
		$nome_formatado = ucfirst(implode("", $nome[0]))." ".ucfirst(implode("", $nome[1]));
		
		$checar_banco = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM players WHERE (name LIKE '$nome_formatado')"));
		$checar_banco = $checar_banco["total"];
		if(($checar_banco == 0) AND (!in_array($nome_formatado, $nomes)))
			$nomes[$a] = $nome_formatado;
		else
			$a--;
	}
	echo implode("", $nomes);
?>