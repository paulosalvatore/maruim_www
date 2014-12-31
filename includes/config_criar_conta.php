<?php
	$formulario_criacao_conta = array(
		array(
			"conta" => array(
				"exibicao" => "Conta",
				"tipo" => "texto",
				"size" => 30,
				"minlength" => 6,
				"maxlength" => 30,
				"tipo_dados" => array(
					"numeros" => true,
					"letras" => true,
					"simbolos" => false,
				),
				"tipo_dados_obrigatorio" => array(
					"numeros" => true,
					"letras" => true,
					"email" => false,
				),
				"obrigatorio" => true,
				"unico" => true,
				"tabela_verificacao" => "accounts",
				"campo_verificacao" => "name",
				"igual" => "",
				"msg_unico" => "Essa conta já está em uso. Por favor digite outra!",
				"msg_igual" => ""
			),
			"email" => array(
				"exibicao" => "E-mail",
				"tipo" => "texto",
				"size" => 30,
				"minlength" => 6,
				"maxlength" => 50,
				"tipo_dados" => array(
					"numeros" => true,
					"letras" => true,
					"simbolos" => true,
				),
				"tipo_dados_obrigatorio" => array(
					"numeros" => false,
					"letras" => false,
					"email" => true,
				),
				"obrigatorio" => true,
				"unico" => true,
				"tabela_verificacao" => "accounts",
				"campo_verificacao" => "email",
				"igual" => "",
				"msg_unico" => "Esse e-mail já está em uso. Por favor digite outro!",
				"msg_igual" => ""
			),
			"senha" => array(
				"exibicao" => "Senha",
				"tipo" => "texto",
				"size" => 30,
				"minlength" => 8,
				"maxlength" => 30,
				"tipo_dados" => array(
					"numeros" => true,
					"letras" => true,
					"simbolos" => true
				),
				"tipo_dados_obrigatorio" => array(
					"numeros" => true,
					"letras" => true,
					"email" => false
				),
				"obrigatorio" => true,
				"unico" => false,
				"igual" => "",
				"msg_unico" => "",
				"msg_igual" => ""
			),
			"repetir_senha" => array(
				"exibicao" => "Repita a Senha",
				"tipo" => "texto",
				"size" => 30,
				"minlength" => 8,
				"maxlength" => 30,
				"tipo_dados" => array(
					"numeros" => true,
					"letras" => true,
					"simbolos" => true
				),
				"tipo_dados_obrigatorio" => array(
					"numeros" => true,
					"letras" => true,
					"email" => false
				),
				"obrigatorio" => true,
				"unico" => false,
				"igual" => "senha",
				"msg_unico" => "",
				"msg_igual" => "As senhas digitadas devem ser iguais.",
				"msg_igual_vazio" => "Por favor digite uma senha."
			),
		),
		array(
			"nome_personagem" => array(
				"exibicao" => "Nome do Personagem",
				"tipo" => "texto",
				"size" => 30,
				"minlength" => 3,
				"maxlength" => 30,
				"tipo_dados" => array(
					"numeros" => true,
					"letras" => true,
					"simbolos" => false,
				),
				"tipo_dados_obrigatorio" => array(
					"numeros" => false,
					"letras" => false,
					"email" => false,
				),
				"sugestao" => true,
				"obrigatorio" => true,
				"unico" => true,
				"tabela_verificacao" => "players",
				"campo_verificacao" => "name",
				"igual" => "",
				"msg_unico" => "Esse nome já está em uso. Por favor digite outro!",
				"msg_igual" => ""
			),
			"sexo_personagem" => array(
				"exibicao" => "Sexo",
				"tipo" => "opcao_radio",
				"opcoes" => array(
					array(
						"exibicao" => "Masculino",
						"valor" => 1
					),
					array(
						"exibicao" => "Feminino",
						"valor" => 0
					)
				),
				"opcao_ativa" => 1,
				"obrigatorio" => true,
				"msg_opcao_inexistente" => "O valor atribuído para o sexo do personagem não é válido."
			),
		)
	);
?>