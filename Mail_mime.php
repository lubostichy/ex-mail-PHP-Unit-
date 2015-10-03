<?php
/* Pripraveno pro test doubles. */
/* Primo vyzadovano testovanym souborem. */

class Mail_mime
{
	public static $body;
	public static $headers;
	
	public function __construct() {
		Mail_mime::$body = '';
		Mail_mime::$headers = array();
	}
		
	public function setHTMLBody($body) {
		Mail_mime::$body = $body;
		
	}
	
	public function get() {		
		return Mail_mime::$body;
	}
	
	public function headers($headers) {
		Mail_mime::$headers = $headers;
	}
}

?>
