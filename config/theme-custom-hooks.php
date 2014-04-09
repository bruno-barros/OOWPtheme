<?php
/**
 * Configurações e personalizações
 *
 * @package OOWPtheme
 * @subpackage config
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 *
 */

/** ========================================================================
 *     Post support
 *     Adiciona funcionalidades, como imagem destacada
 * @link http://codex.wordpress.org/add_theme_support
 * ------------------------------------------------------------------------
 */
add_theme_support('post-thumbnails');

/**
 * =======================================================
 * remove inline css on post gallery
 */
add_filter('use_default_gallery_style', '__return_false');

/**
 * ========================================================
 * modify the gallery template
 * append and prepend html content
 */
add_filter('post_gallery', 'my_post_gallery', 10, 2);
function my_post_gallery($output, $attr)
{
    //    global $post, $wp_locale;
    //dd($output);

    static $instance = 0;
    $instance++;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if (isset($attr['orderby']))
    {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
        {
            unset($attr['orderby']);
        }
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ('RAND' == $order)
    {
        $orderby = 'none';
    }

    if (!empty($include))
    {
        $include      = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val)
        {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }
    elseif (!empty($exclude))
    {
        $exclude     = preg_replace('/[^0-9,]+/', '', $exclude);
        $attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
    }
    else
    {
        $attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
    }

    if (empty($attachments))
    {
        return '';
    }

    if (is_feed())
    {
        $output = "\n";
        foreach ($attachments as $att_id => $attachment)
        {
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        }

        return $output;
    }

    $itemtag    = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns    = intval($columns);
    $itemwidth  = $columns > 0 ? floor(100 / $columns) : 100;
    $float      = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $output = apply_filters('gallery_style', "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns}'>");

    $i = 0;
    foreach ($attachments as $id => $attachment)
    {
        $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "
            <{$icontag} class='gallery-icon'>
                $link
            </{$icontag}>";
        if ($captiontag && trim($attachment->post_excerpt))
        {
            $output .= "
                <{$captiontag} class='gallery-caption'>
                " . wptexturize($attachment->post_excerpt) . "
                </{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
        if ($columns > 0 && ++$i % $columns == 0)
        {
            $output .= '<br style="clear: both" />';
        }
    }

    $output .= "<br style='clear: both;' /></div>\n";

    // before gallery
    $return = '';
    $return .= $output;
    // after gallery
    $return .= '';

    return $return;
}