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
class Wmenu
{

    /**
     * Armazena as configurações
     * @var array
     */
    private $configs = array(
        'theme_location'  => '',
        'container'       => 'div',
        'container_class' => 'menu-header clearfix',
        'container_id'    => '',
        'menu_class'      => 'menu unstyled',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul id="%1$s" class="%2$s">[BEFORE] %3$s [AFTER]</ul>',
        'depth'           => 0,
        'walker'          => '',
        'item_template'   => '<li class="%1$s"><a href="%3$s" class="%2$s">%5$s %4$s</a></li>'
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

    /**
     * @var array
     */
    protected $asArray = array();

    public function __construct($menu = null, $config = array())
    {
        if (is_array($menu) && empty($config))
        {
            $config = $menu;
            $menu   = '';
        }
        $this->menuId            = $menu;
        $this->configs['walker'] = new OOPWTheme_walker_nav_menu();
        $this->initialize($config);
    }

    /**
     * Inicializa configurações do menu.
     * @param array $userConfig
     */
    public function initialize($userConfig)
    {
        $this->configs = array_merge($this->configs, $userConfig);

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
                if ($con == $item)
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
        $new            = array(
            'url'     => $url,
            'label'   => $label,
            'liClass' => $liClass,
            'aClass'  => $aClass,
            'icon'    => $icon,
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
        $new           = array(
            'url'     => $url,
            'label'   => $label,
            'liClass' => $liClass,
            'aClass'  => $aClass,
            'icon'    => $icon
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
            if (is_string($item))
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
            if (is_string($item))
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
     * @return string
     */
    public function renderOneItem($itemArray)
    {
        $lc  = $itemArray['liClass'];
        $ac  = $itemArray['aClass'];
        $u   = $itemArray['url'];
        $l   = $itemArray['label'];
        $ico = $itemArray['icon'];
        $r   = sprintf($this->configs['item_template'], $lc, $ac, $u, $l, $ico);

        return $r;
    }

    /**
     * @param array $options
     * @return mixed
     */
    public function toArray($options = array())
    {
//        $locations = get_nav_menu_locations();
        $menu = wp_get_nav_menu_object( $this->menuId );
        $this->asArray = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );

//        dd($this->asArray);
        if(isset($options['children']))
        {
            $menuItems = $this->arrayChildrenOf($options['children']);
        }
        else
        {
            $menuItems = $this->asArray;
        }
        return $menuItems;
    }

    public function arrayChildrenOf($parent_id)
    {
        $menu = array();
        $menu_parent_id = 0;
        // get nav_menu_id
        foreach($this->asArray as $item)
        {
            if($item->object_id == $parent_id)
            {
                $menu_parent_id = $item->ID;
            }
        }

        foreach($this->asArray as $item)
        {
            if($item->menu_item_parent == $menu_parent_id)
            {
                $menu[] = $item;
            }
        }

        return $menu;
    }

    public function render()
    {
        wp_nav_menu(array(
            'theme_location'  => $this->configs['theme_location'],
            'menu'            => $this->menuId,
            'container'       => $this->configs['container'],
            'container_class' => $this->configs['container_class'],
            'container_id'    => $this->configs['container_id'],
            'menu_class'      => $this->configs['menu_class'],
            'menu_id'         => $this->configs['menu_id'],
            'echo'            => $this->configs['echo'],
            'fallback_cb'     => $this->configs['fallback_cb'],
            'before'          => $this->configs['before'],
            'after'           => $this->configs['after'],
            'link_before'     => $this->configs['link_before'],
            'link_after'      => $this->configs['link_after'],
            'items_wrap'      => $this->preRenderBeforeAfter(),
            'depth'           => $this->configs['depth'],
            'walker'          => $this->configs['walker']
        ));
    }

}


/**
 * Parseia todos os elementos do menu e gera o HTML final
 */
class OOPWTheme_walker_nav_menu extends Walker_Nav_Menu
{

    static public $itemCounter = 0;

    /**
     * Starts the list before the elements are added.
     * add classes to ul sub-menus
     * @param  string $output
     * @param  int $depth
     * @param  array $args
     * @return string
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        // depth dependent classes
        $indent        = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
        $display_depth = ($depth + 1); // because it counts the first submenu as 0
        $classes       = array(
            'sub-menu',
            ($display_depth == 0 ? 'dropdown' : ''),
            ($display_depth > 0 ? 'dropdown-menu' : ''),
        );
        $class_names   = implode(' ', $classes);

        // build html
        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }


    /**
     * Start the element output.
     * add main/sub classes to li's and links
     * @param  string $output
     * @param  object $item
     * @param  int $depth
     * @param  array $args
     * @param  int $current_object_id
     * @return string
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0)
    {
        global $wp_query, $wpdb;
        $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent

        // só faz pesquisa pelos filhos no primeiro nível
        $has_children = 0;
        if ($depth == 0)
        {
            $has_children = $wpdb->get_var("SELECT COUNT(meta_id) FROM {$wpdb->prefix}postmeta WHERE meta_key='_menu_item_menu_item_parent' AND meta_value='" . $item->ID . "'");

            // increments the first level items
            self::$itemCounter++;
        }

        // depth dependent classes
        $depth_classes     = array(
            ($depth == 0 ? 'dropdown' : 'sub-menu-item'),
            $item->current ? 'active' : '',
            'item-' . self::$itemCounter

        );
        $depth_class_names = esc_attr(implode(' ', $depth_classes));

        // passed classes
        $classes     = empty($item->classes) ? array() : (array)$item->classes;
        $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

        // build html
        $output .= $indent . '<li id="nav-menu-item-' . $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

        // link attributes
        // <a href="#" class="dropdown-toggle" data-toggle="dropdown">biblioteca <b class="caret"></b></a>
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        $attributes .= ' class="menu-link menu-depth-' . $depth . ($depth > 0 ? '' : ' dropdown-toggle') . '"';
        $attributes .= $has_children > 0 ? ' data-toggle="dropdown"' : '';

        $caret = $has_children > 0 ? ' <b class="caret"></b>' : '';

        $item_output = sprintf('%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters('the_title', $item->title, $item->ID),
            $args->link_after . $caret,
            $args->after
        );

        // build html
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}