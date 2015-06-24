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
					O conteúdo que você está tentando visualizar não foi encontrado em nosso sistema.
				</div>
			';
			if(!$full)
				return $conteudoNaoEncontrado;
			$conteudoNaoEncontrado = '
				<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="nao_encontrado">
					<div class="conteudo_box pagina">
						<div class="box_frame" carregar_box="1">
							Página Não Encontrada
						</div>
						<div class="box_frame_conteudo_principal" carregar_box="1">
							'.$conteudoNaoEncontrado.'
						</div>
					</div>
				</div>
			';
			return $conteudoNaoEncontrado;
		}
		public function pegarNumeroJogadoresOnline(){
			$numeroJogadoresOnline = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM players_online"));
			return $numeroJogadoresOnline["total"];
		}
		public function exibirNumeroJogadoresOnline(){
			$numeroJogadoresOnline = $this->pegarNumeroJogadoresOnline();
			return $numeroJogadoresOnline."<br>Jogador".($numeroJogadoresOnline == 1 ? "" : "es")." Online";
		}
	}
?>