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
            $this->object = new WP_Query(array('p' => $thePost));
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
     * Pass any unknown varible calls to present{$variable} or fall through to the injected object.
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
     * Imagem destacada
     * @param type $size
     * @param type $attr
     * @return type
     */
    public function presentThumb($size = 'thumbnail', $attr = null)
    {
        $img = wp_get_attachment_image_src(get_post_thumbnail_id($this->ID), $size);

        return $img[0];
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
     * Retorna os IDs das categorias a que o post pertence
     * @return array
     */
    public function presentCategory()
    {
        return wp_get_post_categories($this->ID);
    }
    
    public function presentChildren()
    {

        $all_wp_pages = new WP_Query(array(
            'post_type' => 'page',
            'post_parent' => $this->ID,
            'orderby' => 'menu_order',
            'order' => 'ASC')
        );
        
        if(count($all_wp_pages->posts) > 0)
        {
            return $all_wp_pages;
        }
        
        return false;
//        return get_page_children($pageId, $this->all());
    }

    

}