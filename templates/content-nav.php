<?php 

if ( ! function_exists( 'oowptheme_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function oowptheme_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<!-- <h3 class="assistive-text"><?php _e( 'Post navigation' ); ?></h3> -->
			<div class="nav-previous pull-right"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Anteriores' ) ); ?></div>
			<div class="nav-next pull-right"><?php previous_posts_link( __( 'Recentes <span class="meta-nav">&rarr;</span>' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;