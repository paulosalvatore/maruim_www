<?php
	$formulario_criacao_personagem = array(
		array(
			"nome_personagem" => array(
				"exibicao" => "Nome do Personagem",
				"tipo" => "texto",
				"size" => 25,
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
				"msg_unico" => "Esse nome j� est� em uso. Por favor digite outro!",
				"msg_igual" => ""
			),
			"sexo_personagem" => array(
				"exibicao" => "G�nero",
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
				"msg_opcao_inexistente" => "O valor atribu�do para o sexo do personagem n�o � v�lido."
			),
			"vocacao_personagem" => array(
				"exibicao" => "Voca��o",
				"tipo" => "lista",
				"opcoes" => array(
					array(
						"exibicao" => "Arqueiro",
						"valor" => 1
					),
					array(
						"exibicao" => "Feiticeiro",
						"valor" => 2
					),
					array(
						"exibicao" => "Cl�rigo",
						"valor" => 3
					),
					array(
						"exibicao" => "Cavaleiro",
						"valor" => 4
					)
				),
				"opcao_ativa" => 1,
				"obrigatorio" => true,
				"msg_opcao_inexistente" => "O valor atribu�do para a voca��o do personagem n�o � v�lido."
			)
		)
	);
?>