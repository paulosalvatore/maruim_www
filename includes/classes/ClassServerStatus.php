<?php
	class ServerStatus {
		public $isOnline = false;

		public $ip;
		public $port;
		public $waitAnswerTime = 5;
		public $packet = '';
		public $errorNumber = 0;
		public $errorMessage = '';

		public $answerXML;

		public $playersCount = 0;
		public $playersMaxCount = 0;
		public $playersPeakCount = 0;

		public $mapName = '';
		public $mapAuthor = '';
		public $mapWidth = 0;
		public $mapHeight = 0;

		public $npcs = 0;
		public $monsters = 0;
		public $uptime = 0;
		public $motd = '';
		public $location = '';
		public $url = '';
		public $client = '';
		public $server = '';
		public $serverName = '';
		public $serverIP = '';

		public $ownerName = '';
		public $ownerMail = '';

		public function getErrorNumber($forceReload = false)
		{
			return $this->errorNumber;
		}

		public function getErrorMessage($forceReload = false)
		{
			return $this->errorMessage;
		}

		public function loadStatus($forceReload = false)
		{
			if(!isset($this->answerXML) || $forceReload)
			{
				$this->isOnline = false;
				$serverInfoJson = json_decode(file_get_contents("http://maruim.servegame.com/includes/pegarConexao.php"));
				$serverInfo = array();
				if(!empty($serverInfoJson))
					foreach($serverInfoJson as $c => $v)
						$serverInfo[$c] = $v;
				if(count($serverInfo) > 0)
				{
					$this->isOnline = $serverInfo["isOnline"];
					$this->playersCount = $serverInfo["playersCount"];
					$this->playersMaxCount = $serverInfo["playersMaxCount"];
					$this->playersPeakCount = $serverInfo["playersPeakCount"];
					$this->mapName = $serverInfo["mapName"];
					$this->mapAuthor = $serverInfo["mapAuthor"];
					$this->mapWidth = $serverInfo["mapWidth"];
					$this->mapHeight = $serverInfo["mapHeight"];
					$this->npcs = $serverInfo["npcs"];
					$this->monsters = $serverInfo["monsters"];
					$this->uptime = $serverInfo["uptime"];
					$this->location = $serverInfo["location"];
					$this->url = $serverInfo["url"];
					$this->client = $serverInfo["client"];
					$this->server = $serverInfo["server"];
					$this->serverName = $serverInfo["serverName"];
					$this->serverIP = $serverInfo["serverIP"];
					$this->motd = $serverInfo["motd"];
				}
			}
		}

		public function isOnline($forceReload = false)
		{
			return $this->isOnline;
		}

		public function getPlayersCount($forceReload = false)
		{
			return $this->playersCount;
		}

		public function getPlayersMaxCount($forceReload = false)
		{
			return $this->playersMaxCount;
		}

		public function getPlayersPeakCount($forceReload = false)
		{
			return $this->playersPeakCount;
		}

		public function getMapName($forceReload = false)
		{
			return $this->mapName;
		}

		public function getMapAuthor($forceReload = false)
		{
			return $this->mapAuthor;
		}

		public function getMapWidth($forceReload = false)
		{
			return $this->mapWidth;
		}

		public function getMapHeight($forceReload = false)
		{
			return $this->mapHeight;
		}

		public function getUptime($forceReload = false)
		{
			return $this->uptime;
		}

		public function getMonsters($forceReload = false)
		{
			return $this->monsters;
		}

		public function getNPCs($forceReload = false)
		{
			return $this->npcs;
		}

		public function getMOTD($forceReload = false)
		{
			return $this->motd;
		}

		public function getLocation($forceReload = false)
		{
			return $this->location;
		}

		public function getURL($forceReload = false)
		{
			return $this->url;
		}

		public function getClient($forceReload = false)
		{
			return $this->client;
		}

		public function getServer($forceReload = false)
		{
			return $this->server;
		}

		public function getServerName($forceReload = false)
		{
			return $this->serverName;
		}

		public function getServerIP($forceReload = false)
		{
			return $this->serverIP;
		}

		public function getOwnerName($forceReload = false)
		{
			return $this->ownerName;
		}

		public function getOwnerMail($forceReload = false)
		{
			return $this->ownerMail;
		}
	}
?>