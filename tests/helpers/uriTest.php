<?php
class uriTest extends Testcase
{
    public function setUp()
    {
        $_SERVER['REQUEST_URI'] = 'uma/uri/qualquer';
    }
    public function testUriToArray()
    {
        
        $a = uri_array();
        $this->assertInternalType('array', $a);
        $this->assertEquals(count($a), 3);
    }
    
    public function testIfUriEndsWithAString()
    {
        $b = uri_ends('qualquer');
        $this->assertTrue($b);
        $b2 = uri_ends('qualquer/');
        $this->assertFalse($b2);
    }
}