function aplicarBackgroundTarefas(){
	$("#tarefas .exibir:odd").find("td").css("background", "#D4C0A1");
	$("#tarefas .exibir:even").find("td").css("background", "#F1E0C6");
};
function verificarTarefas(elemento1, elemento2){
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
	$("textarea[name=descricao]").keyup(function(event){
		if((event.ctrlKey) && (event.keyCode == 13))
			$("#adicionarTarefa").submit();
	});
	$("#adicionarTarefa").submit(function(){
		if($("textarea[name=descricao]").val() == ""){
			alert("Por favor, preencha o campo descrição.");
			return false;
		}
		else if($("textarea[name=descricao]").val().length < 8){
			alert("O campo descrição deve possuir, no mínimo, 8 caracteres.");
			return false;
		}
		$.ajax({
			url: "paginas/controladores/desenvolvedor_tarefas.php",
			data:({
				acao: "adicionar",
				formulario: $(this).serialize()
			}),
			success: function(result){
				document.location = "?p=desenvolvedor_tarefas";
			}
		}).responseText;
		return false;
	});
	$(".concluirTarefa").click(function(){
		if(confirm('Caso queira marcar essa tarefa como concluída clique em "OK". Caso não queira clique em "Cancelar".'))
		$.ajax({
			url: "paginas/controladores/desenvolvedor_tarefas.php",
			data:({
				acao: "concluir",
				registro_id: $(this).attr("registro_id")
			}),
			success: function(result){
				document.location = "?p=desenvolvedor_tarefas";
			}
		}).responseText;
		return false;
	});
	$(".deletarTarefa").click(function(){
		if(confirm('Caso queira realmente deletar esse registro clique em "OK". Caso não queira clique em "Cancelar".'))
		$.ajax({
			url: "paginas/controladores/desenvolvedor_tarefas.php",
			data:({
				acao: "deletar",
				registro_id: $(this).attr("registro_id")
			}),
			success: function(result){
				document.location = "?p=desenvolvedor_tarefas";
			}
		}).responseText;
		return false;
	});
	$("#mostrarTodas").click(function(){
		if(!verificarTarefas($(".pendente"), $(".concluida")))
		$(".pendente").each(function(){
			$(this).removeClass("ocultar").addClass("exibir");
		});
		$(".concluida").each(function(){
			$(this).removeClass("ocultar").addClass("exibir");
		});
		$("#statusConcluidas").show();
		$("#statusPendentes").show();
		aplicarBackgroundTarefas();
	});
	$("#mostrarPendentes").click(function(){
		verificarTarefas($(".pendente"));
		$(".pendente").each(function(){
			$(this).removeClass("ocultar").addClass("exibir");
		});
		$(".concluida").each(function(){
			$(this).removeClass("exibir").addClass("ocultar");
		});
		$("#statusConcluidas").hide();
		$("#statusPendentes").show();
		aplicarBackgroundTarefas();
	});
	$("#mostrarConcluidas").click(function(){
		verificarTarefas($(".concluida"));
		$(".concluida").each(function(){
			$(this).removeClass("ocultar").addClass("exibir");
		});
		$(".pendente").each(function(){
			$(this).removeClass("exibir").addClass("ocultar");
		});
		$("#statusConcluidas").show();
		$("#statusPendentes").hide();
		aplicarBackgroundTarefas();
	});
	aplicarBackgroundTarefas();
});