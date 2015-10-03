<?php
/* Pripraveno pro test doubles. */
/* Vyzadovano bootstrap.php jako vychozi zavislosti. Mail.php*/
require "bootstrap.php";

class Db
{
	public static $proforma;
	
	public static function setDbQuery($value) {
		Db::$proforma = $value; // set 0 or 1
	}
	
	public static function DbQuery($query) {
		$arr['proforma'] = Db::$proforma;		
		return $arr;
	}
}

class SMTP
{
	public static $params;
	public static $body;
	public static $to;
	public static $headers;
	
	public function __construct($arr) {	
		SMTP::$params['host'] = $arr['host'];
		SMTP::$params['port'] = $arr['port'];
		SMTP::$params['auth'] = $arr['auth'];
		SMTP::$params['username'] = $arr['username'];
		SMTP::$params['password'] = $arr['password'];
		SMTP::$params['timeout'] = $arr['timeout'];		
	}
	public function send($to, $headers, $body) {
		SMTP::$body = $body;
		SMTP::$headers = $headers;
		SMTP::$to = $to;		
		return new Mail();
	}	
}

class PEAR
{
	public static function isError($mail) {
		return (strcmp($mail->getMessage(), 'error') == 0);
	}
}

?>
