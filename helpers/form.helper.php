<?php

/**
 * Helpers para formulários
 * 
 * @package OOWPtheme
 * @subpackage helpers
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
if (!function_exists('was_form_sent'))
{

    function was_form_sent()
    {
        if (isset($_GET['a']) && $_GET['a'] == 'sent')
        {
            return true;
        }

        return false;
    }

}

if (!function_exists('form_action'))
{
    
}

/**
 * Form Close Tag
 *
 * @access	public
 * @param	string
 * @return	string
 */
if (!function_exists('form_close'))
{

    function form_close($extra = '')
    {
        return "</form>" . $extra;
    }

}


if (!function_exists('form_open'))
{

    /**
     * Form Declaration
     *
     * Creates the opening portion of the form.
     *
     * @access	public
     * @param	string	the URI segments of the form destination
     * @param	array	a key/value pair of attributes
     * @param	array	a key/value pair hidden data
     * @return	string
     */
    function form_open($action = '', $attributes = '', $hidden = array())
    {
        if ($attributes == '')
        {
            $attributes = 'method="post"';
        }

        // If no action is provided then set to the current url
        $action = get_permalink();
        $action .= '?a=sent';
        $action .= '&amp;p=' . get_permalink();

        $form = '<form action="' . $action . '"';

        $form .= _attributes_to_string($attributes, TRUE);

        $form .= '>';
//dd(get_permalink());

        if (is_array($hidden) AND count($hidden) > 0)
        {
            $form .= sprintf("<div style=\"display:none\">%s</div>", form_hidden($hidden));
        }

        return $form;
    }

}


if (!function_exists('form_open_multipart'))
{

    /**
     * Form Declaration - Multipart type
     *
     * Creates the opening portion of the form, but with "multipart/form-data".
     *
     * @access	public
     * @param	string	the URI segments of the form destination
     * @param	array	a key/value pair of attributes
     * @param	array	a key/value pair hidden data
     * @return	string
     */
    function form_open_multipart($action = '', $attributes = array(), $hidden = array())
    {
        if (is_string($attributes))
        {
            $attributes .= ' enctype="multipart/form-data"';
        }
        else
        {
            $attributes['enctype'] = 'multipart/form-data';
        }

        return form_open($action, $attributes, $hidden);
    }

}


if (!function_exists('form_hidden'))
{

    /**
     * Hidden Input Field
     *
     * Generates hidden fields.  You can pass a simple key/value string or an associative
     * array with multiple values.
     *
     * @access	public
     * @param	mixed
     * @param	string
     * @return	string
     */
    function form_hidden($name, $value = '', $recursing = FALSE)
    {
        static $form;

        if ($recursing === FALSE)
        {
            $form = "\n";
        }

        if (is_array($name))
        {
            foreach ($name as $key => $val)
            {
                form_hidden($key, $val, TRUE);
            }
            return $form;
        }

        if (!is_array($value))
        {
            $form .= '<input type="hidden" name="' . $name . '" value="' . form_prep($value, $name) . '" />' . "\n";
        }
        else
        {
            foreach ($value as $k => $v)
            {
                $k = (is_int($k)) ? '' : $k;
                form_hidden($name . '[' . $k . ']', $v, TRUE);
            }
        }

        return $form;
    }

}


if (!function_exists('form_prep'))
{

    /**
     * Form Prep
     *
     * Formats text so that it can be safely placed in a form field in the event it has HTML tags.
     *
     * @access	public
     * @param	string
     * @return	string
     */
    function form_prep($str = '', $field_name = '')
    {
        static $prepped_fields = array();

        // if the field name is an array we do this recursively
        if (is_array($str))
        {
            foreach ($str as $key => $val)
            {
                $str[$key] = form_prep($val);
            }

            return $str;
        }

        if ($str === '')
        {
            return '';
        }

        // we've already prepped a field with this name
        // @todo need to figure out a way to namespace this so
        // that we know the *exact* field and not just one with
        // the same name
        if (isset($prepped_fields[$field_name]))
        {
            return $str;
        }

        $str = htmlspecialchars($str);

        // In case htmlspecialchars misses these.
        $str = str_replace(array("'", '"'), array("&#39;", "&quot;"), $str);

        if ($field_name != '')
        {
            $prepped_fields[$field_name] = $field_name;
        }

        return $str;
    }

}


if (!function_exists('_attributes_to_string'))
{

    /**
     * Attributes To String
     *
     * Helper function used by some of the form helpers
     *
     * @access	private
     * @param	mixed
     * @param	bool
     * @return	string
     */
    function _attributes_to_string($attributes, $formtag = FALSE)
    {
        if (is_string($attributes) AND strlen($attributes) > 0)
        {
            if ($formtag == TRUE AND strpos($attributes, 'method=') === FALSE)
            {
                $attributes .= ' method="post"';
            }

            if ($formtag == TRUE AND strpos($attributes, 'accept-charset=') === FALSE)
            {
                $attributes .= ' accept-charset="' . strtolower('utf-8') . '"';
            }

            return ' ' . $attributes;
        }

        if (is_object($attributes) AND count($attributes) > 0)
        {
            $attributes = (array) $attributes;
        }

        if (is_array($attributes) AND count($attributes) > 0)
        {
            $atts = '';

            if (!isset($attributes['method']) AND $formtag === TRUE)
            {
                $atts .= ' method="post"';
            }

            if (!isset($attributes['accept-charset']) AND $formtag === TRUE)
            {
                $atts .= ' accept-charset="' . strtolower('utf-8') . '"';
            }

            foreach ($attributes as $key => $val)
            {
                $atts .= ' ' . $key . '="' . $val . '"';
            }

            return $atts;
        }
    }

}