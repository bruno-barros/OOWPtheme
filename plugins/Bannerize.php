<?php
/**
 * Classe que extende o plugin Wp Bannerize
 * @link http://wordpress.org/plugins/wp-bannerize/
 * 
 * <code>
 * // no functions.php
 * $bannerHome = new Bannerize('group=destaqueshome&random=1&limit=3');
 * 
 * // no template
 * io('bannerHome')->render();
 * </code> * 
 * 
 * @package OOWPtheme
 * @subpackage plugins
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */

require_once WP_PLUGIN_DIR . '/wp-bannerize/Classes/wpBannerizeFrontend.php';

class Bannerize extends WPBannerizeFrontend {

    private $opts;

    public function __construct($opts = null)
    {
        // super
        parent::WPBannerizeClass(__FILE__);

        // Load configurations options
        $this->options = get_option($this->options_key);

        // configurações na instanciação
        $this->opts = $opts;
    }

    public function render()
    {
        if (!is_null($this->opts))
        {
            echo $this->bannerize($this->opts);
        }
        else
        {
            $this->bannerize($this->opts);
        }
    }

    /**
     * Build HTML output
     *
     * @param $theArgs
     *   Array from comand line or widget
     *
     * group				If '' show all group, else code of group (default '')
     * no_html_wrap			Set to 1 for display only link and image tags
     * before				Before tag banner open (default <div>)
     * after				After tag banner close (default </div>)
     * random				Show random banner sequence (default '')
     * categories			Category ID separated by commas. (default '')
     * limit				Limit rows number (default '' - show all rows)
     *
     * @return mixed|string
     *   HTML Output: banner list to display
     *
     */
    public function bannerize($theArgs)
    {
        global $wpdb;

        // Default args key/value
        $default = array('group' => '',
            'container_class' => 'flexslider',
            'no_html_wrap' => '0',
            'random' => '',
            'categories' => '',
            'limit' => '',
            'before' => '<li>',
            'after' => '</li>'
        );

        // Merge
        $args = wp_parse_args($theArgs, $default);

        // Check first for category
        $categoriesID = $args['categories'];
        if (!is_array($categoriesID))
        {
            if ($categoriesID != '')
            {
                $categoriesID = explode(',', $args['categories']);
            }
        }
        // Fixed by http://wordpress.org/support/profile/schattenmann
        if (is_array($categoriesID) && count($categoriesID) > 0 && !is_category($categoriesID) &&
                !in_category($categoriesID)
        )
        {
            return;
        }

        $sql = "SELECT * FROM `" . $this->table_bannerize . "` WHERE `enabled` = '1' AND `trash` = '0' AND " .
                "(`maximpressions` = 0 OR `impressions` < `maximpressions`) AND " .
                "( (`start_date` < NOW() OR `start_date` = '0000-00-00 00:00:00' ) AND (`end_date` > NOW() OR `end_date` = '0000-00-00 00:00:00') ) ";

        // group
        if ($args['group'] != '')
        {
            $sql .= " AND `group` = '" . $args['group'] . "'";
        }

        // random
        if ($args['random'] != '')
        {
            $sql .= ' ORDER BY RAND()';
        }
        else
        {
            $sql .= ' ORDER BY `sorter` ASC';
        }

        // limit
        if ($args['limit'] != '')
        {
            $sql .= " LIMIT 0," . $args['limit'];
        }

        // Query
        $rows = $wpdb->get_results($sql);

        // Start buffering output
        ob_start();
        if (count($rows) > 0)
        {
            ?>
            <?php
            // Widget
            if (isset($args['before_widget'])) :
                ?>
                <?php
                echo $args['before_widget'];
                $title = apply_filters('widget_title', $args['title']);
                if ($title != '')
                {
                    echo $args['before_title'] . $title . $args['after_title'];
                }
                ?>
            <?php endif; ?>
            <?php if ($args['no_html_wrap'] == '0') : ?>
                <div class="<?php echo $args['container_class']?> <?php
                if ($args['group'] != '')
                {
                    echo $args['group'];
                }
                ?>"> <ul class="slides">
                    
                 <?php endif; ?>
                     <?php foreach ($rows as $row) : ?>
                         <?php
                         // Impressions
                         if ($this->options['impressionsEnabled'] == "1")
                         {
                             $sql =
                                     "UPDATE `" . $this->table_bannerize . "` SET `impressions` = `impressions`+1 WHERE id = " .
                                     $row->id;
                             $result = mysql_query($sql);
                         }
                         ?>
                         <?php
                         // Javascript Click count
                         $javascriptClickCounter = ( $this->options['clickCounterEnabled'] == '1' ) ?
                                 ' onclick="WPBannerizeJavascript.incrementClickCount(' . $row->id . ')" ' : '';
                         ?>
                         <?php
                         // Check for Adobe Flash, Image or free HTML text
                         if ($row->banner_type == kWPBannerizeBannerTypeFromLocal ||
                                 $row->banner_type == kWPBannerizeBannerTypeByURL
                         ) :
                             if ($row->mime == "application/x-shockwave-flash") :
                                 ?>
                            <div style="position:relative; z-index:0">
                                <a <?php echo $javascriptClickCounter ?> style="width:<?php echo $row->width ?>px; height:<?php echo $row->height ?>px;  position:absolute; z-index:999"
                                                                         href="<?php echo $row->url ?>" <?php
                        echo ( (
                        $row->nofollow == '1' ) ? 'rel="nofollow"' : '' )
                                 ?> <?php
                                echo ( (
                                $row->target != '' ) ? 'target="' . $row->target . '"' : '' )
                                ?>></a>
                                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                                        width="<?php echo $row->width ?>"
                                        height="<?php echo $row->height ?>">
                                    <param name="movie" value="<?php echo $row->filename ?>"/>
                                    <param value="<?php echo $this->options['comboWindowModeFlash'] ?>" name="wmode"/>
                                    <!--[if !IE]> -->
                                    <object data="<?php echo $row->filename ?>"
                                            width="<?php echo $row->width ?>"
                                            height="<?php echo $row->height ?>"
                                            type="application/x-shockwave-flash">
                                        <param value="<?php echo $this->options['comboWindowModeFlash'] ?>" name="wmode"/>
                                    </object>
                                    <!--<![endif]-->
                                </object>
                                <?php if ($row->use_description == '1') : ?>
                                    <br/>
                                    <span>
                                        <?php if ($this->options['linkDescription'] && $row->url != '') : ?>
                                            <a <?php echo $javascriptClickCounter ?> href="<?php echo $row->url ?>" <?php
                                echo ( (
                                $row->nofollow == '1' ) ? 'rel="nofollow"' : '' )
                                            ?> <?php
                                            echo ( ($row->target != '' ) ? 'target="' . $row->target . '"' : '' )
                                            ?>>
                                            <?php echo $row->description ?>
                                            </a>
                                            <?php
                                        else : echo $row->description;
                                        endif;
                                        ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <?php
                            if ($args['no_html_wrap'] == '0')
                            {
                                echo $args['before'];
                            }
                            ?>
                            <?php if ($row->url != '') : ?>
                                <a <?php echo $javascriptClickCounter ?> href="<?php echo $row->url ?>" <?php
                            echo ( (
                            $row->nofollow == '1' ) ? 'rel="nofollow"' : '' )
                                ?> <?php
                                echo ( (
                                $row->target != '' ) ? 'target="' . $row->target . '"' : '' )
                                ?>>
                                <?php endif; ?>
                                    <div class="img-limit">
                                <img src="<?php echo $row->filename ?>" alt="<?php echo $row->description ?>" />
                                </div>
                                     <?php if ($row->url != '') : ?>
                                </a>
                            <?php endif; ?>
                            <?php if ($row->use_description == '1') : ?>
                                <div class="description">
                                    <?php if ($this->options['linkDescription'] && $row->url != '') : ?>
                                        <a <?php echo $javascriptClickCounter ?> href="<?php echo $row->url ?>" <?php
                                echo ( (
                                $row->nofollow == '1' ) ? 'rel="nofollow"' : '' )
                                        ?> <?php
                                        echo ( (
                                        $row->target != '' ) ? 'target="' . $row->target . '"' : '' )
                                        ?>>
                                                                                 <?php echo $row->description ?>
                                        </a>
                                        <?php
                                    else : echo $row->description;
                                    endif;
                                    ?>
                                </div>
                            <?php endif; ?>
                            <?php
                            if ($args['no_html_wrap'] == '0')
                            {
                                echo $args['after'];
                            }
                            ?>
                        <?php endif; ?>
                        <?php
                    elseif ($row->banner_type == kWPBannerizeBannerTypeFreeHTML) :
                        ?>
                        <div><?php echo stripslashes($row->free_html); ?></div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if ($args['no_html_wrap'] == '0') : ?>
                </ul>
                </div>
            <?php endif; ?>
           
            <?php
            // Widget
            if (isset($args['after_widget'])) :
                ?>
                <?php echo $args['after_widget'] ?>
            <?php endif; ?>
            <?php
        } else
        {
            // Show form general setting something for NO Banner to display
            echo $this->options['wpBannerizeNoBannerHTMLMessage'];
        }
        $result = ob_get_contents();
        $result = str_replace("\t", '', $result);
        $result = trim($result);
        ob_end_clean();
        return $result;
    }

}