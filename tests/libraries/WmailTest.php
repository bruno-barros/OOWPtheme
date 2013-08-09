<?php

class WmailTest extends Testcase {

    private $mail;

    public function setUp()
    {
        $this->mail = new Wmail();
    }

    public function testWmailIsSetted()
    {
        $this->assertInternalType('object', $this->mail);
    }

    public function testGettingAuthParams()
    {
        $p = $this->mail->getAuthParams();
        $this->assertInternalType('array', $p);
    }

    public function testSettingAuthParams()
    {
        $this->mail->setAuthParams(array(
            'smtpHost' => 'myhost',
            'username' => 'user',
            'password' => 'pass',
            'smtpSecure' => 'tls',
            'smtpPort' => 587,
        ));

        $p = $this->mail->getAuthParams();
        $this->assertTrue($p['smtpAuth']);
        $this->assertEquals($p['smtpHost'], 'myhost');
        $this->assertEquals($p['username'], 'user');
        $this->assertEquals($p['password'], 'pass');
        $this->assertEquals($p['smtpSecure'], 'tls');
        $this->assertEquals($p['smtpPort'], 587);
    }
    
    public function testNoAuthenticateWithOutSmtpHost()
    {
        $this->mail->setAuthParams(array(
            'smtpHost' => '',
            'username' => 'user',
            'password' => 'pass',
            'smtpSecure' => 'tls',
            'smtpPort' => 587,
        ));

        $p = $this->mail->getAuthParams();
        $this->assertFalse($p['smtpAuth']);
    }


    public function testLoadingConfigFromFile()
    {
        $c = $this->mail->defaults;
        $this->assertInternalType('array', $c);
        $this->assertInternalType('string', $c['smtpHost']);
        $this->assertInternalType('string', $c['username']);
        $this->assertInternalType('string', $c['password']);
        $this->assertInternalType('string', $c['smtpSecure']);
        $this->assertInternalType('integer', $c['smtpPort']);
        $this->assertInternalType('string', $c['toEmail']);
        $this->assertInternalType('string', $c['toName']);
        $this->assertInternalType('string', $c['fromEmail']);
        $this->assertInternalType('string', $c['fromName']);
    }
    
    public function testSettingDebugMode()
    {
        $this->assertFalse($this->mail->debug);
        $this->mail->debugModeOn();
        $this->assertTrue($this->mail->debug);
    }
    
    public function testSettingRespondTo()
    {
        $this->assertTrue(empty($this->mail->respondTo));
        $this->mail->respondTo('email@email', 'name');
        $this->assertFalse(empty($this->mail->respondTo));
        $this->assertEquals($this->mail->respondTo['email'], 'email@email');
    }
    
    public function testRendeTextContent()
    {
        $this->mail->body = '<h1>titulo</h1>';
        $txt = $this->mail->renderText();
        $this->assertEquals('TITULO', substr($txt, 0, 6));
    }    

    public function testSettingValidationRules()
    {
        $this->mail->setRules(array(
            'nome' => ''
        ));
    }

}