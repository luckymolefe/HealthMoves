<?php

session_start();

abstract class Helper {
	private $data = null;
	private $sanitized_data = null;
	private $cipher = null;
	private $secretKey = null;
	private $secret_iv = null;
	private $key = null;
	private $vector = null;

	//sanitize/clean all input data that was submitted
	public static function sanitize($params) {
		$sanitized_data = array();
		foreach($params as $k => $v) {
			$sanitized_data[$k] = htmlentities(stripslashes(strip_tags(trim($v)))); 
		}
		return $sanitized_data;
	}
	//call method internally to hash data
	protected function hash_data($data) {
		$this->data = $data;
		return sha1($this->data);
	}
	//call to to break and wrap text
	public function wrapText($data) {
		if(strlen($data) > 15) {
			$data = substr($data, 0, 15).'...';
			return $data;
		} else {
			return $data;
		}
	}
	//call method to initialize encryption variables
	private function initCrypt() {
		//Set up the variables for initialize encryption
		$this->cipher = 'AES-256-CBC';
		$this->secretKey = SHA1('mIcK3yM0u53$Up3r53cR3+'); //use the SHA1 function to generate a key
		$this->secret_iv = 'eaiYYkYTysia2lnHiw0N0';
		$this->key = hash('sha256', $this->secretKey);
		$this->vector = substr(hash('sha256', $this->secret_iv), 0, 16);
	}
	//call to encrypt data
	public function data_encrypt($string) {
		$this->initCrypt();
		$this->data = $string;
		$this->data = openssl_encrypt($this->data, $this->cipher, $this->key, 0, $this->vector);
		return base64_encode($this->data);
	}
	//call to decrypt data
	public function data_decrypt($string) {
		$this->initCrypt();
		$this->data = base64_decode($string);
		$this->data = openssl_decrypt($this->data, $this->cipher, $this->key, 0, $this->vector);
		return $this->data;
	}
	//Email Template
	public function emailTemplate($year, $title, $contents, $img_url) {
		$shoplocation = "http://".$_SERVER['HTTP_HOST']."/".basename(dirname(__DIR__))."/shop.php";
		$img_url = 'http://'.$_SERVER['HTTP_HOST'].'/'.basename(dirname(__DIR__)).$img_url;
$maildata = <<<TEMPLATE
<div style="background-color: #eee;padding: 10px;">
	<div style="max-width: 500px;background-color: #fff;font-family: sans-serif;margin: 0 auto;overflow: hidden;border-radius: 5px;text-align: center;">
		<h1 style="color: #777;">$title</h1>
		<a href="$shoplocation" style="color: #3087F5; text-decoration: none;">
			<img src="$img_url" style="max-width: 100%;">
		</a>
		<p style="margin: 20px;font-size: 18px;font-weight: 300px;color: #666;line-height: 1.5;text-align: left;">
			$contents
		</p>
		<div class="cta" style="margin: 20px; font-weight: bolder;">
			To see more on our special deals click below:<br/>
			<a href="$shoplocation" style="text-decoration: none;display: inline-block;background-color: #72bcd4;color: #fff; transition: all .5s;padding: 10px 20px 10px;border-radius: 5px;border: solid 1px #eee;">click here</a>
		</div>
	</div>
	<div style="background-color: none;padding: 20px;font-size: 10px;font-family: sans-serif;text-align: center;">
		<a href="#">123 Street, Pretoria, 0001</a> | <a href="mailto:info@healthymoves.co.za">Enquiries</a><br>
		<span>&copy;$year All rights reserved.</span>
	</div>
</div>
TEMPLATE;
	return $maildata;
	}
}


?>