<?php
/*
Template Name: Página com coluna de imagens
*/
get_header();

$p = new Wpost($post);

$parent = $p->parent;

$children = $p->children;


if($parent)
{
    $children = io('menuPrincipal')->toArray(array('children' => $parent->ID));
    //    $m1 = $children[1];
    //    dd($m1);
    //    $m1P = new Wpost($m1->object_id);
    //    dd($m1P->title );
}


if (!$children && $parent)
{
    $children = $parent->children;

    //    d($pareChild);
}


?>

    <h2 class="title-tab">
        <?php
        if ($parent)
        {
            echo $parent->title;
        }
        else
        {
            echo $p->title;
        }
        ?>

    </h2>
    <div class="content">


        <div class="row-fluid">

            <div class="span3">

                <?php
                if ($children):
                    ?>

                    <ul class="unstyled page-menu">

                        <?php
                        foreach ($children as $c):
                            ?>
                            <li class="<?php echo ($c->object_id == $p->ID) ? 'active' : '' ?>">
                                <a href="<?php echo $c->url ?>"><?php echo $c->title ?></a>
                            </li>

                        <?php
                        endforeach;
                        ?>
                    </ul>
                <?php
                endif;
                ?>


            </div>

            <div class="span6">

                <article class="post">

                    <h1 class="page-title"><?php echo $p->title ?></h1>

                    <?php echo $p->content ?>

                </article>

            </div>

            <div class="span3">

                <ul class="unstyled page-side-images">
                    <?php

                    $images = $p->gallery;
                    if ($images):
                    endif;
                    foreach ($images as $i):
                        ?>
                        <li><img src="<?php echo $i['url'] ?>" alt=""/></li>
                    <?php
                    endforeach;
                    ?>
                </ul>


            </div>

        </div>

    </div>


<?php

get_footer();
?>