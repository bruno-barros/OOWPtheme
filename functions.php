<?php

/* * |||||||||||||||||||||||||||||||||||||||||
 * ||                                       ||
 * ||   MANTENHA SEU CÓDIGO ORGANIZADO      ||
 * ||                                       ||
 * ||   Separe as camadas de apresentação,  ||
 * ||   dados e regras de negócio.  :-)     ||
 * ||                                       ||
 * |||||||||||||||||||||||||||||||||||||||||||
 * 
 * Template com classes para manipulação de 
 * conteúdo separando em camadas.
 * 
 * - assets    : css, javascript e imagens do tema.
 * - config    : arquivos que configuram ou estabelecem valores padrão, 
 *               como: autenticação de emails, sidebars e custom post types.
 * - core      : scripts de funcionamento interno do tema.
 * - helpers   : funções úteis para tratamento de String, Array, Uri etc.
 * - libraries : repositório de classes que extendem WP e de terceiros.
 * - models    : classes personalizadas que extendem as libs do tema (libraries).
 * - plugins   : classes wraper para plugins instalados no tema.
 * - templates : trexos do template que são reutilizados nos temas e modelos de email.
 * - tests     : testes unitários das libs e helpers do tema.
 * - widgets   : coleção de widgets. habilitar em widgets/widgets.php.
 * 
 * **
 * Para executar testes sob o ambiente do WP e ter exemplos de código crie
 * uma página com o nome 'oowpthemetest', acesse e veja o resultado.
 * **
 * Atenção: não utilizar nome de variáveis comuns para não haver colisão com
 * WP, como: $page, $pages, $post, $posts, $menu, $menus etc.
 * 
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
 *  @see libraries/template_lite/demo
 * -----------------------------------------------------------------------
 */
//$tmpl = new Wtmpl();
//$tmpl->assign('array');
//echo $tmpl->fetch($file);

/**
 * =======================================================================
 *  Faz detecção do tipo de dispositivo
 *  @link http://code.google.com/p/php-mobile-detect/
 * -----------------------------------------------------------------------
 */
// $mobileDetect = new Mobile_Detect();

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

$assets->add('jquery', 'jquery-1.10.2.min.js');
$assets->add('bootstrap-js', 'bootstrap.min.js', 'jquery');

/** ========================================================================
 *     Menus personalizados
 *     Na view: io('menuPrincipal')->render();
 * ------------------------------------------------------------------------
 */
$menuPrincipal = new Wmenu('Principal', array(
    'container' => '',
    'menu_class' => 'nav nav-pills',
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
 *     @link http://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
 * ------------------------------------------------------------------------
 */
function oowptheme_special_filters($query)
{
  if ( !is_admin() && $query->is_main_query() )
  {
    // adiciona custom post types na busca
    if ($query->is_search)
    {
      $query->set('post_type', array('post', 'movies'));
    }
  }
}
add_action('pre_get_posts','oowptheme_special_filters');


/** ========================================================================
 *     Configurações e personalizações
 *     @link http://codex.wordpress.org/add_theme_support
 * ------------------------------------------------------------------------
 */
require config_folder('post-thumbnail.php');

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

/** ========================================================================
 * 	ADMIN
 * 	Alterações no painel de administração
 * ------------------------------------------------------------------------
 */
require config_folder('admin-config.php');

/**     
 * Configuração de FTP que deve ser colocado em wp-config.php
 * @link http://codex.wordpress.org/Editing_wp-config.php#WordPress_Upgrade_Constants
 * 
define('FS_METHOD', 'ftpext');
define('FTP_BASE', '/var/www/vhosts/username/httpdocs/');
define('FTP_USER', 'username');
define('FTP_PASS', 'password');
define('FTP_HOST', 'host');
define('FTP_SSL', false);
  */