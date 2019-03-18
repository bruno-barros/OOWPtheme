<?php
/**
 * Cursos collection
 * 
 * @package OOWPtheme
 * @subpackage models
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
class CursoCollection extends Wcollection
{
    public function __construct($args = array())
    {
        parent::__construct(
            array_merge(array(
            	'post_type' => 'cursos'
        	), $args)
        );
    }
}
