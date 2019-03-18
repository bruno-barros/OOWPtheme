<?php
global $p;
?>

<article class="curso-item clearfix">

    <a class="media" href="<?php echo $p->permalink?>">
        <div class="pull-left">

            <div class="dia"><?php echo $p->dia1?></div>
            <div class="mes"><?php echo $p->mes1?></div>


        </div>
        <div class="media-body">
            <h4 class="media-heading"><?php echo $p->title?></h4>
            <p><?php echo $p->excerpt?></p>
        </div>
    </a>

</article>