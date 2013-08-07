<?php
/**
 * Gerador de menus baseado no Menu do WP
 * 
 * <code>
 * // no functions.php
 * $config = array(
 * 
 * );
 * $menuPrincipal = new Wmenu('menu-principal', $config);
 * 
 * // no template
 * io('menuPrincipal')->render();
 * 
 * //** Não utilizar o termo $menu para instanciar class
 * </code>
 * 
 * @package OOWPtheme
 * @subpackage libraries
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
class Wmenu {

    /**
     * Armazena as configurações
     * @var array
     */
    private $configs = array(
        'theme_location' => '',
        'menu' => '',// identificação do menu no WP
        'container' => 'div',
        'container_class' => 'menu-header clearfix',
        'container_id' => '',
        'menu_class' => 'menu unstyled',
        'menu_id' => '',
        'echo' => true,
        'fallback_cb' => 'wp_page_menu',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'items_wrap' => '<ul id="%1$s" class="%2$s">[BEFORE] %3$s [AFTER]</ul>',
        'depth' => 0,
        'walker' => '',
        'item_template' => '<li class="%1$s"><a href="%3$s" class="%2$s">%5$s %4$s</a></li>'
    );

    /**
     * Itens de menu que serão adicionados no início
     * @var array
     */
    public $before = array();

    /**
     * Itens de menu que serão adicionados no final
     * @var array
     */
    public $after = array();

    /**
     * Identificador do menu para o WP
     * @var string
     */
    private $menuId = '';

    public function __construct($menu, $config = array())
    {
        $this->menuId = $menu;
        $this->initialize($config);
    }

    public function initialize($userConfig)
    {
        foreach ($this->configs as $key => $value)
        {
            if(isset($userConfig[$key]))
            {
                $this->configs[$key] = $userConfig[$key];
            }
        }
        
        // define o ID do menu
        $this->configs['menu'] = $this->menuId;
    }

    /**
     * Retorna as configurações do menu
     * @return array
     */
    public function getConfig($item = null)
    {
        if ($item === null)
        {
            $return = $this->configs;
        }
        else
        {
            $return = null;
            foreach ($this->configs as $con => $val)
            {
                if($con == $item)
                {
                    $return = $val;
                }
            }
        }
        
        return $return;
    }

    /**
     * Insere um item de menu no início
     * @param string $url
     * @param string $label
     * @param string $liClass
     * @param string $aClass
     */
    public function before($url = '', $label = '', $liClass = null, $aClass = null, $icon = null)
    {
        $new = array(
            'url' => $url,
            'label' => $label,
            'liClass' => $liClass,
            'aClass' => $aClass,
            'icon' => $icon,
        );
        $this->before[] = $new;
    }
    
    /**
     * Insere HTML no array de items 'before' 
     * @param string $data
     */
    public function beforeRaw($data = '')
    {
        $this->before[] = $data;
    }
    
    
    /**
     * Insere HTML no array de items 'before' 
     * @param string $data
     */
    public function afterRaw($data = '')
    {
        $this->after[] = $data;
    }


    /**
     * Insere um item de menu no final
     * @param string $url
     * @param string $label
     * @param string $liClass
     * @param string $aClass
     */
    public function after($url = '', $label = '', $liClass = null, $aClass = null, $icon = null)
    {
        $new = array(
            'url' => $url,
            'label' => $label,
            'liClass' => $liClass,
            'aClass' => $aClass,
            'icon' => $icon
        );
        $this->after[] = $new;
    }

    /**
     * Valida e insere no array correspondente
     * @param array $item
     * @param string $position
     */
    public function insertItem($item, $position = 'before')
    {
//        $this->$$position = array_merge($this->$$position, $item);
        
    }
    
    /**
     * Executa os métodos de renderezação do template do menu
     * com os itens 'before' e 'after'
     * @return string
     */
    public function preRenderBeforeAfter()
    {
        $tmp = $this->configs['items_wrap'];
        $tmp = $this->renderBeforeItems($tmp);
        $tmp = $this->renderAfterItems($tmp);
        return $tmp;
    }
    
    /**
     * Gera HTML de items 'before' e insere no template do menu
     * @param string $tmp
     * @return string
     */
    public function renderBeforeItems($tmp = '')
    {
        $b = '';
        foreach ($this->before as $item)
        {
            if(is_string($item))
            {
                $b .= $item;
            }
            else
            {
                $b .= $this->renderOneItem($item);
            }
        }
        return str_replace('[BEFORE]', $b, $tmp);
    }
    
    
    /**
     * Gera HTML de items 'before' e insere no template do menu
     * @param string $tmp
     * @return string
     */
    public function renderAfterItems($tmp = '')
    {
        $a = '';
        foreach ($this->after as $item)
        {
            if(is_string($item))
            {
                $a .= $item;
            }
            else
            {
                $a .= $this->renderOneItem($item);
            }
        }
        return str_replace('[AFTER]', $a, $tmp);
    }
    
    /**
     * Recebe o array do item de menu e monta o HTML
     * @param array $itemArray
     */
    public function renderOneItem($itemArray)
    {
        $lc = $itemArray['liClass'];
        $ac = $itemArray['aClass'];
        $u = $itemArray['url'];
        $l = $itemArray['label'];
        $ico = $itemArray['icon'];
        $r = sprintf($this->configs['item_template'], $lc, $ac, $u, $l, $ico);
        return $r;
    }

    public function render()
    {
        wp_nav_menu(array(
            'theme_location' => $this->configs['theme_location'],
            'menu' => $this->menuId,
            'container' => $this->configs['container'],
            'container_class' => $this->configs['container_class'],
            'container_id' => $this->configs['container_id'],
            'menu_class' => $this->configs['menu_class'],
            'menu_id' => $this->configs['menu_id'],
            'echo' => $this->configs['echo'],
            'fallback_cb' => $this->configs['fallback_cb'],
            'before' => $this->configs['before'],
            'after' => $this->configs['after'],
            'link_before' => $this->configs['link_before'],
            'link_after' => $this->configs['link_after'],
            'items_wrap' => $this->preRenderBeforeAfter(),
            'depth' => $this->configs['depth'],
            'walker' => $this->configs['walker']
        ));
    }

}