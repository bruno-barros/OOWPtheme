<?php
/**
 * Wrapper para a classe de Template Lite
 * 
 * <code>
 * $tpl = new Wtmpl();
 * $tpl->assign("name","Fred Irving");
 * $tpl->assign(array('var1', 'var2'));
 * echo $tpl->fetch("tmp.html");
 * </code>
 * 
 * @package OOWPtheme
 * @subpackage libraries
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
include libraries_folder('template_lite/src/class.template.php');
class Wtmpl extends Template_Lite
{
    protected $tmpl = null;
    
    public function __construct()
    {        
        $this->compile_dir = TEMPLATEPATH . "/templates/compiled/";
        $this->template_dir = TEMPLATEPATH . "/templates";
        $this->force_compile = false;
        $this->compile_check = true;
        $this->cache = false;
        $this->cache_lifetime = 3600;
        
        return $this;
        
    }
}