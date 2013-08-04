<?php
/**
 * Wrapper para looping de páginas
 * 
 * <code>
 * // instancia páginas
 * $pages = new Wpage();
 * // retorna todas as páginas filhas
 * $children = $pages->childrenOf((is_subpage())?is_subpage():$post->ID);
 * 
 * foreach ($children as $page):
 *  
 *  // wrapper para cada pagina
 *  $p = new Wpost($page);
 * 
 * endforeach;
 * </code>
 * 
 * @package OOWPtheme
 * @subpackage libraries
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
class Wpage extends WP_Query {

    private $pages = null;
    public $id;
    public $authorId;
    public $date;
    public $dateGmt;
    public $updatedAt;
    public $content;
    public $title;
    public $excerpt;
    public $status;
    public $commentStatus;
    public $commentCount;
    public $slug;
    public $parentId;
    public $guid;
    public $postType;
    public $mimeType;
    public $menuOrder;
    public $thumb;
    public $uri;

    public function __construct($query = '')
    {
        parent::__construct($query);
    }

    public function all()
    {
        if ($this->pages === null)
        {
            $this->pages = $this->query(array('post_type' => 'page'));
        }

        return $this->pages;
    }

    public function childrenOf($pageId)
    {

        $all_wp_pages = $this->query(array(
            'post_type' => 'page',
            'post_parent' => $pageId,
            'orderby' => 'menu_order',
            'order' => 'ASC')
        );
        
        return $all_wp_pages;
//        return get_page_children($pageId, $this->all());
    }

}