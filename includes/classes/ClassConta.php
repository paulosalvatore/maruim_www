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
			$conteudoEmail = '
				Welcome to Tibia!<br>
				<br>
				Thank you for registering for Tibia.<br>
				Account Name: '.$informacoesConta["name"].'  <br>
				To be able to fully experience all features of a Tibia free account,<br>
				you need to confirm your account. To do so, please click on the<br>
				following link:<br>
				http://127.0.0.1/?p=minha_conta-'.$emailCodigo.'-registrar<br>
				If clicking on the link does not work in your email program, please<br>
				copy and paste it into your browser. The link is possibly split up<br>
				due to a word-wrap.<br>
				Please make sure to copy the complete link.<br>
				Moreover, please read our security hints at<br>
				http://www.tibia.com/gameguides/?subtopic=securityhints<br>
				to learn more on how to protect your account.<br>
				See you in Tibia!<br>
				Your CipSoft Team<br>
			';
			$assunto = "Welcome to Tibia - Please Confirm Your Account";
			$cabecalho = "MIME-Version: 1.0\r\n";
			$cabecalho .= "Content-Type: text/html; charset=ISO_8859-1\r\n";
			$cabecalho .= "From: Maruim Server <atendimento@maruimserver.com.br>\r\n";
			$email = $informacoesConta["email"];
			if(mail($email, $assunto, $conteudoEmail, $cabecalho))
				return true;
			else
				return false;
		}
		public function validarCodigoEmail($codigoEmail, $campo){
			$codigoValidado = 0;
			if(!empty($codigoEmail)){
				$queryValidacaoCodigo = mysql_query("SELECT * FROM accounts WHERE ($campo LIKE '$codigoEmail')");
				while($resultadoValidacaoCodigo = mysql_fetch_assoc($queryValidacaoCodigo)){
					if($campo == "email_codigo"){
						if(empty($resultadoValidacaoCodigo["chave_recuperacao"]))
							$codigoValidado = $resultadoValidacaoCodigo[$campo];
					}
					elseif($campo == "proximo_email_codigo"){
						if(!empty($resultadoValidacaoCodigo["proximo_email"]))
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
			$conteudoEmail = '
				Welcome to Tibia!<br>
				<br>
				Thank you for registering for Tibia.<br>
				Account Name: '.$informacoesConta["name"].'<br>
				E-mail Antigo: '.$informacoesConta["email"].'<br>
				To be able to fully experience all features of a Tibia free account,<br>
				you need to confirm your account. To do so, please click on the<br>
				following link:<br>
				http://127.0.0.1/?p=minha_conta-'.$emailCodigo.'-alterar_email<br>
				If clicking on the link does not work in your email program, please<br>
				copy and paste it into your browser. The link is possibly split up<br>
				due to a word-wrap.<br>
				Please make sure to copy the complete link.<br>
				Moreover, please read our security hints at<br>
				http://www.tibia.com/gameguides/?subtopic=securityhints<br>
				to learn more on how to protect your account.<br>
				See you in Tibia!<br>
				Your CipSoft Team<br>
			';
			$assunto = "Welcome to Tibia - Por Favor Confirme Seu Novo E-mail";
			$cabecalho = "MIME-Version: 1.0\r\n";
			$cabecalho .= "Content-Type: text/html; charset=ISO_8859-1\r\n";
			$cabecalho .= "From: Maruim Server <atendimento@maruimserver.com.br>\r\n";
			if(mail($novoEmail, $assunto, $conteudoEmail, $cabecalho))
				return true;
			else
				return false;
		}
		public function iniciarAlteracaoEmail($informacoesConta){
			$ClassFuncao = new Funcao();
			$this->editarConta($informacoesConta["id"], "email_novo", $informacoesConta["proximo_email"]);
			$this->editarConta($informacoesConta["id"], "email_novo_tempo", time());
			$this->editarConta($informacoesConta["id"], "proximo_email", "");
			$this->editarConta($informacoesConta["id"], "proximo_email_codigo", "");
			$this->editarConta($informacoesConta["id"], "proximo_email_envio", 0);
		}
		public function alterarEmail($informacoesConta){
			print_r($email_novo);
			$this->editarConta($informacoesConta["id"], "email", $informacoesConta["email_novo"]);
			$this->editarConta($informacoesConta["id"], "email_novo", "");
			$this->editarConta($informacoesConta["id"], "email_novo_tempo", "");
		}
	}
?>