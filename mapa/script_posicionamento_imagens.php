<?php
	set_time_limit(60*60*60);
	$diretorioOriginal = "tiles_maruim_original/";
	$diretorio = "tiles_maruim/";
	for($a=7;$a<=7;$a++){
		$pasta1 = $diretorio.$a;
		for($b=1;$b<=5;$b++){
			$imagem = 1;
			$limite = pow(2, $b);
			$pasta2 = $pasta1."/".$b;
			for($c=0;$c<$limite;$c++){
				$x = 0;
				for($d=0;$d<$limite;$d++){
					$y = $limite-$c-1;
					$pasta1 = $diretorio.$a."/";
					$pasta2 = $pasta1.$b."/";
					$pasta3 = $pasta2.$x;
					$exibirImagem = $imagem;
					if($imagem < 10)
						$exibirImagem = "0".$imagem;
					$s = 256*$limite;
					$nomeArquivoImagemOriginal = "MiniMap_".$s."/MiniMap_".$s."_".$exibirImagem.".png";
					if(!file_exists($pasta1))
						mkdir($pasta1);
					if(!file_exists($pasta2))
						mkdir($pasta2);
					if(!file_exists($pasta3))
						mkdir($pasta3);
					$nomeArquivoImagem = "$pasta3/$y.png";
					$arquivoOriginal = $diretorioOriginal.$nomeArquivoImagemOriginal;
					if(filesize($arquivoOriginal) != 1517)
						copy($arquivoOriginal, $nomeArquivoImagem);
					$x++;
					$imagem++;
				}
			}
		}
	}
	echo'
		<style>
			body {
				margin: 0;
			}
			.x_y {
				position: absolute;
				margin-top: -20px;
				margin-left: 5px;
				color: white;
				font-family: Verdana;
			}
			.principal {
				margin-bottom: 7px;
				display: none;
			}
		</style>
		<table class="principal" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<img src="tiles/7-1-0-1.png" /><br>
					<div class="x_y">x0 y1 - 01</div>
				</td>
				<td>
					<img src="tiles/7-1-1-1.png" /><br>
					<div class="x_y">x1 y1 - 02</div>
				</td>
			</tr>
			<tr>
				<td>
					<img src="tiles/7-1-0-0.png" /><br>
					<div class="x_y">x0 y0 - 03</div>
				</td>
				<td>
					<img src="tiles/7-1-1-0.png" /><br>
					<div class="x_y">x1 y0 - 04</div>
				</td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<img src="tiles/7-2-0-3.png" /><br>
					<div class="x_y">x0 y3 - 01</div>
				</td>
				<td>
					<img src="tiles/7-2-1-3.png" /><br>
					<div class="x_y">x1 y3 - 02</div>
				</td>
				<td>
					<img src="tiles/7-2-2-3.png" /><br>
					<div class="x_y">x2 y3 - 03</div>
				</td>
				<td>
					<img src="tiles/7-2-3-3.png" /><br>
					<div class="x_y">x3 y3 - 04</div>
				</td>
			</tr>
			<tr>
				<td>
					<img src="tiles/7-2-0-2.png" /><br>
					<div class="x_y">x0 y2 - 05</div>
				</td>
				<td>
					<img src="tiles/7-2-1-2.png" /><br>
					<div class="x_y">x1 y2 - 06</div>
				</td>
				<td>
					<img src="tiles/7-2-2-2.png" /><br>
					<div class="x_y">x2 y2 - 07</div>
				</td>
				<td>
					<img src="tiles/7-2-3-2.png" /><br>
					<div class="x_y">x3 y2 - 08</div>
				</td>
			</tr>
			<tr>
				<td>
					<img src="tiles/7-2-0-1.png" /><br>
					<div class="x_y">x0 y1 - 09</div>
				</td>
				<td>
					<img src="tiles/7-2-1-1.png" /><br>
					<div class="x_y">x1 y1 - 10</div>
				</td>
				<td>
					<img src="tiles/7-2-2-1.png" /><br>
					<div class="x_y">x2 y1 - 11</div>
				</td>
				<td>
					<img src="tiles/7-2-3-1.png" /><br>
					<div class="x_y">x3 y1 - 12</div>
				</td>
			</tr>
			<tr>
				<td>
					<img src="tiles/7-2-0-0.png" /><br>
					<div class="x_y">x0 y0 - 13</div>
				</td>
				<td>
					<img src="tiles/7-2-1-0.png" /><br>
					<div class="x_y">x1 y0 - 14</div>
				</td>
				<td>
					<img src="tiles/7-2-2-0.png" /><br>
					<div class="x_y">x2 y0 - 15</div>
				</td>
				<td>
					<img src="tiles/7-2-3-0.png" /><br>
					<div class="x_y">x3 y0 - 16</div>
				</td>
			</tr>
		</table>
	';
	// set_time_limit(60*60*60);
	// $diretorioOriginal = "tiles_maruim_original/";
	// $diretorio = "tiles_maruim/";
	// for($a=7;$a<=7;$a++){
		// $pasta1 = $diretorio.$a;
		// for($b=1;$b<=2;$b++){
			// $limite = pow(2, $b);
			// $pasta2 = $pasta1."/".$b;
			// for($c=0;$c<$limite;$c++){
				// for($d=0;$d<$limite;$d++){
					// $pasta3 = $pasta2."/".$d;
					// $n = $c*$limite+$d+1;
					// $s = 256*$limite;
					// if($n < 10)
						// $n = "0$n";
					// $nomeArquivoImagemOriginal = $s."_tiles/MiniMapa_".$s."_".$n.".png";
					// if(!file_exists($pasta1))
						// mkdir($pasta1);
					// if(!file_exists($pasta2))
						// mkdir($pasta2);
					// if(!file_exists($pasta3))
						// mkdir($pasta3);
					// $nomeArquivoImagem = "$pasta3/".($limite-$c).".png";
					// $arquivoOriginal = $diretorioOriginal.$nomeArquivoImagemOriginal;
					// $arquivo = copy($arquivoOriginal, $nomeArquivoImagem);
				// }
			// }
		// }
	// }
?>