<?php
	set_time_limit(60*60*60);
	$diretorioOriginal = "../tiles_original/";
	$diretorio = "../tiles/";
	for($a=0;$a<=15;$a++){
		$pasta1 = $diretorio.$a;
		for($b=1;$b<=6;$b++){
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
					$nomeArquivoImagemOriginal = "Mapa_".$s."_".$exibirImagem;
					if(!file_exists($pasta1))
						mkdir($pasta1);
					if(!file_exists($pasta2))
						mkdir($pasta2);
					if(!file_exists($pasta3))
						mkdir($pasta3);
					$nomeArquivoImagem = "$pasta3/$y.jpg";
					$arquivoOriginal = $diretorioOriginal.$s."/".$a."/".$nomeArquivoImagemOriginal.".png";
					if(!file_exists($arquivoOriginal))
						$arquivoOriginal = $diretorioOriginal.$s."/".$a."/images/".$nomeArquivoImagemOriginal.".png";
					if(!file_exists($arquivoOriginal))
						$arquivoOriginal = $diretorioOriginal.$s."/".$a."/images/".$nomeArquivoImagemOriginal.".jpg";
					// echo "$arquivoOriginal<br>";
					// echo filesize($arquivoOriginal)."<br>";
					// if(filesize($arquivoOriginal) != 1503)
						copy($arquivoOriginal, $nomeArquivoImagem);
					$x++;
					$imagem++;
				}
			}
		}
	}
?>