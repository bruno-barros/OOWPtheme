<?php
/**
 * The main template file.
 *
 * @package OOWPtheme
 */

get_header();
?>

<div id="page">
	
	<div class="container">
		
		<div class="row">

		<div id="main" class="span9 site-content" role="main">

		<?php
		/** ========================================================================
	     *     Breadcrumb
	     * ------------------------------------------------------------------------
	     */
	    if( is_single() || is_page() || is_archive() || is_date() ):
	    	$p = new Wpost();
			$tmplBreadcrumb = new Wtmpl();
			$tmplBreadcrumb->assign(array(
				'breadcrumb' => $p->breadcrumb
			));
			$tmplBreadcrumb->display('breadcrumb.html');
		endif;

		if ( have_posts() ) :
		/** ========================================================================
		 * 	Looping pelos posts
		 * ------------------------------------------------------------------------
		 */
		while ( have_posts() ) : the_post(); 		
			
			get_template_part( 'content', get_post_format() );
		
		endwhile; 
		 
		else : 
		?>

			<p>Nada encontrado</p>

		<?php 
		endif; // end have_posts() check 
		?>

			</div><!-- main -->

			<?php get_sidebar(); ?>
	
		</div><!-- row -->

	</div><!-- container -->

</div><!-- #page -->


<?php get_footer(); ?>