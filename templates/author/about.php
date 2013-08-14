<?php 
/** ========================================================================
 * 	Bloco de apresentação do autor
 * ------------------------------------------------------------------------
 */
?>
<div class="author-info media">
	<div class="author-avatar pull-left">		 
		{ $avatar }
	</div><!-- .author-avatar -->
	<div class="author-description media-body">
		
		<h4 class="media-heading">Sobre { $name }</h4>
		<p>{ $desc }</p>
		
		<div class="author-link">
			<a href="{ $url }" rel="author">
				Veja todos os posts publicados por { $name } <span class="meta-nav">&rarr;</span>
			</a>
		</div><!-- .author-link	-->
	</div><!-- .author-description -->
</div><!-- .author-info -->