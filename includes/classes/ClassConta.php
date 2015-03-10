<?php
	class Conta {
		public function formatarData($tempo){
			return date("d/m/Y, H\hi\ms\s", $tempo);
		}
		public function getStatusConta($status){
			if($status == 0)
				return '<span class="vermelho">Conta Gratuita</span>';
			else
				return '<span class="verde">Conta Premium</span>';
		}
		public function getInformacoesConta($accountName){
			$queryConta = mysql_query("SELECT * FROM accounts WHERE (name LIKE '$accountName')");
			while($resultadoConta = mysql_fetch_assoc($queryConta))
				foreach($resultadoConta as $c => $v){
					if($c == "creation")
						$informacoesConta["exibirDataCriacao"] = $this->formatarData($v);
					$informacoesConta[$c] = $v;
				}
			return $informacoesConta;
		}
		public function registrarUltimoAcesso($contaId){
			mysql_query("UPDATE accounts SET ultimo_acesso = '".time()."' WHERE id = '$contaId'");
		}
	}
?>