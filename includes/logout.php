<?php
	session_start();
	session_unset();
	header("Location: ../?p=ultimas_noticias");
?>