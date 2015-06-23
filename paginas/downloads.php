<?php
	$conteudo_pagina .= '
		<div class="conteudo_pagina" carregar_box="1" carregar_imagem_titulo="'.$pagina.'">
			<div class="conteudo_box pagina">
				<div class="box_frame" carregar_box="1">
					Downloads
				</div>
				<div class="box_frame_conteudo_principal borda2_padding" carregar_box="1">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td>
								<div class="box_frame_conteudo" carregar_box="1">
									<table cellpadding="0" cellspacing="0" class="box_frame_tabela">
										<tr class="conteudo dark">
											<td>
												<table width="100%" cellpadding="0" cellspacing="0">
													<tr align="center">
														<td>
															<a href="arquivos/desenvolvedor/tibia'.$config["versao"]["valor"].'.exe">
																<img src="imagens/corpo/download_windows.png" class="imgDownloadClient" border="0" alt="" title="Windows Tibia - Client '.$config["versao"]["exibicao"].'" /><br>
																Windows Tibia<br>Client '.$config["versao"]["exibicao"].'
															</a>
														</td>
														<td>
															<a href="arquivos/desenvolvedor/tibia'.$config["versao"]["valor"].'.tgz">
																<img src="imagens/corpo/download_linux.png" class="imgDownloadClient" border="0" alt="" title="Linux Tibia - Client '.$config["versao"]["exibicao"].'" /><br>
																Linux Tibia<br>Client '.$config["versao"]["exibicao"].'
															</a>
														</td>
														<td>
															<a href="arquivos/desenvolvedor/ipchanger.exe">
																<img src="imagens/corpo/download_ip.png" class="imgDownloadIp" border="0" alt="" title="Tibia IP Changer" /><br>
																Tibia IP Changer
															</a>
															<br>
															<br>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</div>
								<br>
							</td>
						</tr>
						<tr>
							<td>
								<div class="box_frame_conteudo" carregar_box="1">
									<table cellpadding="0" cellspacing="0" class="box_frame_tabela download">
										<tr class="conteudo dark">
											<td width="200" align="center">
												<img src="imagens/corpo/download_ok.png" alt="" title="" />
											</td>
											<td valign="top">
												<span class="negrito grande">Requisitos Mínimos:</span><br>
												<br>
												<b>Windows:</b><br>
												Windows XP (<i>Service Pack</i> 2 ou superior)/Vista/7/8/8.1<br>
												<i>DirectX</i> versão 5.0 ou superior, ou <i>OpenGL</i><br>
												147 MB de espaço livre no HD<br>
												Conexão com a Internet<br>
												<br>
												<b>Linux:</b><br>
												Bibliotecas do <i>32 bits</i> em um sistema operacional de <i>64 bits</i><br>
												Linux com libc versão 6 ou superior<br>
												<i>X-Window system</i> instalado<br>
												<i>Driver</i> de Acelerador de <i>Hardware</i> Gráfico<br>
												146 MB de espaço livre no HD<br>
												Conexão com a Internet<br>
											</td>
										</tr>
									</table>
								</div>
								<br>
							</td>
						</tr>
						<tr>
							<td>
								<div class="box_frame_conteudo dark" carregar_box="1">
									<table cellpadding="0" cellspacing="0" class="box_frame_tabela download">
										<tr class="conteudo dark">
											<td>
												<span class="negrito grande">Observação:</span><br>
												<br>
												Os programas e qualquer documentação relacionada são fornecidos "como estão" sem garantia de qualquer tipo. Todos os riscos decorrentes do uso do mesmo permanece com você. Em nenhum caso seremos responsáveis por quaisquer danos ao seu computador ou perda de dados.
											</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	';
?>