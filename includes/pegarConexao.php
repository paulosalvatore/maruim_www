<?php
	$sock = @fsockopen("maruim.servegame.com", "7171");
	$packet = chr(6).chr(0).chr(255).chr(255).'info';
	fwrite($sock, $packet);
	$answer = ''; 
	while (!feof($sock))
		$answer .= fgets($sock, 1024);
	fclose($sock);
	$answerXML = new DOMDocument();
	if(empty($answer) || !$answerXML->loadXML($answer))
		exit;
	$serverInfo = array();
	$serverInfo["isOnline"] = true;
	$elements = $answerXML->getElementsByTagName('players');
	if($elements->length == 1)
	{
		$element = $elements->item(0);
		if($element->hasAttribute('online'))
			$serverInfo["playersCount"] = $element->getAttribute('online');
		if($element->hasAttribute('max'))
			$serverInfo["playersMaxCount"] = $element->getAttribute('max');
		if($element->hasAttribute('peak'))
			$serverInfo["playersPeakCount"] = $element->getAttribute('peak');
	}

	$elements = $answerXML->getElementsByTagName('map');
	if($elements->length == 1)
	{
		$element = $elements->item(0);
		if($element->hasAttribute('name'))
			$serverInfo["mapName"] = $element->getAttribute('name');
		if($element->hasAttribute('author'))
			$serverInfo["mapAuthor"] = $element->getAttribute('author');
		if($element->hasAttribute('width'))
			$serverInfo["mapWidth"] = $element->getAttribute('width');
		if($element->hasAttribute('height'))
			$serverInfo["mapHeight"] = $element->getAttribute('height');
	}

	$elements = $answerXML->getElementsByTagName('npcs');
	if($elements->length == 1)
	{
		$element = $elements->item(0);
		if($element->hasAttribute('total'))
			$serverInfo["npcs"] = $element->getAttribute('total');
	}

	$elements = $answerXML->getElementsByTagName('monsters');
	if($elements->length == 1)
	{
		$element = $elements->item(0);
		if($element->hasAttribute('total'))
			$serverInfo["monsters"] = $element->getAttribute('total');
	}

	$elements = $answerXML->getElementsByTagName('serverinfo');
	if($elements->length == 1)
	{
		$element = $elements->item(0);
		if($element->hasAttribute('uptime'))
			$serverInfo["uptime"] = $element->getAttribute('uptime');
		if($element->hasAttribute('location'))
			$serverInfo["location"] = $element->getAttribute('location');
		if($element->hasAttribute('url'))
			$serverInfo["url"] = $element->getAttribute('url');
		if($element->hasAttribute('client'))
			$serverInfo["client"] = $element->getAttribute('client');
		if($element->hasAttribute('server'))
			$serverInfo["server"] = $element->getAttribute('server');
		if($element->hasAttribute('serverName'))
			$serverInfo["serverName"] = $element->getAttribute('serverName');
		if($element->hasAttribute('ip'))
			$serverInfo["serverIP"] = $element->getAttribute('ip');
	}

	$elements = $answerXML->getElementsByTagName('motd');
	if($elements->length == 1)
	{
		$serverInfo["motd"] = $elements->item(0)->nodeValue;
	}
	echo json_encode($serverInfo);
?>