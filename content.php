<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
$p = new Wpost();
?>

	<article id="post-<?php echo $p->ID; ?>" <?php post_class(); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
	
		<?php endif; ?>

		<header class="entry-header">

			

			<?php 
			if ( is_single() || is_page() ) : 
			?>
			<h1 class="page-title"><?php echo $p->title ?></h1>
			<?php 
			else : 
			?>
			<h1 class="entry-title">
				<a href="<?php echo $p->permalink ?>" title="" rel="bookmark"><?php echo $p->title ?></a>
			</h1>
			<?php endif; // is_single() ?>


			<?php if($p->thumb): ?>
			<img src="<?php echo $p->thumbSize('medium') ?>">			
			<?php endif; ?>


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
			<?php echo get_the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php 
		else : 
		?>
		<div class="entry-content">
			
			<?php // método padrão para não interferir nos hooks
			the_content( 'Continue lendo <span class="meta-nav">&rarr;</span>' );
			?>
			
		</div><!-- .entry-content -->
		<?php 
		endif; 
		?>

		<footer class="entry-meta">

			<?php // @see templates/entry-meta.php
			$entryMeta = new Wtmpl();
			$entryMeta->assign(array(
				'category' => $p->category,
				'tags' => $p->tags,
				'post' => $p->toArray(),
				'author' => $p->author
			));
			$entryMeta->display('post/entry-meta.html');
			?>

			<?php // link para edição do post
			edit_post_link( 'Editar', '<span class="edit-link">', '</span>' ); ?>

			<?php 
			// If a user has filled out their description and this is a multi-author blog, show a bio on their entries. 
			if ( is_singular() && is_multi_author() ) : 

				$authorTmp = new Wtmpl();
				$authorTmp->assign(array(
					'name' => $p->authorName,
					'email' => $p->authorEmail,
					'desc' => $p->authorDescription,
					'url' => $p->authorUrl,
					'avatar' => $p->avatar,
				));
				echo $authorTmp->fetch("author/about.php");
			?>
			<?php 
			endif; 
			?>
		</footer><!-- .entry-meta -->

	</article><!-- #post -->
