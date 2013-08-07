<?php
class arrayTest extends Testcase
{
    private $a;
    private $a2;
    
    public function setUp()
    {
        $this->a = array('a', 'b', array('c', 'd'));
        $this->a2 = array('a' => 'aa', 'b' => 'bb', 'c' => 'cc');
    }
    
    public function testGetLastItem()
    {
        $l = last($this->a);
        $this->assertInternalType('array', $l);
        $l2 = last($this->a2);
        $this->assertEquals($l2, 'cc');
    }
}