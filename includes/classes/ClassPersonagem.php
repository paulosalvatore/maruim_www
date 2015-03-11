<?php
	class Personagem {
		private $limiteRank = 100;
		private $cidades = array(
			1 => "Cidade"
		);
		private $vocacoes = array(
			0 => array("campo" => "nenhuma", "exibicao" => "Nenhuma"),
			1 => array("campo" => "arqueiro", "exibicao" => "Arqueiro"),
			2 => array("campo" => "cavaleiro", "exibicao" => "Cavaleiro"),
			3 => array("campo" => "feiticeiro", "exibicao" => "Feiticeiro"),
			4 => array("campo" => "clerigo", "exibicao" => "Clérigo")
		);
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
			return $this->cidades[$cidadeId];
		}
		public function exibirGenero($genero){
			if($genero == 0)
				return "Feminino";
			else
				return "Masculino";
		}
		public function getCampoVocacao($vocacaoId){
			return $this->vocacoes[$vocacaoId]["campo"];
		}
		public function getNomeVocacao($vocacaoId){
			return $this->vocacoes[$vocacaoId]["exibicao"];
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
				$queryPersonagem = mysql_query("SELECT * FROM players WHERE (name LIKE '$personagemId')");
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
					"ocultar_conta" => $resultadoPersonagem["ocultar_conta"],
					"ultimo_login" => $this->formatarLogin($resultadoPersonagem["lastlogin"])
				);
			return $informacoesPersonagem;
		}
		public function getListaPersonagens($contaId, $tabelaRank = ""){
			$listaPersonagens = array();
			$rank = 1;
			if(!empty($tabelaRank))
				$queryListaPersonagem = mysql_query("SELECT * FROM players ORDER BY $tabelaRank DESC LIMIT 0,".$this->limiteRank);
			elseif(!empty($contaId))
				$queryListaPersonagem = mysql_query("SELECT * FROM players WHERE (account_id LIKE '$contaId')");
			while($resultadoListaPersonagem = mysql_fetch_assoc($queryListaPersonagem))
				if((empty($tabelaRank)) OR ((!empty($tabelaRank)) AND ($resultadoListaPersonagem["group_id"] == 1)))
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
						"ocultar_conta" => $resultadoListaPersonagem["ocultar_conta"]
					);
			return $listaPersonagens;
		}
		public function getRank($rank){
			$rank = 1;
			$listaRank = array();
			$queryListaPersonagem = mysql_query("SELECT * FROM players ORDER BY $rank ASC");
			while($resultadoListaPersonagem = mysql_fetch_assoc($queryListaPersonagem))
				if($resultadoListaPersonagem["group_id"] == 1)
					$listaRank[] = array(
						"id" => $resultadoListaPersonagem["id"],
						"nome" => $resultadoListaPersonagem["name"],
						"link" => '?p=personagens-'.urlencode($resultadoListaPersonagem["name"]),
						"nivel" => $resultadoListaPersonagem["level"],
						"experience" => $resultadoListaPersonagem["experience"],
						"skill_fist" => $resultadoListaPersonagem["skill_fist"],
						"skill_club" => $resultadoListaPersonagem["skill_club"],
						"skill_sword" => $resultadoListaPersonagem["skill_sword"],
						"skill_axe" => $resultadoListaPersonagem["skill_axe"],
						"skill_dist" => $resultadoListaPersonagem["skill_dist"],
						"skill_shielding" => $resultadoListaPersonagem["skill_shielding"],
						"skill_fishing" => $resultadoListaPersonagem["skill_fishing"],
						"rank" => $rank++
					);
			return $listaRank;
		}
		public function exibirListaPersonagens($listaPersonagens, $paginaConta = 0, $personagemAtualId = ""){
			$exibirListaPersonagens = "";
			if(count($listaPersonagens) > 0){
				foreach($listaPersonagens as $c => $v){
					$status = ($paginaConta == 0 ? $v["status"] : $v["statusCompleto"]);
					$botoesConta = '
						<input type="button" class="botao editar_personagem" personagem="'.$v["id"].'" value="Editar" /><br>
						<input type="button" class="botao" value="Deletar" onClick="alert(\'Opção indisponível no momento.\');" style="margin-top: 2px;" />
					';
					$botoesPersonagem = '
						<input type="button" class="botao" value="Ver" onClick="document.location = \''.$v["link"].'\';" />
					';
					$botoes = ($paginaConta == 0 ? $botoesPersonagem : $botoesConta);
					if(($paginaConta == 1) OR (($paginaConta == 0) AND(($v["ocultar_conta"] == 0)AND((!empty($personagemAtualId)) AND ($v["id"] != $personagemAtualId)))))
						$exibirListaPersonagens .= '
							<tr class="item">
								<td width="10%">
									<img src="imagens/vocacoes/'.$v["vocacao_campo"].'_miniatura.png">
								</td>
								<td width="50%">
									<a href="'.$v["link"].'"><span class="grande">'.$v["nome"].'</span></a><br>
									<b>'.$v["vocacao"].' - Nível '.$v["nivel"].'</b>
								</td>
								<td width="20%" align="center">
									'.$status.'
								</td>
								<td width="20%" align="center">
									'.$botoes.'
								</td>
							</tr>
						';
				}
			}
			return $exibirListaPersonagens;
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
	}
?>