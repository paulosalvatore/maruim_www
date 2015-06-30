<?php
	class Funcao {
		public function transformarDiasTempo($dias){
			return $dias*24*60*60;
		}
		public function formatarData($tempo, $extenso = false){
			if($extenso){
				setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
				date_default_timezone_set('America/Sao_Paulo');
				return strftime('%d de %B de %Y �s %Hh%Mm%Ss', $tempo);
			}
			return date("d/m/Y, H\hi\ms\s", $tempo);
		}
		public function exibirTempo($tempo){
			$meses = floor(($tempo/2592000));
			$dias = floor(fmod($tempo/86400, 30));
			$horas = floor(fmod($tempo/3600, 24));
			$minutos = floor(fmod($tempo/60, 60));
			$segundos = fmod($tempo, 60);
			$exibirMeses = ($tempo >= 2592000 ? $meses." ".($meses != 1 ? "meses" : "m�s").", " : "");
			$exibirDias = ($tempo >= 86400 ? $dias." dia".($dias != 1 ? "s" : "")." e " : "");
			$exibirHoras = ($tempo >= 3600 ? ($horas < 10 ? "0".$horas : $horas)."h" : "");
			$exibirMinutos = ($tempo >= 60 ? ($minutos < 10 ? "0".$minutos : $minutos)."m" : "");
			$exibirSegundos = ($tempo > 0 ? ($segundos < 10 ? "0".$segundos : $segundos)."s" : "");
			return $exibirMeses.$exibirDias.$exibirHoras.$exibirMinutos.$exibirSegundos;
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
		public function separarForm($array, $utf8_decode = false){
			$arrayReturn = array();
			if(!is_array($array))
				parse_str($array, $array);
			if(is_array($array)){
				foreach($array as $c => $v){
					if($utf8_decode)
						$v = utf8_decode($v);
					$arrayReturn[$c] = addslashes($v);
				}
			}
			return $arrayReturn;
		}
		public function pegarConteudoNaoEncontrado($full = false){
			$conteudoNaoEncontrado = '
				<div class="box_frame_conteudo padding dark">
					O conte�do que voc� est� tentando visualizar n�o foi encontrado em nosso sistema.
				</div>
			';
			if(!$full)
				return $conteudoNaoEncontrado;
			$conteudoNaoEncontrado = '
				<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="nao_encontrado">
					<div class="conteudo_box pagina">
						<div class="box_frame" carregar_box="1">
							P�gina N�o Encontrada
						</div>
						<div class="box_frame_conteudo_principal" carregar_box="1">
							'.$conteudoNaoEncontrado.'
						</div>
					</div>
				</div>
			';
			return $conteudoNaoEncontrado;
		}
		public function ordenarResultadosBusca(&$arr, $col, $dir = SORT_ASC){
			$sort_col = array();
			foreach($arr as $key=> $row)
				$sort_col[$key] = $row[$col];
			array_multisort($sort_col, $dir, $arr);
		}
	}
?>