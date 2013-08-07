<?php

//require_once "libraries/Menu.php";

class WmenuTest extends Testcase {

    private $menu;

    public function setUp()
    {
        $this->menu = new Wmenu('test', array(
            'container' => 'ul'
        ));
    }

    public function testGetConfig()
    {
        $config = $this->menu->getConfig('menu');
        $this->assertEquals($config, 'test');
        
        $config2 = $this->menu->getConfig('container');
        $this->assertEquals($config2, 'ul');
    }
    
    public function testAddItemBefore()
    {
        $this->assertTrue(empty($this->menu->before));
        
        $this->menu->before('/', 'Home');
        
        $this->assertEquals(count($this->menu->before), 1);
    }
    
    public function testAddItemAfter()
    {
        $this->assertTrue(empty($this->menu->after));
        
        $this->menu->after('contato', 'Contato');
        
        $this->assertEquals(count($this->menu->after), 1);
    }
    
    public function testAddRawBefore()
    {
        $this->menu->beforeRaw('<li>raw</li>');
        
        $this->assertEquals(count($this->menu->before), 1);
        $this->assertEquals($this->menu->before[0], '<li>raw</li>');
    }
    
    public function testAddRawAfter()
    {
        $this->menu->afterRaw('<li>raw</li>');
        
        $this->assertEquals(count($this->menu->after), 1);
        $this->assertEquals($this->menu->after[0], '<li>raw</li>');
    }
    
    
    public function testPreRenderBeforeAfter()
    {
        $this->menu->before('/', 'Home');
        $this->menu->after('contato', 'Contato');
        $template = $this->menu->preRenderBeforeAfter();
        
        $this->assertInternalType('string', $template);
    }

}