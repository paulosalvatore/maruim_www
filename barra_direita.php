<?php
	$conteudo_barra_direita .= '
		<div id="boxPedestalOnline">
			<img id="monstroSemana" src="imagens/criaturas/Demon.gif" onClick="window.location = \'?p=criaturas-Demon\';" alt="Monstro da Semana" />
			<img id="pedestalOnline" src="imagens/barra_direita/pedestal_online.png" alt="" style="max-width: none;" />
			<div id="jogadoresOnline" onClick="window.location = \'?p=jogadores_online\';">'.$ClassFuncao->exibirNumeroJogadoresOnline().'</div>
		</div>
		<div id="premiumBox">
			<img src="imagens/barra_direita/premiumbox.gif" alt="" /><br>
			<div id="adquirirPremium">
				<input type="button" class="botao_verde" value="adquirir" onClick="document.location = \'?p=adquirir_premium\'" />
			</div>
		</div>
	';
?>