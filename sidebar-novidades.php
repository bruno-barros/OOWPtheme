<?php

global $p;

$related = new NovidadeCollection(array(
    'posts_per_page' => 4
));

if ($related->count()):
    ?>

    <div class="related clearfix">

        <h4 class="related-title">Outras notícias</h4>

        <?php
        foreach ($related->posts as $rel):

            $r = new Novidade($rel, false);

            if($r->ID == $p->ID)
            {
                continue;
            }
            ?>

            <a class="media-vertical clearfix" href="<?php echo $r->permalink?>">

                <?php if($r->thumb):?>

                    <div class="pull-left">
                        <img class="media-object" src="<?php echo $r->thumb?>">
                    </div>

                <?php else:?>

                    <div class="top-bar"></div>

                <?php endif;?>

                <div class="media-body">

                    <h4 class="media-heading"><?php echo $r->title?></h4>



                </div>
            </a>
        <?php
        endforeach;
        ?>

        <a href="<?php echo site_url('novidades')?>" class="btn btn-primary">mais novidades</a>

    </div>

<?php
endif;
?>