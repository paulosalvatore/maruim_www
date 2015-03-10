function construirTabelaExperiencia(){
	var levelMaximo = 1000;
	tabela = '\
		<table class="tabela" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed; border-spacing: 0px;">\
			<tr class="cabecalho">\
				<td colspan="4">\
					Tabela de Experiência\
				</td>\
			</tr>\
			<tr class="conteudo">\
				';
				for(i=0;i<4;i++){
					tabela += '\
						<td>\
							<table class="tabela" cellpadding="0" cellspacing="0" width="100%">\
								<tr class="item">\
									<td>\
										<b>Nível</b>\
									</td>\
									<td>\
										<b>Experiência</b>\
									</td>\
								</tr>\
								';
								for(j=1;j<=levelMaximo/4;j++){
									nivelAtual = i*levelMaximo/4+j;
									experiencia = Math.round(50/3*(Math.pow(nivelAtual, 3)-6*Math.pow(nivelAtual, 2)+17*nivelAtual-12));
									tabela += '\
										<tr class="item">\
											<td>\
												'+nivelAtual+'\
											</td>\
											<td>\
												'+experiencia+'\
											</td>\
										</tr>\
									';
								}
								tabela += '\
							</table>\
						</td>\
					';
				}
				tabela += '\
			</tr>\
		</table>\
	';
	return tabela;
}
$(function(){
	var tabelaExperiencia = construirTabelaExperiencia();
	$("#tabelaExperiencia").html(tabelaExperiencia);
})