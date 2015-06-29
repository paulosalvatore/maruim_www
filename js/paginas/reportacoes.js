function aplicarBackgroundReportacoes(){
	$("#reportacoes .exibir:odd").find("td").css("background", "#D4C0A1");
	$("#reportacoes .exibir:even").find("td").css("background", "#F1E0C6");
};
function verificarReportacoes(elemento1, elemento2){
	var quantidadeElementos = 0;
	if(elemento1)
		quantidadeElementos += $(elemento1).length;
	if(elemento2)
		quantidadeElementos += $(elemento2).length;
	if(quantidadeElementos == 0)
		$(".vazio").show();
	else
		$(".vazio").hide();
};
$(function(){
	$("textarea[name=mensagem]").keyup(function(event){
		if((event.ctrlKey) && (event.keyCode == 13))
			$("#adicionarReportacao").submit();
		else
			$("#caracteresRestantes").html(Math.max(0, parseInt($("textarea[name=mensagem]").attr("maxlength"))-parseInt($("textarea[name=mensagem]").val().length)));
	}).keyup().focus();
	$("select[name=categoria]").keyup(function(event){
		if((event.ctrlKey) && (event.keyCode == 13))
			$("#adicionarReportacao").submit();
	});
	$("#adicionarReportacao").submit(function(){
		if($("textarea[name=mensagem]").val() == ""){
			alert("Por favor, preencha o campo mensagem.");
			$("textarea[name=mensagem]").focus();
			return false;
		}
		else if($("textarea[name=mensagem]").val().length < 8){
			alert("O campo mensagem deve possuir, no mínimo, 8 caracteres.");
			$("textarea[name=mensagem]").focus();
			return false;
		}
		else if($("select[name=categoria]").val().length == 0){
			alert("Selecione uma categoria.");
			$("select[name=categoria]").focus();
			return false;
		}
		$.ajax({
			url: "paginas/controladores/reportacoes.php",
			data:({
				acao: "adicionar",
				formulario: $(this).serialize()
			}),
			success: function(result){
				if(result == 1)
					document.location = "?p=reportacoes";
				else
					alert("Algum erro ocorreu ou você inseriu dados inválidos.");
			}
		}).responseText;
		return false;
	});
	$(".concluirReportacao").click(function(){
		if(confirm('Caso queira marcar essa reportação como corrigida clique em "OK". Caso não queira clique em "Cancelar".'))
		$.ajax({
			url: "paginas/controladores/reportacoes.php",
			data:({
				acao: "concluir",
				registro_id: $(this).attr("registro_id")
			}),
			success: function(result){
				document.location = "?p=reportacoes";
			}
		}).responseText;
		return false;
	});
	$(".deletarReportacao").click(function(){
		if(confirm('Caso queira realmente deletar essa reportação clique em "OK". Caso não queira clique em "Cancelar".'))
		$.ajax({
			url: "paginas/controladores/reportacoes.php",
			data:({
				acao: "deletar",
				registro_id: $(this).attr("registro_id")
			}),
			success: function(result){
				document.location = "?p=reportacoes";
			}
		}).responseText;
		return false;
	});
	$("#mostrarTodas").click(function(){
		if(!verificarReportacoes($(".pendente"), $(".concluida"))){
			$(".pendente").each(function(){
				$(this).removeClass("ocultar").addClass("exibir");
			});
			$(".concluida").each(function(){
				$(this).removeClass("ocultar").addClass("exibir");
			});
		}
		$("#statusConcluidas").show();
		$("#statusPendentes").show();
		aplicarBackgroundReportacoes();
	});
	$("#mostrarPendentes").click(function(){
		verificarReportacoes($(".pendente"));
		$(".pendente").each(function(){
			$(this).removeClass("ocultar").addClass("exibir");
		});
		$(".concluida").each(function(){
			$(this).removeClass("exibir").addClass("ocultar");
		});
		$("#statusConcluidas").hide();
		$("#statusPendentes").show();
		aplicarBackgroundReportacoes();
	}).click();
	$("#mostrarConcluidas").click(function(){
		verificarReportacoes($(".concluida"));
		$(".concluida").each(function(){
			$(this).removeClass("ocultar").addClass("exibir");
		});
		$(".pendente").each(function(){
			$(this).removeClass("exibir").addClass("ocultar");
		});
		$("#statusConcluidas").show();
		$("#statusPendentes").hide();
		aplicarBackgroundReportacoes();
	});
	aplicarBackgroundReportacoes();
});