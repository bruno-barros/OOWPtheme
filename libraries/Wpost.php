<?php
/**
 * Wrapper para posts individuais
 * 
 * <code>
 * // dentro de um loop...
 * 
 * $p = new Wpost($post);
 * 
 * $p->thumb();
 * $p->title;
 * $p->slug;
 * $p->uri; // permalink
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

    private $post;
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
    public $thumb;
    public $uri;

//  ["guid"]=>
//  string(78) "http://localhost/aldeiamontessori.com.br/trunk/?post_type=chamadas&p=1643"
//  ["menu_order"]=>
//  int(0)
//  ["post_type"]=>
//  string(8) "chamadas"
//  ["post_mime_type"]=>
//  string(0) ""
//  ["comment_count"]=>
//  string(1) "0"
//  ["filter"]=>
//  string(3) "raw"

    public function __construct($thePost)
    {
        $this->post = $thePost;
        $this->setAttrbs();
        $this->setUri();

//        dd($this->post);
    }
    
    public function __call($name, $arguments = array())
    {
        if(isset($this->$name))
        {
            return $this->$name;
        }
    }

    public function setAttrbs()
    {
        $this->id = $this->post->ID;
        $this->authorId = $this->post->post_author;
        $this->date = $this->post->post_date;
        $this->dateGmt = $this->post->post_date_gmt;
        $this->updatedAt = $this->post->post_modified;
        $this->content = $this->post->post_content;
        $this->title = $this->post->post_title;
        $this->excerpt = $this->post->post_excerpt;
        $this->status = $this->post->post_status;
        $this->commentStatus = $this->post->comment_status;
        $this->commentCount = $this->post->comment_count;
        $this->slug = $this->post->post_name;
        $this->parentId = $this->post->post_parent;
        $this->guid = $this->post->guid;
        $this->postType = $this->post->post_type;
        $this->mimeType = $this->post->post_mime_type;
    }

    public function title()
    {
        return $this->post->post_title;
    }
    
    public function setPostThumbnail()
    {
        
    }
    
    public function thumb($size = 'thumbnail', $attr = null)
    {
        $img = wp_get_attachment_image_src( get_post_thumbnail_id($this->id), $size);

        return  $img[0];
//        return  get_the_post_thumbnail( $this->id, $size, $attr );
    }
    
    public function setUri()
    {
        $this->uri = get_permalink($this->id);
    }

}