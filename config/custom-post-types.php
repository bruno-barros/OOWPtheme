<?php
/**
 * Post types
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 * @package OOWPtheme
 * @subpackage config
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
function wptheme_posttype_chamadas() {
  $labels = array(
    'name' => 'Chamadas da home',
    'singular_name' => 'Chamada da home',
    'add_new' => 'Adicionar nova',
    'add_new_item' => 'Adicionar nova Chamada',
    'edit_item' => 'Editar chamada',
    'new_item' => 'Nova chamada',
    'all_items' => 'Todos as chamadas',
    'view_item' => 'Ver chamadas da home',
    'search_items' => 'Pesquisar chamadas da home',
    'not_found' =>  'Nenhuma chamada encontrada',
    'not_found_in_trash' => 'Nenhuma chamada encontrada na lixeira', 
    'parent_item_colon' => '',
    'menu_name' => 'Chamadas da home'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'sobre' ),
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => 4,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
  ); 

    register_post_type( 'chamadas', $args );
    /* this adds your post categories to your custom post type */
    //register_taxonomy_for_object_type('category', 'chamadas');
    /* this adds your post tags to your custom post type */
    //register_taxonomy_for_object_type('post_tag', 'chamadas');
}
add_action( 'init', 'wptheme_posttype_chamadas' );

function wptheme_posttype_depoimentos() {
  $labels = array(
    'name' => 'Depoimentos',
    'singular_name' => 'Depoimento',
    'add_new' => 'Adicionar novo',
    'add_new_item' => 'Adicionar novo depoimento',
    'edit_item' => 'Editar depoimento',
    'new_item' => 'Novo depoimento',
    'all_items' => 'Todos os depoimentos',
    'view_item' => 'Ver depoimentos',
    'search_items' => 'Pesquisar depoimentos',
    'not_found' =>  'Nenhum depoimento encontrado',
    'not_found_in_trash' => 'Nenhuma depoimento encontrado na lixeira', 
    'parent_item_colon' => '',
    'menu_name' => 'Depoimentos'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'depoimentos' ),
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array( 'title', 'editor', 'author')
  ); 

  register_post_type( 'depoimentos', $args );
}
add_action( 'init', 'wptheme_posttype_depoimentos' );