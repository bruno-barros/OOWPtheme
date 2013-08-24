<?php
/**
 * Post types
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * !! Após criar novos custom post types      !!
 * !! Vá em Configurações > Links Permanentes !!
 * !! e salve as configurações para atualizar !!
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 * @package OOWPtheme
 * @subpackage config
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */

/**
 * ================================================
 * Modelo para novo Custom Post Type
 */
add_action( 'init', 'wptheme_posttype_EXAMPLE', 0 );
function wptheme_posttype_EXAMPLE() {
  $labels = array(
    'menu_name' => 'EXAMPLEs',
    'name' => 'EXAMPLEs',
    'singular_name' => 'EXAMPLE',
    'add_new' => 'Adicionar novo',
    'add_new_item' => 'Adicionar novo',
    'edit_item' => 'Editar EXAMPLE',
    'new_item' => 'Novo EXAMPLE',
    'all_items' => 'Todos os EXAMPLE',
    'view_item' => 'Ver EXAMPLEs',
    'search_items' => 'Pesquisar EXAMPLEs',
    'not_found' =>  'Nenhum EXAMPLE encontrado',
    'not_found_in_trash' => 'Nenhum EXAMPLE encontrado na', 
    'parent_item_colon' => ''
  );

  $args = array(
    'labels' => $labels,
    'description' => '',
    'public' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'menu_icon' => null,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'EXAMPLE' ),
    'capability_type' => 'post', // post|page
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => 4,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats'),
    // optional
    // compartilha estas taxonomias com posts
    // 'taxonomies' => array('category', 'post_tag'),
  ); 

    register_post_type( 'example', $args );
}
/**
 * Registra taxonomias exclusivas para este custom post type
 */
add_action( 'init', 'wptheme_taxonomie_EXAMPLE', 0 );
function wptheme_taxonomie_EXAMPLE() {
    $labels = array(
        'name'              => _x( 'Categorias de EXAMPLES', 'CategoriaS de EXAMPLES' ),
        'singular_name'     => _x( 'Categoria do EXAMPLE', 'Categoria de EXAMPLE' ),
        'search_items'      => __( 'Pesquisar categorias de EXAMPLE' ),
        'all_items'         => __( 'Todas as categorias de EXAMPLE' ),
        'parent_item'       => __( 'Categoria mãe (EXAMPLE)' ),
        'parent_item_colon' => __( 'Categoria mãe (EXAMPLE):' ),
        'edit_item'         => __( 'Editar categoria de EXAMPLE' ),
        'update_item'       => __( 'Atualizar categoria de EXAMPLE' ),
        'add_new_item'      => __( 'Adicionar categoria de EXAMPLE' ),
        'new_item_name'     => __( 'Nova categoria de EXAMPLE' ),
        'menu_name'         => __( 'Categorias de EXAMPLE' ),
        'not_found'         => __( 'Nenhuma categorias de EXAMPLE encontrada.' ),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'rewrite' => array( 'slug' => 'catEXAMPLE' ),
    );
    register_taxonomy( 'categoria_example', 'example', $args );

}
/**
 *     FIM do custom post type
 * ------------------------------------------------------------------------
 */
