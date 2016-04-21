<?php

Class Lotto{
	
	private $_APIAddress = "http://localhost/lotto/API.php";
	private $_clientID = null;
	private $_clientSecret = null;
	private $_connected = false;
	private $_lastErrorCode;
	private $_lastErrorDesc;
	private $_time;
	private $_token;
	
	public function __construct($clientID = null, $clientSecret = null){
		$this->_clientID = $clientID;
		$this->_clientSecret = $clientSecret;
		$this->_time = time();
		$this->connect();
	}
	
	private function curl($postData){
		$postData['time'] = time();
		$postData['token'] = $this->_token;
		$postDataJSON = json_encode($postData);
		// echo "<br>Request:".$postDataJSON."<br>";
		$postDataJSONArr['request'] = $postDataJSON;
		$ch = curl_init($this->_APIAddress);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJSONArr);
		$response = curl_exec($ch);
		// echo "Response: ".$response."<br>";
		curl_close($ch);
		return json_decode($response, true);
	}
	
	public function connect(){
		$data['id'] = $this->_clientID;
		$data['secret'] = $this->_clientSecret;
		$data['constructTime'] = $this->_time;
		$data['type'] = "authenticate";
		$response = $this->curl($data);
		if(isset($response['status']) && $response['status'] == 1){
			$this->_connected = true;
			$this->_token = $response['token'];
			return true;
		}else{
			$this->_lastErrorCode = $response['error']['code'];
			$this->_lastErrorDesc = $response['error']['description'];
			return false;
		}
	}
	
	public function getLastError(){
		$error = (!empty($this->_lastErrorCode)) ? "[#ERR ".$this->_lastErrorCode."]: ".$this->_lastErrorDesc: null;
		return $error;
	}
	
	public function getLotto($date = 0){
		if($date == 0){
			$data['type'] = "getLotto";
		}else{
			if(preg_match("|[0-9]{4}-[0-9]{2}-[0-9]{2}|", $date)){
				$data['type'] = "getLottoByDate";
				$data['date'] = $date;
			}else{
				$this->_lastErrorCode = "clientSide1";
				$this->_lastErrorDesc = "Data wprowadzona w niewłaściwym formacie. Prawidłowy: YYYY-MM-DD";
				return false;
			}
		}
		return $this->curl($data);
	}
	
	public function getLottoPlus($date = 0){
		if($date == 0){
			$data['type'] = "getLottoPlus";
		}else{
			if(preg_match("|[0-9]{4}-[0-9]{2}-[0-9]{2}|", $date)){
				$data['type'] = "getLottoPlusByDate";
				$data['date'] = $date;
			}else{
				$this->_lastErrorCode = "clientSide1";
				$this->_lastErrorDesc = "Data wprowadzona w niewłaściwym formacie. Prawidłowy: YYYY-MM-DD";
				return false;
			}
		}
		return $this->curl($data);
	}
	
	public function getMiniLotto($date = 0){
		if($date == 0){
			$data['type'] = "getMiniLotto";
		}else{
			if(preg_match("|[0-9]{4}-[0-9]{2}-[0-9]{2}|", $date)){
				$data['type'] = "getMiniLottoByDate";
				$data['date'] = $date;
			}else{
				$this->_lastErrorCode = "clientSide1";
				$this->_lastErrorDesc = "Data wprowadzona w niewłaściwym formacie. Prawidłowy: YYYY-MM-DD";
				return false;
			}
		}
		return $this->curl($data);
	}
	
	public function getMultiMulti($date = 0){
		if($date == 0){
			$data['type'] = "getMultiMulti";
		}else{
			if(preg_match("|[0-9]{4}-[0-9]{2}-[0-9]{2}|", $date)){
				$data['type'] = "getMultiMultiByDate";
				$data['date'] = $date;
			}else{
				$this->_lastErrorCode = "clientSide1";
				$this->_lastErrorDesc = "Data wprowadzona w niewłaściwym formacie. Prawidłowy: YYYY-MM-DD";
				return false;
			}
		}
		return $this->curl($data);
	}
	
	public function getKaskada($date = 0){
		if($date == 0){
			$data['type'] = "getKaskada";
		}else{
			if(preg_match("|[0-9]{4}-[0-9]{2}-[0-9]{2}|", $date)){
				$data['type'] = "getKaskadaByDate";
				$data['date'] = $date;
			}else{
				$this->_lastErrorCode = "clientSide1";
				$this->_lastErrorDesc = "Data wprowadzona w niewłaściwym formacie. Prawidłowy: YYYY-MM-DD";
				return false;
			}
		}
		return $this->curl($data);
	}
	
	public function getEkstraPensja($date = 0){
		if($date == 0){
			$data['type'] = "getEkstraPensja";
		}else{
			if(preg_match("|[0-9]{4}-[0-9]{2}-[0-9]{2}|", $date)){
				$data['type'] = "getEkstraPensjaByDate";
				$data['date'] = $date;
			}else{
				$this->_lastErrorCode = "clientSide1";
				$this->_lastErrorDesc = "Data wprowadzona w niewłaściwym formacie. Prawidłowy: YYYY-MM-DD";
				return false;
			}
		}
		return $this->curl($data);
	}
	
	public function getKenyo($date = 0){
		if($date == 0){
			$data['type'] = "getKenyo";
		}else{
			if(preg_match("|[0-9]{4}-[0-9]{2}-[0-9]{2}|", $date)){
				$data['type'] = "getKenyoByDate";
				$data['date'] = $date;
			}else{
				$this->_lastErrorCode = "clientSide1";
				$this->_lastErrorDesc = "Data wprowadzona w niewłaściwym formacie. Prawidłowy: YYYY-MM-DD";
				return false;
			}
		}
		return $this->curl($data);
	}
	
	
	
	
	
}