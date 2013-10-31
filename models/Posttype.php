<?php 
/**
 * Exemplo de model personalizado para um post
 * 
 * @package OOWPtheme
 * @subpackage models
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
class Posttype extends Wpost {


    public function __construct($post = null)
    {
        parent::__construct($post);
    }
}