<?php

/**
 * Template com classes para manipulação de conteúdo separando em camadas:
 * - Model
 * -- libraires
 * -- models
 * -- plugins
 * - View
 * -- templates
 * - Tests
 * -- PHPUnit
 * -- page-oowpthemetest
 * 
 * **
 * Para executar testes sob o ambiente do WP e ter exemplos de código crie
 * uma página com o nome 'oowpthemetest', acesse e veja o resultado.
 * 
 * @package OOWPtheme
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
define('ENVIROMENT', ($_SERVER['HTTP_HOST'] == 'localhost') ? 'development' : 'production');
// bootstrap do tema
require(TEMPLATEPATH . '/core/WpThemeStart.php');

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
 * Classe para insejeção de scripts
 * -----------------------------------------------------------------------
 */
$assets = new Wassets();
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
$menuPrincipal = new Wmenu('Menu principal', array(
    'menu_id' => ''
        ));
$menuPrincipal->afterRaw('<li class="item-aluno"><a href="#" target="_blank"> <i class="ico"></i> <span>Aluno</span></a></li>');

/** ========================================================================
 *     Execuções no momento da geração do header
 *     Injeção de scripts seletivos
 * ------------------------------------------------------------------------
 */
function oowptheme_header_actions()
{
    if (is_home())
    {
//        io('assets')->add('flexslider', 'jquery.flexslider.min.js', 'jquery');        
    }
    else if (is_page('fale-conosco'))
    {
//        io('assets')->add('minimalect', 'minimalect/jquery.minimalect.min.js', 'jquery');
//        io('assets')->add('validate', 'jquery.validate.min.js', 'jquery');
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
add_theme_support('post-thumbnails');

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



/** ========================================================================
 * 	ADMIN
 * 	Alterações no painel de administração
 * ------------------------------------------------------------------------
 */
include core_folder('AdminConfig.php');

/**     
 * Configuração de FTP que deve ser colocado em wp-config.php
 * @link http://codex.wordpress.org/Editing_wp-config.php#WordPress_Upgrade_Constants
 * 
define('FS_METHOD', 'ftpext');
define('FTP_BASE', '/var/www/vhosts/chriscoyier.net/httpdocs/');
define('FTP_USER', 'username');
define('FTP_PASS', 'password');
define('FTP_HOST', 'host');
define('FTP_SSL', false);
  */