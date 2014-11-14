<?php 

class ReferralLink {
	
	public function __construct($settings = array()){

		$this->keyName = (isset($settings['keyName'])) ? $settings['keyName'] : 'ref'; 
		$this->linkLength = (isset($settings['length'])) ? $settings['length'] : 5;
		$this->url = (isset($settings['url'])) ? $settings['url'] : $_SERVER['HTTP_HOST'];  

	}

	public function createLink(){
		return implode('?', array($this->getUrl(), $this->getQueryString()));
	}

	private function getUrl(){
		return 'http://' . $this->url;  
	}

	private function getQueryString(){
		return implode('=', array($this->keyName, $this->getRandomId())); 
	}

	private function getRandomId($length = 5){
		$alphabet = $this->getAlphabet(); 
		$result   = array(); 

		for($i = 0; $i <= $length; $i++){
			$randomLetterIndex = array_rand($alphabet); 
			$result[] = $alphabet[$randomLetterIndex]; 
		}

		return implode('', $result); 

	}

	private function getAlphabet(){
		$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$letters  = array();

		for($i = 0; $i < strlen($alphabet); $i++){
			$letters[] = $alphabet[$i]; 
		}

		return $letters; 

	}
}