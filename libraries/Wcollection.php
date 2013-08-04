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
        // Force these args
        $args = array_merge(array(
            'post_type' => 'book',
            'posts_per_page' => -1, // Turn off paging
            'no_found_rows' => true, // Optimize query for no paging
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false
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

    function posts_fields($sql)
    {
        global $wpdb;
        return $sql . ", $wpdb->terms.name AS 'book_category'";
    }

    function posts_join($sql)
    {
        global $wpdb;
        return $sql . "
                INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) 
                INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id) 
                INNER JOIN $wpdb->terms ON ($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id) 
		";
    }

    function posts_where($sql)
    {
        global $wpdb;
        return $sql . " AND $wpdb->term_taxonomy.taxonomy = 'book_category'";
    }

    function posts_orderby($sql)
    {
        global $wpdb;
        return "$wpdb->terms.name ASC, $wpdb->posts.post_title ASC";
    }

}