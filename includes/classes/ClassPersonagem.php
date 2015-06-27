<?php
	class Personagem {
		public $limiteRank = 100;
		public $diasDeletarPersonagem = 7;
		public $maximoUltimasMortes = 5;
		public $diasUltimasMortes = 10;
		public $limiteLinhasComentario = 15;
		public $vocacoes = array(
			0 => array(
				"campo" => "nenhuma",
				"exibicao" => "Nenhuma"
			),
			1 => array(
				"campo" => "sorcerer",
				"exibicao" => "Sorcerer",
				"disponivel" => true,
				"texto" => "
					Ataque Mágico<br>
					<b>Tipo:</b> Mago<br>
					<b>Elemento:</b> <img src='imagens/icones/fire_icone.gif'/> <img src='imagens/icones/energy_icone.gif'/><br>
					<b>Promoção:</b><br>
					Master Sorcerer<br>
					<br>
					<b>Ganhos por Nível:</b><br>
					10 oz de capacidade<br>
					5 pontos de vida<br>
					30 de Mana<br>
				",
				"informacoes" => array(
					"armamento" => array(
						8921 => "Wands"
					),
					"tipo" => "Mago",
					"elemento" => array("fire", "energy"),
					"promocao" => "Master Sorcerer",
					"ganhos" => array(10, 5, 30)
				)
			),
			2 => array(
				"campo" => "druid",
				"exibicao" => "Druid",
				"disponivel" => true,
				"texto" => "
					Ataque Mágico<br>
					<b>Tipo:</b> Mago<br>
					<b>Elemento:</b> <img src='imagens/icones/ice_icone.gif'/> <img src='imagens/icones/earth_icone.gif'/><br>
					<b>Promoção:</b><br>
					Elder Druid<br>
					<br>
					<b>Ganhos por Nível:</b><br>
					10 oz de capacidade<br>
					5 pontos de vida<br>
					30 de Mana<br>
				",
				"informacoes" => array(
					"armamento" => array(
						2185 => "Rods"
					),
					"tipo" => "Mago",
					"elemento" => array("ice", "earth"),
					"promocao" => "Elder Druid",
					"ganhos" => array(10, 5, 30)
				)
			),
			3 => array(
				"campo" => "paladin",
				"exibicao" => "Paladin",
				"disponivel" => true,
				"texto" => "
					Ataque à distância<br>
					<b>Tipo:</b> Arqueiro<br>
					<b>Elemento:</b> <img src='imagens/icones/holy_icone.gif'/><br>
					<b>Promoção:</b><br>
					Royal Paladin<br>
					<br>
					<b>Ganhos por Nível:</b><br>
					20 oz de capacidade<br>
					10 pontos de vida<br>
					15 de Mana<br>
				",
				"informacoes" => array(
					"armamento" => array(
						2389 => "Lanças",
						2456 => "Arcos",
						2455 => "Bestas",
					),
					"tipo" => "Arqueiro",
					"elemento" => array("holy"),
					"promocao" => "Royal Paladin",
					"ganhos" => array(20, 10, 15)
				)
			),
			4 => array(
				"campo" => "knight",
				"exibicao" => "Knight",
				"disponivel" => true,
				"texto" => "
					Ataque corpo-a-corpo<br>
					<b>Tipo:</b> Cavaleiro<br>
					<b>Elemento:</b> <img src='imagens/icones/physical_icone.gif'/><br>
					<b>Promoção:</b><br>
					Elite Knight<br>
					<br>
					<b>Ganhos por Nível:</b><br>
					25 oz de capacidade<br>
					15 pontos de vida<br>
					5 de Mana<br>
				",
				"informacoes" => array(
					"armamento" => array(
						2387 => "Machados",
						2391 => "Clavas",
						2397 => "Espadas",
					),
					"tipo" => "Cavaleiro",
					"elemento" => array("physical"),
					"promocao" => "Elite Knight",
					"ganhos" => array(25, 15, 5)
				)
			),
			5 => array(
				"campo" => "master sorcerer",
				"exibicao" => "Master Sorcerer",
				"imagem" => "sorcerer"
			),
			6 => array(
				"campo" => "elder druid",
				"exibicao" => "Elder Druid",
				"imagem" => "druid"
			),
			7 => array(
				"campo" => "royal paladin",
				"exibicao" => "Royal Paladin",
				"imagem" => "paladin"
			),
			8 => array(
				"campo" => "elite knight",
				"exibicao" => "Elite Knight",
				"imagem" => "knight"
			)
		);
		public function transformarDiasTempo($dias){
			return $dias*24*60*60;
		}
		public function formatarLogin($tempo){
			$ClassFuncao = new Funcao();
			if($tempo > 0)
				$formatarLogin = $ClassFuncao->formatarData($tempo);
			else
				$formatarLogin = "Nunca efetuou login.";
			return $formatarLogin;
		}
		public function calcularIdadeTibia($tempoOnline){
			$dia = 3600;
			$mes = $dia*30;
			$ano = $mes*12;
			if($tempoOnline < 60)
				return;
			$idadeEmAnos = ($tempoOnline-(fmod($tempoOnline, $ano)))/$ano;
			if($idadeEmAnos > 0)
				return $idadeEmAnos." ano".($idadeEmAnos > 1 ? "s" : "");
			$idadeEmMeses = ($tempoOnline-(fmod($tempoOnline, $mes)))/$mes;
			if($idadeEmMeses > 0)
				return $idadeEmMeses." ".($idadeEmMeses > 1 ? "meses" : "mês");
			$idadeEmDias = ($tempoOnline-(fmod($tempoOnline, $dia)))/$dia;
			if($idadeEmDias > 0)
				return $idadeEmDias." dia".($idadeEmDias > 1 ? "s" : "");
		}
		public function getNomeCidade($cidadeId){
			$queryCidade = mysql_query("SELECT * FROM z_cidades WHERE (id LIKE '$cidadeId')");
			while($resultadoCidade = mysql_fetch_assoc($queryCidade))
				return $resultadoCidade["nome"];
			return "Cidade sem nome";
		}
		public function exibirGenero($genero){
			if($genero == 0)
				return "Feminino";
			else
				return "Masculino";
		}
		public function getCampoVocacao($vocacaoId){
			if(array_key_exists($vocacaoId, $this->vocacoes))
				return $this->vocacoes[$vocacaoId]["campo"];
			return $this->vocacoes[$vocacaoId][0];
		}
		public function getImagemVocacao($vocacaoId){
			$vocacao = $this->vocacoes[$vocacaoId];
			if($vocacao["imagem"])
				return $vocacao["imagem"];
			return $vocacao["campo"];
		}
		public function getNomeVocacao($vocacaoId){
			if(array_key_exists($vocacaoId, $this->vocacoes))
				return $this->vocacoes[$vocacaoId]["exibicao"];
			return $this->vocacoes[0]["exibicao"];
		}
		public function validarPersonagemConta($personagemId, $contaId){
			$contaPersonagemId = 0;
			$queryPersonagem = mysql_query("SELECT * FROM players WHERE (id LIKE '$personagemId')");
			while($resultadoPersonagem = mysql_fetch_assoc($queryPersonagem))
				$contaPersonagemId = $resultadoPersonagem["account_id"];
			if($contaId == $contaPersonagemId)
				return true;
			return false;
		}
		public function getStatusPersonagem($personagemId, $completo = 0){
			$exibirPersonagemStatus = '';
			$personagemStatus = 0;
			$queryPersonagemOnline = mysql_query("SELECT * FROM players_online WHERE (player_id LIKE '$personagemId')");
			while($resultadoPersonagemOnline = mysql_fetch_assoc($queryPersonagemOnline))
				$personagemStatus = 1;
			if($completo == 1){
				$queryPersonagem = mysql_query("SELECT * FROM players WHERE (id LIKE '$personagemId')");
				while($resultadoPersonagem = mysql_fetch_assoc($queryPersonagem))
					if($resultadoPersonagem["ocultar_conta"] == 1)
						$exibirPersonagemStatus .= '<b>Oculto</b><br>';
			}
			if($personagemStatus == 0)
				$exibirPersonagemStatus .= '<span class="vermelho">Offline</span>';
			elseif($personagemStatus == 1)
				$exibirPersonagemStatus .= '<span class="verde">Online</span>';
			return $exibirPersonagemStatus;
		}
		public function getInformacoesPersonagem($personagemId){
			$informacoesPersonagem = array();
			if(is_numeric($personagemId))
				$queryPersonagem = mysql_query("SELECT * FROM players WHERE (id LIKE '$personagemId')");
			else
				$queryPersonagem = mysql_query("SELECT * FROM players WHERE ((name LIKE '$personagemId') AND (deletion LIKE '0'))");
			while($resultadoPersonagem = mysql_fetch_assoc($queryPersonagem))
				$informacoesPersonagem = array(
					"id" => $resultadoPersonagem["id"],
					"contaId" => $resultadoPersonagem["account_id"],
					"nome" => $resultadoPersonagem["name"],
					"link" => $this->gerarLinkPersonagem($resultadoPersonagem["name"]),
					"genero" => $resultadoPersonagem["sex"],
					"exibirGenero" => $this->exibirGenero($resultadoPersonagem["sex"]),
					"lookBody" => $resultadoPersonagem["lookbody"],
					"lookFeet" => $resultadoPersonagem["lookfeet"],
					"lookHead" => $resultadoPersonagem["lookhead"],
					"lookLegs" => $resultadoPersonagem["looklegs"],
					"lookType" => $resultadoPersonagem["looktype"],
					"lookAddons" => $resultadoPersonagem["lookaddons"],
					"residencia" => $this->getNomeCidade($resultadoPersonagem["town_id"]),
					"nivel" => $resultadoPersonagem["level"],
					"vocacao" => $this->getNomeVocacao($resultadoPersonagem["vocation"]),
					"vocacao_campo" => $this->getCampoVocacao($resultadoPersonagem["vocation"]),
					"status" => $this->getStatusPersonagem($resultadoPersonagem["id"]),
					"comentario" => htmlentities($resultadoPersonagem["comentario"]),
					"exibirComentario" => preg_replace('/\n/', '<br>', htmlentities($resultadoPersonagem["comentario"]), $this->limiteLinhasComentario),
					"deletar" => $resultadoPersonagem["deletion"],
					"ocultar_conta" => $resultadoPersonagem["ocultar_conta"],
					"ultimo_login" => $this->formatarLogin($resultadoPersonagem["lastlogin"]),
					"idade_tibia" => $this->calcularIdadeTibia($resultadoPersonagem["onlinetime"])
				);
			return $informacoesPersonagem;
		}
		public function gerarLinkPersonagem($personagemNome){
			return '?p=personagens-'.urlencode(utf8_encode($personagemNome));
		}
		public function getListaPersonagens($contaId, $tabelaRank = ""){
			$listaPersonagens = array();
			$rank = 1;
			if(!empty($tabelaRank))
				$queryListaPersonagem = mysql_query("SELECT * FROM players WHERE (deletion LIKE '0') ORDER BY $tabelaRank DESC LIMIT 0,".$this->limiteRank);
			elseif(!empty($contaId))
				$queryListaPersonagem = mysql_query("SELECT * FROM players WHERE (account_id LIKE '$contaId')");
			while($resultadoListaPersonagem = mysql_fetch_assoc($queryListaPersonagem))
				if((empty($tabelaRank) AND (($resultadoListaPersonagem["deletion"] == 0) OR ($resultadoListaPersonagem["deletion"] >= time()))) OR ((!empty($tabelaRank)) AND ($resultadoListaPersonagem["group_id"] == 1) AND ($resultadoListaPersonagem["deletion"] == 0)))
					$listaPersonagens[] = array(
						"id" => $resultadoListaPersonagem["id"],
						"nome" => $resultadoListaPersonagem["name"],
						"link" => $this->gerarLinkPersonagem($resultadoListaPersonagem["name"]),
						"nivel" => $resultadoListaPersonagem["level"],
						"level" => $resultadoListaPersonagem["level"],
						"experience" => number_format($resultadoListaPersonagem["experience"], 0, "", "."),
						"skill_fist" => $resultadoListaPersonagem["skill_fist"],
						"skill_club" => $resultadoListaPersonagem["skill_club"],
						"skill_sword" => $resultadoListaPersonagem["skill_sword"],
						"skill_axe" => $resultadoListaPersonagem["skill_axe"],
						"skill_dist" => $resultadoListaPersonagem["skill_dist"],
						"skill_shielding" => $resultadoListaPersonagem["skill_shielding"],
						"skill_fishing" => $resultadoListaPersonagem["skill_fishing"],
						"rank" => $rank++,
						"vocacao" => $this->getNomeVocacao($resultadoListaPersonagem["vocation"]),
						"vocacao_campo" => $this->getCampoVocacao($resultadoListaPersonagem["vocation"]),
						"imagem" => $this->getImagemVocacao($resultadoListaPersonagem["vocation"]),
						"status" => $this->getStatusPersonagem($resultadoListaPersonagem["id"]),
						"statusCompleto" => $this->getStatusPersonagem($resultadoListaPersonagem["id"], 1),
						"deletar" => $resultadoListaPersonagem["deletion"],
						"ocultar_conta" => $resultadoListaPersonagem["ocultar_conta"]
					);
			return $listaPersonagens;
		}
		public function exibirListaPersonagens($listaPersonagens, $contaId = 0, $personagemAtualId = ""){
			$exibirListaPersonagens = "";
			if(count($listaPersonagens) > 0){
				foreach($listaPersonagens as $c => $v){
					$status = ($contaId == 0 ? $v["status"] : $v["statusCompleto"]);
					$ClassFuncao = new Funcao();
					$exibirTempoDeletado = $ClassFuncao->formatarData(time()+$this->transformarDiasTempo($this->diasDeletarPersonagem));
					$statusDeletado = '
						<b>Deletado</b> <div class="infoDeletado" exibirTempo="'.$exibirTempoDeletado.'"></div>
						<div class="boxInfo">
							<div class="HelperDivContainer">
								<center>
									<div class="HelperDivArrow"></div>
									Esse personagem será deletado em:<br>
									<b>'.$exibirTempoDeletado.'</b>.<br>
									<br>
									Você pode cancelar essa ação a qualquer momento antes dessa data.<br>
									<br>
									<img class="Ornament" src="imagens/corpo/ornamento.gif"><br>
								</center>
							</div>
						</div>
					';
					$status = ($v["deletar"] > 0 ? $statusDeletado : $status);
					$botoesContaPadrao = '<input type="button" class="botao editar_personagem" onClick="document.location = \'?p=minha_conta-'.$v["id"].'-editar\';" value="Editar" /><br>';
					$verificarDeletarPersonagem = $this->verificarDeletarPersonagem($listaPersonagens, $contaId);
					if($verificarDeletarPersonagem)
						$botoesContaPadrao .= '<input type="button" class="botao deletar_personagem" onClick="document.location = \'?p=minha_conta-'.$v["id"].'-deletar\';" value="Deletar" style="margin-top: 2px;" />';
					$botoesContaDeletado = '<input type="button" class="botao cancelar_deletar_personagem" onClick="document.location = \'?p=minha_conta-'.$v["id"].'-cancelar\';" value="Cancelar Deletar" />';
					$botoesConta = ($v["deletar"] > 0 ? $botoesContaDeletado : $botoesContaPadrao);
					$botoesPersonagem = '<input type="button" class="botao" value="Ver" onClick="document.location = \''.$v["link"].'\';" />';
					$botoes = ($contaId == 0 ? $botoesPersonagem : $botoesConta);
					if(($contaId > 0) OR (($contaId == 0) AND ($v["deletar"] == 0) AND (($v["ocultar_conta"] == 0) AND ((!empty($personagemAtualId)) AND ($v["id"] != $personagemAtualId)))))
						$exibirListaPersonagens .= '
							<tr class="item">
								<td width="10%" align="center">
									<img src="imagens/vocacoes/'.$v["imagem"].'_miniatura.png" alt="" title="'.$v["vocacao"].'" />
								</td>
								<td width="40%">
									<a href="'.$v["link"].'"><span class="grande">'.$v["nome"].'</span></a><br>
									<b>'.$v["vocacao"].' - Nível '.$v["nivel"].'</b>
								</td>
								<td width="20%" align="center">
									'.$status.'
								</td>
								<td width="25%" align="center">
									'.$botoes.'
								</td>
							</tr>
						';
				}
			}
			return $exibirListaPersonagens;
		}
		public function verificarDeletarPersonagem($listaPersonagens, $contaId){
			$deletar = 0;
			$ClassConta = new Conta();
			$informacoesConta = $ClassConta->getInformacoesConta($contaId, true);
			if(empty($informacoesConta["chave_recuperacao"]))
				return false;
			foreach($listaPersonagens as $c => $v)
				if($v["deletar"] > 0)
					$deletar++;
			if($deletar == count($listaPersonagens)-1)
				return false;
			return true;
		}
		public function getPersonagemSemVocacao($contaId){
			$personagemId = 0;
			$queryPersonagem = mysql_query("SELECT * FROM players WHERE ((account_id LIKE '$contaId') AND (vocation LIKE '0'))");
			while($resultadoPersonagem = mysql_fetch_assoc($queryPersonagem))
				$personagemId = $resultadoPersonagem["id"];
			return $personagemId;
		}
		public function mudarVocacaoPersonagem($personagemId, $vocacao){
			if(mysql_query("UPDATE players SET vocation = '$vocacao' WHERE id = '$personagemId'"))
				return true;
			return false;
		}
		public function checarPersonagemSemVocacao($contaId){
			$queryPersonagem = mysql_query("SELECT * FROM players WHERE (account_id LIKE '$contaId')");
			while($resultadoPersonagem = mysql_fetch_assoc($queryPersonagem))
				if($resultadoPersonagem["vocation"] == 0)
					return true;
			return false;
		}
		public function editarPersonagem($personagemId, $campo, $valor){
			if(mysql_query("UPDATE players SET $campo = '$valor' WHERE id = '$personagemId'"))
				return true;
			return false;
		}
		public function deletarPersonagem($personagemId, $informacoesConta, $dadosForm){
			if	((sha1($dadosForm["confirmar_senha"]) == $informacoesConta["password"]) AND
				($dadosForm["chave_recuperacao"] == $informacoesConta["chave_recuperacao"]) AND
				($this->verificarDeletarPersonagem($this->getListaPersonagens($informacoesConta["id"]), $informacoesConta["id"])))
				if(mysql_query("UPDATE players SET deletion = '".(time()+($this->transformarDiasTempo($this->diasDeletarPersonagem)))."' WHERE id = '$personagemId'"))
					return true;
			return false;
		}
		public function cancelarDeletarPersonagem($personagemId, $informacoesConta, $dadosForm){
			if((sha1($dadosForm["confirmar_senha"]) == $informacoesConta["password"]) AND ($dadosForm["chave_recuperacao"] == $informacoesConta["chave_recuperacao"]))
				if(mysql_query("UPDATE players SET deletion = '0' WHERE id = '$personagemId'"))
					return true;
			return false;
		}
		public function pegarUltimasMortesPersonagem($personagemId){
			$ultimasMortes = array();
			$queryUltimasMortes = mysql_query("SELECT * FROM player_deaths WHERE ((player_id LIKE '$personagemId') AND (time >= '".(time()-$this->diasUltimasMortes*24*60*60)."')) ORDER BY time DESC LIMIT 0,".$this->maximoUltimasMortes);
			while($resultadoUltimasMortes = mysql_fetch_assoc($queryUltimasMortes))
				$ultimasMortes[] = $resultadoUltimasMortes;
			return $ultimasMortes;
		}
		public function exibirUltimasMortesPersonagem($personagemId){
			$ClassFuncao = new Funcao();
			$ultimasMortes = $this->pegarUltimasMortesPersonagem($personagemId);
			if(count($ultimasMortes) == 0)
				return;
			$exibirUltimasMortes = '
				<div style="margin-bottom: 30px;">
					<table cellpadding="0" cellspacing="0" class="tabela odd" width="100%">
						<tr class="cabecalho">
							<td colspan="2">
								Mortes do Personagem
							</td>
						</tr>
						';
						foreach($ultimasMortes as $numeroMorte => $informacoesMorte){
							$mortoPor = ($informacoesMorte["is_player"] == 1 ? $this->exibirPersonagem($informacoesMorte["mostdamage_by"], true) : $informacoesMorte["mostdamage_by"]);
							$exibirUltimasMortes .= '
								<tr class="item">
									<td width="260" align="center">
										'.$ClassFuncao->formatarData($informacoesMorte["time"], true).'
									</td>
									<td>
										Morto no nível '.$informacoesMorte["level"].' para '.$mortoPor.'.
									</td>
								</tr>
							';
						}
						$exibirUltimasMortes .= '
					</table>
				</div>
			';
			return $exibirUltimasMortes;
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
				$ClassFuncao = new Funcao();
				foreach($ultimasMortes as $numeroMorte => $informacoesMorte){
					$mortoPor = ($informacoesMorte["is_player"] == 1 ? $this->exibirPersonagem($informacoesMorte["mostdamage_by"], true) : $informacoesMorte["mostdamage_by"]);
					$exibirUltimasMortes .= '
						<tr class="item">
							<td align="center">
								'.($numeroMorte+1).'
							</td>
							<td>
								'.$this->exibirPersonagem($informacoesMorte["player_id"], true).'
							</td>
							<td>
								'.$ClassFuncao->formatarData($informacoesMorte["time"], true).', no nível '.$informacoesMorte["level"].' para '.$mortoPor.'.
							</td>
						</tr>
					';
				}
			}
			return $exibirUltimasMortes;
		}
		public function pegarNomePersonagem($personagemId){
			$queryJogador = mysql_query("SELECT * FROM players WHERE (id LIKE '$personagemId')");
			while($resultadoJogador = mysql_fetch_assoc($queryJogador))
				return $resultadoJogador["name"];
			return "";
		}
		public function exibirPersonagem($personagemId, $link = false){
			$personagemNome = (is_numeric($personagemId) ? $this->pegarNomePersonagem($personagemId) : $personagemId);
			if(($link) and (!empty($personagemNome)))
				return '<a href="'.$this->gerarLinkPersonagem($personagemNome).'">'.$personagemNome.'</a>';
			if(empty($personagemNome))
				$personagemNome = "Jogador Sem Nome";
			return $personagemNome;
		}
		public function pegarImagemPersonagem($personagem, $z = ""){
			$arquivoImagem = 'includes/classes/ClassOutfit.php?id='.$personagem["lookType"].'&head='.$personagem["lookHead"].'&body='.$personagem["lookBody"].'&legs='.$personagem["lookLegs"].'&feet='.$personagem["lookFeet"].'&addons='.$personagem["lookAddons"].'&mount='.$personagem["lookMount"];
			$estilos = array("imagemOutfit");
			if($personagem["lookMount"] == 0)
				$estilos[] = 'semMontaria';
			$exibirZ = (!empty($z) ? ' style="position: relative; z-index: '.$z.';"' : '');
			return '
				<div class="imagemOutfit">
					<img src="'.$arquivoImagem.'" alt="'.$personagem["nome"].'" title="'.$personagem["nome"].'" border="0" class="'.implode(" ", $estilos).'"'.$exibirZ.' />
				</div>
			';
		}
	}
?>