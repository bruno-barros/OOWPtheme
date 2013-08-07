<!DOCTYPE html>
<html>
<head>
<title>OOWPtheme test</title>
<?php wp_head();?>
<body>
<?php 
/** 
 * 	Template para rodar testes de classes que utilizam funções
 * 	nativas do WordPress
 * 	@package OOWPtheme
 * 	@subpackage test
 */
/** ========================================================================
 * 	Classe para manipulação de páginas
 * ------------------------------------------------------------------------
 */
d('CLASSE PARA MANIPULAÇÃO DE PÁGINAS');

$wPages = new Wcollection( array('post_type' => 'page') );
d($wPages->count());
// d($query);
while($wPages->have_posts()){
	$wPages->the_post();
	$p = new Wpost();
	echo $p->title;
	echo '<br>';
}


/** ========================================================================
 * 	Retorna coleção de posts
 * ------------------------------------------------------------------------
 */
d('RETORNA COLEÇÃO DE POSTS');
$loopOfPosts = new Wcollection();// por padrão retorna post_type = post
d($loopOfPosts->count());
if($loopOfPosts->have_posts()){

	while($loopOfPosts->have_posts()){
		$loopOfPosts->the_post();
		$p = new Wpost($post);
		// the_title();
		echo $p->title;
		echo '<br>';
	}
}

// $loop = new Wcollection( array( 'post_type' => 'chamadas', 'posts_per_page' => 4 ) );


/** ========================================================================
 * 	Presenter para posts e páginas
 * ------------------------------------------------------------------------
 */
d('PRESENTER PARA POSTS E PÁGINAS');
$post = new Wpost(1);
d($post->slug);
d($post->title);
d($post->permalink);
d($post->thumb);
d($post->category);


/** ========================================================================
 * 	Exemplo de model personalizado
 * ------------------------------------------------------------------------
 */
d('EXEMPLO DE MODEL PERSONALIZADO');
$exemplo = new MyPersonalPostType();
d($exemplo->count());
$oneExample = new Wpost($exemplo->posts[0]);
d($oneExample->title);
d($oneExample->permalink);
d();
?>
</body>
</html>
