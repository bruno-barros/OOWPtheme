<?php

/**
 * Helpers para manipulação de URL e identificação de conteúdo baseado na URI
 * 
 * @package OOWPtheme
 * @subpackage helpers
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
if (!function_exists('uri_array'))
{

    /**
     * Retorna a uri como array
     * @return array
     */
    function uri_array()
    {
        $uri = trim($_SERVER["REQUEST_URI"], '/');
        $aUri = explode('/', $uri);

        return $aUri;
    }

}

if (!function_exists('uri_ends'))
{

    function uri_ends($needed)
    {
        if (end(uri_array()) == $needed)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}

if (!function_exists('is_subpage'))
{

    function is_subpage()
    {
        global $post; // load details about this page

        if (is_page() && $post->post_parent)
        {   // test to see if the page has a parent
            return $post->post_parent; // return the ID of the parent post
        }
        else
        {   // there is no parent so ...
            return false; // ... the answer to the question is false
        }
    }

}