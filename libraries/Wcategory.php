<?php 
/**
 * Wrapper para categoria
 * 
 * <code>
 * 
 * // instancia categoria
 * $cat = new Wcategory([obj|id|slug]);
 * // retorna atributos
 * $cat->name
 * $cat->permalink
 * 
 * </code>
 * 
 * @link http://codex.wordpress.org/Function_Reference/get_categories
 * @see Wcategories
 * @package OOWPtheme
 * @subpackage libraries
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
class Wcategory {

    /**
     * Instância da categoria
     * @var stdClass
     */
    protected $category;

    /**
     * Memória das categorias filhas
     * @var array
     */
    protected $children = array();

    /**
     * Dados de configuração
     * @see Wcategories
     * @var array
     */
    protected $config = array(
        'taxonomy' => 'category',
        'post_type' => 'post',
    );

    public function __construct($category = null, $config = array())
    {
        // primeiro seta configurações
        $this->config = array_merge($this->config, $config);

        if(is_numeric($category) || is_string($category))
        {
            $this->find($category);
        }
        else
        {
            $this->category = $category;            
        }


        // for chaining
        return $this;
    }

    /**
     * Retorna o atributo se existir, senão verifica se existe um método.
     * 
     * @param  string $name Nome do método ou atributo
     * @return stdClass
     */
    public function __get($name)
    {
        if(isset($this->category->$name))
        {
            return $this->category->$name;
        }
        else if (method_exists($this, $name))
        {
            return $this->$name();
        }

        throw new Exception("The category attribute [{$name}] does not existis.");
    }


    /**
     * Retorna objeto da categoria pelo ID ou slug.
     * 
     * @param  string|int $categorySlugOrId ID ou slug
     * @return Wcategory
     */
    public function find($categorySlugOrId = null)
    {
        if($categorySlugOrId === null)
        {
            return null;
        }

        if(is_numeric($categorySlugOrId))
        {
            $this->category = get_term_by('ID', $categorySlugOrId, $this->config['taxonomy']);
        }
        else
        {
            $this->category = get_term_by('slug', $categorySlugOrId, $this->config['taxonomy']);            
        }

        return $this;

    }

    /**
     * Retorna o ID da categoria.
     * 
     * @return int
     */
    public function id()
    {
        return $this->category->term_id;
    }


    /**
     * Retorna o "permalink" da categoria
     * @return string URL absoluta
     */
    public function permalink()
    {
        return get_term_link( $this->category, $this->config['taxonomy'] );
    }

    /**
     * Retorna um array com todas as categorias filhas
     * 
     * @param  boolean $all Se retorna todas os filhos e netos
     * @return array
     */
    public function children($all = true)
    {
        if(! empty($this->children))
        {
            return $this->children;
        }

        $this->children = get_terms($this->config['taxonomy'], 
            array(
                'child_of' => $this->id,
                'hide_empty' => !$all
            )
        );       

        return $this->children;
    }

    /**
     * Retorna o total de posts da categoria.
     * Com ou sem as categorias filhas.
     * 
     * @param  string $children Conta os posts diretamente filhos, ou de subcategorias
     * @return int
     */
    public function postsCount($children = '')
    {
        if($children === 'all')
        {
            $count = $this->count;
            $chl = $this->children();

            if($chl)
            {
                foreach ($chl as $tax_term) {
                    $count +=$tax_term->count;
                }                
            }
            return $count;

        }
        else
        {
            return $this->count;
        }
    }


    /**
     * Retorna os posts da categoria.
     * 
     * @param  string $children Inclui subcategorias?
     * @param  string $limit    Quantidade de posts
     * @return array
     */
    public function posts($children = '', $limit = -1)
    {
        if(is_numeric($children))
        {
            $limit = $children;
        }

        // inclusive das categorias filhas
        $args = array(
            'posts_per_page' => $limit,
            'post_type' => $this->config['post_type'],
            'tax_query' => array(
                array(
                    'taxonomy' => $this->config['taxonomy'],
                    'field' => 'id',
                    'terms' => array($this->id),
                    'include_children' => ($children === 'all') ? true : false
                )
            )
        );
       
        return new Wcollection($args);
    }

}