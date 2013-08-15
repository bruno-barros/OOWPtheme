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
- libraries/Mobile_Detect.php
- libraries/Validation.php
- libraries/Wasets.php
- libraries/Wcollection.php
- libraries/Wmail.php
- libraries/Wmenu.php
- libraries/Wpost.php
- libraries/Wtmpl.php

Plugins
--------------------
Wrapper para plugins com modificações no seu funcionamento normal.

- plugins/Bannerize.php


Como extender as bibliotecas básicas
-----------------------------------
A pasta model é destinada as classes que extendem as bibliotecas, como Wpost(). Deve ser utilizado em pesquisas personalizadas e custom_post_types.

Exemplos
========

Dentro do loop de posts
-----------------------

	while($loop->have_posts()){
		$loop->the_post();

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
Em breve...