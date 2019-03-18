<?php
/**
 * Novidades collection
 * 
 * @package OOWPtheme
 * @subpackage models
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
class NovidadeCollection extends Wcollection
{
    public function __construct($args = array())
    {
        parent::__construct(
            array_merge(array(
            	'post_type' => 'post'
        	), $args)
        );
    }
}
