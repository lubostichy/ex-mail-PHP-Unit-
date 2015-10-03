<?php

require "ex_mail.php";

class MyMailTest extends PHPUnit_Framework_TestCase
{
	/**
     * @before
     */
	public function init() {
		
		global $CONFIG, $ERRORMSG;
		
		$CONFIG['mail_odesilatel'] = "from@example.com";
        $CONFIG['mail_server'] = "smtp.example.com";
        $CONFIG['mail_server_name'] = "smtp.example.com";
        $CONFIG['mail_server_pass'] = "s3cr3dp4ssw0rd";
        $CONFIG['mail_server_port'] = "25";
        $CONFIG['proforma_splatnost'] = "7";
        
        Mail::setMessage("some text");
        
        Db::setDbQuery(0);
	
	}
	
	/**
     * @test
     */
    public function TEST_isHTML() {
		
        global $ERRORMSG;
        
        $result = MyMail::pear_mail("to@example.com", "Subject text", "Nadpis x y", "some body");
        
        $this->assertEquals(SMTP::$to, "to@example.com");
        $this->assertEquals(SMTP::$body, '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">'. "\xA".       
        '          <html><body><h1>Nadpis x y</h1><div id="ObsahMailu">some body</div></body></html>');
        $this->assertEquals(Mail_mime::$headers['From'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Reply-to'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Subject'], "Subject text");
        $this->assertEquals(Mail_mime::$headers['Content-Type'], "text/html; charset=utf-8");
        $this->assertEquals(SMTP::$params['username'], "smtp.example.com");
        $this->assertEquals(SMTP::$params['password'], "s3cr3dp4ssw0rd");
        $this->assertEmpty($ERRORMSG); 
        $this->assertEquals(Mail::$text, "some text");
        $this->assertEquals(Mail::$backend, "smtp");
        $this->assertTrue($result);          
    }
    
    /**
     * @test
     */
    public function TEST_isText() {
		
		global $ERRORMSG;
		
		$result = MyMail::pear_mail("to@example.com", "Subject text", "Nadpis x y", "some body", "0");
        
        $this->assertEquals(SMTP::$to, "to@example.com");
        $this->assertEquals(SMTP::$body, '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">'. "\xA".       
        '          <html><body><h1>Nadpis x y</h1><div id="ObsahMailu">some body</div></body></html>');
        $this->assertEquals(Mail_mime::$headers['From'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Reply-to'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Subject'], "Subject text");
        $this->assertEquals(Mail_mime::$headers['Content-Type'], "text/plain; charset=utf-8");
        $this->assertEquals(SMTP::$params['username'], "smtp.example.com");
        $this->assertEquals(SMTP::$params['password'], "s3cr3dp4ssw0rd");
        $this->assertEmpty($ERRORMSG); 
        $this->assertEquals(Mail::$text, "some text");
        $this->assertEquals(Mail::$backend, "smtp");
        $this->assertTrue($result);
	}
	
	/**
     * @test
     */
    public function TEST_fromIsNotEmpty() {	
		
		global $ERRORMSG;
		
		$result = MyMail::pear_mail("to@example.com", "Subject text", "Nadpis x y", "some body", "1", "from@example.com");
        
        $this->assertEquals(SMTP::$to, "to@example.com");
        $this->assertEquals(SMTP::$body, '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">'. "\xA".       
        '          <html><body><h1>Nadpis x y</h1><div id="ObsahMailu">some body</div></body></html>');
        $this->assertEquals(Mail_mime::$headers['From'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Reply-to'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Subject'], "Subject text");
        $this->assertEquals(Mail_mime::$headers['Content-Type'], "text/html; charset=utf-8");
        $this->assertEquals(SMTP::$params['username'], "smtp.example.com");
        $this->assertEquals(SMTP::$params['password'], "s3cr3dp4ssw0rd");
        $this->assertEmpty($ERRORMSG); 
        $this->assertEquals(Mail::$text, "some text");
        $this->assertEquals(Mail::$backend, "smtp");
        $this->assertTrue($result);
	}
	
	/**
     * @test
     */
    public function TEST_isProforma_1() {
		
		global $ERRORMSG;
		
		Db::setDbQuery(1);
		
		$result = MyMail::pear_mail("to@example.com", "Subject text", "Objednávka č. 1232456", '</br> <div id="obsahMailu"></div>');

		$this->assertEquals(SMTP::$to, "to@example.com");
		$this->assertEquals(SMTP::$body, '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">'. "\xA".       
        '          <html><body><h1>Proforma faktura č. 1232456</h1><div id="ObsahMailu">' .
		'</br> <div id="obsahMailu"><fieldset><legend>Údaje o platbě</legend><br />Číslo účtu: XXSANITIZEDXX<br />Variabilní symbol: 1232456<br />Splatnost: ' 
		. date("d.m.Y", strtotime("+7 days")) . 
		'</fieldset></div>' .
		'<p>Děkujeme za Vaši objednávku v našem eshopu. Objednávka byla přijata, o jejím potvrzení Vás budeme co nejdříve informovat.</p>' .
		'</div></body></html>');
        $this->assertEquals(Mail_mime::$headers['From'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Reply-to'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Subject'], "Subject text");
        $this->assertEquals(Mail_mime::$headers['Content-Type'], "text/html; charset=utf-8");
        $this->assertEquals(SMTP::$params['username'], "smtp.example.com");
        $this->assertEquals(SMTP::$params['password'], "s3cr3dp4ssw0rd");
        $this->assertEmpty($ERRORMSG); 
        $this->assertEquals(Mail::$text, "some text");
        $this->assertEquals(Mail::$backend, "smtp");
        $this->assertTrue($result);		
		
	}
	
	/**
     * @test
     */
    public function TEST_isProforma_2() {
		
		global $ERRORMSG;
		
		Db::setDbQuery(1);
		
		$result = MyMail::pear_mail("to@example.com", "Subject text", "Nadpis x y", "Some body");

		$this->assertEquals(SMTP::$to, "to@example.com");
		$this->assertEquals(SMTP::$body, '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">'. "\xA".
		'          <html><body><h1>Nadpis x y</h1><div id="ObsahMailu">Some body</div></body></html>');
		$this->assertEquals(Mail_mime::$headers['From'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Reply-to'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Subject'], "Subject text");
        $this->assertEquals(Mail_mime::$headers['Content-Type'], "text/html; charset=utf-8");
        $this->assertEquals(SMTP::$params['username'], "smtp.example.com");
        $this->assertEquals(SMTP::$params['password'], "s3cr3dp4ssw0rd");
        $this->assertEmpty($ERRORMSG); 
        $this->assertEquals(Mail::$text, "some text");
        $this->assertEquals(Mail::$backend, "smtp");
        $this->assertTrue($result);		
		
	}
	
	/**
     * @test
     */
    public function TEST_nadpisNoSpaces() {
		
        global $ERRORMSG;
        
        $result = MyMail::pear_mail("to@example.com", "Subject text", "Nadpisxy", "some body");
        
        $this->assertEquals(SMTP::$to, "to@example.com");
        $this->assertEquals(SMTP::$body, '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">'. "\xA".
		'          <html><body><h1>Nadpis x y</h1><div id="ObsahMailu">some body</div></body></html>');
        $this->assertEquals(Mail_mime::$headers['From'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Reply-to'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Subject'], "Subject text");
        $this->assertEquals(Mail_mime::$headers['Content-Type'], "text/html; charset=utf-8");
        $this->assertEquals(SMTP::$params['username'], "smtp.example.com");
        $this->assertEquals(SMTP::$params['password'], "s3cr3dp4ssw0rd");
        $this->assertEmpty($ERRORMSG); 
        $this->assertEquals(Mail::$text, "some text");
        $this->assertEquals(Mail::$backend, "smtp");
        $this->assertTrue($result);          
    }
	
	
	/**
     * @test
     */
    public function TEST_isError() {	
		
		global $ERRORMSG;
		
		Mail::setMessage('error');
		
		$result = MyMail::pear_mail("to@example.com", "Subject text", "Nadpis x y", "Some body");

		$this->assertEquals(SMTP::$to, "to@example.com");
		$this->assertEquals(SMTP::$body, '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">'. "\xA".       
        '          <html><body><h1>Nadpis x y</h1><div id="ObsahMailu">Some body</div></body></html>');
        $this->assertEquals(Mail_mime::$headers['From'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Reply-to'], "from@example.com");
        $this->assertEquals(Mail_mime::$headers['Subject'], "Subject text");
        $this->assertEquals(Mail_mime::$headers['Content-Type'], "text/html; charset=utf-8");
        $this->assertEquals(SMTP::$params['username'], "smtp.example.com");
        $this->assertEquals(SMTP::$params['password'], "s3cr3dp4ssw0rd");
        $this->assertEquals($ERRORMSG, Mail::$text."\n"); 
        $this->assertEquals(Mail::$text, "error");
        $this->assertEquals(Mail::$backend, "smtp");
        $this->assertFalse($result);	
		
	
	}
}
?>

