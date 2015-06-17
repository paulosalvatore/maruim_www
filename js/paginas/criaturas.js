function aplicarBackgroundTabelaCriaturas(){
	$("#criaturas .exibir:odd").find(".coluna").css("background", "#D4C0A1");
	$("#criaturas .exibir:even").find(".coluna").css("background", "#F1E0C6");
};
function alterarTipoOrdenar(elemento, ordenar, ativo){
	var diretorio = "imagens/corpo/", titulo;
	var imagens = [
		"ordenar",
		"ordenar_decrescente",
		"ordenar_crescente"
	];
	if(ordenar == 2)
		titulo = "decrescente";
	else
		titulo = "crescente";
	if(ativo)
		elemento.removeClass("ativo");
	else
		elemento.addClass("ativo");
	elemento
	.attr("src", diretorio+imagens[ordenar-1]+".png")
	.attr("ordenar", ordenar)
	.attr("title", "Ordenar por ordem "+titulo);
};
function exibirCriaturas(){
	var tipoExibicao, exibicao
	if($("#criaturas").hasClass("galeria"))
		tipoExibicao = "galeria";
	else
		tipoExibicao = "lista";
	if(tipoExibicao == "lista"){
		if($("#criaturas").attr("ordenar_ativo") == 0){
			var imagemOrdenar = '<img src="imagens/corpo/ordenar.png" class="ordenar" ordenar="1">';
			$("#criaturas .coluna").each(function(){
				if($(this).attr("ordenar")){
					$(this).append(imagemOrdenar);
					if($(this).attr("ordenar") == "nome")
						alterarTipoOrdenar($(this).find(".ordenar"), 2, false);
					else
						alterarTipoOrdenar($(this).find(".ordenar"), 1, false);
				}
			});
			$(".ordenar").click(function(){
				var tipoOrdenar = parseInt($(this).attr("ordenar")), novoTipoOrdenar, ordenar = $(this).closest(".coluna").attr("ordenar"), ordenarPor;
				novoTipoOrdenar = tipoOrdenar+1;
				if(novoTipoOrdenar > 3)
					novoTipoOrdenar = 2;
				alterarTipoOrdenar($(".ordenar.ativo"), 1, true);
				alterarTipoOrdenar($(this), novoTipoOrdenar, false);
				if(novoTipoOrdenar == 2)
					ordenarPor = "asc";
				else if(novoTipoOrdenar == 3)
					ordenarPor = "desc";
				$("#criaturas .criatura").tsort({order: "asc", attr: "id"});
				$("#criaturas .criatura").tsort({order: ordenarPor, attr: ordenar});
				gerarCookie("ultimaOrdem", ordenar+"-"+ordenarPor, 700);
				aplicarBackgroundTabelaCriaturas();
			});
			$("#criaturas").attr("ordenar_ativo", 1);
		}
		$("#criaturas.lista .criatura").each(function(){
			exibicao = '\
				<div class="coluna">\
					<a href="'+$(this).attr("link")+'"><img src="'+$(this).attr("imagem")+'" title="'+$(this).attr("nome")+'" border="0" /></a>\
				</div>\
				<div class="coluna">\
					<a href="'+$(this).attr("link")+'">'+$(this).attr("nome")+'</a>\
				</div>\
				<div class="coluna">\
					'+$(this).attr("experiencia")+'\
				</div>\
				<div class="coluna">\
					'+$(this).attr("vida")+'\
				</div>\
				<div class="coluna">\
					'+$(this).attr("sumonar")+'\
				</div>\
				<div class="coluna">\
					'+$(this).attr("convencer")+'\
				</div>\
			';
			$(this).html(exibicao);
		}).promise().done(function(){
			aplicarBackgroundTabelaCriaturas();
		});
	}
	else if(tipoExibicao == "galeria"){
		$("#criaturas.galeria .criatura").each(function(){
			exibicao = '\
				<div class="imagem">\
					<a href="'+$(this).attr("link")+'"><img src="'+$(this).attr("imagem")+'" title="'+$(this).attr("nome")+'" border="0" /></a>\
				</div>\
				<div class="nome">\
					<a href="'+$(this).attr("link")+'">'+$(this).attr("nome")+'</a>\
				</div>\
			';
			$(this).html(exibicao);
		});
	}
};
$(function(){
	$(".exibicao").click(function(){;
		$(".exibicao.ativo").removeClass("ativo");
		$(this).addClass("ativo");
		var tipoTabela = $(this).attr("id");
		if((tipoTabela == "lista") && (!$("#criaturas").hasClass(tipoTabela))){
			$("#criaturas")
			.removeClass("galeria")
			.addClass("lista");
			$("#vazio")
			.css("background", "#F1E0C6");
		}
		else if((tipoTabela == "galeria") && (!$("#criaturas").hasClass(tipoTabela))){
			$("#criaturas")
			.removeClass("lista")
			.addClass("galeria");
			$("#vazio")
			.css("background", "none");
		}
		exibirCriaturas();
		gerarCookie("exibicao", tipoTabela, 700);
	});
	var exibicao = getCookie("exibicao");
	if((exibicao != "lista") && (exibicao != "galeria"))
		exibicao = "lista";
	$("#"+exibicao).click();
	var ultimaOrdem = getCookie("ultimaOrdem"), ordenarPor;
	if(!ultimaOrdem)
		ultimaOrdem = "nome-asc";
	ultimaOrdem = ultimaOrdem.split("-");
	if(ultimaOrdem[1] == "desc")
		ordenarPor = 2
	else
		ordenarPor = 1
	$(".coluna."+ultimaOrdem[0]).find(".ordenar").attr("ordenar", ordenarPor).click();
	aplicarBackgroundTabelaCriaturas();
	var criaturas = []
	$("#criaturas .criatura").each(function(){
		var nome = $(this).attr("nome");
		criaturas.push(nome);
	});
	if($("#criaturas .criatura").length == 0)
		$("#vazio").show();
	$("#buscar_criaturas").donetyping(function(){
		var valor = $(this).val().toLowerCase(), elemento, procurarValor, encontrado = 0;
		$.each(criaturas, function(c, v){
			elemento = $("#criaturas .criatura[nome='"+v+"']");
			procurarValor = v.toLowerCase();
			if(procurarValor.indexOf(valor) !== -1){
				encontrado = 1;
				if(elemento.hasClass("ocultar"))
					elemento.removeClass("ocultar").addClass("exibir");
			}
			else{
				if(elemento.hasClass("exibir"))
					elemento.addClass("ocultar").removeClass("exibir");
			}
		});
		if(encontrado == 0)
			$("#vazio").show();
		else
			$("#vazio").hide();
		aplicarBackgroundTabelaCriaturas();
	});
});