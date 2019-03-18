<?php
/**
 * List of cursos
 *
 * @package OOWPtheme
 */

get_header();

//$categories = get_terms('escolas_categoria', array(
//    'child_of' => 6,
//    'hierarchical' => false,
//    'parent' => 0
//));
//dd($categories);

?>
    <script>
        jQuery(document).ready(function($){

            $('a', '.page-submenu').on('click', function(e){
                e.preventDefault();
//                console.log();
                $.scrollTo($(this).attr('href'), 1000, {offset:-50});

            });

        });
    </script>

    <h2 class="title-tab">
        Escolas
    </h2>


    <div class="content">


        <div class="row-fluid">

            <div class="span3">

                <?php

                // current category slug
                $current_tax = get_query_var('escolas_categoria');
                $current_tax = get_term_by('slug', $current_tax, $wp_query->query_vars['taxonomy']);


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
                            <li class="<?php echo ($c->slug == $current_tax->slug) ? 'active' : '' ?>">
                                <a href="<?php echo $c->permalink ?>"><?php echo $c->name ?></a>

                                <?php
                                // show the states of the active region
                                if ($c->slug == $current_tax->slug):

                                    $subCats = new EscolaCategory(array(
                                        'child_of'     => $c->term_id,
                                        'hierarchical' => false,
                                        'hide_empty'   => false,
                                        'parent'       => ''
                                    ));

                                    $subChildren = $subCats->getAll();

                                    if ($subChildren):
                                        ?>
                                        <ul class="unstyled page-submenu">

                                            <?php
                                            foreach ($subChildren as $sc):
                                                if($sc->parent != $c->term_id)
                                                {
                                                    continue;
                                                }
                                                ?>
                                                <li><a href="#<?php echo $sc->slug?>"><?php echo $sc->name?></a></li>
                                            <?php
                                            endforeach;
                                            ?>

                                        </ul>
                                    <?php
                                    endif;
                                endif;
                                ?>


                            </li>
                        <?php
                        endforeach;
                        ?>
                    </ul>
                <?php
                endif;
                ?>


            </div>

            <div class="span6 -content-pad">

                <h1 class="page-title">Escolas Montessorianas na região <?php echo $current_tax->name ?></h1>

                <?php

                $states = new Wcategory($current_tax->term_id, array(
                    'taxonomy'  => 'escolas_categoria',
                    'post_type' => 'escolas'
                ));

                $statesChildren = $states->children();

                //                d($current_tax->term_id);

                /*
                 * loop though states
                 */
                foreach ($statesChildren as $s):

                    if ($s->parent == $current_tax->term_id)
                    {
                        echo "<div id=\"{$s->slug}\" class=\"state-div\">{$s->name}</div>";

                        /**
                         * loop though cities
                         */
                        foreach ($statesChildren as $c):

                            if ($c->parent == $s->term_id)
                            {
                                echo "<div class=\"city-div\">{$c->name}</div>";

                                $city = new Wcategory($c->term_id, array(
                                    'taxonomy'  => 'escolas_categoria',
                                    'post_type' => 'escolas'
                                ));

                                $cityScools = $city->posts();

                                if ($cityScools->count()):

                                    // ordering
                                    $order = array();

                                    foreach ($cityScools->posts as $k => $o)
                                    {
                                        $order[$k] = $o->post_title;
                                    }

                                    array_multisort($order, SORT_ASC, $cityScools->posts);
                                    // end ordering

                                    foreach ($cityScools->posts as $school):

                                        $sc = new Escola($school, false);

                                        echo "<h2 class=\"school-title\">{$sc->title}</h2>";
                                        echo "<div class=\"school-content\">{$sc->content}</div>";


                                    endforeach;

                                endif;
                            }

                        endforeach;
                    }

                endforeach;

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