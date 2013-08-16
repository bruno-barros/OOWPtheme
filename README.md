OOWPtheme
=========

Template básico que serve de ponto de partida. TwiterBootstrap,  classes para manipulação de posts, páginas e imagens. Exemplos de códigos úteis e testes unitários com PHPunit.

Bibliotecas básicas
--------------------
### Helpers
- helpers/array.helper.php
- helpers/form.helper.php
- helpers/str.helper.php
- helpers/uri.helper.php

### Libraries
- libraries/Wasets.php
- libraries/Wcollection.php
- libraries/Wmail.php
- libraries/Wmenu.php
- libraries/Wpost.php
- libraries/Wtmpl.php

Plugins
-------
Wrapper para plugins com modificações no seu funcionamento normal.

- plugins/Bannerize.php


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

	}

Menus personalizados
--------------------
Wrapper para espandir o uso de menus. Supondo que você criou um menu com o nome <code>Menu Principal</code>.
No <code>functions.php</code>:

	// opcional
	// configurações padrão do WP	
	$configs = array(
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
	$menuPrincipal = new Wmenu('Menu Principal', $config);

	// adicionado itens antes e depois do menu gerenciado no WP
	// retorna: <li class="link-li"><a href="url/da/pagina" class="link-a"> <i class="icon-mail"></i> descrição link</a></li>
	$menuPrincipal->before('url/da/pagina', 'descrição link', 'link-li', 'link-a', '<i class="icon-mail"></i>');
	// outros métodos:
	$menuPrincipal->after($url = '', $label = '', $liClass = null, $aClass = null, $icon = null);
	$menuPrincipal->beforeRaw($data = '');
	$menuPrincipal->afterRaw($data = '');

No template:

	io('menuPrincipal')->render();