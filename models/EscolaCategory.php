<?php

class EscolaCategory extends Wcategories
{
    protected $args = array(

        'type'         => 'escolas',
        'child_of'     => 0,
        'parent'       => '',
        'orderby'      => 'term_group',
        'order'        => 'ASC',
        'hide_empty'   => 1,
        'hierarchical' => 1,
        'exclude'      => '',
        'include'      => '',
        'number'       => '',
        'taxonomy'     => 'escolas_categoria',
        'pad_counts'   => false
    );


    function __construct($args = array())
    {
        parent::__construct(array_merge($this->args, $args));
    }
}