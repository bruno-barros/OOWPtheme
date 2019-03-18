<?php
/**
 * HOMEPAGE
 */
get_header();
?>

    <div class="home-slider">
        <?php
        /*
         * home slider
         */
        echo do_shortcode("[metaslider id=46]");
        ?>
    </div>

<?php
$featured = new HomeFeatured();
$featuredResults = $featured->get();
if ($featuredResults->count()):
    ?>

    <!--<h2 class="title-tab"><a href="#">Montessori</a></h2>-->
    <h2 class="title-tab">Montessori</h2>
    <div class="content content-pad">

        <div class="row-fluid">

            <?php

            foreach ($featuredResults->posts as $featPage):

                $f = new Wpost($featPage, false);
                ?>

                <div class="span4">

                    <a class="media-vertical light clearfix" href="<?php echo $f->permalink?>">

                        <?php if($f->thumb):?>
                        <div class="pull-left">
                            <img class="media-object" src="<?php echo $f->thumb ?>">
                        </div>
                        <?php endif;?>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $f->title?></h4>

                            <div class="media-desc">
                                <?php echo $f->excerpt?>
                            </div>

                        </div>
                    </a>

                </div>

            <?php
            endforeach;
            ?>

        </div>

    </div>
    <!--content-->
<?php
endif;
?>


<?php
get_footer();
?>