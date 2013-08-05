<?php

/**
 *
 * @package OOWPtheme
 */
define('ENVIROMENT', 'development');
require(TEMPLATEPATH . '/core/WpThemeStart.php');

$mobileDetect = new Mobile_Detect();

/**
 * =======================================================================
 *  Assets
 * -----------------------------------------------------------------------
 * Classe para insejeção de scripts
 * -----------------------------------------------------------------------
 */
 $assets = new Assets();
 // scripts padrão
$assets->add('bootstrap', 'bootstrap.css');
$assets->add('bootstrap-responsive', 'bootstrap-responsive.css', 'bootstrap');
$assets->add('base-layout', 'base-layout.css', 'bootstrap');
$assets->add('module-template', 'module-template.css', 'base-layout');

$assets->add('jquery', 'jquery-1.8.3.min.js');
$assets->add('bootstrap-js', 'bootstrap.min.js', 'jquery');

/** ========================================================================
 *     Menus personalizados
 * ------------------------------------------------------------------------
 */
$menuPrincipal = new Menu('Menu Aldeia', array(
    'menu_id' => ''
));
$menuPrincipal->afterRaw('<li class="item-aluno"><a href="http://www.aldeiamontessori.com.br/aluno/" target="_blank"> <i class="ico icon-aluno"></i> <span>Aluno</span></a></li>');


/** ========================================================================
 *     Execuções no momento da geração do header
 *     Injeção de scripts...
 * ------------------------------------------------------------------------
 */
function oowptheme_header_actions()
{
    io('assets')->add('flexslider', 'jquery.flexslider.min.js', 'jquery');
    if (is_home()) {

    }
    else if(is_page('fale-conosco')){
        io('assets')->add('minimalect', 'minimalect/jquery.minimalect.min.js', 'jquery');
        io('assets')->add('validate', 'jquery.validate.min.js', 'jquery');
    }
}
add_action('get_header', 'oowptheme_header_actions');


/** ========================================================================
 *    Registra widgets e sidebars
 * ------------------------------------------------------------------------
 */
require_once widgets_folder('sidebars.php');
require_once widgets_folder('widgets.php');


/** ========================================================================
 *     Post support
 *     Adiciona funcionalidades, como imagem destacada
 *     @link http://codex.wordpress.org/add_theme_support
 * ------------------------------------------------------------------------
 */
add_theme_support( 'post-thumbnails' );

/** ========================================================================
 *     Custom Post types
 * ------------------------------------------------------------------------
 */
require_once config_folder('custom-post-types.php');


/** ========================================================================
 *     Templates de comentários
 * ------------------------------------------------------------------------
 */
require_once templates_folder('comments/list-callback.php');


/** ========================================================================
 *     Templates de metadados de posts
 * ------------------------------------------------------------------------
 */
require_once templates_folder('entry-meta.php');
require_once templates_folder('content-nav.php');






