<?php 
/**
 * Especifica os plugins necessários para o tema
 * 
 * @package OOWPtheme
 * @subpackage plugins
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */

/**
 * Classe responsável pelo gerenciamento de dependências
 * @link https://github.com/thomasgriffin/TGM-Plugin-Activation
 */
require "inc/tgm-plugin-activation.php";


add_action( 'tgmpa_register', 'oowptheme_register_required_plugins' );

function oowptheme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin pre-packaged with a theme
        array(
            // The plugin name
            'name'                  => 'TGM Example Plugin', 
            // The plugin slug (typically the folder name)
            'slug'                  => 'tgm-example-plugin', 
            // The plugin source
            'source'                => plugins_folder('required/tgm-example-plugin.zip'),
            // If false, the plugin is only 'recommended' instead of required 
            'required'              => true, 
            // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'version'               => '', 
            // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_activation'      => false,
             // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins 
            'force_deactivation'    => false,
            // If set, overrides default API URL and points to an external URL
            'external_url'          => '', 
        ),

        // This is an example of how to include a plugin from the WordPress Plugin Repository
        array(
            'name'      => 'Query Monitor',
            'slug'      => 'query-monitor',
            'required'  => false,
        ),

    );

    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'oowp-theme';

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        // Text domain - likely want to be the same as your theme.
        'domain' => $theme_text_domain,  
        // Default absolute path to pre-packaged plugins        
        'default_path' => '',
        // Default parent menu slug
        'parent_menu_slug' => 'themes.php',
        // Default parent URL slug
        'parent_url_slug' => 'themes.php',
        // Menu slug
        'menu' => 'install-required-plugins',
        // Show admin notices or not  
        'has_notices' => true,
        // Automatically activate plugins after installation or not                        
        'is_automatic' => true,
        // Message to output right before the plugins table                       
        'message' => '',
        'strings' => array(
            'page_title' => __( 'Instalar plugins necessários', $theme_text_domain ),

            'menu_title' => __( 'Instalar plugins', $theme_text_domain ),

            // %1$s = plugin name
            'installing' => __( 'Instalando plugin: %s', $theme_text_domain ),

            'oops' => __( 'Algo de errado aconteceu com a API do plugin.', $theme_text_domain ),

            // %1$s = plugin name(s)
            'notice_can_install_required' => _n_noop( 'Este tema necessita do plugin: %1$s.', 'Este tema necessita dos plugins: %1$s.' ), 

            // %1$s = plugin name(s)
            'notice_can_install_recommended' => _n_noop( 'Este tema recomenda o plugin: %1$s.', 'Este tema recomenda os plugins: %1$s.' ), 

            // %1$s = plugin name(s)
            'notice_cannot_install' => _n_noop( 'Desculpe, mas você não tem as permissões corretas para instalar o plugin %s. Contacte o administrador.', 'Desculpe, mas você não tem as permissões corretas para instalar os plugins %s. Contacte o administrador.' ),

            // %1$s = plugin name(s)
            'notice_can_activate_required' => _n_noop( 'O seguinte plugin é necessário, mas está inativo: %1$s.', 'Os seguintes plugins são necessários, mas estão inativos: %1$s.' ),

            // %1$s = plugin name(s)
            'notice_can_activate_recommended' => _n_noop( 'O seguinte plugin é recomendado, mas está inativo: %1$s.', 'Os seguintes plugins são recomendados, mas estão inativos: %1$s.' ),

            // %1$s = plugin name(s)
            'notice_cannot_activate' => _n_noop( 'Desculpe, mas você não tem as permissões corretas para ativar o plugin %s. Contacte o administrador.', 'Desculpe, mas você não tem as permissões corretas para ativar os plugins %s. Contacte o administrador.' ),

            // %1$s = plugin name(s)
            'notice_ask_to_update' => _n_noop( 'O seguinte plugin precisa ser atualizado para garantir sua máxima compatibilidade com o tema: %1$s.', 'Os seguintes plugins precisam ser atualizados para garantir sua máxima compatibilidade com o tema: %1$s.' ),

            // %1$s = plugin name(s)
            'notice_cannot_update' => _n_noop( 'Desculpe, mas você não tem as permissões corretas para atualizar o plugin %s. Contacte o administrador.', 'Desculpe, mas você não tem as permissões corretas para atualizar os plugins %s. Contacte o administrador.' ),

            'install_link' => _n_noop( 'Iniciar instalação do plugin', 'Iniciar instalação dos plugins' ),

            'activate_link' => _n_noop( 'Ativar plugin instalado', 'Ativar plugins instalados' ),

            'return' => __( 'Retornar para instalação dos plugins necessários', $theme_text_domain ),

            'plugin_activated' => __( 'Plugin ativado com sucesso.', $theme_text_domain ),

            'activated_successfully' => __( 'O seguinte plugin foi ativado com sucesso:' ),

            // %1$s = dashboard link
            'complete' => __( 'Todos os plugins foram instalados e ativados com sucesso. %s', $theme_text_domain ),

            // Determines admin notice type - can only be 'updated' or 'error'
            'nag_type' => 'updated',

            'dismiss' => __( 'Remover esta mensagem' ),
        )
    );

    tgmpa( $plugins, $config );

}