<?php 
/**
 * Sidebars
 * 
 * @package OOWPtheme
 * @subpackage widgets
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
function wptheme_widgets_init()
{
    register_sidebar(array(
        'name' => 'Sidebar principal',
        'id' => 'sidebar-1',
        'description' => 'Sidebar principal.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Sidebar home',
        'id' => 'sidebar-2',
        'description' => 'Box para plugin social',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Sidebar ternário',
        'id' => 'sidebar-3',
        'description' => 'Sidebar ternário',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

add_action('widgets_init', 'wptheme_widgets_init');