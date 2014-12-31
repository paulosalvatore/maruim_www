function verificarCampo(campo, valor){
	console.log("Verificar apenas um campo.");
	campo_igual = $("#"+$("#"+campo).attr("igual")).val();
	$.ajax({
		url: "paginas/controladores/criar_conta.php",
		data:({
			campo: campo,
			valor: valor,
			campo_igual: campo_igual
		}),
		// dataType: "json",
		success: function(result){
			console.log(result)
			id_campo = result["id_campo"];
			mensagem = result["mensagem"];
			funcao = result["funcao"];
			if(funcao == "inserirMensagem")
				inserirMensagem(id_campo, mensagem);
			limparCampos(id_campo);
		}
	}).responseText;
};
function verificarCampos(formulario){
	console.log("Verificar todos os campos.");
	$.ajax({
		url: "paginas/controladores/criar_conta.php",
		data:({
			formulario: formulario
		}),
		dataType: "json",
		success: function(result){
			id_campo = result["id_campo"];
			mensagem = result["mensagem"];
			funcao = result["funcao"];
			if(funcao == "inserirMensagem")
				inserirMensagem(id_campo, mensagem);
			limparCampos(id_campo);
		}
	}).responseText;
};
$(function(){
	$("#formulario_criacao_conta input[type=text]").blur(function(){
		verificarCampo($(this).attr("name"), $(this).val());
	});
	$("#formulario_criacao_conta").submit(function(){
		verificarCampos($(this).serialize());
		return false;
	});
	$("#sugerir_nome").click(function(){
		return false;
	});
});
function inserirMensagem(id, mensagem){
	$("#"+id)
	.closest("td")
	.find(".mensagem_erro")
	.html(mensagem)
	.closest("tr")
	.find(".exibicao_bloco")
	.css({
		color: "red"
	});
};
function limparCampos(){
	$("#formulario_criacao_conta").each(function(){
		$(this)
		.closest("td")
		.find(".mensagem_erro")
		.html("")
		.closest("tr")
		.find(".exibicao_bloco")
		.css({
			color: ""
		});
	});
};
$(function(){
	$("#formulario_criacao_conta").submit(function(){
		$.ajax({
			url: "paginas/controladores/criar_conta.php",
			data:({
				formulario: $(this).serialize()
			}),
			dataType: "json",
			success: function(result) {
				id_campo = result["id_campo"];
				mensagem = result["mensagem"];
				funcao = result["funcao"];
				if(funcao == "inserirMensagem")
					inserirMensagem(id_campo, mensagem);
				limparCampos(id_campo);
			}
		}).responseText;
		return false;
	});
});