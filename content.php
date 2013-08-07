<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
	
		<?php endif; ?>

		<header class="entry-header">

			<?php the_post_thumbnail(); ?>
			<?php 
			if ( is_single() ) : 
			?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php 
			else : 
			?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>


			<?php 
			if ( comments_open() ) : 
			?>
				<div class="comments-link">
					<?php comments_popup_link( '<span class="leave-reply">Faça um comentário</span>', '1 comentário', __( '% comentários') ); ?>
				</div><!-- .comments-link -->
			<?php 
			endif; // comments_open() 
			?>

		</header><!-- .entry-header -->

		<?php 
		if ( is_search() ) : // Only display Excerpts for Search 
		?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php 
		else : 
		?>
		<div class="entry-content">
			<?php the_content( 'Continue lendo <span class="meta-nav">&rarr;</span>' ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">Páginas ', 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php 
		endif; 
		?>

		<footer class="entry-meta">

			<?php oowptheme_entry_meta(); ?>

			<?php edit_post_link( 'Editar', '<span class="edit-link">', '</span>' ); ?>

			<?php 
			// If a user has filled out their description and this is a multi-author blog, show a bio on their entries. 
			if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : 
			?>
				<div class="author-info">
					<div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
					</div><!-- .author-avatar -->
					<div class="author-description">
						<h2><?php printf( 'Sobre o autor', get_the_author() ); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
						<div class="author-link">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>' ), get_the_author() ); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
			<?php 
			endif; 
			?>
		</footer><!-- .entry-meta -->

	</article><!-- #post -->
