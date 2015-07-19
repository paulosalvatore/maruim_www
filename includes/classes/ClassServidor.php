<?php
	class Servidor {
		public function serverInfo(){
			$serverInfo = array();
			$queryServerInfo = mysql_query("SELECT * FROM server_config");
			while($resultadoServerInfo = mysql_fetch_assoc($queryServerInfo)){
				foreach($resultadoServerInfo as $c => $v){
					if($c == "config")
						$chave = $v;
					else
						$serverInfo[$chave] = $v;
				}
			}
			return $serverInfo;
		}
		public function isOnline(){
			$serverInfo = $this->serverInfo();
			if((count($serverInfo) > 0) AND ($serverInfo["online"] >= time()-10))
				return true;
			return false;
		}
		public function statusServidor(){
			if($this->isOnline())
				return "Online";
			return "Offline";
		}
		public function exibirTempoOnline(){
			if($this->isOnline()){
				$serverInfo = $this->serverInfo();
				$uptime = (isset($serverInfo["uptime"]) ? time()-$serverInfo["uptime"] : 0);
				return '
					<tr>
						<td class="negrito">
							Tempo Online:
						</td>
						<td>
							<div id="tempoOnline" tempo="'.$uptime.'"></div>
						</td>
					</tr>
				';
			}
		}
		public function pegarNumeroJogadoresOnline(){
			$numeroJogadoresOnline = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM players_online"));
			return $numeroJogadoresOnline["total"];
		}
		public function exibirNumeroJogadoresOnline(){
			$numeroJogadoresOnline = $this->pegarNumeroJogadoresOnline();
			return $numeroJogadoresOnline."<br>Jogador".($numeroJogadoresOnline == 1 ? "" : "es")." Online";
		}
		public function exibirJogadoresOnline(){
			$numeroJogadoresOnline = $this->pegarNumeroJogadoresOnline();
			$exibirJogadoresOnline = '
				<table width="100%" cellpadding="0" cellspacing="0" class="tabela odd">
					<tr class="cabecalho">
						<td colspan="2" style="position: relative; z-index: '.($numeroJogadoresOnline+1).';">
							Jogador
						</td>
						<td width="100">
							Nível
						</td>
						<td width="150">
							Vocação
						</td>
					</tr>
					';
					$q = $numeroJogadoresOnline;
					if($numeroJogadoresOnline > 0){
						$ClassPersonagem = new Personagem();
						$queryJogadoresOnline = mysql_query("SELECT * FROM players_online");
						while($resultadoJogadoresOnline = mysql_fetch_assoc($queryJogadoresOnline)){
							$jogador = $ClassPersonagem->getInformacoesPersonagem($resultadoJogadoresOnline["player_id"]);
							$exibirJogadoresOnline .= '
								<tr class="item">
									<td width="30">
										<a href="'.$jogador["link"].'">'.$ClassPersonagem->pegarImagemPersonagem($jogador, $q--).'</a>
									</td>
									<td>
										<a href="'.$jogador["link"].'">'.$jogador["nome"].'</a>
									</td>
									<td>
										'.$jogador["nivel"].'
									</td>
									<td>
										'.$jogador["vocacao"].'
									</td>
								</tr>
							';
						}
					}
					else
						$exibirJogadoresOnline .= '
							<tr class="item">
								<td colspan="4" height="80" class="negrito" align="center">
									Nenhum jogador está online no momento.
								</td>
							</tr>
						';
					$exibirJogadoresOnline .= '
				</table>
			';
			return $exibirJogadoresOnline;
		}
		public function pegarRecordeOnline(){
			$recordeOnline = 0;
			$recordeOnlineData = 0;
			$queryPersonagem = mysql_query("SELECT * FROM server_config WHERE (config LIKE 'players_record%')");
			while($resultadoPersonagem = mysql_fetch_assoc($queryPersonagem)){
				if($resultadoPersonagem["config"] == "players_record")
					$recordeOnline = $resultadoPersonagem["value"];
				elseif($resultadoPersonagem["config"] == "players_record_time")
					$recordeOnlineData = $resultadoPersonagem["value"];
			}
			$ClassFuncao = new Funcao();
			return $recordeOnline." Jogador".($recordeOnline == 1 ? "" : "es").($recordeOnlineData > 0 ? " (em ".$ClassFuncao->formatarData($recordeOnlineData, true).")" : "");
		}
	}
?>