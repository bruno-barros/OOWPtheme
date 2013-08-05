<?php

class formTest extends Testcase
{
    public function testWasFormNoSent()
    {
        $this->assertFalse(was_form_sent());
    }

    public function testWasFormSent()
    {
        $_GET['a'] = 'sent';
        $this->assertTrue(was_form_sent());
    }
}