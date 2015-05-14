<?php
	$limite_noticias_rapidas = 5;
	$limite_noticias = 5;
	$categorias_noticias_rapidas = array(
		"CipSoft",
		"Comunidade",
		"Desenvolvimento",
		"Suporte",
		"Problemas Tщcnicos",
	);
	$noticias_rapidas_min = mysql_fetch_array(mysql_query("SELECT MIN(data) as valor FROM z_noticias_rapidas;"));
	$noticias_min = mysql_fetch_array(mysql_query("SELECT MIN(data) as valor FROM z_noticias;"));
	$data_min[] = $noticias_rapidas_min["valor"];
	$data_min[] = $noticias_min["valor"];
	$data_min = gmdate("d/m/Y", min($data_min));
	$config["login_obrigatorio"] = array(
		"criar_noticia"
	);
	$config["acesso_restrito"] = array(
		"criar_noticia"
	);
	$config["players"] = array(
		"lookbody" => 44,
		"lookfeet" => 98,
		"lookhead" => 15,
		"looklegs" => 76,
		"looktype" => 128,
		"town_id" => 1,
		"posx" => 1000,
		"posy" => 1000,
		"posz" => 7,
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
			"nome" => "Data de Criaчуo",
			"coluna" => "exibirDataCriacao"
		),
		"ultimo_login" => array(
			"nome" => "кltimo Login",
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
		"premium_time" => array(
			"nome" => "Premium Time",
			"descricao" => "Adquira Premium Time para sua conta.",
			"itens" => array(),
		),
		"premium_scroll" => array(
			"nome" => "Premium Scroll",
			"descricao" => "Adquira Premium Scroll para sua conta.",
			"itens" => array(),
		),
		"servicos_extras" => array(
			"nome" => "Serviчos Extras",
			"descricao" => "Buy an extra service to transfer a character to another game world, to change your character name or sex, to change your account name, or to get a new recovery key.",
		),
		"montaria" => array(
			"nome" => "Montaria",
			"descricao" => "Buy your characters one or more of the fabulous mounts offered here.",
		),
		"outfits" => array(
			"nome" => "Outfits",
			"descricao" => "Buy your characters one or more of the fancy outfits offered here.",
		),
		"itens" => array(
			"nome" => "Itens",
			"descricao" => "Buy items for your character be more stronger in the game.",
		)
	);
?>