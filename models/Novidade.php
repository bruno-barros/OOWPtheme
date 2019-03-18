<?php 
/**
 * 
 * @package OOWPtheme
 * @subpackage models
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
class Novidade extends Wpost {

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

    public function __construct($post = null, $mainQuery = true)
    {
        parent::__construct($post, $mainQuery);
    }
}