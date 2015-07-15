$(function(){
	$("body").on("copy", "#gerar_chave_acesso", function(e) {
		var chaveAcesso = ""
		$.ajax({
			url: "paginas/controladores/desenvolvedor_chaves_acesso.php",
			async: false,
			success: function(result){
				$("#chave_acesso").val(result);
				chaveAcesso = result
			}
		}).responseText;
		e.clipboardData.clearData();
		e.clipboardData.setData("text/plain", chaveAcesso);
		e.preventDefault();
	});
});