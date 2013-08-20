<?php

/**
 * Helpers para manipulação de arrays
 * 
 * @package OOWPtheme
 * @subpackage helpers
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
if (!function_exists('last'))
{

    /**
     * Retorna o últime elemento de um array
     * @param array $array
     * @return mixed
     */
    function last($array)
    {
        if (count($array) < 1)
            return null;

        $keys = array_keys($array);
        return $array[$keys[sizeof($keys) - 1]];
    }

}
if(!function_exists('object_to_array'))
{
    
    function object_to_array($d)
    {

        if (is_object($d))
        {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d))
        {
            /*
             * Return array converted to object
             * Using __FUNCTION__ (Magic constant)
             * for recursive call
             */
            return array_map(__FUNCTION__, $d);
        }
        else
        {
            // Return array
            return $d;
        }
    }
}