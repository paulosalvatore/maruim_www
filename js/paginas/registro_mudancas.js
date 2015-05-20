$(function(){
	$("textarea[name=descricao]").keyup(function(event){
		if((event.ctrlKey) && (event.keyCode == 13))
			$("#adicionarRegistroMudanca").submit();
	});
	$("#adicionarRegistroMudanca").submit(function(){
		if($("textarea[name=descricao]").val() == ""){
			alert("Por favor, preencha o campo descri��o");
			return false;
		}
		else if($("textarea[name=descricao]").val().length < 8){
			alert("O campo descri��o deve possuir, no m�nimo, 8 caracteres.");
			return false;
		}
		$.ajax({
			url: "paginas/controladores/registro_mudancas.php",
			data:({
				acao: "adicionar",
				formulario: $(this).serialize()
			}),
			success: function(result){
				document.location = "?p=registro_mudancas";
			}
		}).responseText;
		return false;
	});
	$(".deletarRegistroMudanca").click(function(){
		if(confirm('Caso queira realmente deletar esse registro clique em "OK". Caso n�o queira clique em "Cancelar".'))
		$.ajax({
			url: "paginas/controladores/registro_mudancas.php",
			data:({
				acao: "deletar",
				registro_id: $(this).attr("registro_id")
			}),
			success: function(result){
				document.location = "?p=registro_mudancas";
			}
		}).responseText;
		return false;
	});
});