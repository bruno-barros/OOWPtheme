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
if(!function_exists('site_url'))
{
    function site_url($page = '')
    {
        return get_site_url() .'/'. trim($page, '/');
    }
}

if (!function_exists('uri_array'))
{

    /**
     * Retorna a uri como array
     * @return array
     */
    function uri_array()
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $aUri = explode('/', $uri);

        return $aUri;
    }

}

if (!function_exists('uri_ends'))
{

    /**
     * Verifica se a uri termina com a string passada como argumento
     * 
     * @param string $needed
     * @return boolean
     */
    function uri_ends($needed)
    {
        $uriArray = uri_array();
        $final = $uriArray[count($uriArray) - 1];
        if ($final == $needed)
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

    function is_subpage($pageSlug = '')
    {
        global $post;
        
        // test to see if the page has a parent
        if ( is_page() && $post->post_parent )
        {   
            if($pageSlug !== '')
            {
                $parent = new WP_Query(array('name' => $pageSlug, 'post_type' => 'page'));
                return ($parent->post->ID === $post->post_parent) ? true : false;
            }
            else
            {
                return true;
            }
        }
        else
        {   // there is no parent so ...
            return false;
        }
    }

}

if (!function_exists('img_folder'))
{

    /**
     * caminho absoluto para a pasta de imagens de template
     * @param type $img
     * @return string
     */
    function img_folder($img = '', $basepath = false)
    {
        if ($basepath)
        {
            $filename = TEMPLATEPATH . '/assets/img/' . trim($img, '/');
        }
        else
        {
            $filename = get_template_directory_uri() . '/assets/img/' . trim($img, '/');
        }
        return $filename;
    }

}

if (!function_exists('js_folder'))
{

    /**
     * caminho absoluto para a pasta de scripts de template
     * @param type $img
     * @return string
     */
    function js_folder($script = '', $basepath = false)
    {
        if ($basepath)
        {
            $filename = TEMPLATEPATH . '/assets/js/' . trim($script, '/');
        }
        else
        {
            $filename = get_template_directory_uri() . '/assets/js/' . trim($script, '/');
        }
        return $filename;
    }

}

if (!function_exists('css_folder'))
{

    /**
     * caminho absoluto para a pasta de scripts de template
     * @param type $img
     * @return string
     */
    function css_folder($script = '', $basepath = false)
    {
        if ($basepath)
        {
            $filename = TEMPLATEPATH . '/assets/css/' . trim($script, '/');
        }
        else
        {
            $filename = get_template_directory_uri() . '/assets/css/' . trim($script, '/');
        }
        return $filename;
    }

}

if (!function_exists('config_folder'))
{

    /**
     * caminho absoluto para a pasta de configuração
     * @param type $img
     * @return string
     */
    function config_folder($script = '')
    {
        $filename = TEMPLATEPATH . '/config/' . trim($script, '/');

        return $filename;
    }

}

if (!function_exists('templates_folder'))
{

    /**
     * caminho absoluto para a pasta de templates
     * @param type $img
     * @return string
     */
    function templates_folder($script = '')
    {
        $filename = TEMPLATEPATH . '/templates/' . trim($script, '/');

        return $filename;
    }

}

if (!function_exists('libraries_folder'))
{

    /**
     * caminho absoluto para a pasta de templates
     * @param type $img
     * @return string
     */
    function libraries_folder($script = '')
    {
        $filename = TEMPLATEPATH . '/libraries/' . trim($script, '/');

        return $filename;
    }

}

if (!function_exists('widgets_folder'))
{

    /**
     * caminho absoluto para a pasta de templates
     * @param type $img
     * @return string
     */
    function widgets_folder($script = '')
    {
        $filename = TEMPLATEPATH . '/widgets/' . trim($script, '/');

        return $filename;
    }

}

if (!function_exists('core_folder'))
{

    /**
     * caminho absoluto para a pasta de templates
     * @param type $img
     * @return string
     */
    function core_folder($script = '')
    {
        $filename = TEMPLATEPATH . '/core/' . trim($script, '/');

        return $filename;
    }

}

if (!function_exists('plugins_folder'))
{

    /**
     * caminho absoluto para a pasta de plugins
     * @param type $img
     * @return string
     */
    function plugins_folder($script = '')
    {
        $filename = TEMPLATEPATH . '/plugins/' . trim($script, '/');

        return $filename;
    }

}
