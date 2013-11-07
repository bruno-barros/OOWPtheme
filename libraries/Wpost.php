<?php

/**
 * Wrapper para posts individuais
 * 
 * <code>
 * // dentro de um loop...
 * 
 * $p = new Wpost($post);
 * 
 * $p->thumb;
 * $p->title;
 * $p->slug;
 * $p->permalink;
 * ...
 * 
 * 
 * </code>
 * 
 * @package OOWPtheme
 * @subpackage libraries
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
class Wpost {

    protected $object;

    /**
     * Métodos do tipo presenter que serão retornados no ->toArray()
     * @var array
     */
    protected $toArray = array('Time', 'Date', 'DateUrl', 'Title', 'Slug', 'Permalink', 'Thumb');

    public function __construct($thePost = null)
    {
        global $post;

        if (is_object($thePost))
        {
            $this->object = $thePost;
        }
        else if (is_numeric($thePost))
        {
            $this->object = get_post($thePost);
        }
        else if (is_string($thePost))
        {
            $this->object = new WP_Query(array('name' => $thePost));
        }
        else
        {
            $this->object = $post;
        }
        
        /*
        @link https://codex.wordpress.org/Function_Reference/setup_postdata
        Sets up global post data. Helps to format custom query results for using Template tags.
        setup_postdata() fills the global variables $id, $authordata, $currentday, $currentmonth, 
        $page, $pages, $multipage, $more, $numpages, which help many Template Tags work in the 
        current post context. It does not assign the global $post variable, but seems to expect 
        that its argument is a reference to it.
         */
        setup_postdata( $this->object );
    }

    /**
     * Pass any unknown varible calls to present{$variable} 
     * or fall through to the injected object.
     *
     * @param  string $var
     * @return mixed
     */
    public function __get($var)
    {
        $method = 'present' . str_replace(' ', '', ucwords(str_replace(array('-', '_'), ' ', $var)));

        if (method_exists($this, $method))
        {
            return $this->$method();
        }

        if (get_class($this->object) == 'WP_Post')
        {
            return $this->object->$var;
        }
        else // WP_Query
        {
            return $this->object->post->$var;
        }
    }

    /**
     * Pass any uknown methods through to the inject object.
     *
     * @param  string $method
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->object, $method), $arguments);
    }

    /**
     * Retorna o post como array
     * @return array
     */
    public function toArray()
    {
        $methods = get_class_methods($this);
        $objArray = array();

        foreach ($methods as $m)
        {
            $part = str_replace('present', '', $m);

            if (in_array($part, $this->toArray))
            {
                $objArray[lower($part)] = $this->$m();
            }
        }

        return $objArray;
    }

    /**
     * ==========================================================
     * ==========================================================
     * ==========================================================
     * Acesso as informações do post através dos 'presenters' 
     * e métodos personalizados
     * ---------------------------------------------------------
     */

    /**
     * Retorna a hora no formato padrão definido no admin
     * @see http://codex.wordpress.org/Function_Reference/get_the_time
     * @return string
     */
    public function presentTime()
    {
        return esc_attr(get_the_time('', $this->ID));
    }

    /**
     * Retorna a data no formato definido no admin
     * @return string
     */
    public function presentDate()
    {
        return esc_html(mysql2date(get_option('date_format'), $this->post_date));
    }

    /**
     * Retorna a url para listagem de posts do mesmo mês e ano
     * @return string
     */
    public function presentDateUrl()
    {
        return get_month_link(get_the_time('Y', $this->ID), get_the_time('m', $this->ID));
    }

    /**
     * Retorna o título
     * @return string
     */
    public function presentTitle()
    {
        return esc_attr($this->post_title);
    }

    /**
     * Retorna o nome para url
     * @return string
     */
    public function presentSlug()
    {
        return $this->post_name;
    }

    /**
     * URL completa do post
     * @return string
     */
    public function presentPermalink()
    {
        return get_permalink($this->ID);
    }
    
    /**
     * Retorna o resumo do post
     * @return string
     */
    public function presentExcerpt()
    {
        return get_the_excerpt();
    }

    /**
     * Conteúdo do post
     * @return string
     */
    public function presentContent()
    {
        // aplica filtros
        $content = apply_filters('the_content', get_the_content());
        $content = str_replace(']]>', ']]&gt;', $content);
        return $content;
    }

    /**
     * Retorna posts relacionados... na mesma categoria
     * Excluindo próprío post
     * 
     * @param int $limit -1 = sem limite
     * @return \WP_Query
     */
    public function getRelated($limit = -1)
    {
        $args = '';

        $args = wp_parse_args($args, array(
            'showposts' => $limit,
            'post__not_in' => array($this->ID),
            'ignore_sticky_posts' => 0,
            'category__in' => wp_get_post_categories($this->ID)
        ));

        $query = new WP_Query($args);

        return $query;
    }

    /**
     * Retorna a página mãe como um objeto Wpost
     * @return \self
     */
    public function presentParent()
    {
        if ((int) $this->post_parent === 0)
        {
            return false;
        }
        $parent = get_post($this->post_parent);
        return new self($parent);
    }

    /**
     * Retorna array de objetos com as categorias a que o post pertence
     * stdClass Object
      (
      [term_id] => 4
      [name] => Pintura
      [slug] => pintura
      [term_group] => 0
      [term_taxonomy_id] => 4
      [taxonomy] => category
      [description] =>
      [parent] => 3
      [count] => 6
      [permalink] => http://localhost/wordpress/category/arte/pintura/
      )
     * @return array
     */
    public function presentCategory()
    {        
        // posts regulares 
        if($this->object->post_type === 'post' || $this->object->post_type === 'page')
        {
            $categories = $this->getRegularCategories();
        }
        // é custom post type
        else 
        {
            $categories = $this->getTerms();
        }

        return $categories;
        
    }

    /**
     * Retorna um array de objetos das categorias de posts regulares como "post" e "page"
     * @see  presentCategory()
     * @return array
     */
    public function getRegularCategories()
    {
        $args = array(
            'fields' => 'all',
            'orderby' => 'name',
            'order' => 'ASC'
        );
        $categories = wp_get_post_categories($this->ID, $args);

        if (count($categories) == 0 || !$categories)
        {
            return false;
        }

        $cats = array();
        foreach ($categories as $c)
        {
            $c->permalink = get_category_link($c->term_id);
            $cats[] = $c;
        }

        return $cats;
    }

    /**
     * @todo
     * Retorna um array de objetos de categorias de custom post types
     * @see  presentCategory()
     * @return [type] [description]
     */
    public function getTerms()
    {

    }

    /**
     * Retorna um array com as categorias do conteúdo de um tipo de taxonomia
     * @param  string $taxonomy 
     * @return array 
     */
    public function getCategoriesType($taxonomy = '')
    {
        $categories = wp_get_post_terms($this->ID, $taxonomy);
        $cats = array();
        foreach ($categories as $c)
        {
            $c->permalink = get_term_link($c, $c->taxonomy);
            $cats[] = $c;
        }
        return $cats;
    }

    /**
     * Retorna páginas diretamente filhas como um array de objetos Wpost()
     * @return \Wpost|boolean
     */
    public function presentChildren()
    {

        $all_wp_pages = new WP_Query(array(
            'post_type' => 'page',
            'post_parent' => $this->ID,
            'post_status' => 'publish',
            'orderby' => 'menu_order',
            'order' => 'ASC'
                )
        );

        if (count($all_wp_pages->posts) > 0)
        {
            $posts = array();
            foreach ($all_wp_pages->posts as $p)
            {
                $posts[] = new self($p);
            }
            return $posts;
        }

        return false;
    }

    /**
     * Retorna objeto com dados do post type
     * @link http://codex.wordpress.org/Function_Reference/get_post_type_object
     * @return object
     */
    public function presentPostType()
    {
        return get_post_type_object(get_post_type( $this->ID ));
    }

    /**
     * Presenter que retorna breadcrumb como array e nome da página inicial "Início"
     * @see  breadcrumb()
     * @return array
     */
    public function presentBreadcrumb()
    {
        return $this->breadcrumb('Início');
    }

    /**
     * Retorna o breadcrumb do post ou página
     * @param  boolean|string $overWriteHome Nome da página inicial
     * @return array                 Array com 'title' e 'url' das páginas
     */
    public function breadcrumb($overWriteHome = false) {

        $b = array();

        if (!is_front_page()) 
        {
            $b[] = array(
                'title' => ($overWriteHome) ? $overWriteHome : get_bloginfo('name'),
                'url' => get_option('home')
            );

            if ( is_category() || is_single() ) 
            {
                if($this->category)
                {
                    foreach($this->category as $c)
                    {
                        $b[] = array(
                            'title' => $c->name,
                            'url' => $c->permalink
                        );
                    }
                }                

                if ( is_single() ) 
                {
                    $b[] = array(
                        'title' => $this->title,
                        'url' => false
                    );
                }

            } 
            elseif( is_date() )
            {
                $b[] = array(
                        'title' => get_the_time('F \d\e Y'),
                        'url' => false
                    );
            }
            elseif ( is_page() && $this->post_parent ) 
            {
                for ($i = count($this->ancestors)-1; $i >= 0; $i--) 
                {
                    $b[] = array(
                        'id' => $this->ancestors[$i],
                        'title' => get_the_title($this->ancestors[$i]),
                        'url' => get_permalink($this->ancestors[$i])
                    );
                }

                $b[] = array(
                    'title' => $this->title,
                    'url' => false
                );

            } 
            elseif (is_page())
            {
                $b[] = array(
                    'title' => $this->title,
                    'url' => false
                );
            } 
            elseif (is_404())
            {
                $b[] = array(
                    'title' => "404",
                    'url' => false
                );
            }
        } 
        else 
        {
            $b[] = array(
                'title' => ($overWriteHome) ? $overWriteHome : get_bloginfo('name'),
                'url' => false
            );
        }
        return $b;
    }


    /**
     * Retorna array de tags como objetos:
     * stdClass Object
      (
      [term_id] => 20
      [name] => futuro
      [slug] => futuro
      [term_group] => 0
      [term_taxonomy_id] => 21
      [taxonomy] => post_tag
      [description] =>
      [parent] => 0
      [count] => 1
      [permalink] => http://localhost/wordpress/tag/futuro/
      )
     * @return boolean
     */
    public function presentTags()
    {
        $args = array(
            'fields' => 'all',
            'orderby' => 'name',
            'order' => 'ASC'
        );
        $tags = wp_get_post_tags($this->ID, $args);

        if (count($tags) == 0 || !$tags)
        {
            return false;
        }


        $cats = array();
        foreach ($tags as $c)
        {
            $c->permalink = get_tag_link($c->term_id);
            $cats[] = $c;
        }

        return $cats;
    }

    /**
     * ==========================================================
     * Sobre imagens
     * ---------------------------------------------------------
     */

    /**
     * Imagem destacada no tamanho 'thumbnail'
     * @param string $size
     * @param array $attr
     * @return string
     */
    public function presentThumb()
    {
        return $this->thumbSize('thumbnail');
    }

    /**
     * Retorna a imagem em destaque com o tamanho personalizado
     * @param string $size
     * @param array $attr
     * @return string
     */
    public function thumbSize($size = 'thumbnail', $attr = null)
    {
        $img = wp_get_attachment_image_src(get_post_thumbnail_id($this->ID), $size);

        return $img[0];
    }

    /**
     * Retorna as galerias do post como array
     * @return array
     */
    public function presentGallery()
    {
        return $this->gallery('thumbnail', 'array');
    }

    /**
     * Retorna as imagens da galeria do post
     * Formato:
     * array(5) {
        ['url']=> "http://localhost/wordpress/wp-content/uploads/DSC02435-150x150.jpg"
        ['width']=> 150
        ['height']=> 150
        ['resized']=> true // true if $url is a resized image, false if it is the original.
        ["title"]=> "Título da imagem"
       }
     * @param string $size
     * @param string $format Retorna array com tags <img>
     * @return string|array
     */
    public function gallery($size = 'thumbnail', $format = 'array', $limit = -1)
    {
        $return = array();
        if ($images = get_posts(array(
            'post_parent' => $this->ID,
            'post_type' => 'attachment',
            'numberposts' => $limit,
            'post_status' => null,
            'post_mime_type' => 'image',
            'orderby' => 'menu_order',
            'order' => 'ASC',
                )))
        {

            foreach ($images as $image)
            {
                if ($format == 'array')
                {
                    $img = wp_get_attachment_image_src($image->ID, $size, false);
                    $i = array();
                    $i['url'] = $img[0];
                    $i['width'] = $img[1];
                    $i['height'] = $img[2];
                    $i['resized'] = $img[3];
                    $i['title'] = $image->post_title;
                    $return[] = $i;
                }
                else if ($format == 'html')
                {
                    $return[] = wp_get_attachment_image($image->ID, $size, false);
                }
            }
            return $return;
        }
        else
        {
            return false;
        }
    }

    /**
     * ====================================================
     * Sobre o Autor
     * ----------------------------------------------------
     */

    /**
     * Retorna um objeto com os dados do autor combinados
     */
    public function presentAuthor()
    {
        $a = new stdClass();
        $a->id = $this->presentAuthorId();
        $a->avatar = $this->presentAvatar();
        $a->name = $this->presentAuthorName();
        $a->email = $this->presentAuthorEmail();
        $a->description = $this->presentAuthorDescription();
        $a->url = $this->presentAuthorUrl();

        return $a;
    }

    /**
     * Retorna o ID do autor
     * @return int
     */
    public function presentAuthorId()
    {
        return get_the_author_meta('ID');
    }

    /**
     * Retorna a tag <img> com o gravatar padrão
     * @return string
     */
    public function presentAvatar()
    {
        return $this->avatar();
    }

    /**
     * Retorna a tag <img> com o gravatar
     * @param int $size Tamanho
     * @param string $default Imagem alternativa se avatar não existir
     * @param string $alt Texto alternativo da imagem
     * @return string
     */
    public function avatar($size = 96, $default = '', $alt = false)
    {
        return get_avatar($this->presentAuthorEmail(), $size, $default, $alt);
    }

    /**
     * Retorna a url para posts do autor
     * @return string
     */
    public function presentAuthorUrl()
    {
        return esc_url(get_author_posts_url($this->presentAuthorId()));
    }

    /**
     * Retorna o nome do autor
     * @return string
     */
    public function presentAuthorName()
    {
        return get_the_author();
    }

    /**
     * Retorna o e-mail do autor
     * @return string
     */
    public function presentAuthorEmail()
    {
        return get_the_author_meta('user_email');
    }

    /**
     * Retorna a descrição do autor
     * @return string
     */
    public function presentAuthorDescription()
    {
        return get_the_author_meta('description');
    }
    
    /**
     * Retorna o meta dado com a chave passada como argumento
     * @param  string  $metaKey Chave do metadado
     * @param  boolean $single  Se retorna um array de valores, ou string punica
     * @return mixed
     */
    public function getMeta($metaKey = '', $single = true)
    {
        $meta_values = get_post_meta( $this->ID, $metaKey, $single );
        return $meta_values;
    }

}
