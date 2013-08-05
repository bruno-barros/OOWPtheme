<?php

class MYdepoimentos extends Wpost
{
    public function __construct($thePost)
    {
        parent::__construct($thePost);
    }
    
    public function __call($name, $arguments = array())
    {
//        d($name);
    }


    public function resumo()
    {
        return words($this->content, 80, '...');
    }
}