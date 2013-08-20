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
echo 'Total: ' . $wPages->count() .'<br>';
// d($query);
while($wPages->have_posts()){
	$wPages->the_post();
	$p = new Wpost();
	echo $p->title . " => {$p->permalink}";
	echo '<br>';
}


/** ========================================================================
 * 	Retorna coleção de posts
 * ------------------------------------------------------------------------
 */
echo '<br><br>';
d('RETORNA COLEÇÃO DE POSTS');
$loopOfPosts = new Wcollection();// por padrão retorna post_type = post
echo 'Total: ' . $loopOfPosts->count() .'<br>';
if($loopOfPosts->have_posts()){

	while($loopOfPosts->have_posts()){
		$loopOfPosts->the_post();
		$p = new Wpost($post);
		// the_title();
		echo $p->title . " => {$p->permalink}";
		echo '<br>';
	}
}

// $loop = new Wcollection( array( 'post_type' => 'chamadas', 'posts_per_page' => 4 ) );


/** ========================================================================
 * 	Presenter para posts e páginas
 * ------------------------------------------------------------------------
 */
echo '<br><br>';
d('PRESENTER PARA POSTS E PÁGINAS');
$myPost = new Wpost(1);


echo "Data: {$myPost->date} <br>";
echo "Slug: {$myPost->slug} <br>";
echo "title: {$myPost->title} <br>";
echo "permalink: {$myPost->permalink} <br>";
echo "thumb: {$myPost->thumb} <br>";
echo "category name: {$myPost->category[0]->name} <br>";
echo "category link: {$myPost->category[0]->permalink} <br>";
echo "authorName: {$myPost->authorName} <br>";
echo '<small><pre>';
print_r($myPost->tags[0]);// array
echo '</pre></small><br>';

echo '---<br>';
$myPage = new Wpost(2);
echo "page title: {$myPage->title} <br>";
echo "páginas filhas: ".count($myPage->children) ."<br>";
echo "título da filha [0]: {$myPage->children[0]->title} <br>";



/** ========================================================================
 * 	Exemplo de model personalizado
 * ------------------------------------------------------------------------
 */
echo '<br><br>';
d('EXEMPLO DE MODEL PERSONALIZADO');
$exemplo = new MyPersonalPostType();
echo 'Total: ' . $exemplo->count() .'<br>';
$oneExample = new Wpost($exemplo->posts[0]);
echo "title: {$oneExample->title} <br>";
echo "permalink: {$oneExample->permalink} <br>";


/** ========================================================================
 * 	Utilizando templates
 * ------------------------------------------------------------------------
 */
echo '<br><br>';
d('UTILIZANDO TEMPLATES');
$tmpl = new Wtmpl();
$tmpl->assign(array(
	'nome' => 'João',
	'email' => 'joao@email',
	'mensagem' => 'Maria',
));
echo $tmpl->fetch("email/contato.html");

$tmpl->assign(array(
	'nome' => 'Maria',
	'email' => 'maria@email',
));
echo $tmpl->fetch("email/contato.html");
?>
</body>
</html>
