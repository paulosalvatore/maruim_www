function ativarOverlay(){
	$("#conteudo").before('<div id="overlay"></div>');
	$(".conteudo_pagina").css({
		"position": "relative",
		"z-index": 11
	});
};
function construirBarraProgresso(){
	var barraProgressoElemento = $("#barraProgresso");
	var tipo = barraProgressoElemento.data("tipo");
	var maxOpcoes, icones = [], corIcones = [], tubos = [], negritos = [], textos = [];
	if(tipo == "servicos"){
		maxOpcoes = 4;
		icones = ["icone1", "icone2", "icone3", "icone4"];
		textos = ["Selecionar Serviço", "Informações do Pagamento", "Confirmação", "Finalização"];
	}
	else if(tipo == "registrar"){
		maxOpcoes = 3;
		icones = ["icone2", "icone3", "icone4"];
		textos = ["Informações de Registro", "Verificação", "Chave de Recuperação"];
	}
	if(maxOpcoes > 0){
		var config = parseInt(barraProgressoElemento.data("config"));
		for(i=0;i<maxOpcoes;i++){
			corIcones[i] = "azul";
			if(i == 0)
				tubos[i] = "azul";
			tubos[i+1] = "azul";
			negritos[i] = "";
		}
		if(config > 0){
			negritos[config-1] = " negrito";
			for(i=0;i<=config;i++){
				if(i > 0)
					corIcones[i-1] = "verde";
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
				<div class="barraProgressoTuboDireita '+tubos[maxOpcoes]+'"></div>\
				<div id="barraProgressoPrimeiroPasso">\
					<div class="barraProgressoPrimeiroPassoIcone">\
						<img src="imagens/corpo/barraProgresso_'+icones[0]+'_'+corIcones[0]+'.gif">\
					</div>\
					<div class="barraProgressoTexto'+negritos[0]+'" align="left">'+textos[0]+'</b></div>\
				</div>\
				<div id="barraProgressoPassos">\
					<div id="barraProgressoPassosConteudo">\
						';
						for(i=1;i<maxOpcoes;i++)
							barraProgresso += '\
								<div class="barraProgressoPasso" style="width: '+(100/(maxOpcoes-1))+'%;">\
									<div class="barraProgressoTubo">\
										<img src="imagens/corpo/barraProgresso_tubo_'+tubos[i]+'.gif">\
									</div>\
									<div class="barraProgressoIcone" align="right">\
										<img src="imagens/corpo/barraProgresso_'+icones[i]+'_'+corIcones[i]+'.gif">\
										<div class="barraProgressoTexto'+negritos[i]+'">'+textos[i]+'</div>\
									</div>\
								</div>\
							';
						barraProgresso += '\
					</div>\
				</div>\
			</div>\
		';
		barraProgressoElemento.html(barraProgresso);
	}
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
	elemento.html("<b>"+mensagem+"</b>");
	elemento_principal.show();
};
function verificarEmail(email){
	var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	if(filter.test(email))
		return true;
	return false;
};
function atualizarTempo(){
	var elemento = $("#tempoOnline");
	var tempo = parseInt(elemento.attr("tempo"));
	var horas = parseInt(tempo/3600);
	var minutos = parseInt(tempo/60)%60;
	var segundos = tempo%60;
	var exibirTempo = (horas>0?(horas<10?"0"+horas:horas)+"h":"")+(minutos>0||horas>0?(minutos<10?"0"+minutos:minutos)+"m":"")+(segundos<10?"0"+segundos:segundos)+"s";
	elemento
	.attr("tempo", tempo + 1)
	.html(exibirTempo);
	setTimeout(function(){
		atualizarTempo();
	}, 1000);
};
$(window).load(function(){
	$("img.imagemOutfit").each(function(){
		$(this).addClass("largura64");
		if($(this).width() != 64)
			$(this).removeClass("largura64");
	});
	$("input[name=busca]").focus();
});
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
	var opcoes = getCookie("opcoes");
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
	atualizarTempo();
});