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

class Assets {

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
        
        
        // scripts padrão
        $this->add('bootstrap', 'bootstrap.css');
        $this->add('bootstrap-responsive', 'bootstrap-responsive.css', 'bootstrap');
        $this->add('base-layout', 'base-layout.css', 'bootstrap');
        $this->add('module-template', 'module-template.css', 'base-layout');

        $this->add('jquery', 'jquery-1.8.3.min.js');
        $this->add('bootstrap-js', 'bootstrap.min.js', 'jquery');

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
                'script' => '/css/' . trim($script, '/'),
                'dependency' => $dependency,
                'version' => $version,
                'extra' => $extra
            );
        }
        else
        {
            $this->scripts[] = array(
                'name' => $name,
                'script' => '/js/' . trim($script, '/'),
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
                wp_enqueue_style($css['name'], get_template_directory_uri() . $css['script'], $css['dependency'], $css['version']);
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
                wp_enqueue_script($js['name'], get_template_directory_uri() . $js['script'], $js['dependency'], $js['version']);
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
        $filename = TEMPLATEPATH . '/' . trim($script, '/');
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