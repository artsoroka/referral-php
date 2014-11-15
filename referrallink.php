<?php 

class ReferralLink {
	
	private $db = false;  

	public function __construct($settings = array()){

		$this->keyName = (isset($settings['keyName'])) ? $settings['keyName'] : 'ref'; 
		$this->linkLength = (isset($settings['length'])) ? $settings['length'] : 5;
		$this->url = (isset($settings['url'])) ? $settings['url'] : $_SERVER['HTTP_HOST'];  
		
		$this->db_type = (isset($settings['db_type'])) ? $settings['db_type'] : 'mysql';
		$this->db_host = (isset($settings['db_host'])) ? $settings['db_host'] : 'localhost';
		$this->db_port = (isset($settings['db_port'])) ? $settings['db_port'] : '3306';
		$this->db_name = (isset($settings['db_name'])) ? $settings['db_name'] : 'test';
		$this->db_user = (isset($settings['db_user'])) ? $settings['db_user'] : 'root';
		$this->db_pass = (isset($settings['db_pass'])) ? $settings['db_pass'] : '';

		$this->db = $this->getDBConnection(); 
	}

	public function find($refKey = null){

		if( ! $refKey ) return false;   

		$sth = $this->db->prepare("SELECT * FROM referral_links WHERE ref_key = :refKey");
		$sth->execute(array(':refKey' => $refKey)); 
		return $sth->fetch();

	}

	public function findAll(){
		
		$sth = $this->db->prepare("SELECT * FROM referral_links");
		$sth->execute(); 
		return $sth->fetchAll();

	}

	public function increment($link_id = null){
		if ( ! $link_id ) return false; 
		
		$sth = $this->db->prepare("INSERT INTO referral_counter VALUES(null, :link_id)");
		$result = $sth->execute(array(':link_id' => $link_id)); 
		return $sth->rowCount(); 

	} 

	public function keyPresentsIn($queryString = null){

		if(empty($queryString)) return false; 
		
		$refKey = $this->findReferralKey($queryString); 
		if( ! empty($refKey) ){
			$this->foundReferralKey = $refKey;
			return $refKey;   
		}	
		
		return false; 		
	}

	public function statistics(){

		$sql = 'SELECT 
				rc.link_id, rl.ref_key as link, rl.user_id, count(rc.link_id) AS count 
				FROM referral_counter AS rc 
				JOIN referral_links AS rl 
				ON rc.link_id = rl.link_id 
				GROUP BY link_id'; 

		$sth = $this->db->prepare($sql); 
		$sth->execute(); 
		return $sth->fetchAll();

	}

	public function getPath($ref_key = null){
		if ( ! $ref_key ) return null; 

		$queryString = implode('=', array($this->keyName, $ref_key));  
		return implode('?', array($this->getUrl(), $queryString));
	}

	public function generateLink($user_id = null){
		if( ! $user_id ) return false; 
		$refKey = $this->getRandomId(); 

		if($this->find($refKey)) return $this->generateLink($user_id); 

		$sql  = "INSERT INTO referral_links 
				VALUES(null, :user_id, :ref_key)"; 
		$sth  = $this->db->prepare($sql);
		$params = array(
			':user_id' => $user_id,
			':ref_key' => $refKey
		); 
		$sth->execute($params); 
		if( $sth->rowCount() ){
			return $this->createLink($refKey); 
		}  
		return false;  
	}

	private function createLink($refKey = null){
		return implode('?', array($this->getUrl(), $this->getQueryString($refKey)));
	}

	private function getUrl(){
		return 'http://' . $this->url;  
	}

	private function getQueryString($refKey = null){
		$refKey = ($refKey) ?: $this->getRandomId(); 
		return implode('=', array($this->keyName, $refKey)); 
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

	private function getConnectionString(){
		$connection = $this->db_type . ':host=' . $this->db_host .';dbname=' . $this->db_name; 		
		
		return $connection; 

	}

	private function createDBConnection(){

		$dbc = null; 

		try {
			$dbc = new PDO($this->getConnectionString(), $this->db_user, $this->db_pass);
		} catch (PDOException $e) {
		    echo 'Connection failed: ' . $e->getMessage();
		}

		return $dbc; 

	}

	private function getDBConnection(){
		
		if( ! $this->db ){
			$this->db = $this->createDBConnection(); 
		} 

		return $this->db; 

	}

	private function findReferralKey($queryString){

		$params = explode('&', $queryString);

		foreach ($params as $keyValue) {
			if(strpos($keyValue, '=')){
				list($key, $value) = explode('=', $keyValue); 
				if($key == $this->keyName) return $value; 
			}
		}

		return false; 

	}

}