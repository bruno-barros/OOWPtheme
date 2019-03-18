<?php

global $p;
?>

<div class="span3">

    <a class="media-vertical clearfix" href="<?php echo $p->permalink?>">

        <?php if($p->thumb):?>

        <div class="pull-left">
            <img class="media-object" src="<?php echo $p->thumb?>">
        </div>

        <?php else:?>

        <div class="top-bar"></div>

        <?php endif;?>

        <div class="media-body">

            <h4 class="media-heading"><?php echo $p->title?></h4>

            <div class="media-desc">
                <?php echo $p->excerpt?>
            </div>

        </div>
    </a>

</div>