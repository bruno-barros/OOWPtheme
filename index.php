<?php
/**
 * The main template file.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WPtheme
 */

get_header(); 


?>


<div id="page">
	
	<div class="container">
		
		<div class="row">

		<div id="main" class="span9 site-content" role="main">
			
		
	

		<?php 
		/*
		|=================================================================================
		|	Se existem posts...
		|---------------------------------------------------------------------------------
		*/
		if ( have_posts() ) : 
		/*
		|=================================================================================
		|	Looping pelos posts
		|---------------------------------------------------------------------------------
		*/
		while ( have_posts() ) : the_post(); 
		?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php 
		endwhile; 
		?>

		<?php 
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