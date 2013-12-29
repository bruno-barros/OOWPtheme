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

    /**
     * Taxonomia para categoria
     * category (default), false
     * @var string
     */
    protected $categoryTax = 'category';

    /**
     * Taxonomia para tags
     * post_tag (default), false
     * @var string
     */
    protected $tagTax = 'post_tag';

    public function __construct($post = null)
    {
        parent::__construct($post);
    }
}