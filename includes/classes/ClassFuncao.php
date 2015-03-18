<?php
	class Funcao {
		public function transformarDiasTempo($dias){
			return $dias*24*60*60;
		}
		public function formatarData($tempo){
			return date("d/m/Y, H\hi\ms\s", $tempo);
		}
		public function formatarLogin($tempo){
			if($tempo > 0)
				$formatarLogin = $this->formatarData($tempo);
			else
				$formatarLogin = "Nunca efetuou login.";
			return $formatarLogin;
		}
	}
?>