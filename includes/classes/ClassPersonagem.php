<?php
	class Personagem {
		public $limiteRank = 100;
		public $diasDeletarPersonagem = 30;
		private $cidades = array(
			1 => "Cidade"
		);
		private $vocacoes = array(
			0 => array("campo" => "nenhuma", "exibicao" => "Nenhuma"),
			1 => array("campo" => "arqueiro", "exibicao" => "Arqueiro"),
			2 => array("campo" => "feiticeiro", "exibicao" => "Feiticeiro"),
			3 => array("campo" => "clerigo", "exibicao" => "Clérigo"),
			4 => array("campo" => "cavaleiro", "exibicao" => "Cavaleiro")
		);
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
		public function getNomeCidade($cidadeId){
			if(in_array($cidadeId, $this->cidades))
				return $this->cidades[$cidadeId];
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
					"nome" => $resultadoPersonagem["name"],
					"genero" => $resultadoPersonagem["sex"],
					"exibirGenero" => $this->exibirGenero($resultadoPersonagem["sex"]),
					"residencia" => $this->getNomeCidade($resultadoPersonagem["town_id"]),
					"nivel" => $resultadoPersonagem["level"],
					"vocacao" => $this->getNomeVocacao($resultadoPersonagem["vocation"]),
					"vocacao_campo" => $this->getCampoVocacao($resultadoPersonagem["vocation"]),
					"status" => $this->getStatusPersonagem($resultadoPersonagem["id"]),
					"comentario" => $resultadoPersonagem["comentario"],
					"deletar" => $resultadoPersonagem["deletion"],
					"ocultar_conta" => $resultadoPersonagem["ocultar_conta"],
					"ultimo_login" => $this->formatarLogin($resultadoPersonagem["lastlogin"])
				);
			return $informacoesPersonagem;
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
						"link" => '?p=personagens-'.urlencode($resultadoListaPersonagem["name"]),
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
					$exibirTempoDeletado = $this->formatarData(time()+$this->transformarDiasTempo($this->diasDeletarPersonagem));
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
								<td width="10%">
									<img src="imagens/vocacoes/'.$v["vocacao_campo"].'_miniatura.png">
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
		public function getUltimoPersonagem($contaId){
			$personagemId = 0;
			$queryPersonagem = mysql_query("SELECT * FROM players WHERE (account_id LIKE '$contaId')");
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
	}
?>