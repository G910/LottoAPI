<?php

Class Lotto{
	
	private $APIAddress = "http://81.2.251.149/lotto/API.php";
	private $clientID = null;
	private $clientSecret = null;
	private $connected = false;
	private $lastErrorCode;
	private $lastErrorDesc;
	private $time;
	private $token;
	private $debug = false;
	private $debugFile = "./LottoAPI.log";

	public function __construct($clientID = null, $clientSecret = null, $debug = false){
		$this->clientID = $clientID;
		$this->clientSecret = $clientSecret;
		$this->time = time();
		$this->connect();
		$this->debug = $debug;
	}

	private function appendLog($content){
		if(!file_exists($this->debugFile))
			file_put_contents($this->debugFile, "");
		file_put_contents($this->debugFile, file_get_contents($this->debugFile).$content);
	}

	private function curl($postData){
		$postData['time'] = time();
		$postData['token'] = $this->token;
		$postData['clientIP'] = $_SERVER['REMOTE_ADDR'];
		$postDataJSON = json_encode($postData);
		$postDataJSONArr['request'] = $postDataJSON;
		$ch = curl_init($this->APIAddress);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJSONArr);
		$response = curl_exec($ch);
		if($this->debug){
			$this->appendLog("Request:".$postDataJSON."\r\nResponse: ".$response."\r\n\r\n");
		}
		curl_close($ch);
		$response = json_decode($response, true);
		if(empty($response['status']) || $response['status'] != 1) {
			$this->lastErrorCode = $response['error']['code'];
			$this->lastErrorDesc = $response['error']['description'];
			return [];
		}
		return $response;
	}

	private function isDateValid($date){
		$isCorrectData = preg_match("|[0-9]{4}-[0-9]{2}-[0-9]{2}|", $date);
		if ($date !== null && !$isCorrectData) {
			$this->lastErrorCode = "clientSide1";
			$this->lastErrorDesc = "Data wprowadzona w niewłaściwym formacie. Prawidłowy: YYYY-MM-DD";
			return false;
		}
		return $date;
	}
	
	private function createRequest($date, $from){
		if(($date = $this->isDateValid($date)) === false) {
			return [];
		}
		$data = [];
		$data['type'] = 'get'.$from;
		if ($date !== null) {
			$data['type'] .= 'ByDate';
			$data['date'] = $date;
		}
		return $this->curl($data);
	}

	public function connect(){
		$data = ['id' => $this->clientID, 'secret' => $this->clientSecret, 'constructTime' => $this->time, 'type' => "authenticate", 'clientIP' => $_SERVER['REMOTE_ADDR']];
		$response = $this->curl($data);
	 	$this->connected = true;
		$this->token = $response['token'];
		return true;
	}

	public function getLastError(){
		return (!empty($this->lastErrorCode)) ? "[#ERR ".$this->lastErrorCode."]: ".$this->lastErrorDesc: "";
	}

	public function getLotto($date = null){
		return $this->createRequest($date, "Lotto");
	}

	public function getLottoPlus($date = null){
		return $this->createRequest($date, "LottoPlus");
	}

	public function getMiniLotto($date = null){
		return $this->createRequest($date, "MiniLotto");
	}

	public function getMultiMulti($date = null){
		return $this->createRequest($date, "MultiMulti");
	}

	public function getKaskada($date = null){
		return $this->createRequest($date, "Kaskada");
	}

	public function getEkstraPensja($date = null){
		return $this->createRequest($date, "EkstraPensja");
	}

	public function getKeno($date = null){
		return $this->createRequest($date, "Keno");
	}
	
}