<?php
/**
 * Helpers para debug
 * 
 * @package OOWPtheme
 * @subpackage helpers
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */

if(!function_exists('d'))
{
    function d($var = '')
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}

if (!function_exists('dd')) {

    function dd($var, $print = false)
    {
        echo '<pre>';

        if( $print ){
            print_r($var);
        } else {
            var_dump($var);
        }
        exit;
    }

}