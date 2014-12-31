function getCookie(cookiename){
	var cookiestring=RegExp(""+cookiename+"[^;]+").exec(document.cookie);
	return unescape(!!cookiestring ? cookiestring.toString().replace(/^[^=]+./,"") : "");
};
function gerarCookie(nome, valor, duracao){
	var data = new Date();
	if(duracao){
		data.setTime(data.getTime()+(duracao*24*60*60*1000));
		var duracao = "; expires="+data.toGMTString();
	}
	else
		var duracao = "";
	document.cookie = nome+"="+valor+duracao+";";
};
function gravarCookies(tipo){
	if(tipo == "barra_lateral_esquerda"){
		var o = "";
		$(".categoria").each(function(){
			if($(this).hasClass("ativo"))
				o += "1";
			else
				o += "0";
		});
		gerarCookie("o", o, 700);
	}
};
$(function(){
	var pagina = $("#conteudo").attr("pagina");
	$("#barra_esquerda .opcoes .opcao."+pagina).addClass("ativo");
	$("#barra_esquerda .categoria .botao").click(function(event){
		var categoria = $(this).closest(".categoria");
		if(categoria.hasClass("ativo"))
			categoria.removeClass("ativo");
		else
			categoria.addClass("ativo");
		gravarCookies("barra_lateral_esquerda");
	});
	opcoes = getCookie("o");
	if(isNaN(opcoes[0]))
		opcoes = "1";
	for(i=0;i<opcoes.length;i++){
		valor_o = opcoes[i];
		categoria = $(".categoria").eq(i);
		if(valor_o == 0)
			categoria.removeClass("ativo");
		else if(valor_o == 1)
			categoria.addClass("ativo");
		gravarCookies();
	}
	$(".criar_link_form").each(function(){
		var p = $(this).attr("p");
		if(p){
			var link = '\
				<form method="GET">\
					<input type="hidden" name="p" value="'+p+'">\
					'+$(this).html()+'\
				</form>\
			';
			$(this).html(link);
		}
	});
	function isEllipsisActive(a){
	}
	$(".texto_breve").each(function(){
		$("body").append('<span id="tmpsmp" style="display: none;">'+$(this).html()+'</span>');
		if($(this).width() > $("#tmpsmp").width()){
			$(this).closest(".item").find(".exibir_ocultar div").hide();
			$(this).closest(".item").find(".ellipsis").hide();
		}
		$("#tmpsmp").remove();
	});
	var data_min = $(".data.de").data("min")
	var data_max = $(".data.de").data("max")
	$(".data").mask("99/99/9999");
	$(".data.de").datepicker({
		minDate: data_min,
		maxDate: data_max,
		showButtonPanel: true,
		changeMonth: true,
		changeYear: true,
		showAnim: "slideDown",
		onClose: function(selectedDate) {
			console.log(selectedDate);
			if((selectedDate) && (selectedDate != "__/__/____"))
				$(".data.para").datepicker("option", "minDate", selectedDate);
		}
	});
	$(".data.para").datepicker({
		minDate: data_min,
		maxDate: data_max,
		showButtonPanel: true,
		changeMonth: true,
		changeYear: true,
		showAnim: "slideDown",
		onClose: function(selectedDate) {
			console.log(selectedDate);
			if((selectedDate) && (selectedDate != "__/__/____"))
				$(".data.de").datepicker("option", "maxDate", selectedDate);
		}
	});
});