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
 * 	Desativação de alguns boxes no painel principal
 * ------------------------------------------------------------------------
 */
function disable_default_dashboard_widgets() {
	// remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget

	// remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');         //
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //

	// removing plugin dashboard boxes
	remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget

}
// removing the dashboard widgets
add_action('admin_menu', 'disable_default_dashboard_widgets');


/** ========================================================================
 * 	Rodapé personalizado
 * ------------------------------------------------------------------------
 */
// Custom Backend Footer
function oowptheme_custom_admin_footer() {
	_e('<span id="footer-thankyou">Desenvolvido por <a href="http://www.brunobarros.com" target="_blank">Bruno Barros</a></span> utilizando o tema  <a href="https://github.com/bruno-barros/OOWPtheme" target="_blank">OOWPtheme</a>.');
}

// adding it to the admin area
add_filter('admin_footer_text', 'oowptheme_custom_admin_footer');