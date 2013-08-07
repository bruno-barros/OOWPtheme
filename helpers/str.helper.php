<?php
/**
 * Helpers para manipulação de strings
 * 
 * @package OOWPtheme
 * @subpackage helpers
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */

if (!function_exists('studly'))
{

    /**
     * Convert a value to studly caps case.
     *
     * @param  string  $value
     * @return string
     */
    function studly($value)
    {
        $value = ucwords(str_replace(array('-', '_'), ' ', $value));

        return str_replace(' ', '', $value);
    }

}

if (!function_exists('camel'))
{

    /**
     * Convert a value to camel case.
     *
     * @param  string  $value
     * @return string
     */
    function camel($value)
    {
        return lcfirst(studly($value));
    }

}

if (!function_exists('contains'))
{

    /**
     * Determine if a given string contains a given sub-string.
     *
     * @param  string        $haystack
     * @param  string|array  $needle
     * @return bool
     */
    function contains($haystack, $needle)
    {
        foreach ((array) $needle as $n)
        {
            if (strpos($haystack, $n) !== false)
                return true;
        }

        return false;
    }

}

if (!function_exists('ends_with'))
{

    /**
     * Determine if a given string ends with a given needle.
     *
     * @param string $haystack
     * @param string|array $needles
     * @return bool
     */
    function ends_with($haystack, $needles)
    {
        foreach ((array) $needles as $needle)
        {
            if ($needle == substr($haystack, strlen($haystack) - strlen($needle)))
                return true;
        }

        return false;
    }

}

if (!function_exists('finish'))
{

    /**
     * Cap a string with a single instance of a given value.
     *
     * @param  string  $value
     * @param  string  $cap
     * @return string
     */
    function finish($value, $cap)
    {
        return rtrim($value, $cap) . $cap;
    }

}

if (!function_exists('is'))
{

    /**
     * Determine if a given string matches a given pattern.
     *
     * @param  string  $pattern
     * @param  string  $value
     * @return bool
     */
    function is($pattern, $value)
    {
        if ($pattern == $value)
            return true;

        $pattern = preg_quote($pattern, '#');

        // Asterisks are translated into zero-or-more regular expression wildcards
        // to make it convenient to check if the strings starts with the given
        // pattern such as "library/*", making any string check convenient.
        if ($pattern !== '/')
        {
            $pattern = str_replace('\*', '.*', $pattern) . '\z';
        }
        else
        {
            $pattern = '/$';
        }

        return (bool) preg_match('#^' . $pattern . '#', $value);
    }

}

if (!function_exists('length'))
{

    /**
     * Return the length of the given string.
     * ATENÇÃO: caracteres acentuados pesam 2 bytes
     *
     * @param  string  $value
     * @return int
     */
    function length($value)
    {
        return mb_strlen($value);
    }

}

if (!function_exists('limit'))
{

    /**
     * Limit the number of characters in a string.
     *
     * @param  string  $value
     * @param  int     $limit
     * @param  string  $end
     * @return string
     */
    function limit($value, $limit = 100, $end = '...')
    {
        if (mb_strlen($value) <= $limit)
            return $value;

        return mb_substr($value, 0, $limit, 'UTF-8') . $end;
    }

}

if (!function_exists('lower'))
{

    /**
     * Convert the given string to lower-case.
     *
     * @param  string  $value
     * @return string
     */
    function lower($value)
    {
        return mb_strtolower($value);
    }

}

if (!function_exists('words'))
{

    /**
     * Limit the number of words in a string.
     *
     * @param  string  $value
     * @param  int     $words
     * @param  string  $end
     * @return string
     */
    function words($value, $words = 100, $end = '...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' . $words . '}/u', $value, $matches);

        if (!isset($matches[0]))
            return $value;

        if (strlen($value) == strlen($matches[0]))
            return $value;

        return rtrim($matches[0]) . $end;
    }

}

if (!function_exists('quick_random'))
{

    /**
     * Generate a "random" alpha-numeric string.
     *
     * Should not be considered sufficient for cryptography, etc.
     *
     * @param  int     $length
     * @return string
     */
    function quick_random($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

}

if (!function_exists('upper'))
{

    /**
     * Convert the given string to upper-case.
     *
     * @param  string  $value
     * @return string
     */
    function upper($value)
    {
        return mb_strtoupper($value);
    }

}

if (!function_exists('slug'))
{

    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param  string  $title
     * @param  string  $separator
     * @return string
     */
    function slug($title, $separator = '-')
    {
//		$title = static::ascii($title);
        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $title = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', mb_strtolower($title));

        // Convert all dashes/undescores into separator
        $flip = $separator == '-' ? '_' : '-';

        $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);

        // Replace all separator characters and whitespace by a single separator
        $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);

        return trim($title, $separator);
    }

}

if (!function_exists('snake'))
{

    /**
     * Convert a string to snake case.
     *
     * @param  string  $value
     * @param  string  $delimiter
     * @return string
     */
    function snake($value, $delimiter = '_')
    {
        $replace = '$1' . $delimiter . '$2';

        return ctype_lower($value) ? $value : strtolower(preg_replace('/(.)([A-Z])/', $replace, $value));
    }

}

if (!function_exists('starts_with'))
{

    /**
     * Determine if a string starts with a given needle.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     */
    function starts_with($haystack, $needles)
    {
        foreach ((array) $needles as $needle)
        {
            if (strpos($haystack, $needle) === 0)
                return true;
        }

        return false;
    }

}
