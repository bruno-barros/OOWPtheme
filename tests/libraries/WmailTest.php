<?php

class WmailTest extends Testcase {

    private $mail;

    public function setUp()
    {
        $this->mail = new Wmail();
    }

    public function testWmailIsSetted()
    {
        $this->assertTrue(true);
    }

    public function testGettingAuthParams()
    {
        $p = $this->mail->getAuthParams();
        $this->assertInternalType('array', $p);
    }

    public function testSettingAuthParams()
    {
        $this->mail->setAuthParams(array(
            'host' => 'myhost',
            'username' => 'user',
            'password' => 'pass',
            'smtpSecure' => 'tls'
        ));

        $p = $this->mail->getAuthParams();
        $this->assertTrue($p['smtpAuth']);
        $this->assertEquals($p['host'], 'myhost');
        $this->assertEquals($p['username'], 'user');
        $this->assertEquals($p['password'], 'pass');
        $this->assertEquals($p['smtpSecure'], 'tls');
    }
    
    public function testLoadingConfigFromFile()
    {
        $c = $this->mail->defaults;
        $this->assertInternalType('array', $c);
        $this->assertInternalType('string', $c['host']);
    }

}