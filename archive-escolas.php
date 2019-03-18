<?php
/**
 * List of cursos
 *
 * @package OOWPtheme
 */

get_header();
?>

    <h2 class="title-tab">
        Escolas
    </h2>


    <div class="content">


        <div class="row-fluid">

            <div class="span3">

                <?php

                $cats = new EscolaCategory(array(
                    'hierarchical' => false,
                    'hide_empty'   => false,
                    'parent'       => 0
                ));

                $children = $cats->getAll();

                if ($children):
                    ?>

                    <ul class="unstyled page-menu">

                        <?php
                        foreach ($children as $c):
                            ?>
                            <li class=""><a
                                    href="<?php echo $c->permalink ?>"><?php echo $c->name ?></a></li>
                        <?php
                        endforeach;
                        ?>
                    </ul>
                <?php
                endif;
                ?>


            </div>

            <div class="span6 -content-pad">

                <?php
                $p = get_page_by_path('escolas');
                echo $p->post_content;
                ?>

            </div>

            <div class="span3">

                <?php
                $t = new Citacao();
                $cit = $t->tag('todas,escolas');

                if ($cit):
                    ?>

                    <div class="media-vertical theme-<?php echo rand(1, 5) ?> clearfix">

                        <?php if ($cit->thumb): ?>
                            <div class="pull-left">
                                <img class="media-object" src="<?php echo $cit->thumb ?>">
                            </div>
                        <?php endif; ?>
                        <div class="media-body">

                            <div class="media-desc">
                                <?php echo $cit->content ?>
                            </div>

                        </div>
                    </div>

                <?php
                endif;
                ?>


            </div>


        </div>

        <?php //echo oowp_pagination(); ?>

    </div>


<?php get_footer(); ?>