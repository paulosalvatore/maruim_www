$(function(){
	$("input[name=min]").keydown(function(event){
		setTimeout(function(valor){
			if((valor == $("input[name=max]").val()) || ($("input[name=max]").val() == ""))
				$("input[name=max]").val($("input[name=min]").val());
		}, 0, $(this).val());
	});
	$("select[name=categoria]").change(function(event){
		if($(this).val() == "storage"){
			$("#valor").show();
			$("#tipo_valor").show();
		}
		else{
			$("#valor").hide();
			$("#tipo_valor").hide();
		}
	});
	$("textarea[name=descricao]").keyup(function(event){
		if((event.ctrlKey) && (event.keyCode == 13))
			$("#adicionarIDUtilizada").submit();
	});
	$("#adicionarIDUtilizada").submit(function(){
		if($("input[name=min]").val() == ""){
			alert("Por favor, insira uma ID.");
			return false;
		}
		if((isNaN($("input[name=min]").val())) || (isNaN($("input[name=max]").val())) || (isNaN($("input[name=valor]").val()))){
			alert("Insira apelas valores num�ricos.");
			return false;
		}
		else if($("textarea[name=descricao]").val() == ""){
			alert("Por favor, preencha o campo descri��o.");
			return false;
		}
		else if($("textarea[name=descricao]").val().length < 4){
			alert("O campo descri��o deve possuir, no m�nimo, 4 caracteres.");
			return false;
		}
		$.ajax({
			url: "paginas/controladores/desenvolvedor_ids_utilizadas.php",
			data:({
				acao: "adicionar",
				formulario: $(this).serialize()
			}),
			success: function(result){
				if(result == 1)
					document.location = "?p=desenvolvedor_ids_utilizadas";
				else{
					if(($("input[name=max]").val() > 0) && ($("input[name=max]").val() != $("input[name=min]").val()))
						alert("Uma ou mais IDs dentro do intervalo inserido j� est�o sendo utilizadas.");
					else
						alert("A ID inserida j� est� sendo utilizada.");
				}
			}
		}).responseText;
		return false;
	});
});