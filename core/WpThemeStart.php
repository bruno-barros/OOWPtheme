<?php
/**
 * Boootrap do tema
 * * Deve ser inserido no início do functions.php
 * 
 * @package OOWPtheme
 * @subpackage core
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */

/**
 * =========================================================================
 * Auto-Loader
 * --------------------------------------------------------------------------
 * Faz inclusão automática de classes
 * --------------------------------------------------------------------------
 */
$autoLoadDirectories = array(
    'libraries',
    'plugins',
    'core',
);

function __autoload($class_name)
{
    global $autoLoadDirectories;

    //for each directory
    foreach ($autoLoadDirectories as $directory)
    {
        $fullPath = TEMPLATEPATH . '/' . $directory . '/' . $class_name . '.php';

        //see if the file exsists
        if (file_exists($fullPath))
        {
            require_once($fullPath);
            //only require the class once, so quit after to save effort 
            //(if you got more, then name them something else 
            return;
        }
    }
}


/**
 * =========================================================================
 * Auto-Loader Helpers
 * --------------------------------------------------------------------------
 */
// Load files from the start directory.
foreach (new DirectoryIterator(TEMPLATEPATH . "/helpers") as $file)
{
    if ($file->isDot() or $file->isDir() or !endsWith($file->getFilename(), ".helper.php"))
        continue;

    require $file->getPathname();
}

/**
 * Determine if a given string ends with a given needle.
 *
 * @param string $haystack
 * @param string|array $needles
 * @return bool
 */
function endsWith($haystack, $needles)
{
    foreach ((array) $needles as $needle)
    {
        if ($needle == substr($haystack, strlen($haystack) - strlen($needle)))
            return true;
    }

    return false;
}

/**
 * Retorna a instancia da classe
 * @example getInstanceOf('assets')->add();
 * @global array $app
 * @return array
 */
function getInstanceOf($className)
{
    global $$className;

    if (isset($$className))
    {
        return $$className;
    }
    trigger_error("Unable to load class: {$className}", E_USER_WARNING);
}

/**
 * Alias
 * @param string $className
 * @return object
 */
function io($className)
{
    return getInstanceOf($className);
}
