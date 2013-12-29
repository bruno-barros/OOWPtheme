OOWPtheme
=========

Template básico que serve de ponto de partida. TwiterBootstrap, classes para manipulação de posts, páginas e imagens. Exemplos de códigos úteis e testes unitários com PHPunit.
Um framework para gerenciamento de opções de tema foi incorporado _[veja abaixo](#framework-para-op%C3%A7%C3%B5es-de-tema)_.

Bibliotecas básicas
--------------------
### Helpers
- helpers/array.helper.php
- helpers/form.helper.php
- helpers/str.helper.php
- helpers/uri.helper.php
- helpers/template.helper.php
- helpers/theme.helper.php

### Libraries
- libraries/Wassets.php // gerenciamento de JS e CSS
- libraries/Wcollection.php // manipulação de coleções (custom post type)
- libraries/Wmail.php // validação e envio de formulários com autenticação
- libraries/Wmenu.php // manipulação de menus
- libraries/Wpost.php // manipulação de posts e páginas
- libraries/Wtmpl.php // gerenciamento de templates para pequenas partes
- libraries/Wcategories.php // manipulação de coleções de categorias
- libraries/Wcategory.php // manipulação de categorias

Plugins
-------
Classe para embutir plugins necessários ao tema, ou recomendados.

### Gerenciando plugins do tema
* Vá em `plugins/plugin-activation.php`
* Adicione seus plugins no array `$plugins = array()`

Wrapper para plugins com modificações no seu funcionamento normal. 

- plugins/Bannerize.php [WP Bannerize](http://wordpress.org/plugins/wp-bannerize/)


Exemplos
========

Dentro do loop de posts
-----------------------

	while( have_posts() ){
		the_post();

		// cria objeto do post dentro do loop
		$p = new Wpost();

		// link do post
		<a href="{ $p->permalink }">{ $p->title }</a>

		// thumbnail
		if($p->thumb):
			<img src="{ $p->thumb }">
		endif;

		// link da categoria
		<a href="{ $p->category[0]->permalink }">{ $p->category[0]->name }</a>

		// link do autor
		<a href="{ $p->authorUrl }">{ $p->authorName }</a>
		// ou
		<a href="{ $p->author->url }">{ $p->author->name }</a>

	}

Menus personalizados
--------------------
Wrapper para expandir o uso de menus. Supondo que você criou um menu com o nome <code>Menu Principal</code>.
No <code>functions.php</code>:

	// opcional
	// configurações padrão do WP	
	$config = array(
        'theme_location' => '',
        'container' => 'div',
        'container_class' => 'menu-header clearfix',
        'container_id' => '',
        'menu_class' => 'menu unstyled',
        'menu_id' => '',
        'echo' => true,
        'fallback_cb' => 'wp_page_menu',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        // template do menu com "shortcodes" para adicionar itens 
        'items_wrap' => '<ul id="%1$s" class="%2$s">[BEFORE] %3$s [AFTER]</ul>',
        'depth' => 0,
        'walker' => '',
        // template para cada item que é adicionado nos "shortcodes"
        'item_template' => '<li class="%1$s"><a href="%3$s" class="%2$s">%5$s %4$s</a></li>'
    );

    // cria objeto do menu
	$menuPrincipal = new Wmenu('Menu Principal', $config);

	// adicionado itens antes e depois do menu gerenciado no WP
	// retorna: <li class="link-li"><a href="url/da/pagina" class="link-a"> <i class="icon-mail"></i> descrição link</a></li>
	$menuPrincipal->before('url/da/pagina', 'descrição link', 'link-li', 'link-a', '<i class="icon-mail"></i>');

	// adiciona item no final
	$menuPrincipal->after($url = '', $label = '', $liClass = null, $aClass = null, $icon = null);

	// adiciona HTML personalizado
	$menuPrincipal->beforeRaw($data = '');
	$menuPrincipal->afterRaw($data = '');

No template:

	io('menuPrincipal')->render();


Usando partes de templates
--------------------------

No looping (PHP):
	
	$p = new Wpost();

	// instancia lib
	$entryMeta = new Wtmpl();

	// cria variáveis no template
	$entryMeta->assign(array(
		'category' => $p->category,
		'tags' => $p->tags,
		'post' => $p->toArray(),
		'author' => $p->author
	));

	// renderiza, faz cache e exibe
	$entryMeta->display('post/entry-meta.html');

No template: 'templates/post/entry-meta.html' (Só HTML ;-P)

	<div class="entry-meta">

		Este post foi publicado em <a href="{ $post.permalink }" title="{ $post.time }" rel="bookmark">
		<time class="entry-date">{ $post.date }</time></a>
		
		{ if $category } 
			na categoria 
		{ /if }

		{ foreach value=cat from=$category }		
			<a href="{ $cat.permalink }">{ $cat.name }</a>
		{ /foreach }
		
		{ if $tags } 
			com as tags
		{ /if }

		{ foreach value=tag from=$tags }
			<a href="{ $tag.permalink }">{ $tag.name }</a>
		{ /foreach }

		<span class="author vcard">
			 por <a class="url fn n" href="{ $author.url }" title="{ $author.name }" rel="author">{ $author.name }</a>
		</span>

	</div>


Como extender as bibliotecas básicas
-----------------------------------
A pasta <code>model</code> é destinada as classes que extendem as bibliotecas, como <code>Wpost</code>. Deve ser utilizado em pesquisas personalizadas e custom_post_types.

	// models/MyPersonalPostType.php
	// Classe personalizada para custom post type "depoimentos"
	class MyPersonalPostType extends Wcollection
	{
	    public function __construct()
	    {
	        parent::__construct(array(
	            'post_type' => 'depoimentos'
	        ));
	    }
	}

No template:

	$myPersonalPostType = new MyPersonalPostType();
	if($myPersonalPostType->have_posts()){
		while($myPersonalPostType->have_posts()){
			$myPersonalPostType->the_post();

			$p = new Wpost();
			// ...
		}
	} else {
		// Não existem depoimentos.
	}

<a href="themeframework"></a>Framework para opções de tema
----------------------------------------------------------
[Veja o projeto original](https://github.com/devinsays/options-framework-theme)

Para criar campos personalizados na administração, crie os campos necessários em `config/theme-options.php`.
Exemplos de vários tipos de campos estão em `config/theme-options-example.php`.
Por padrão o link é "Opções do site" e está disponível em "Aparência", mas pode ser alterado.

Campos disponíveis:

	- heading: cria uma aba de opções
	- text
	- textarea
	- select 
	- radio
	- checkbox
	- multicheck
	- color: plugin colorpicker
	- upload: upload de imagem
	- images: usa imagens ao invés de radio
	- background: opções para definir imagem de fundo
	- typography: opções para tipografia
	- editor: campo de conteúdo como em posts
	- info: apenas campo de texto informativo

Para usar as configurações no tema use:

	// opt('ID do campo', [Valor padrão]);

	if( opt('telefone') ):
		echo "Ligue para " . opt('telefone');
	endif;