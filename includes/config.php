<?php
	$exibirProfissoes = false;
	$limite_noticias_rapidas = 5;
	$limite_noticias = 5;
	$categorias_noticias_rapidas = array(
		"CipSoft",
		"Comunidade",
		"Desenvolvimento",
		"Suporte",
		"Problemas T�cnicos",
	);
	$noticias_rapidas_min = mysql_fetch_array(mysql_query("SELECT MIN(data) as valor FROM z_noticias_rapidas;"));
	$noticias_min = mysql_fetch_array(mysql_query("SELECT MIN(data) as valor FROM z_noticias;"));
	$data_min[] = $noticias_rapidas_min["valor"];
	$data_min[] = $noticias_min["valor"];
	$data_min = gmdate("d/m/Y", min($data_min));
	$config["versao"] = array(
		"valor" => "1078",
		"exibicao" => "10.78"
	);
	$config["info"] = array(
		"ip" => "maruim.servegame.com",
		"protecao" => 1,
		"taxas" => array(
			"experiencia" => array(
				1 => 4,
				9 => 15,
				51 => 12,
				81 => 10,
				121 => 6,
				151 => 5,
				171 => 3,
				201 => 2,
				221 => 1
			),
			"skill" => 15,
			"magic" => 5,
			"loot" => "Personalizada"
		),
		"red" => 3,
		"black" => 6,
		"tempo_frag" => "24 horas",
		"casas" => array(
			"sqm" => 1000,
			"aluguel" => array(1000, "semanalmente"),
			"nivel" => 1,
			"tempo" => "30 dias"
		)
	);
	$config["login_obrigatorio"] = array(
		"reportacoes"
	);
	$config["acesso_restrito"] = array(
		"criar_noticia",
		"desenvolvedor_downloads",
		"desenvolvedor_gerenciamento",
		"desenvolvedor_ids_utilizadas",
		"desenvolvedor_informacoes_uteis",
		"desenvolvedor_orcish",
		"desenvolvedor_tarefas",
		"criar_npc"
	);
	$config["players"] = array(
		"lookbody" => 44,
		"lookfeet" => 98,
		"lookhead" => 15,
		"looklegs" => 76,
		"looktype0" => 136,
		"looktype1" => 128,
		"town_id" => 1,
		"posicoes" => array(
			1 => array(600, 983, 7),
			2 => array(545, 948, 5),
			3 => array(448, 957, 2),
			4 => array(647, 902, 8)
		),
		"cap" => 420,
		"maxPersonagens" => 5
	);
	$config["minha_conta"] = array(
		"conta" => array(
			"nome" => "Conta",
			"coluna" => "name",
			"ocultar_caracteres" => true
		),
		"email" => array(
			"nome" => "E-mail",
			"coluna" => "email",
			"ocultar_caracteres" => true
		),
		"data_criacao" => array(
			"nome" => "Data de Cria��o",
			"coluna" => "exibirDataCriacao"
		),
		"ultimo_login" => array(
			"nome" => "�ltimo Login",
			"coluna" => "ultimo_acesso",
			"formatar" => "data",
			"mensagem_valor_vazio" => "Nunca efetuou login."
		),
		"status_conta" => array(
			"nome" => "Status da Conta",
			"coluna" => "premdays"
		),
		"registro_conta" => array(
			"nome" => "Registro da Conta",
			"coluna" => "chave_recuperacao"
		)
	);
	$config["servicos"] = array(
		"premium" => array(
			"nome" => "Premium / Pontos",
			"descricao" => "Adquira Premium Scroll ou Pontos para sua conta.",
			"padrao" => true
		),
		"servicos_extras" => array(
			"nome" => "Servi�os Extras",
			"descricao" => "Compre um servi�o extra para trocar o nome ou o sexo de seu personagem, trocar o nome da sua conta ou adquirir uma nova chave de recupera��o."
		),
		"montarias" => array(
			"nome" => "Montarias",
			"descricao" => "Compre para seus personagens fabulosas montarias ofertadas aqui."
		),
		"outfits" => array(
			"nome" => "Outfits",
			"descricao" => "Compre para seus personagens estilosos outfits ofertados aqui."
		),
		"itens" => array(
			"nome" => "Itens",
			"descricao" => "Compre itens para seus personagens e fique mais forte no jogo."
		)
	);
?>