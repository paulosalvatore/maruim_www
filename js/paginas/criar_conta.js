function inserirValidacao(tipo, campo, mensagem){
	if(tipo == "erro"){
		$("#"+campo)
		.closest("td")
		.find(".mensagem_erro")
		.html(mensagem)
		.closest("td")
		.find(".imagem")
		.addClass("errado")
		.removeClass("certo")
		.closest("tr")
		.find(".exibicao_bloco")
		.css({
			color: "red"
		});
	}
	else if(tipo == "sucesso"){
		$("#"+campo)
		.closest("td")
		.find(".mensagem_erro")
		.html("")
		.closest("td")
		.find(".imagem")
		.addClass("certo")
		.removeClass("errado")
		.closest("tr")
		.find(".exibicao_bloco")
		.css({
			color: ""
		});
	}
};
function verificarCampo(campo, valor){
	if(campo == "acordo"){
		if(!valor){
			inserirValidacao("erro", "acordo", "Você precisa concordar com o Acordo de Serviço, as Regras e a Política de Privacidade, respectivamente, para criar sua conta!");
			retorno = false;
		}
		else
			inserirValidacao("sucesso", "acordo");
	}
	else{
		campo_igual = $("#"+$("#"+campo).attr("igual")).val();
		$.ajax({
			url: "paginas/controladores/criar_conta.php",
			data:({
				campo: campo,
				valor: valor,
				campo_igual: campo_igual
			}),
			dataType: "json",
			success: function(result){
				$.each(result, function(index, value){
					if(value != "")
						inserirValidacao("erro", index, value);
					else
						inserirValidacao("sucesso", index);
				});
			}
		}).responseText;
	}
};
function verificarCampos(formulario){
	var retorno = true;
	if(!$("#acordo").is(":checked"))
		inserirValidacao("erro", "acordo", "Você precisa concordar com o Acordo de Serviço, as Regras e a Política de Privacidade, respectivamente, para criar sua conta!");
	else{
		inserirValidacao("sucesso", "acordo");
		$.ajax({
			url: "paginas/controladores/criar_conta.php",
			data:({
				formulario: formulario
			}),
			dataType: "json",
			success: function(result){
				console.log(result);
				$.each(result, function(index, value){
					if(value != ""){
						inserirValidacao("erro", index, value);
						retorno = false;
					}
					else
						inserirValidacao("sucesso", index);
				});
			},
			complete: function(result){
				if(retorno)
					document.location = "?p=minha_conta";
			}
		}).responseText;
	}
};
$(function(){
	$("#formulario_criacao_conta input[type=text], #formulario_criacao_conta input[type=password]").blur(function(){
		verificarCampo($(this).attr("name"), $(this).val());
	});
	$("#formulario_criacao_conta input[type=checkbox]").change(function(){
		verificarCampo($(this).attr("name"), $(this).is(":checked"));
	});
	$("#formulario_criacao_conta").submit(function(){
		verificarCampos($(this).serialize());
		return false;
	});
	$("#sugerir_nome").click(function(){
		$.ajax({
			url: "paginas/sugestao_nome.php",
			success: function(result){
				$("#nome_personagem").val(result).blur();
			}
		}).responseText;
		return false;
	});
});