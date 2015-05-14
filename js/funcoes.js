function ativarOverlay(){
	$("#conteudo").before('<div id="overlay"></div>');
	$(".conteudo_pagina").css({
		"position": "relative",
		"z-index": 11
	});
};
function construirBarraProgresso(){
	var barraProgressoElemento = $("#barraProgresso");
	var config = parseInt(barraProgressoElemento.data("config"));
	config = 0;
	var icones = ["azul", "azul", "azul", "azul"];
	var tubos = ["azul", "azul", "azul", "azul", "azul"];
	var negritos = ["", "", "", ""];
	if(config > 0){
		negritos[config-1] = " negrito";
		for(i=0;i<=config;i++){
			if(i > 0)
				icones[i-1] = "verde";
			if(i == tubos.length-1)
				tubos[i] = "verde";
			else if((i == config) && (i != 0) && (i != tubos.length-1))
				tubos[i] = "verde_azul";
			else
				tubos[i] = "verde";
		}
	}
	var barraProgresso = '\
		<div id="barraProgressoBase">\
			<div id="barraProgressoInicio"></div>\
			<div id="barraProgressoFim"></div>\
		</div>\
		<div id="barraProgressoConteudo">\
			<div class="barraProgressoTuboEsquerda '+tubos[0]+'"></div>\
			<div class="barraProgressoTuboDireita '+tubos[4]+'"></div>\
			<div id="barraProgressoPrimeiroPasso">\
				<div class="barraProgressoPrimeiroPassoIcone">\
					<img src="imagens/corpo/barraProgresso_icone1_'+icones[0]+'.gif">\
				</div>\
				<div class="barraProgressoTexto'+negritos[0]+'" align="left">Selecionar Serviço</b></div>\
			</div>\
			<div id="barraProgressoPassos">\
				<div id="barraProgressoPassosConteudo">\
					<div class="barraProgressoPasso">\
						<div class="barraProgressoTubo">\
							<img src="imagens/corpo/barraProgresso_tubo_'+tubos[1]+'.gif">\
						</div>\
						<div class="barraProgressoIcone" align="right">\
							<img src="imagens/corpo/barraProgresso_icone2_'+icones[1]+'.gif">\
							<div class="barraProgressoTexto'+negritos[1]+'">Informações do Pagamento</div>\
						</div>\
					</div>\
					<div class="barraProgressoPasso">\
						<div class="barraProgressoTubo">\
							<img src="imagens/corpo/barraProgresso_tubo_'+tubos[2]+'.gif">\
						</div>\
						<div class="barraProgressoIcone" align="right">\
							<img src="imagens/corpo/barraProgresso_icone3_'+icones[2]+'.gif">\
							<div class="barraProgressoTexto'+negritos[2]+'">Confirmação</div>\
						</div>\
					</div>\
					<div class="barraProgressoPasso">\
						<div class="barraProgressoTubo">\
							<img src="imagens/corpo/barraProgresso_tubo_'+tubos[3]+'.gif">\
						</div>\
						<div class="barraProgressoIcone" align="right">\
							<img src="imagens/corpo/barraProgresso_icone4_'+icones[3]+'.gif">\
							<div class="barraProgressoTexto'+negritos[3]+'">Revisão</div>\
						</div>\
					</div>\
				</div>\
			</div>\
		</div>\
	';
	barraProgressoElemento.html(barraProgresso);
};
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
		gerarCookie("opcoes", o, 700);
	}
};
function inserirMensagemErro(mensagem, tipo){
	var elemento_principal = $(".small_box_frame");
	var elemento = $(".small_box_frame .mensagem");
	if(tipo == "sucesso" && elemento_principal.hasClass("erro"))
		elemento_principal.addClass("sucesso").removeClass("erro");
	else if(tipo == "erro" && elemento_principal.hasClass("sucesso"))
		elemento_principal.addClass("erro").removeClass("sucesso");
	elemento.html(mensagem);
	elemento_principal.show();
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
	opcoes = getCookie("opcoes");
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
	$(".botao_azul, .botao_verde, .botao_vermelho").each(function(){
		var corBotao;
		if($(this).hasClass("botao_azul"))
			corBotao = "azul";
		else if($(this).hasClass("botao_verde"))
			corBotao = "verde";
		else if($(this).hasClass("botao_vermelho"))
			corBotao = "vermelho";
		var valor = $(this).val();
		var imagem = "imagens/botoes/"+valor+".png";
		$(this)
		.css("background", "url("+imagem+")")
		.val("");
		var botao = $(this).clone();
		var id_botao = $("div.fundo_botao_"+corBotao).length+1;
		var fundo_botao = '<div class="fundo_botao_'+corBotao+'" id="botao_'+corBotao+'_'+id_botao+'"></div>';
		$(this).before(fundo_botao);
		$("#botao_"+corBotao+"_"+id_botao).html(botao);
		$(this).remove();
	});
	if($("#barraProgresso").length)
		construirBarraProgresso();
});