<?php

/**
 *
 * @package WPtheme
 */
require(TEMPLATEPATH . '/core/WpThemeStart.php');

/**
 * =======================================================================
 *  Assets
 * -----------------------------------------------------------------------
 * Classe para insejeção de scripts
 * -----------------------------------------------------------------------
 */
$assets = new Assets();

/** ========================================================================
 *     Menus personalizados
 * ------------------------------------------------------------------------
 */
$menuPrincipal = new Menu('Testing Menu', array('menu_id' => 'menu'));
$menuPrincipal->before('contato', 'Item especial', 'lili', 'aaa', 'ICO');
$menuPrincipal->after('contato', 'Item especial', 'lili', 'aaa', 'ICO');

/** ========================================================================
 *     Wrapper para plugin WP Bannerize
 * ------------------------------------------------------------------------
 */
#$bannerHome = new Bannerize('group=destaqueshome&random=1&limit=3&container_class=webdoor-slides flexslider');

/** ========================================================================
 *     Execuções no momento da geração do header
 *     Injeção de scripts...
 * ------------------------------------------------------------------------
 */
function wptheme_header_actions()
{
  if (is_home()) {
    // io('assets')->add('flexslider', 'jquery.flexslider.min.js', 'jquery');
  } else if(is_page()){

  } else if(is_single()){

  }
}
add_action('get_header', 'wptheme_header_actions');

/*
  |=================================================================================
  |	SIDEBAR
  |	Registers our main widget area and the front page widget areas.
  |---------------------------------------------------------------------------------
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
        'name' => 'Sidebar secundário',
        'id' => 'sidebar-2',
        'description' => 'Sidebar secundário',
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


/** ========================================================================
 *     Post support
 *     Adiciona funcionalidades, como imagem destacada
 *     @link http://codex.wordpress.org/add_theme_support
 * ------------------------------------------------------------------------
 */
add_theme_support( 'post-thumbnails' );


/** ========================================================================
 *     Post type
 *     @link http://codex.wordpress.org/Function_Reference/register_post_type
 * ------------------------------------------------------------------------
 */
function wptheme_posttype_example() {
  $labels = array(
    'name' => 'Books',
    'singular_name' => 'Book',
    'add_new' => 'Adicionar novo',
    'add_new_item' => 'Adicionar novo Book',
    'edit_item' => 'Editar Book',
    'new_item' => 'Novo Book',
    'all_items' => 'Todos os Books',
    'view_item' => 'Ver Book',
    'search_items' => 'Pesquisar Books',
    'not_found' =>  'Nenhum books encontrado',
    'not_found_in_trash' => 'Nenhum books encontrado na lixeira', 
    'parent_item_colon' => '',
    'menu_name' => 'Books'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'book' ),
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => 4,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
  ); 

  register_post_type( 'book', $args );
}
add_action( 'init', 'wptheme_posttype_example' );

if (!function_exists('wptheme_entry_meta')) :

    /**
     * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
     *
     * Create your own wptheme_entry_meta() to override in a child theme.
     *
     * @since Twenty Twelve 1.0
     */
    function wptheme_entry_meta()
    {
        // Translators: used between list items, there is a space after the comma.
        $categories_list = get_the_category_list(__(', '));

        // Translators: used between list items, there is a space after the comma.
        $tag_list = get_the_tag_list('', __(', '));

        $date = sprintf('<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>', esc_url(get_permalink()), esc_attr(get_the_time()), esc_attr(get_the_date('c')), esc_html(get_the_date())
        );

        $author = sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_attr(sprintf(__('View all posts by %s'), get_the_author())), get_the_author()
        );

        // Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
        if ($tag_list)
        {
            $utility_text = __('This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.');
        }
        elseif ($categories_list)
        {
            $utility_text = __('This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.');
        }
        else
        {
            $utility_text = __('This entry was posted on %3$s<span class="by-author"> by %4$s</span>.');
        }

        printf(
                $utility_text, $categories_list, $tag_list, $date, $author
        );
    }


endif;