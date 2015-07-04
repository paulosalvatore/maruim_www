<?php
	class Conta {
		public $diasTrocarEmail = 7;
		public $delayReenvio = 60;
		public function getStatusConta($status){
			if($status == 0)
				return '<span class="vermelho">Conta Gratuita</span>';
			else
				return '<span class="verde">Conta Premium</span>';
		}
		public function getInformacoesConta($conta, $id = false){
			if($id)
				$queryConta = mysql_query("SELECT * FROM accounts WHERE (id LIKE '$conta')");
			else
				$queryConta = mysql_query("SELECT * FROM accounts WHERE (name LIKE '$conta')");
			while($resultadoConta = mysql_fetch_assoc($queryConta)){
				foreach($resultadoConta as $c => $v){
					if($c == "creation"){
						$ClassFuncao = new Funcao();
						$informacoesConta["exibirDataCriacao"] = $ClassFuncao->formatarData($v);
					}
					elseif($c == "pontos")
						$informacoesConta["exibirPontos"] = ($v > 1 ? $v." pontos" : $v." ponto");
					$informacoesConta[$c] = $v;
				}
			}
			return $informacoesConta;
		}
		public function getResultado($conta, $campo){
			$valor = "";
			$queryConta = mysql_query("SELECT * FROM accounts WHERE (id LIKE '$conta')");
			while($resultadoConta = mysql_fetch_assoc($queryConta))
				$valor = $resultadoConta[$campo];
			return $valor;
		}
		public function registrarUltimoAcesso($contaId){
			mysql_query("UPDATE accounts SET ultimo_acesso = '".time()."' WHERE id = '$contaId'");
		}
		public function enviarEmailRegistro($informacoesConta){
			$emailCodigo = $this->gerarEmailCodigo($informacoesConta["id"]);
			$this->editarConta($informacoesConta["id"], "email_codigo", $emailCodigo);
			$link = 'http://'.$_SERVER["HTTP_HOST"].'/?p=minha_conta-'.$emailCodigo.'-registrar';
			$conteudoEmail = '
				Seja bem-vindo ao MaruimOT!<br>
				<br>
				Obrigado por registrar sua conta.<br>
				<br>
				<b>Conta:</b> '.$informacoesConta["name"].'<br>
				<br>
				Para ser capaz de experimentar completamente todos os recursos disponíveis,<br>
				você precisa confirmar a sua conta. Para fazer isso, clique no seguinte link:<br>
				<a href="'.$link.'">'.$link.'</a><br>
				Caso clicar sobre o link não funciona em seu e-mail, por favor<br>
				copie e cole no seu navegador.<br>
				Certifique-se de que copiou ou endereço completo.<br>
				Além disso, por favor leia as nossas dicas de segurança em<br>
				http://'.$_SERVER["HTTP_HOST"].'/?p=dicas_seguranca<br>
				para saber um pouco mais sobre como proteger sua conta.<br>
				<br>
				Nos vemos no MaruimOT!<br>
				<br>
				<b>Atenciosamente,<br>
				Equipe MaruimOT.</b><br>
			';
			$assunto = "Equipe MaruimOT! - Registrar Conta";
			$cabecalho = "MIME-Version: 1.0\r\n";
			$cabecalho .= "Content-Type: text/html; charset=ISO_8859-1\r\n";
			$cabecalho .= "From: MaruimOT <maruimot@gmail.com>\r\n";
			$email = $informacoesConta["email"];
			if(mail($email, $assunto, $conteudoEmail, $cabecalho))
				return true;
			else
				return false;
		}
		public function validarCodigoEmail($codigoEmail, $campo, $checar = true){
			$codigoValidado = 0;
			if(!empty($codigoEmail)){
				$queryValidacaoCodigo = mysql_query("SELECT * FROM accounts WHERE ($campo LIKE '$codigoEmail')");
				while($resultadoValidacaoCodigo = mysql_fetch_assoc($queryValidacaoCodigo)){
					if($campo == "email_codigo"){
						if(empty($resultadoValidacaoCodigo["chave_recuperacao"]))
							$codigoValidado = $resultadoValidacaoCodigo[$campo];
					}
					elseif($campo == "proximo_email_codigo"){
						if((!$checar) or ($checar and !empty($resultadoValidacaoCodigo["proximo_email"])))
							$codigoValidado = $resultadoValidacaoCodigo[$campo];
					}
				}
			}
			return $codigoValidado;
		}
		public function gerarEmailCodigo($contaId){
			return sha1($contaId).substr(sha1(microtime()), 0, 20).substr(sha1(microtime()), 0, 10).substr(md5(microtime()), 0, 20).substr(md5(microtime()), 0, 10);
		}
		public function registrarConta($contaId, $chaveRecuperacao){
			if(($this->editarConta($contaId, "chave_recuperacao", $chaveRecuperacao)) AND ($this->editarConta($contaId, "email_codigo", "")))
				return true;
			return false;
		}
		public function gerarChaveRecuperacao($contaId){
			return strtoupper(substr(md5($contaId), 0, 6)."-".substr(md5(microtime()), 0, 6)."-".substr(sha1(microtime()), 0, 6)."-".substr(sha1($contaId), 0, 6));
		}
		public function editarConta($contaId, $campo, $valor){
			if(mysql_query("UPDATE accounts SET $campo = '$valor' WHERE id = '$contaId'"))
				return true;
			return false;
		}
		public function validarConta($conta, $senha){
			$validarConta = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM accounts WHERE ((name LIKE '$conta') AND (password LIKE '$senha'))"));
			$validarConta = $validarConta["total"];
			if($validarConta == 1)
				return true;
			return false;
		}
		public function solicitarAlteracaoEmail($informacoesConta, $novoEmail){
			$emailCodigo = $this->gerarEmailCodigo($informacoesConta["id"]);
			$this->editarConta($informacoesConta["id"], "proximo_email", $novoEmail);
			$this->editarConta($informacoesConta["id"], "proximo_email_codigo", $emailCodigo);
			$this->editarConta($informacoesConta["id"], "proximo_email_envio", time());
			$linkConfirmar = 'http://'.$_SERVER["HTTP_HOST"].'/?p=minha_conta-'.$emailCodigo.'-alterar_email';
			$linkInformar = 'http://'.$_SERVER["HTTP_HOST"].'/?p=minha_conta-'.$emailCodigo.'-cancelar_alteracao_email';
			$conteudoEmailConfirmar = '
				Caro jogador,<br>
				<br>
				Registramos a sua solicitação de alteração do e-mail.<br>
				<br>
				<b>Conta:</b> '.$informacoesConta["name"].'<br>
				<b>E-mail Atual:</b> '.$informacoesConta["email"].'<br>
				<b>Novo E-mail:</b> '.$novoEmail.'<br>
				<br>
				Para sua segurança, é necessário confirmar a solicitação da troca do e-mail.<br>
				Para fazer isso, clique no seguinte link:<br>
				<a href="'.$linkConfirmar.'">'.$linkConfirmar.'</a><br>
				Caso clicar sobre o link não funciona em seu e-mail, por favor<br>
				copie e cole no seu navegador.<br>
				Certifique-se de que copiou ou endereço completo.<br>
				<br>
				Após a confirmação, em '.$this->diasTrocarEmail.' dias o e-mail será trocado.<br>
				<br>
				Além disso, por favor leia as nossas dicas de segurança em<br>
				http://'.$_SERVER["HTTP_HOST"].'/?p=dicas_seguranca<br>
				para saber um pouco mais sobre como proteger sua conta.<br>
				<br>
				Nos vemos no MaruimOT!<br>
				<br>
				<b>Atenciosamente,<br>
				Equipe MaruimOT.</b><br>
			';
			$conteudoEmailInformar = '
				Caro jogador,<br>
				<br>
				Uma solicitação de alteração do e-mail foi registrada em sua conta.<br>
				<br>
				<b>Conta:</b> '.$informacoesConta["name"].'<br>
				<b>E-mail Atual:</b> '.$informacoesConta["email"].'<br>
				<b>Novo E-mail:</b> '.$novoEmail.'<br>
				<br>
				Caso você não tenha solicitado essa troca, clique no seguinte link:<br>
				<a href="'.$linkInformar.'">'.$linkInformar.'</a><br>
				Caso clicar sobre o link não funciona em seu e-mail, por favor<br>
				copie e cole no seu navegador.<br>
				Certifique-se de que copiou ou endereço completo.<br>
				<br>
				Além disso, por favor leia as nossas dicas de segurança em<br>
				http://'.$_SERVER["HTTP_HOST"].'/?p=dicas_seguranca<br>
				para saber um pouco mais sobre como proteger sua conta.<br>
				<br>
				Nos vemos no MaruimOT!<br>
				<br>
				<b>Atenciosamente,<br>
				Equipe MaruimOT.</b><br>
			';
			$assuntoConfirmar = "Equipe MaruimOT! - Confirmar Troca de E-mail";
			$assuntoInformar = "Equipe MaruimOT! - Troca de E-mail Solicitada";
			$cabecalho = "MIME-Version: 1.0\r\n";
			$cabecalho .= "Content-Type: text/html; charset=ISO_8859-1\r\n";
			$cabecalho .= "From: MaruimOT <maruimot@gmail.com>\r\n";
			mail($novoEmail, $assuntoConfirmar, $conteudoEmailConfirmar, $cabecalho);
			mail($informacoesConta["email"], $assuntoInformar, $conteudoEmailInformar, $cabecalho);
			return true;
		}
		public function cancelarSolicitacaoTrocaEmail($contaId){
			$this->editarConta($contaId, "email_novo", "");
			$this->editarConta($contaId, "email_novo_tempo", 0);
			$this->editarConta($contaId, "proximo_email", "");
			$this->editarConta($contaId, "proximo_email_envio", 0);
			$this->editarConta($contaId, "proximo_email_codigo", "");
		}
		public function iniciarAlteracaoEmail($informacoesConta){
			$this->editarConta($informacoesConta["id"], "email_novo", $informacoesConta["proximo_email"]);
			$this->editarConta($informacoesConta["id"], "email_novo_tempo", time());
			$this->editarConta($informacoesConta["id"], "proximo_email", "");
			$this->editarConta($informacoesConta["id"], "proximo_email_envio", 0);
		}
		public function alterarEmail($informacoesConta){
			$this->editarConta($informacoesConta["id"], "email", $informacoesConta["email_novo"]);
			$this->editarConta($informacoesConta["id"], "email_novo", "");
			$this->editarConta($informacoesConta["id"], "email_novo_tempo", "");
			$this->editarConta($informacoesConta["id"], "proximo_email_codigo", "");
		}
		public function exibirProblemas($cabecalho, $listaProblemas){
			$exibirProblemas = '
				<table class="tabela dark" cellpadding="0" cellspacing="0" width="100%">
					<tr class="cabecalho">
						<td colspan="2">
							'.$cabecalho.'
						</td>
					</tr>
					';
					$posicao = 0;
					foreach($listaProblemas as $problema => $exibicaoProblema){
						$exibicaoProblema .= ".";
						$posicao++;
						if($problema == "enviar_email")
							$exibicaoProblema .= '
								
							';
						$exibirProblemas .= '
							<tr class="item">
								<td width="20" align="center">
									<input type="radio" id="'.$posicao.'" name="problema" value="'.$problema.'" />
								</td>
								<td>
									<label for="'.$posicao.'">'.$exibicaoProblema.'</label>
								</td>
							</tr>
						';
					}
					$exibirProblemas .= '
				</table>
			';
			return $exibirProblemas;
		}
	}
?>