<?php
class ValidationTest extends Testcase
{
    private $validData = array();
    private $invalidData = array();
    private $v = null;


    public function setUp()
    {
        $this->validData = array(
            'nome' => 'antônio dos dantos    ',
            'email' => '   mail@mail.com  ',
            'url' => 'http://www.site.com',
            'idade' => '18',
            'mensagem' => 'olá isso é mensagemolá isso é mensagemolá isso é mensagem'
        );
        $this->invalidData = array(
            'nome' => 'a',
            'email' => '   mail@mail',
            'url' => 'site.com',
            'idade' => '',
            'mensagem' => 'olá isso é mensagem'
        );
        
        $this->v = new Validation();
    }
    
    public function testRunWithGoodSource()
    {
        $this->v->addSource($this->validData);
        $this->v->addRule('nome', 'string', true, 3)
                ->addRule('email', 'email', true)
                ->addRule('url', 'url', true)
                ->addRule('idade', 'integer', true)
                ->addRule('mensagem', 'string', true, 25);

        $this->assertTrue($this->v->isValid());
        $this->assertTrue(empty($this->v->errors));
    }
    public function testRunWithBadSource()
    {
        $this->v->addSource($this->invalidData);
        $this->v->addRule('nome', 'string', true, 3)
                ->addRule('email', 'email', true)
                ->addRule('url', 'url', true)
                ->addRule('idade', 'integer', true)
                ->addRule('mensagem', 'string', true, 25);
                
        $this->assertFalse($this->v->isValid());
        $this->assertFalse(empty($this->v->errors));
    }
}