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
			return false;
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
	
	public function connect(){
		$data['id'] = $this->clientID;
		$data['secret'] = $this->clientSecret;
		$data['constructTime'] = $this->time;
		$data['type'] = "authenticate";
		$data['clientIP'] = $_SERVER['REMOTE_ADDR'];
		$response = $this->curl($data);
	 	$this->connected = true;
		$this->token = $response['token'];
		return true;
	}
	
	public function getLastError(){
		$error = (!empty($this->lastErrorCode)) ? "[#ERR ".$this->lastErrorCode."]: ".$this->lastErrorDesc: false;
		return $error;
	}
	
	public function getLotto($date = null){
		if(($date = $this->isDateValid($date)) === false) {
			return false;
		}
		$data = [];
		$data['type'] = 'getLotto';
		if ($date !== null) {
			$data['type'] .= 'ByDate';
			$data['date'] = $date;
		}
		return $this->curl($data);
	}
	
	public function getLottoPlus($date = null){
		if(($date = $this->isDateValid($date)) === false) {
			return false;
		}
		$data = [];
		$data['type'] = 'getLottoPlus';
		if ($date !== null) {
			$data['type'] .= 'ByDate';
			$data['date'] = $date;
		}
		return $this->curl($data);
	}
	
	public function getMiniLotto($date = null){
		if(($date = $this->isDateValid($date)) === false) {
			return false;
		}
		$data = [];
		$data['type'] = 'getMiniLotto';
		if ($date !== null) {
			$data['type'] .= 'ByDate';
			$data['date'] = $date;
		}
		return $this->curl($data);
	}
	
	public function getMultiMulti($date = null){
		if(($date = $this->isDateValid($date)) === false) {
			return false;
		}
		$data = [];
		$data['type'] = 'getMultiMulti';
		if ($date !== null) {
			$data['type'] .= 'ByDate';
			$data['date'] = $date;
		}
		return $this->curl($data);
	}
	
	public function getKaskada($date = null){
		if(($date = $this->isDateValid($date)) === false) {
			return false;
		}
		$data = [];
		$data['type'] = 'getKaskada';
		if ($date !== null) {
			$data['type'] .= 'ByDate';
			$data['date'] = $date;
		}
		return $this->curl($data);
	}
	
	public function getEkstraPensja($date = null){
		if(($date = $this->isDateValid($date)) === false) {
			return false;
		}
		$data = [];
		$data['type'] = 'getEkstraPensja';
		if ($date !== null) {
			$data['type'] .= 'ByDate';
			$data['date'] = $date;
		}
		return $this->curl($data);
	}
	
	public function getKenyo($date = null){
		if(($date = $this->isDateValid($date)) === false) {
			return false;
		}
		$data = [];
		$data['type'] = 'getKenyo';
		if ($date !== null) {
			$data['type'] .= 'ByDate';
			$data['date'] = $date;
		}
		return $this->curl($data);
	}
	
	
	
	
	
}
