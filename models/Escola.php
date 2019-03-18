<?php

class Escola extends Wpost
{

    /**
     * Taxonomia para categoria
     * category (default), false
     * @var string
     */
    protected $categoryTax = '';

    /**
     * Taxonomia para tags
     * post_tag (default), false
     * @var string
     */
    protected $tagTax = '';

    public function __construct($post = null, $mainQuery = true)
    {
        parent::__construct($post, $mainQuery);

    }

}