$(function(){
	$("#conta").focus();
	$(".infoDeletado").mouseenter(function(){
		$(this).next(".boxInfo").show();
	}).mouseleave(function(){
		$(this).next(".boxInfo").hide();
	});
	$("#alterar_email").submit(function(){
		$.ajax({
			url: "paginas/controladores/minha_conta.php",
			data:({
				acao: "alterar_email",
				informacoesAlterarEmail: $(this).serialize()
			}),
			success: function(result){
				if(result == 0)
					$(".small_box_frame.erro").show();
				else if(result == 1)
					document.location = "?p=minha_conta-alterar_email-email_enviado";
			}
		}).responseText;
		return false;
	});
	$("#alterar_senha").submit(function(){
		$.ajax({
			url: "paginas/controladores/minha_conta.php",
			data:({
				acao: "alterar_senha",
				informacoesAlterarSenha: $(this).serialize()
			}),
			success: function(result){
				if(result == 0)
					$(".small_box_frame.erro").show();
				else if(result == 1)
					document.location = "?p=minha_conta-alterar_senha-senha_alterada";
			}
		}).responseText;
		return false;
	});
	$("#registrar_conta").submit(function(){
		$.ajax({
			url: "paginas/controladores/minha_conta.php",
			data:({
				acao: "registrar_conta",
				informacoesRegistrarConta: $(this).serialize()
			}),
			success: function(result){
				if(result == 0)
					$(".small_box_frame.erro").show();
				else if(result == 1)
					document.location = "?p=minha_conta-registrar-email_enviado";
			}
		}).responseText;
		return false;
	});
	$("#cancelar_deletar_personagem").submit(function(){
		var personagemId = $(this).attr("personagem");
		$.ajax({
			url: "paginas/controladores/minha_conta.php",
			data:({
				acao: "cancelar_deletar_personagem",
				personagemId: personagemId,
				informacoesDeletarPersonagem: $(this).serialize()
			}),
			success: function(result){
				if(result == 0)
					$(".small_box_frame.erro").show();
				else if(result == 1)
					document.location = "?p=minha_conta-"+personagemId+"-cancelado";
			}
		}).responseText;
		return false;
	});
	$("#deletar_personagem").submit(function(){
		var personagemId = $(this).attr("personagem");
		$.ajax({
			url: "paginas/controladores/minha_conta.php",
			data:({
				acao: "deletar_personagem",
				personagemId: personagemId,
				informacoesDeletarPersonagem: $(this).serialize()
			}),
			success: function(result){
				if(result == 0)
					$(".small_box_frame.erro").show();
				else if(result == 1)
					document.location = "?p=minha_conta-"+personagemId+"-deletado";
			}
		}).responseText;
		return false;
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
	$(".aba").click(function(){
		var servicoId = $(this).data("servico_id");
		var imagemAtiva = "imagens/corpo/fundo_aba_ativa.png";
		var imagemInativa = "imagens/corpo/fundo_aba_inativa.png";
		$(".aba.ativa")
		.removeClass("ativa")
		.find("img").attr("src", imagemInativa);
		$(this)
		.addClass("ativa")
		.find("img").attr("src", imagemAtiva);
		$(".conteudo_aba.exibir").removeClass("exibir");
		$("#conteudo_aba_"+servicoId).addClass("exibir");
	});
});