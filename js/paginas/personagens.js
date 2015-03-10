$(function(){
	if($("#exibirPersonagem").length == 0)
		$("#nomePersonagem").focus();
	$("#nomePersonagem")
	.keydown(function(e){
		if(e.keyCode == 13)
			$("#buscarPersonagem").click();
	});
	$("#buscarPersonagem")
	.click(function(){
		var nomePersonagem = $("#nomePersonagem").val();
		$.ajax({
			url: "paginas/controladores/personagens.php",
			data:({
				acao: "buscar",
				personagem: nomePersonagem
			}),
			// dataType: "json",
			success: function(result){
				if(result)
					document.location = "?p=personagens-"+result;
				else{
					$("#exibirPersonagem").hide();
					$("#resultadoBusca").show().find("#exibirNomePersonagem").html(nomePersonagem);
				}
				// $.each(result, function(index, value){
					// if(value != "")
						// inserirValidacao("erro", index, value);
					// else
						// inserirValidacao("sucesso", index);
				// });
			}
		}).responseText;
	});
});