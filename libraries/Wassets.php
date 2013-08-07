<?php
/**
 * Gerenciamento para injetar scripts CSS e JS
 * 
 * @package OOWPtheme
 * @subpackage libraries
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
function oowptheme_scripts_styles()
{
    io('assets')->render();
}

add_action('wp_enqueue_scripts', 'oowptheme_scripts_styles');

class Wassets {

    public static $instance;

    /**
     * Array com os estilos que serão inseridos
     * @var array
     */
    public $styles = array();

    /**
     * Array com os scripts
     * @var array
     */
    public $scripts = array();

    public function __construct()
    {
        self::$instance = $this;

        $this->addBasedOnUri();
    }

    public function addBasedOnUri()
    {
        foreach ($this->getUri() as $u)
        {
            
        }
    }
    

    public function add($name = '', $script = '', $dependency = null, $version = '0', $extra = '')
    {
        $ext = substr($script, -3);

        if ($dependency !== null && !is_array($dependency))
        {
            $dependency = explode(',', $dependency);
        }

        if (strtolower($ext) === 'css')
        {
            $this->styles[] = array(
                'name' => $name,
                'script' => $script,
                'dependency' => $dependency,
                'version' => $version,
                'extra' => $extra
            );
        }
        else
        {
            $this->scripts[] = array(
                'name' => $name,
                'script' => $script,
                'dependency' => $dependency,
                'version' => $version,
                'extra' => $extra
            );
        }
    }

    /**
     * Executado com uma action para exibir os scripts para o WP
     * @return void
     */
    public function render()
    {
        if (!empty($this->styles))
        {
            foreach ($this->styles as $css)
            {
                if (!$this->check($css['script']))
                {
                    continue;
                }
                wp_enqueue_style($css['name'], css_folder($css['script']), $css['dependency'], $css['version']);
            }
        }
        if (!empty($this->scripts))
        {
            foreach ($this->scripts as $js)
            {
                if (!$this->check($js['script']))
                {
                    continue;
                }
                wp_enqueue_script($js['name'], js_folder($js['script']) , $js['dependency'], $js['version']);
            }
        }
    }

    /**
     * Valida a existência do script
     * @param string $script
     * @return boolean
     */
    public function check($script = '')
    {
        $ext = substr($script, -3);
        
        if (strtolower($ext) === 'css')
        {
            $filename = css_folder($script, true);
        }
        else
        {
             $filename = js_folder($script, true);
        }
        
        if (file_exists($filename))
        {
            return true;
        }

        return false;
    }

    /**
     * Retorna a uri como array
     * @return array
     */
    private function getUri()
    {
        $uri = trim($_SERVER["REQUEST_URI"], '/');
        $aUri = explode('/', $uri);

        return $aUri;
    }

}