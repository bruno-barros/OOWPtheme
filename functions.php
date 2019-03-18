<?php

/*  *
 * @package OOWPtheme
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
add_action('init', 'oowp_start_session', 1);

define('ENVIROMENT', ($_SERVER['HTTP_HOST'] == 'localhost') ? 'development' : 'production');
// bootstrap do tema
require_once TEMPLATEPATH . '/core/WpThemeStart.php';

/**
 * =======================================================================
 *  Sistema de template
 *  Arquivos de template devem estar dentro da pasta 'templates'
 * @see libraries/template_lite/demo
 * -----------------------------------------------------------------------
 */
//$tmpl = new Wtmpl();
//$tmpl->assign('array');
//echo $tmpl->fetch($file);

/**
 * =======================================================================
 *  Assets
 * -----------------------------------------------------------------------
 * Classe para injeção de scripts
 * -----------------------------------------------------------------------
 */
$assets = new Wassets();
// scripts padrão
$assets->add('bootstrap', 'bootstrap.css');
$assets->add('bootstrap-responsive', 'bootstrap-responsive.css', 'bootstrap');
$assets->add('base', 'base.css', 'bootstrap');
$assets->add('layout', 'layout.css', 'base');
$assets->add('modules', 'modules.css', 'layout');
$assets->add('templates', 'templates.css', 'modules');


function oowp_wp_enqueue_script(){wp_enqueue_script('jquery');}
add_action('wp_enqueue_scripts', 'oowp_wp_enqueue_script');

$assets->add('bootstrap-js', 'bootstrap.min.js', 'jquery');
$assets->add('scrollTo', 'jquery.scrollTo.min.js', 'jquery');




/** ========================================================================
 *     Menus personalizados
 *     Na view: io('menuPrincipal')->render();
 * ------------------------------------------------------------------------
 */
$menuPrincipal = new Wmenu('Principal', array(
    'container'  => '',
    'menu_class' => 'nav ',
));

if(! is_admin())
{

//    $menuPrincipalArray = $menuPrincipal->toArray(array('children' => 4));
//    dd($menuPrincipalArray);
}


//
//dd($menuitems);

$menuFooter = new Wmenu('Menu footer', array(
    'container'  => '',
    'menu_class' => 'footer-menu unstyled',
));




/** ========================================================================
 *     Execuções no momento da geração do header
 *     Injeção de scripts seletivos
 * ------------------------------------------------------------------------
 */
function oowptheme_header_actions()
{
    if (is_home())
    {
        //io('assets')->add('personalslider', 'personalslider.js', 'jquery');
    }
    else if (is_page('contato'))
    {
        //io('assets')->add('validate', 'jquery.validate.min.js', 'jquery');
    }
}

add_action('get_header', 'oowptheme_header_actions');

/**
 * ========================================================================
 *     Altera o comportamento das queries principais
 * @link http://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
 * ------------------------------------------------------------------------
 */
function oowptheme_special_filters($query)
{
    if (!is_admin() && $query->is_main_query())
    {
        /**
         * URI: /novidades => post type 'post'
         */
        if (isset($query->query['post_type']) && $query->query['post_type'] == 'novidades')
        {
            $query->query['post_type'] = 'post';
            $query->set('post_type', 'post');
//            add_action('template_redirect', 'oowptheme_get_template_biblioteca');
        }

        // adiciona custom post types na busca
        if ($query->is_search)
        {
            $query->set('post_type', array('post', 'escolas', 'cursos'));
        }
    }
}

add_action('pre_get_posts', 'oowptheme_special_filters');

/** ========================================================================
 *     Configurações e personalizações
 * @link http://codex.wordpress.org/add_theme_support
 * ------------------------------------------------------------------------
 */
require config_folder('theme-custom-hooks.php');

/** ========================================================================
 *    Registra widgets e sidebars
 * ------------------------------------------------------------------------
 */
require config_folder('sidebars.php');
require widgets_folder('widgets.php');

/** ========================================================================
 *     Custom Post types
 * ------------------------------------------------------------------------
 */
require config_folder('custom-post-types.php');

/** ========================================================================
 *     Templates de comentários
 * ------------------------------------------------------------------------
 */
require templates_folder('comments/list-callback.php');

/** ========================================================================
 *     Templates de metadados de posts
 * ------------------------------------------------------------------------
 */
require templates_folder('entry-meta.php');
require templates_folder('content-nav.php');

/**
 * ========================================================================
 *  ADMIN. Configurações da administração.
 * ------------------------------------------------------------------------
 */
if (is_admin())
{
    //Alterações no painel de administração
    require config_folder('admin-config.php');

    // Plugins necessários
    require plugins_folder('plugin-activation.php');

    // Opções para site na administração
    require config_folder('theme-options.php');

    // Carregando framework de opções de tema
    define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/config/theme-options/');
    require_once config_folder('theme-options/options-framework.php');

}



/**
 * Configuração de FTP que deve ser colocado em wp-config.php
 * @link http://codex.wordpress.org/Editing_wp-config.php#WordPress_Upgrade_Constants
 *
 * define('FS_METHOD', 'ftpext');
 * define('FTP_BASE', '/var/www/vhosts/username/httpdocs/');
 * define('FTP_USER', 'username');
 * define('FTP_PASS', 'password');
 * define('FTP_HOST', 'host');
 * define('FTP_SSL', false);
 */
