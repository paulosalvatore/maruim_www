function verificarItens(){
	if($(".item_info").length > 0)
		$(".vazio").hide();
	else
		$(".vazio").show();
}
$(function(){
	$("#item_id, #valor").keydown(function(event){
		if(event.keyCode == 13)
			$("#incluir").click();
	});
	$("#incluir").click(function(){
		var item_id = parseInt($("#item_id").val());
		var valor = parseInt($("#valor").val());
		console.log(item_id, valor);
		if((isNaN(item_id)) || (item_id == 0) || (isNaN(valor)) || (valor == 0)){
			if((isNaN(item_id)) || (item_id == 0))
				$("#item_id").focus();
			else if((isNaN(valor)) || (valor == 0))
				$("#valor").focus();
			inserirMensagemErro("Preencha todos os campos com dados válidos.", "erro");
			return false;
		}
		var itens = [];
		$(".item").each(function(){
			itens.push($(this).data("item_id"));
		});
		if($.inArray(item_id, itens) >= 0){
			$("#item_id").focus();
			inserirMensagemErro("Essa ID já está adicionada.", "erro");
			return false;
		}
		$("<tr class=\'item item_info\' data-item_id=\'"+item_id+"\' data-valor=\'"+valor+"\' align=\'center\'><td>"+item_id+"</td><td>"+valor+"<div class=\'remover_item\'></div></td></tr>").insertBefore(".vazio");
		$(".remover_item").click(function(){
			if(confirm("Clique em 'OK' para remover esse item ou em 'Cancelar' para suspender a exclusão.")){
				$(this).closest(".item_info").remove();
				inserirMensagemErro("Item removido com sucesso.", "sucesso");
				verificarItens();
			}
		});
		verificarItens();
		$("#item_id").val("").focus();
		$("#valor").val("");
		inserirMensagemErro("Item adicionado com sucesso.", "sucesso");
	});
	$("#gerar_xml").click(function(){
		var itens = [], itensValores = [];
		$(".item").each(function(){
			item_id = $(this).data("item_id");
			valor = $(this).data("valor");
			itens.push(item_id);
			itensValores.push(valor);
		});
		if(itens.length == 0){
			inserirMensagemErro("", "erro");
			return false;
		}
		var tipo = $("input[name=tipo]:checked").val();
		$.ajax({
			url: "paginas/criar_npc.php",
			data:({
				area: "carregar_itens",
				itens: itens,
				itensValores: itensValores,
				tipo: tipo
			}),
			success: function(result){
				console.log(result);
				if(parseInt(result) == 0){
					inserirMensagemErro("Falha ao gerar o XML. Insira pelo menos um item válido.", "erro");
					$("#resultado").html("");
				}
				else{
					inserirMensagemErro("XML gerado com sucesso.", "sucesso");
					$("#resultado").html(result);
				}
			}
		}).responseText;
	});
	$("#selecionar_codigo").click(function(){
		$("#resultado").select();
	});
	$("#remover_itens").click(function(){
		if($(".item_info").length == 0)
			inserirMensagemErro("Não existem itens para remover.", "erro");
		else{
			if(confirm("Clique em 'OK' para remover todos os itens ou em 'Cancelar' para suspender a exclusão.")){
				inserirMensagemErro("Itens removidos com sucesso.", "sucesso");
				$(".item_info").each(function(){
					$(this).remove();
				});
				verificarItens();
			}
		}
	});
});