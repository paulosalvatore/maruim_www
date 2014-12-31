<?php
	$config_menu = array(
		"noticias" => array(
			"background" => 0,
			"opcoes" => array(
				"ultimas_noticias" => "Últimas Notícias",
				"arquivo_noticias" => "Arquivo de Notícias",
				"registro_mudancas" => "Registro de Mudanças"
			)
		),
		"conta" => array(
			"background" => 6,
			"opcoes" => array(
				"minha_conta" => "Minha Conta",
				"criar_conta" => "Criar Conta",
				"recuperar_conta" => "Recuperar Conta",
				"downloads" => "Downloads"
			)
		),
		"sobre" => array(
			"background" => 1,
			"opcoes" => array(
				"caracteristicas" => "Características",
				"screenshots" => "Screenshots"
			)
		),
		"guias" => array(
			"background" => 2,
			"opcoes" => array(
				"iniciando" => "Iniciando",
				"manual" => "Manual",
				"dicas_seguranca" => "Dicas de Segurança"
			)
		),
		"biblioteca" => array(
			"background" => 3,
			"opcoes" => array(
				"criaturas" => "Criaturas",
				"magias" => "Magias",
				"conquistas" => "Conquistas (?)",
				"tabela_experiencia" => "Tabela de Experiência",
				"mapas" => "Mapas",
				"cidades" => "Cidades (?)"
			)
		),
		"comunidade" => array(
			"background" => 4,
			"opcoes" => array(
				"personagens" => "Personagens",
				"rank" => "Rank",
				"estatisticas_abates" => "Estatísticas de Abates",
				"casas" => "Casas",
				"clas" => "Clãs",
				"enquetes" => "Enquetes (?)"
			)
		),
		"forum" => array(
			"background" => 5,
			"opcoes" => array(
				"forum_geral" => "Geral",
				"forum_comercio" => "Comércio",
				"forum_comunidade" => "Comunidade",
				"forum_suporte" => "Suporte",
				"forum_clas" => "Clãs"
			)
		),
		"suporte" => array(
			"background" => 7,
			"opcoes" => array(
				"faq" => "FAQ",
				"regras" => "Regras",
				"guia_tutor" => "Guia de Tutores"
			)
		),
		"shop" => array(
			"background" => 8,
			"opcoes" => array(
				"adquirir_pontos" => "Adquirir Pontos",
				"trocar_pontos" => "Trocar Pontos"
			)
		),
		"desenvolvedor" => array(
			"background" => 9,
			"opcoes" => array(
				"desenvolvedor_downloads" => "Downloads",
				"desenvolvedor_informacoes_uteis" => "Informações Úteis",
				"desenvolvedor_ids_utilizadas" => "IDs Utilizadas",
				"tarefas_jogo" => "Tarefas do Jogo"
			)
		)
	);
	$botoes_menu = '
		<div class="box">
			<div class="borda_superior"></div>
			';
			foreach($config_menu as $categoria_id => $categoria){
				$categoria_background = $categoria["background"];
				$categoria_opcoes = $categoria["opcoes"];
				$botoes_menu .= '
					<div class="categoria">
						<div class="botao">
							<div class="icone" style="background-position: -'.($categoria_background*32).'px;"></div>
							<div class="etiqueta" style="background-position: 0 -'.($categoria_background*22).'px;"></div>
							<div class="luz_verde se"></div>
							<div class="luz_verde sd"></div>
							<div class="luz_verde ie"></div>
							<div class="abrir_fechar_botao"></div>
						</div>
						<div class="opcoes">
							';
							foreach($categoria_opcoes as $botao_id => $botao_nome){
								$botoes_menu .= '
									<div class="opcao '.$botao_id.'">
										<a href="?p='.$botao_id.'">
											<div class="borda_esquerda"></div>
											<div class="icone"></div>
											<div class="texto">'.$botao_nome.'</div>
											<div class="borda_direita"></div>
										</a>
									</div>
								';
							}
							$botoes_menu .= '
						</div>
					</div>
				';
			}
			$botoes_menu .= '
			<div class="borda_inferior"></div>
		</div>
	';
	if($usuario_encontrado)
		$botao_criar_conta_sair = '<div class="botao_sair" onClick="document.location = \'includes/logout.php\';"></div>';
	else
		$botao_criar_conta_sair = '<div class="botao_criar_conta" onClick="document.location = \'?p=criar_conta\';"></div>';
	$conteudo_barra_esquerda .= '
		<div id="logo">
			<a href="?p=ultimas_noticias">
				<img src="imagens/barra_esquerda/logo.png" border="0">
			</a>
		</div>
		<div class="login_box">
			<div class="borda_superior"></div>
			<div class="conteudo_box">
				<div class="borda_esquerda"></div>
				<div class="botao_login">
					<a href="?p=minha_conta">
						<img src="imagens/barra_esquerda/jogar_agora.png" border="0">
					</a>
				</div>
				'.$botao_criar_conta_sair.'
				<div class="borda_direita"></div>
			</div>
			<div class="borda_inferior"></div>
		</div>
		'.$botoes_menu.'
	';
?>