<?php
/**
 * Exemplo de model personalizado
 * 
 * @package OOWPtheme
 * @subpackage models
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
class MyPersonalPostType extends Wcollection
{
    public function __construct()
    {
        parent::__construct(array(
            'post_type' => 'depoimentos'
        ));
    }
}