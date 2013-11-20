<?php 
/**
 * Helpers para gerar HTML
 * 
 * @package OOWPtheme
 * @subpackage helpers
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
if(! function_exists('oowp_pagination'))
{
	function oowp_pagination($options = array())
	{
		global $wp_query, $wp_rewrite;
		
		// default options
		$opt = array_merge(array(
			'container_class' => 'pagination'
		), $options);

		//use the query for paging
        $wp_query->query_vars[ 'paged' ] > 1 ? $current = $wp_query->query_vars[ 'paged' ] : $current = 1;

		//set the "paginate_links" array to do what we would like it it. 
		//Check the codex for examples http://codex.wordpress.org/Function_Reference/paginate_links
        $pagination = array(
            'base' => @add_query_arg( 'paged', '%#%' ),
            //'format' => '',
            'showall' => false,
            'end_size' => 4,
            'mid_size' => 4,
            'total' => $wp_query->max_num_pages,
            'current' => $current,
            'type' => 'list'
        );

        //build the paging links
        if ( $wp_rewrite->using_permalinks() ){
            $pagination[ 'base' ] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
        }

        //more paging links
        if ( !empty( $wp_query->query_vars[ 's' ] ) ){
            $pagination[ 'add_args' ] = array( 's' => get_query_var( 's' ) );        	
        }

        return "<div class=\"{$opt['container_class']}\">" . paginate_links($pagination) . "</div>";
	}
}
