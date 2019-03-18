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
add_action('init', 'wptheme_posttype_escolas', 0);
function wptheme_posttype_escolas()
{
    $labels = array(
        'menu_name'          => 'Escolas',
        'name'               => 'Escolas',
        'singular_name'      => 'Escola',
        'add_new'            => 'Adicionar nova',
        'add_new_item'       => 'Adicionar nova',
        'edit_item'          => 'Editar Escola',
        'new_item'           => 'Nova Escola',
        'all_items'          => 'Todas as Escolas',
        'view_item'          => 'Ver Escola',
        'search_items'       => 'Pesquisar Escolas',
        'not_found'          => 'Nenhuma Escola encontrada',
        'not_found_in_trash' => 'Nenhuma Escola encontrada na',
        'parent_item_colon'  => ''
    );

    $args = array(
        'labels'              => $labels,
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => null,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'escolas'),
        'capability_type'     => 'post', // post|page
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 4,
        'supports'            => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats'),
        // optional
        // compartilha estas taxonomias com posts
        // 'taxonomies' => array('category', 'post_tag'),
    );

    register_post_type('escolas', $args);
}
/**
 * Registra taxonomias exclusivas para este custom post type
 */
add_action('init', 'wptheme_taxonomie_escolas', 0);
function wptheme_taxonomie_escolas()
{
    $labels = array(
        'name'              => 'Categorias de escolas',
        'singular_name'     => 'Categoria de escola',
        'search_items'      => 'Pesquisar categorias de escola',
        'all_items'         => 'Todas as categorias de escola',
        'parent_item'       => 'Categoria mãe (escola)',
        'parent_item_colon' => 'Categoria mãe (escola):',
        'edit_item'         => 'Editar categoria de escola',
        'update_item'       => 'Atualizar categoria de escola',
        'add_new_item'      => 'Adicionar categoria de escola',
        'new_item_name'     => 'Nova categoria de escola',
        'menu_name'         => 'Categorias de escola',
        'not_found'         => 'Nenhuma categoria de escola encontrada.',
    );
    $args   = array(
        'labels'       => $labels,
        'hierarchical' => true,
        'public'       => true,
        'show_admin_column'   => true,
        'rewrite'      => array('slug' => 'escolas_categoria'),
    );
    register_taxonomy('escolas_categoria', 'escolas', $args);

}
/**
 *     FIM do custom post type
 * ------------------------------------------------------------------------
 */

/**
 * ================================================
 * CURSOS
 * ------------------------------------------------
 */
//add_action('init', 'wptheme_posttype_cursos', 0);
function wptheme_posttype_cursos()
{
    $labels = array(
        'menu_name'          => 'Cursos',
        'name'               => 'Cursos',
        'singular_name'      => 'Curso',
        'add_new'            => 'Adicionar novo',
        'add_new_item'       => 'Adicionar novo',
        'edit_item'          => 'Editar Curso',
        'new_item'           => 'Novo Curso',
        'all_items'          => 'Todos os Cursos',
        'view_item'          => 'Ver Curso',
        'search_items'       => 'Pesquisar Cursos',
        'not_found'          => 'Nenhum Curso encontrado',
        'not_found_in_trash' => 'Nenhum Curso encontrado na',
        'parent_item_colon'  => ''
    );

    $args = array(
        'labels'              => $labels,
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => null,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'cursos'),
        'capability_type'     => 'post', // post|page
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 4,
        'supports'            => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats'),
        // optional
        // compartilha estas taxonomias com posts
        // 'taxonomies' => array('category', 'post_tag'),
    );

    register_post_type('cursos', $args);
}

/**
 * ================================================
 * EVENTOS
 * ------------------------------------------------
 */
add_action('init', 'wptheme_posttype_eventos', 0);
function wptheme_posttype_eventos()
{
    $labels = array(
        'menu_name'          => 'Eventos',
        'name'               => 'Eventos',
        'singular_name'      => 'Evento',
        'add_new'            => 'Adicionar novo',
        'add_new_item'       => 'Adicionar novo',
        'edit_item'          => 'Editar Evento',
        'new_item'           => 'Novo Evento',
        'all_items'          => 'Todos os Eventos',
        'view_item'          => 'Ver Evento',
        'search_items'       => 'Pesquisar Eventos',
        'not_found'          => 'Nenhum Evento encontrado',
        'not_found_in_trash' => 'Nenhum Evento encontrado na',
        'parent_item_colon'  => ''
    );

    $args = array(
        'labels'              => $labels,
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => null,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'eventos'),
        'capability_type'     => 'post', // post|page
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 4,
        'supports'            => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats'),
        // optional
        // compartilha estas taxonomias com posts
        // 'taxonomies' => array('category', 'post_tag'),
    );

    register_post_type('eventos', $args);
}


add_action('init', 'wptheme_taxonomie_eventos', 0);
function wptheme_taxonomie_eventos()
{
    $labels = array(
        'name'              => 'Categorias de eventos',
        'singular_name'     => 'Categoria de evento',
        'search_items'      => 'Pesquisar categorias de evento',
        'all_items'         => 'Todas as categorias de evento',
        'parent_item'       => 'Categoria mãe (evento)',
        'parent_item_colon' => 'Categoria mãe (evento):',
        'edit_item'         => 'Editar categoria de evento',
        'update_item'       => 'Atualizar categoria de evento',
        'add_new_item'      => 'Adicionar categoria de evento',
        'new_item_name'     => 'Nova categoria de evento',
        'menu_name'         => 'Categorias de evento',
        'not_found'         => 'Nenhuma categoria de evento encontrada.',
    );
    $args   = array(
        'labels'       => $labels,
        'hierarchical' => true,
        'public'       => true,
        'show_admin_column'   => true,
        'rewrite'      => array('slug' => 'eventos_categoria'),
    );
    register_taxonomy('eventos_categoria', 'eventos', $args);

}


/**
 * ================================================
 * NOVIDADES
 * ------------------------------------------------
 */
add_action('init', 'wptheme_posttype_novidades', 0);
function wptheme_posttype_novidades()
{
    $labels = array(
        'menu_name'          => 'Novidades',
        'name'               => '',
        'singular_name'      => '',
        'add_new'            => 'Adicionar novo',
        'add_new_item'       => 'Adicionar novo',
        'edit_item'          => 'Editar Curso',
        'new_item'           => 'Novo Curso',
        'all_items'          => 'Todos os Cursos',
        'view_item'          => 'Ver Curso',
        'search_items'       => 'Pesquisar Cursos',
        'not_found'          => 'Nenhum Curso encontrado',
        'not_found_in_trash' => 'Nenhum Curso encontrado na',
        'parent_item_colon'  => ''
    );

    $args = array(
        'labels'              => $labels,
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'show_ui'             => false,
        'show_in_menu'        => true,
        'menu_icon'           => null,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'novidades'),
        'capability_type'     => 'post', // post|page
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 4,
        'supports'            => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats'),
        // optional
        // compartilha estas taxonomias com posts
        // 'taxonomies' => array('category', 'post_tag'),
    );

    register_post_type('novidades', $args);
}




/**
 * ================================================
 * CITAÇÕES
 * ------------------------------------------------
 */
add_action('init', 'wptheme_posttype_citacoes', 0);
function wptheme_posttype_citacoes()
{
    $labels = array(
        'menu_name'          => 'Citações',
        'name'               => 'Citações',
        'singular_name'      => 'Citação',
        'add_new'            => 'Adicionar nova',
        'add_new_item'       => 'Adicionar nova',
        'edit_item'          => 'Editar Citação',
        'new_item'           => 'Nova Citação',
        'all_items'          => 'Todas as Citações',
        'view_item'          => 'Ver Citação',
        'search_items'       => 'Pesquisar Citações',
        'not_found'          => 'Nenhuma Citação encontrada',
        'not_found_in_trash' => 'Nenhuma Citação encontrada na',
        'parent_item_colon'  => ''
    );

    $args = array(
        'labels'              => $labels,
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => null,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'citacoes'),
        'capability_type'     => 'post', // post|page
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 4,
        'supports'            => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields'),
        // optional
        // compartilha estas taxonomias com posts
         'taxonomies' => array('citacao_tag'),
    );

    register_post_type('citacoes', $args);
}

/**
 * Registra taxonomias exclusivas para este custom post type
 */
add_action('init', 'wptheme_taxonomie_citacoestags', 0);
function wptheme_taxonomie_citacoestags()
{
    $labels = array(
        'name'              => 'Tags de citações',
        'singular_name'     => 'Tag de citação',
        'search_items'      => 'Pesquisar tags de citações',
        'all_items'         => 'Todas as tags de citações',
        'parent_item'       => 'Tag mãe (citação)',
        'parent_item_colon' => 'Tag mãe (citação):',
        'edit_item'         => 'Editar tag de citações',
        'update_item'       => 'Atualizar tag de citações',
        'add_new_item'      => 'Adicionar tag de citações',
        'new_item_name'     => 'Nova tag de citações',
        'menu_name'         => 'Tags de citações',
        'not_found'         => 'Nenhuma tag de citações encontrada.',
    );
    $args   = array(
        'labels'       => $labels,
        'hierarchical' => false,
        'public'       => true,
        'show_admin_column'   => true,
        'rewrite'      => array('slug' => 'citacao_tag'),
    );
    register_taxonomy('citacao_tag', 'citacoes', $args);

}
