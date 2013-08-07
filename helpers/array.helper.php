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