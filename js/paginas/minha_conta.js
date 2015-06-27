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
	$("#informacoesPersonagem").submit(function(){
		var personagemId = $(this).attr("personagem");
		$.ajax({
			url: "paginas/controladores/minha_conta.php",
			data:({
				acao: "editar_personagem",
				personagemId: personagemId,
				informacoesEditarPersonagem: $(this).serialize()
			}),
			success: function(result){
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
				else if(result == 1){
					if($("input[name=url]").val() != "")
						document.location = $("input[name=url]").val();
					else
						document.location = "?p=minha_conta";
				}
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
	$(".servico").click(function(){
		if(!$(this).find(".fundoDesativado").hasClass("exibir")){
			$(this).find("input:radio").prop("checked", true);
			$(".servico .fundoSelecionado.exibir").removeClass("exibir");
			$(this).find(".fundoSelecionado").addClass("exibir");
			var formaPagamento = $(this).data("pagamento");
			$(".formaPagamento").each(function(){
				if($(this).data("tipo") != formaPagamento){
					$(this).find(".fundoSelecionado.exibir").removeClass("exibir");
					$(this).find(".fundoDesativado").addClass("exibir");
					$(this).find("input:radio").prop("checked", false);
				}
				else
					$(this).find(".fundoDesativado.exibir").removeClass("exibir");
			});
			var pontosDisponiveis = parseInt($("#pontosDisponiveis").data("pontos"));
			var pontos = parseInt($(this).data("pontos"));
			var balancoRapido = pontosDisponiveis;
			if(formaPagamento == "ponto")
				balancoRapido -= pontos;
			else if(formaPagamento == "real")
				balancoRapido += pontos;
			var exibirBalancoRapido = balancoRapido;
			if(balancoRapido < 0)
				exibirBalancoRapido = "Pontos insuficientes";
			else if(balancoRapido == 1)
				exibirBalancoRapido += " ponto";
			else
				exibirBalancoRapido += " pontos";
			$("#balancoRapido")
			.show()
			.find("span")
			.html(exibirBalancoRapido);
		}
	});
	$(".formaPagamento").click(function(){
		if(!$(this).find(".fundoDesativado").hasClass("exibir")){
			$(this).find("input:radio").prop("checked", true);
			$(".formaPagamento .fundoSelecionado.exibir").removeClass("exibir");
			$(this).find(".fundoSelecionado").addClass("exibir");
		}
	});
	$("#servicos").submit(function(){
		var produtoSelecionado = $("input[name=produto]:checked");
		var produtoSelecionadoPreco = produtoSelecionado.closest(".servico").data("preco");
		var pagamentoSelecionado = $("input[name=pagamento]:checked");
		var pagamentoSelecionadoTipo = pagamentoSelecionado.closest(".formaPagamento").data("tipo");
		var pontosDisponiveis = parseInt($("#pontosDisponiveis").data("pontos"));
		var balancoRapido = pontosDisponiveis - produtoSelecionadoPreco;
		if(!produtoSelecionado.length)
			inserirMensagemErro("Selecione um produto.", "erro");
		else if(!pagamentoSelecionado.length)
			inserirMensagemErro("Selecione um pagamento.", "erro");
		else if((pagamentoSelecionadoTipo == "ponto") && (balancoRapido < 0))
			inserirMensagemErro("Você não possui pontos suficientes.", "erro");
		else
			return true;
		return false;
	});
	$("#informacoesPagamento").submit(function(){
		var nome = $("input[name=nome]").val();
		var cidade = $("input[name=cidade]").val();
		var email = $("input[name=email]").val();
		if(nome.length == 0)
			inserirMensagemErro("Informe seu nome.", "erro");
		else if(cidade.length == 0)
			inserirMensagemErro("Informe sua cidade.", "erro");
		else if(email.length == 0)
			inserirMensagemErro("Informe seu e-mail.", "erro");
		else if(!verificarEmail(email))
			inserirMensagemErro("Informe um e-mail válido.", "erro");
		else
			return true;
		return false;
	});
	$("#confirmarPagamento").submit(function(){
		var aceitarRegras = $("#aceitar_regras");
		if(!aceitarRegras.is(":checked"))
			inserirMensagemErro("Você deve estar de acordo com as Regras do Servidor antes de prosseguir.", "erro");
		else
			return true;
		return false;
	});
});