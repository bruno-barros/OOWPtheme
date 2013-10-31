<?php
/**
 * Exemplo de model personalizado para uma coleção de posts (loop)
 * 
 * @package OOWPtheme
 * @subpackage models
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
class PosttypeCollection extends Wcollection
{
    public function __construct($args = array())
    {
        parent::__construct(
            array_merge(array(
            	'post_type' => 'my-personal-post-type'
        	), $args)
        );
    }
}
