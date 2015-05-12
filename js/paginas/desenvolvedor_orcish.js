function adicionarPalavra(elemento){
	var closestTd = elemento.closest("td");
	var inputPalavra = closestTd.find("input:text");
	var palavraId = inputPalavra.data("palavra_id");
	var palavra = inputPalavra.val();
	if((palavra == "") || (palavra == undefined)){
		alert("Digite uma palavra.");
		return false;
	}
	$.ajax({
		url: "?p=desenvolvedor_orcish-adicionar_palavra",
		data:({
			palavraId: palavraId,
			palavra: palavra
		}),
		success: function(result){
			var exibirPalavra = '\
				<input type="text" size="10" data-palavra_id="'+palavraId+'" value="'+palavra+'" class="ocultar">\
				<span>'+palavra+'</span>\
				<input type="button" value="Editar" class="botao editar" style="margin-top: -16px;">\
			';
			closestTd.html(exibirPalavra);
			closestTd.find("input:text").keypress(function(event){
				if(event.keyCode == 13)
					$(this).closest("td").find("input:button").click();
			});
			closestTd.find(".editar").click(function(){
				editarPalavra($(this));
				$(this).css("margin-top", "-20px");
			});
		}
	}).responseText;
}
function editarPalavra(elemento){
	var closestTd = elemento.closest("td");
	var inputPalavra = closestTd.find("input:text");
	if(inputPalavra.hasClass("ocultar")){
		inputPalavra.attr("class", "");
		closestTd.find("span").html("");
		inputPalavra.focus();
	}
	else
		adicionarPalavra(closestTd.find(".editar"));
}
$(function(){
	$("input:text").keypress(function(event){
		if(event.keyCode == 13)
			$(this).closest("td").find("input:button").click();
	});
	$(".adicionar").click(function(){
		adicionarPalavra($(this));
	});
	$(".editar").click(function(){
		editarPalavra($(this));
		$(this).css("margin-top", "1px");
	});
});