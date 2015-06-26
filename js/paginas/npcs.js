$(function(){
	$("img.imagemNpc").each(function(){
		$(this).load(function(){
			$(this).addClass("largura64");
			if($(this).width() != 64)
				$(this).removeClass("largura64");
		});
	});
});