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
//            dd($this->object);
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
     * Retorna o título
     * @return string
     */
    public function presentTitle()
    {
        return $this->post_title;
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
     * Conteúdo do post
     * @return string
     */
    public function presentContent()
    {
        return get_the_content();
    }

    /**
     * Retorna posts relacionados... na mesma categoria
     * Excluindo próprío post
     * 
     * @return \WP_Query
     */
    public function getRelated()
    {
        $args = '';

        $args = wp_parse_args($args, array(
            'showposts' => -1,
            'post__not_in' => array($this->ID),
            'ignore_sticky_posts' => 0,
            'category__in' => wp_get_post_categories($this->ID)
        ));

        $query = new WP_Query($args);

        return $query;
    }

    /**
     * Retorna a páginas mãe como um objeto Wpost
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
     * @return array
     */
    public function presentCategory()
    {
        $args = array(
            'fields' => 'all',
            'orderby' => 'name', 
            'order' => 'ASC'
            );
        $categories = wp_get_post_categories($this->ID, $args);
        
        if(count($categories) == 0 || !$categories)
        {
            return false;
        }
        
        $cats = array();
        foreach($categories as $c)
        {
            $c->permalink = get_category_link( $c->term_id );
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
            foreach($all_wp_pages->posts as $p)
            {
                $posts[] = new self($p);
            }
            return $posts;
        }

        return false;
    }
    
    public function presentTags()
    {
        $args = array(
            'fields' => 'all',
            'orderby' => 'name', 
            'order' => 'ASC'
            );
        $tags = wp_get_post_tags($this->ID, $args);
        
        if(count($tags) == 0 || !$tags)
        {
            return false;
        }
        
        
        $cats = array();
        foreach($tags as $c)
        {
            $c->permalink = get_tag_link( $c->term_id );
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
                    $return[] = wp_get_attachment_image_src($image->ID, $size, false);
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
        return the_author_meta('description');
    }

}