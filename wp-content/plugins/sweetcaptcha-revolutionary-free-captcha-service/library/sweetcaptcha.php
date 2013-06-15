<?php

// in case this is called like standalone script - we need wordpress functions available
if ( ! function_exists( 'get_option' ) ) {
	// absolute path to wp installation root
	$wordpress_path = realpath ( dirname ( __FILE__ ) . '/../../../../' );
	require_once $wordpress_path . '/wp-load.php';
}

// init SweetCaptcha instance
$sweetcaptcha_instance = new Sweetcaptcha(
	get_option( 'sweetcaptcha_app_id' ), 
	get_option( 'sweetcaptcha_key' ), 
	get_option( 'sweetcaptcha_secret' ), 
	//get_option( 'sweetcaptcha_public_url' )
	SWEETCAPTCHA_PHP_PATH
);

/*
 * Do not change below here.
 */

/**
 * Handles remote negotiation with Sweetcaptcha.com.
 *
 * @version 1.0
 * @since December 14th, 2010
 * 
 */

if (isset($_POST['ajax']) and $method = $_POST['ajax']) {
	echo $sweetcaptcha_instance->$method(isset($_POST['params']) ? $_POST['params'] : array());
}

class Sweetcaptcha {
	
	private $appid;
	private $key;
	private $secret;
	private $path;
	
	const API_URL = SWEETCAPTCHA_SITE_URL; //'qa.sweetcaptcha.com';
  //const API_URL_IP = '109.201.141.91';
	
	function __construct($appid, $key, $secret, $path) {
		$this->appid = $appid;
		$this->key = $key;
		$this->secret = $secret;
		$this->path = $path;
	}
	
	private function api($method, $params) {
		
		$basic = array(
			'method' => $method,
			'appid' => $this->appid,
			'key' => $this->key,
			'secret' => $this->secret,
			'path' => $this->path,
			'is_mobile' => preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT']) ? 'true' : 'false',
			'user_ip' => $_SERVER['REMOTE_ADDR'],
		);
		
		return $this->call(array_merge(isset($params[0]) ? $params[0] : $params, $basic));
	}
	
	private function call($params) {
		$param_data = "";		
		foreach ($params as $param_name => $param_value) {
			$param_data .= urlencode($param_name) .'='. urlencode($param_value) .'&'; 
		}
		//echo 'Connecting to '.self::API_URL_IP;
		$fs = fsockopen(self::API_URL, 80, $errno, $errstr, 10);
		if ( ! $fs ) {
			die ("Couldn't connect to server: $errstr ($errno)");
    }
    
		$req = "POST /api.php HTTP/1.0\r\n";
		$req .= "Host: ".self::API_URL."\r\n";
		$req .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$req .= "Referer: " . $_SERVER['HTTP_HOST']. "\r\n";
		$req .= "Content-Length: " . strlen($param_data) . "\r\n\r\n";
		$req .= $param_data;		
	
		$response = '';
		fwrite($fs, $req);
		
		while ( !feof($fs) ) {
			$response .= fgets($fs, 1160);
		}
		
		fclose($fs);
		
		$response = explode("\r\n\r\n", $response, 2);
		
		return $response[1];	
	}
	
	public function __call($method, $params) {
		return $this->api($method, $params);
	}
}
