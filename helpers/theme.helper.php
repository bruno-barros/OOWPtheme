<?php
/**
 * Helpers úteis com funções genéricas, como: plugins e adaptações para o tema
 * 
 * @package OOWPtheme
 * @subpackage helpers
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */

if ( !function_exists( 'opt' ) )
{
    /**
     * Helper function to return the theme option value. If no value has been saved, it returns $default.
     * Needed because options are saved as serialized strings.
     * @param  string  $name    ID da opção
     * @param  boolean|string $default Fallback
     * @return string
     */
    function opt($name, $default = false) 
    {        
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