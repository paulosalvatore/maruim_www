function inserirValidacao(tipo, campo, mensagem){
	if(tipo == "erro"){
		$("#"+campo)
		.closest("td")
		.find(".mensagem_erro")
		.html(mensagem);
		$("#"+campo)
		.closest("td")
		.find(".imagem")
		.addClass("errado")
		.removeClass("certo");
		$("#"+campo)
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
		.html("");
		$("#"+campo)
		.closest("td")
		.find(".imagem")
		.addClass("certo")
		.removeClass("errado");
		$("#"+campo)
		.closest("tr")
		.find(".exibicao_bloco")
		.css({
			color: ""
		});
	}
};
function verificarCampo(campo, valor){
	$.ajax({
		url: "paginas/controladores/criar_personagem.php",
		data:({
			campo: campo,
			valor: valor
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
};
function verificarCampos(formulario){
	var retorno = true;
	$.ajax({
		url: "paginas/controladores/criar_personagem.php",
		data:({
			formulario: formulario
		}),
		dataType: "json",
		success: function(result){
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
};
$(function(){
	$("#formulario_criacao_personagem input[type=text], #formulario_criacao_personagem input[type=password]").blur(function(){
		verificarCampo($(this).attr("name"), $(this).val());
	});
	$("#formulario_criacao_personagem input[type=checkbox]").change(function(){
		verificarCampo($(this).attr("id"), $(this).is(":checked"));
	});
	$("#formulario_criacao_personagem").submit(function(){
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