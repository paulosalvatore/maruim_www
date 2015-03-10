$(function(){
	$(".editar_personagem").click(function(){
		document.location = "?p=minha_conta-"+$(this).attr("personagem")+"-editar";
	});
	$("#informacoes_personagem").submit(function(){
		var personagemId = $(this).attr("personagem");
		$.ajax({
			url: "paginas/controladores/minha_conta.php",
			data:({
				acao: "editar_personagem",
				personagemId: personagemId,
				informacoesEditarPersonagem: $(this).serialize()
			}),
			success: function(result){
				console.log(result);
				if(result == 0)
					$(".small_box_frame.erro").show();
				else if(result == 1)
					document.location = "?p=minha_conta-"+personagemId+"-editado";
			}
		}).responseText;
		return false;
	});
	$(".mudar_vocacao_personagem").click(function(){
		$.ajax({
			url: "paginas/controladores/minha_conta.php",
			data:({
				vocacao: $(this).attr("vocacao")
			}),
			success: function(result){
				document.location = "?p=minha_conta";
			}
		}).responseText;
	});
	$("#form_login").submit(function(){
		var formulario = $(this).serialize();
		$.ajax({
			url: "includes/login.php",
			data:({
				formulario: formulario
			}),
			success: function(result){
				if(result == 0)
					$(".small_box_frame.erro").show();
				else if(result == 1)
					document.location = "?p=minha_conta";
			}
		}).responseText;
		return false;
	});
	$(".ocultar_exibir_caracteres").click(function(){
		var html;
		if($(this).hasClass("ocultar")){
			html = $(this).prev(".valor").attr("valor");
			$(this)
			.removeClass("ocultar")
			.addClass("exibir")
			.prev(".valor")
			.html(html);
		}
		else if($(this).hasClass("exibir")){
			html = $(this).prev(".valor").attr("exibir_valor");
			$(this)
			.removeClass("exibir")
			.addClass("ocultar")
			.prev(".valor")
			.html(html);
		}
	});
});