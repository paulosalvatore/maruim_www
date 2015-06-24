<?php
	class Funcao {
		public function transformarDiasTempo($dias){
			return $dias*24*60*60;
		}
		public function formatarData($tempo, $extenso = false){
			if($extenso){
				setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
				date_default_timezone_set('America/Sao_Paulo');
				return strftime('%A, %d de %B de %Y às %Hh%Mm%Ss', $tempo);
			}
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
		public function pegarUltimasMortes(){
			$ultimasMortes = array();
			$queryUltimasMortes = mysql_query("SELECT * FROM player_deaths ORDER BY time DESC");
			while($resultadoUltimasMortes = mysql_fetch_assoc($queryUltimasMortes))
				$ultimasMortes[] = $resultadoUltimasMortes;
			return $ultimasMortes;
		}
		public function exibirUltimasMortes(){
			$ultimasMortes = $this->pegarUltimasMortes();
			$exibirUltimasMortes = "";
			if(count($ultimasMortes) == 0)
				$exibirUltimasMortes .= '
					<tr class="item" height="100">
						<td colspan="3" align="center">
							O servidor não possui nenhuma morte registrada.
						</td>
					</tr>
				';
			else{
				foreach($ultimasMortes as $numeroMorte => $informacoesMorte){
					$mortoPor = ($informacoesMorte["is_player"] == 1 ? $this->exibirJogador($informacoesMorte["mostdamage_by"], true) : $informacoesMorte["mostdamage_by"]);
					$exibirUltimasMortes .= '
						<tr class="item">
							<td align="center">
								'.($numeroMorte+1).'
							</td>
							<td>
								'.$this->exibirJogador($informacoesMorte["player_id"], true).'
							</td>
							<td>
								'.$this->formatarData($informacoesMorte["time"], true).', no nível '.$informacoesMorte["level"].' para '.$mortoPor.'.
							</td>
						</tr>
					';
				}
			}
			return $exibirUltimasMortes;
		}
		public function pegarNomeJogador($jogadorId){
			$queryJogador = mysql_query("SELECT * FROM players WHERE (id LIKE '$jogadorId')");
			while($resultadoJogador = mysql_fetch_assoc($queryJogador))
				return $resultadoJogador["name"];
			return "";
		}
		public function exibirJogador($jogadorId, $link = false){
			if(is_numeric($jogadorId))
				$jogadorNome = $this->pegarNomeJogador($jogadorId);
			else
				$jogadorNome = $jogadorId;
			if($link){
				if(!empty($jogadorNome))
					return '<a href="?p=personagens-'.$jogadorNome.'">'.$jogadorNome.'</a>';
			}
			if(empty($jogadorNome))
				$jogadorNome = "Jogador Sem Nome";
			return $jogadorNome;
		}
	}
?>