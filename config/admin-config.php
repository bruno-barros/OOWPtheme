<?php
/**
 * Configurações para painel administrativo
 *
 * @package OOWPtheme
 * @subpackage core
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 *
 */

/** ========================================================================
 *    Altera o menu
 * ------------------------------------------------------------------------
 */
function change_post_menu_label()
{
    global $menu;
    global $submenu;
    $menu[5][0]                 = 'Novidades';
    $submenu['edit.php'][5][0]  = 'Novidades';
    $submenu['edit.php'][10][0] = 'Adicionar nova';
    echo '';
}

function change_post_object_label()
{
    global $wp_post_types;
    $labels                     = & $wp_post_types['post']->labels;
    $labels->name               = 'Novidade';
    $labels->singular_name      = 'Novidade';
    $labels->add_new            = 'Adicionar nova';
    $labels->add_new_item       = 'Adicionar nova';
    $labels->edit_item          = 'Editar conteúdo';
    $labels->new_item           = 'Novidade';
    $labels->view_item          = 'Ver conteúdo';
    $labels->search_items       = 'Pesquisar conteúdo';
    $labels->not_found          = 'Nenhum conteúdo encontrado';
    $labels->not_found_in_trash = 'Nenhum conteúdo encontrado na lixeira';
}

add_action('init', 'change_post_object_label');
add_action('admin_menu', 'change_post_menu_label');

/**
 * ---------------------------------
 *  adds excerpt to pages
 * --------------------------------
 */
add_action('init', 'oowp_add_excerpts_to_pages');
function oowp_add_excerpts_to_pages()
{
    add_post_type_support('page', 'excerpt');
}

/** ========================================================================
 *    Desativação de alguns boxes no painel principal
 * ------------------------------------------------------------------------
 */
function disable_default_dashboard_widgets()
{
    // remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'core'); // Incoming Links Widget
    remove_meta_box('dashboard_plugins', 'dashboard', 'core'); // Plugins Widget

    // remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core'); // Recent Drafts Widget
    remove_meta_box('dashboard_primary', 'dashboard', 'core'); //
    remove_meta_box('dashboard_secondary', 'dashboard', 'core'); //

    // removing plugin dashboard boxes
    remove_meta_box('yoast_db_widget', 'dashboard', 'normal'); // Yoast's SEO Plugin Widget

}

// removing the dashboard widgets
add_action('admin_menu', 'disable_default_dashboard_widgets');

/** ========================================================================
 *    Rodapé personalizado
 * ------------------------------------------------------------------------
 */
// Custom Backend Footer
function oowptheme_custom_admin_footer()
{
    _e('<span id="footer-thankyou">Desenvolvido por <a href="http://www.brunobarros.com" target="_blank">Bruno Barros</a></span> utilizando o tema  <a href="https://github.com/bruno-barros/OOWPtheme" target="_blank">OOWPtheme</a>.');
}

// adding it to the admin area
add_filter('admin_footer_text', 'oowptheme_custom_admin_footer');

/** ========================================================================
 *    Remove itens de menu
 * ------------------------------------------------------------------------
 */
// add_action('admin_menu', 'oowptheme_remove_menus');
function oowptheme_remove_menus()
{
    global $menu;
    $restricted = array(__('Dashboard'), __('Posts'), __('Media'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'));
    end($menu);
    while (prev($menu))
    {
        $value = explode(' ', $menu[key($menu)][0]);
        if (in_array($value[0] != null ? $value[0] : "", $restricted))
        {
            unset($menu[key($menu)]);
        }
    }
}

/** ========================================================================
 *    Adiciona folha de estilo no editor tinymce
 * ------------------------------------------------------------------------
 */
//add_action( 'init', 'oowptheme_add_editor_styles' );
function oowptheme_add_editor_styles()
{
    add_editor_style('assets/css/tinymce.css');
}

