<?php
/* Pripraveno pro test doubles. */
/* Primo vyzadovano testovanym souborem. */

class Mail
{
	public static $backend;
	public static $text;
	
	public static function setMessage($text) {
		Mail::$text = $text; // error or text
	}
	
	public function factory($backend, $arr_to_connect) {	
		Mail::$backend = $backend;	
		return new SMTP($arr_to_connect);		
	}
	
	public function getMessage() {
		return Mail::$text;
	}	
}

?>
