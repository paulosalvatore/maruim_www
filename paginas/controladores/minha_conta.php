<?php
	session_start();
	require_once("../../conexao/conexao.php");
	include("../../includes/funcoes.php");
	check_is_ajax(__FILE__);
	include("../../includes/protocolo.php");
	foreach($_REQUEST as $c => $v)
		$$c = $v;
	$login = $_SESSION["login"];
	include("../../includes/classes/ClassConta.php");
	include("../../includes/classes/ClassPersonagem.php");
	$ClassConta = new Conta();
	$ClassPersonagem = new Personagem();
	$informacoesConta = $ClassConta->getInformacoesConta($login);
	if(count($informacoesConta) > 0){
		$contaId = $informacoesConta["id"];
		if(!empty($acao)){
			if($acao == "registrar_conta"){
				parse_str(addslashes($informacoesRegistrarConta), $informacoesRegistrarConta);
				if(sha1($informacoesRegistrarConta["confirmar_senha"]) == $informacoesConta["password"]){
					if($ClassConta->enviarEmailRegistro($informacoesConta))
						echo 1;
					else
						echo 0;
				}
				else
					echo 0;
			}
			elseif($acao == "editar_personagem"){
				if(!empty($personagemId)){
					if($ClassPersonagem->validarPersonagemConta($personagemId, $contaId)){
						parse_str(addslashes($informacoesEditarPersonagem), $informacoesEditarPersonagem);
						$comentario = $informacoesEditarPersonagem["comentario"];
						if(strlen($comentario) > 500)
							$comentario = substr($comentario, 0, 500);
						if($informacoesEditarPersonagem["ocultar_conta"] == "on")
							$ClassPersonagem->editarPersonagem($personagemId, "ocultar_conta", 1);
						else
							$ClassPersonagem->editarPersonagem($personagemId, "ocultar_conta", 0);
						if(!empty($comentario))
							$ClassPersonagem->editarPersonagem($personagemId, "comentario", $comentario);
						echo 1;
					}
					else
						echo 0;
				}
				else
					echo 0;
			}
			elseif($acao == "deletar_personagem"){
				if(!empty($personagemId)){
					if($ClassPersonagem->validarPersonagemConta($personagemId, $contaId)){
						parse_str(addslashes($informacoesDeletarPersonagem), $informacoesDeletarPersonagem);
						if($ClassPersonagem->deletarPersonagem($personagemId, $informacoesConta, $informacoesDeletarPersonagem))
							echo 1;
						else
							echo 0;
					}
					else
						echo 0;
				}
				else
					echo 0;
			}
			elseif($acao == "cancelar_deletar_personagem"){
				if(!empty($personagemId)){
					if(($ClassPersonagem->validarPersonagemConta($personagemId, $contaId)) AND ($ClassPersonagem->getListaPersonagens($contaId) > 1)){
						parse_str(addslashes($informacoesDeletarPersonagem), $informacoesDeletarPersonagem);
						if($ClassPersonagem->cancelarDeletarPersonagem($personagemId, $informacoesConta, $informacoesDeletarPersonagem))
							echo 1;
						else
							echo 0;
					}
					else
						echo 0;
				}
				else
					echo 0;
			}
			elseif($acao == "alterar_senha"){
				parse_str(addslashes($informacoesAlterarSenha), $informacoesAlterarSenha);
				if(($informacoesAlterarSenha["senha_atual"] != $informacoesAlterarSenha["nova_senha"]) AND ($informacoesConta["password"] == sha1($informacoesAlterarSenha["senha_atual"])) AND ($informacoesAlterarSenha["nova_senha"] == $informacoesAlterarSenha["confirmar_nova_senha"])){
					if($ClassConta->editarConta($contaId, "password", sha1($informacoesAlterarSenha["nova_senha"]))){
						session_unset();
						echo 1;
					}
					else
						echo 0;
				}
				else
					echo 0;
			}
			elseif($acao == "alterar_email"){
				parse_str(addslashes($informacoesAlterarEmail), $informacoesAlterarEmail);
				$checarEmail = mysql_fetch_array(mysql_query("SELECT COUNT(*) as total FROM accounts WHERE ((email LIKE '".$informacoesAlterarEmail["novo_email"]."') OR (email_novo LIKE '".$informacoesAlterarEmail["novo_email"]."') OR (proximo_email LIKE '".$informacoesAlterarEmail["novo_email"]."'))"));
				$checarEmail = $checarEmail["total"];
				if(($informacoesConta["email"] != $informacoesAlterarEmail["novo_email"]) AND ($informacoesConta["password"] == sha1($informacoesAlterarEmail["confirmar_senha"])) AND (preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $informacoesAlterarEmail["novo_email"])) AND ($checarEmail == 0)){
					if($ClassConta->solicitarAlteracaoEmail($informacoesConta, $informacoesAlterarEmail["novo_email"]))
						echo 1;
					else
						echo 0;
				}
				else
					echo 0;
			}
		}
		elseif(!empty($vocacao)){
			$vocacoes_permitidas = array(1, 2, 3, 4);
			if(!in_array($vocacao, $vocacoes_permitidas))
				$vocacao = 1;
			$personagemId = $ClassPersonagem->getUltimoPersonagem($contaId);
			if($ClassPersonagem->mudarVocacaoPersonagem($personagemId, $vocacao))
				$ClassConta->registrarUltimoAcesso($contaId);
		}
	}
?>