<?php 
/**
 * Tela de opções para o site ou tema com três abas
 *
 * @link https://github.com/devinsays/options-framework-theme
 * @package OOWPtheme
 * @subpackage widgets
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

    // inicia opções
    $options = array();

    /*
        Cria uma aba para separar os campos
     */
    $options[] = array(
        // Nome da aba
        'name' => __('Opções gerais', 'options_framework_theme'),

        // tipo da opção: aba
        'type' => 'heading');

     /*
        Modelo de campo
     */
    $options[] = array(
        // nome do campo | idioma (opcional)
        'name' => __('Link do Facebook', 'options_framework_theme'),

        // descrição do campo | idioma (opcional)
        'desc' => __('O link pode ser do perfil ou da página. Deve começar com "http://"', 'options_framework_theme'),

        // identificador único do campo
        'id' => 'facebook_link',

        // se houverem opções (dropdown, chekbox etc), esta será a opção padrão.
        // string|array
        'std' => 'http://',

        // tipo de campo: 
        // - heading: cria uma aba de opções
        // - text
        // - textarea
        // - select 
        // - radio
        // - checkbox
        // - multicheck
        // - color: plugin colorpicker
        // - upload: upload de imagem
        // - images: usa imagens ao invés de radio
        // - background: opções para definir imagem de fundo
        // - typography: opções para tipografia
        // - editor: campo de conteúdo como em posts
        // - info: apenas campo de texto informativo
        'type' => 'text',

        // mini, tiny, small, hidden
        'class' => 'tiny', 

        // dependendo do tip de campo pode ser string ou array de opções
        'options' => '',

        // quando usar plugin WP e passar configurações
        'settings' => false
        );


    $options[] = array(
        'name' => __('Caixa de texto', 'options_framework_theme'),
        'type' => 'heading' 
        );

    /**
     * For $settings options see:
     * http://codex.wordpress.org/Function_Reference/wp_editor
     *
     * 'media_buttons' are not supported as there is no post to attach items to
     * 'textarea_name' is set by the 'id' you choose
     */

    $wp_editor_settings = array(
        'wpautop' => true, // Default
        'textarea_rows' => 5,
        'tinymce' => array( 'plugins' => 'wordpress' )
    );

    $options[] = array(
        'name' => __('Default Text Editor', 'options_framework_theme'),
        'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'options_framework_theme' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
        'id' => 'example_editor',
        'type' => 'editor',
        'settings' => $wp_editor_settings );

    return $options;
}

/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

    // This gets the theme name from the stylesheet
    $themename = wp_get_theme();
    $themename = sanitize_title(preg_replace("/\W/", "_", strtolower($themename) ));

    $optionsframework_settings = get_option( 'optionsframework' );
    $optionsframework_settings['id'] = $themename;
    update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * # este helper está disponível em theme.helper.php  como opt()#
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 */
if ( !function_exists( 'of_get_option' ) ) {
    function of_get_option($name, $default = false) {
        
        $optionsframework_settings = get_option('optionsframework');
        
        // Gets the unique option id
        $option_name = $optionsframework_settings['id'];
        
        if ( get_option($option_name) ) {
            $options = get_option($option_name);
        }
            
        if ( isset($options[$name]) ) {
            return $options[$name];
        } else {
            return $default;
        }
    }
}


/**
 * Exemplo de como inserir scripts no painel de admin
 */
function optionsframework_custom_scripts() 
{ ?>

    <script type="text/javascript">
    jQuery(document).ready(function() {

        // faz algo

    });
    </script>
 
<?php }
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

/* 
 * This is an example of how to override a default filter
 * for 'text' sanitization and use a different one.
 */
/*
add_action('admin_init','optionscheck_change_santiziation', 100);

function optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_text', 'sanitize_text_field' );
    add_filter( 'of_sanitize_text', 'of_sanitize_text_field' );
}

function of_sanitize_text_field($input) {
    global $allowedtags;
    $output = wp_kses( $input, $allowedtags);
    return $output;
}
*/

/**
 * Localização das configurações das opções disponíveis
 * @return array
 */
function options_framework_location_override() {
    return array('/config/theme-options.php');
}
add_filter('options_framework_location','options_framework_location_override');


/**
 * Sobreescrevendo no nome do item de menu
 * @param  array $menu
 * @return array
 */
function optionscheck_options_menu_params( $menu ) {
    
    $menu['page_title'] = __( 'Opções do site', 'textdomain');
    $menu['menu_title'] = __( 'Opções do site', 'textdomain');
    // $menu['menu_slug'] = 'hello-options';
    return $menu;
}
add_filter( 'optionsframework_menu', 'optionscheck_options_menu_params' );
