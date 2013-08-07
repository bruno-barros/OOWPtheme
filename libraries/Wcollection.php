<?php

/**
 * Wrapper para looping de posts
 * 
 * <code>
 * // instancia coleção
 * $loop = new Wcollection( array( 'post_type' => 'post', 'posts_per_page' => 2 ) );
 * 
 * while ( $loop->have_posts() ) : $loop->the_post();
 *  
 *  // wrapper para cada post
 *  $p = new Wpost($post);
 * 
 * endwhile;
 * </code>
 * @link http://codex.wordpress.org/Class_Reference/WP_Query
 * @see Wpost
 * @package OOWPtheme
 * @subpackage libraries
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
class Wcollection extends WP_Query {

    public function __construct($args = array())
    {
        global $paged;
//        d($paged);
        // Force these args
        $args = array_merge(array(
            //-- autor --//
            //ID do autor
            'author' => null,
            // nicename do autor
            'author_name' => null,
            //-- categoria --//
            // ID da categoria
            'cat' => null,
            // slug da categoia
            'category_name' => null,
            // posts em multiplas categorias (array)
            'category__and' => null,
            // posts que pertencem a pelo menos uma das categorias (array)
            'category__in' => null,
            // posts que não pertençam a nenhumas destas categorias (array)
            'category__not_in' => null,
            //-- tags --//
            // slug da tag
            'tag' => null,
            // ID da tag
            'tag_id' => null,
            // posts que contenham todas as tags (array of ids)
            'tag__and' => null,
            // posts que contenham pelo meno uma das tags (array of ids)
            'tag__in' => null,
            // posts que não tenham nenhuma destas tags (array of ids)
            'tag__not_in' => null,
            // posts que contenham todas as tags (array of slugs)
            'tag_slug__and' => null,
            // posts que contenham pelo meno uma das tags (array of slugs)
            'tag_slug__in' => null,
            //-- pesquisa livre --//
            // string para busta fulltext
            's' => null,
            // tipo de post
            'post_type' => 'post',
            // posts por página. -1 sem limite
            'posts_per_page' => -1,
            'no_found_rows' => true, // Optimize query for no paging
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false,
            'paged' => $paged
                ), $args);
        
        
//        add_filter('posts_fields', array($this, 'posts_fields'));
//        add_filter('posts_join', array($this, 'posts_join'));
//        add_filter('posts_where', array($this, 'posts_where'));
//        add_filter('posts_orderby', array($this, 'posts_orderby'));

        parent::__construct($args);

        // Make sure these filters don't affect any other queries
//        remove_filter('posts_fields', array($this, 'posts_fields'));
//        remove_filter('posts_join', array($this, 'posts_join'));
//        remove_filter('posts_where', array($this, 'posts_where'));
//        remove_filter('posts_orderby', array($this, 'posts_orderby'));
    }

    /**
     * Retorna o total de posts
     * @return int
     */
    public function count()
    {
        if (!isset($this->posts))
        {
            return null;
        }
        return count($this->posts);
    }

    public function posts_fields($sql)
    {
        global $wpdb;
        return $sql . ", $wpdb->terms.name AS 'book_category'";
    }

    public function posts_join($sql)
    {
        global $wpdb;
        return $sql . "
                INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) 
                INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id) 
                INNER JOIN $wpdb->terms ON ($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id) 
		";
    }

    public function posts_where($sql)
    {
        global $wpdb;
        return $sql . " AND $wpdb->term_taxonomy.taxonomy = 'book_category'";
    }

    public function posts_orderby($sql)
    {
        global $wpdb;
        return "$wpdb->terms.name ASC, $wpdb->posts.post_title ASC";
    }


}