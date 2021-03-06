function calcularLevel(n){
	if(n == 0)
		return 0
	else{
		o = 0
		if(n != 1)
			o = Math.pow((0.188*(Math.pow(n, 1.4))), 2)+10
		return Math.max(0, (n-1)*40+o)+calcularLevel(n-1)
	}
}
function construirTabelaExperiencia(){
	var id = $("#tabelaExperiencia").data("id");
	var nivelMaximoPermitido = (id == "profissao" ? 100 : 1000);
	var nivelMinimo = 4;
	var nivelMaximo = parseInt($("input:text.nivelMaximo").val());
	if(nivelMaximo > nivelMaximoPermitido)
		nivelMaximo = nivelMaximoPermitido;
	if(nivelMaximo%4 > 0)
		nivelMaximo = nivelMaximo-nivelMaximo%4+4;
	else
		nivelMaximo = nivelMaximo-nivelMaximo%4;
	if((isNaN(nivelMaximo)) || (nivelMaximo < nivelMinimo))
		nivelMaximo = nivelMinimo;
	if($("#tabelaExperiencia").data("nivel") == nivelMaximo)
		return false;
	var limiteNivel = nivelMaximo/4;
	var tabelaExperiencia = '\
		<table class="tabela" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed; border-spacing: 0px;">\
			<tr class="cabecalho">\
				<td colspan="4">\
					Tabela de Experi�ncia'+(id == "profissao" ? " - Profiss�o" : "")+'\
				</td>\
			</tr>\
			<tr class="conteudo">\
				';
				for(i=1;i<=nivelMaximo;i++){
					if((i == 1) || ((i-1)%limiteNivel == 0))
						tabelaExperiencia += '\
							<td style="vertical-align: top;">\
								<table class="tabela" cellpadding="0" cellspacing="0" width="100%">\
									<tr class="item">\
										<td>\
											<b>N�vel</b>\
										</td>\
										<td>\
											<b>Experi�ncia</b>\
										</td>\
									</tr>\
						';
					nivelAtual = i;
					experiencia = Math.round((id == "profissao" ? calcularLevel(nivelAtual) : 50/3*(Math.pow(nivelAtual, 3)-6*Math.pow(nivelAtual, 2)+17*nivelAtual-12)));
					tabelaExperiencia += '\
						<tr class="item">\
							<td>\
								'+nivelAtual+'\
							</td>\
							<td>\
								'+experiencia+'\
							</td>\
						</tr>\
					';
					if(((i%limiteNivel) == 0) || i == nivelMaximo)
						tabelaExperiencia += '\
								</table>\
							</td>\
						';
				}
				tabelaExperiencia += '\
			</tr>\
		</table>\
	';
	$("#tabelaExperiencia").html(tabelaExperiencia).data("nivel", nivelMaximo);
}
$(function(){
	$(".botao.nivelMaximo").click(function(){
		construirTabelaExperiencia();
	});
	$("input:text.nivelMaximo").keydown(function(event){
		if(event.keyCode == 13)
			$(".botao.nivelMaximo").click();
	});
	$("select.nivelMaximo").change(function(){
		$("input:text.nivelMaximo").val($(this).val());
		$(".botao.nivelMaximo").click();
	}).change();
});