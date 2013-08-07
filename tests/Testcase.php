<?php
/**
 * Bootstrap dos testes com PHPunit
 * 
 * @package OOWPtheme
 * @subpackage tests
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
$thisDir = dirname(realpath(__FILE__));
// path do template
define('TEMPLATEPATH', str_replace('\tests', '', $thisDir));

define('ENVIROMENT', 'testing');

require_once TEMPLATEPATH . '/core/WpThemeStart.php';
include_once(TEMPLATEPATH . '/core/AutoLoader.php');

// Register the directory to your include files
AutoLoader::registerDirectory('libraries');
AutoLoader::registerDirectory('models');
AutoLoader::registerDirectory('plugins');



class Testcase extends PHPUnit_Framework_Testcase
{
    public function __construct()
    {
        
    }
}