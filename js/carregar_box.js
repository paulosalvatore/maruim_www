$(function(){
	$(".conteudo_pagina").each(function(){
		var carregar_box = $(this).attr("carregar_box");
		var imagem = $(this).attr("carregar_imagem_titulo");
		if(imagem)
			imagem = '<img src="imagens/paginas/'+imagem+'.png">';
		if(carregar_box == 1){
			var box = '\
				<div class="box">\
					<div class="canto_borda se"></div>\
					<div class="canto_borda sd"></div>\
					<div class="borda"></div>\
					<div class="titulo verde pagina">'+imagem+'</div>\
					<div class="conteudo_borda">\
						'+$(this).html()+'\
					</div>\
					<div class="borda"></div>\
					<div class="canto_borda ie"></div>\
					<div class="canto_borda id"></div>\
				</div>\
			';
			$(this).html(box);
		}
	});
	$(".small_box_frame").each(function(){
		var carregar_box = $(this).attr("carregar_box");
		var erro = $(this).hasClass("erro");
		var atencao = $(this).hasClass("atencao");
		if(carregar_box == 1){
			if(erro || atencao)
				var conteudo_box = '\
					<table cellpadding="0" cellspacing="0">\
						<tr>\
							<td width="40">\
								<img src="imagens/corpo/atencao.gif">\
							</td>\
							<td class="mensagem">\
								'+$(this).html()+'\
							</td>\
						</tr>\
					</table>\
				';
			else
				var conteudo_box = $(this).html();
			var box = '\
				<div class="canto se"></div>\
				<div class="canto sd"></div>\
				<div class="borda_horizontal"></div>\
				<div class="texto">\
					<div class="borda_vertical esquerda"></div>\
					<div class="borda_vertical direita"></div>\
						'+conteudo_box+'\
				</div>\
				<div class="borda_horizontal"></div>\
				<div class="canto ie"></div>\
				<div class="canto id"></div>\
			';
			$(this).html(box);
		}
	});
	$(".box_frame").each(function(){
		var carregar_box = $(this).attr("carregar_box");
		if(carregar_box == 1){
			var box = '\
				<div class="canto se"></div>\
				<div class="canto sd"></div>\
				<div class="borda_horizontal"></div>\
				<div class="texto">\
					<div class="borda_vertical esquerda"></div>\
					<div class="borda_vertical direita"></div>\
					'+$(this).html()+'\
				</div>\
				<div class="borda_horizontal"></div>\
				<div class="canto ie"></div>\
				<div class="canto id"></div>\
			';
			$(this).html(box);
		}
	});
	$(".box_frame_conteudo_principal").each(function(){
		var carregar_box = $(this).attr("carregar_box");
		var sombra = $(this).hasClass("sombra");
		if(carregar_box == 1){
			if(sombra)
				var conteudo_box = '\
					<div class="box_frame_conteudo" carregar_box="1">\
						<div class="box_frame_conteudo_borda3">\
							<div class="box_frame_conteudo_borda4">\
								'+$(this).html()+'\
							</div>\
						</div>\
					</div>\
				';
			else
				var conteudo_box = '\
					<div class="box_frame_conteudo_borda3">\
						<div class="box_frame_conteudo_borda4">\
							'+$(this).html()+'\
						</div>\
					</div>\
				';
			var box = '\
				<div class="box_frame_conteudo_borda1">\
					<div class="box_frame_conteudo_borda2">\
						'+conteudo_box+'\
					</div>\
				</div>\
			';
			$(this).html(box);
		}
	});
	$(".box_frame_conteudo").each(function(){
		var carregar_box = $(this).attr("carregar_box");
		if(carregar_box == 1){
			var box = '\
				<div class="box_frame_tabela_canto_sd"></div>\
				<div class="box_frame_tabela_sombra_vertical">\
					'+$(this).html()+'\
				</div>\
				<div class="box_frame_tabela_canto_ie"></div>\
				<div class="box_frame_tabela_canto_id"></div>\
				<div class="box_frame_tabela_sombra_horizontal"></div>\
			';
			$(this).html(box);
		}
	});
});