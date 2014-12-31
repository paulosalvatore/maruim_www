<?php
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$incluir_arquivo.'">
			<div class="conteudo_box pagina">
				<div class="box_frame" carregar_box="1">
					Storage ID
				</div>
				<div class="box_frame_conteudo_principal" carregar_box="0">
					<div class="box_frame_conteudo">
						<table class="tabela odd center" cellpadding="0" cellspacing="0" width="100%">
							<tr class="cabecalho">
								<td width="50">
									ID
								</td>
								<td width="180">
									Tipo de Valor
								</td>
								<td>
									Descrição
								</td>
							</tr>
							';
							for($i=0;$i<10;$i++){
								$conteudo_pagina .= '
									<tr class="item">
										<td>
											<b>1000'.$i.'</b>
										</td>
										<td>
											Milissegundos<br>
											(Ex.: 1000 = 1 segundo)
										</td>
										<td>
											Valor definido pra bla bla bla
										</td>
									</tr>
								';
							}
							$conteudo_pagina .= '
						</table>
					</div>
				</div>
			</div>
		</div>
	';
?>