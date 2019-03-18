<?php
/**
 * List of cursos
 *
 * @package OOWPtheme
 */

get_header();

// current category slug
$current_tax = get_query_var('eventos_categoria');
$current_tax = get_term_by('slug', $current_tax, $wp_query->query_vars['taxonomy']);
//d($current_tax);
?>

    <h2 class="title-tab">
        Eventos
        <?php if($current_tax):
            echo ' &gt; '. $current_tax->name;
        endif;?>
    </h2>


    <div class="content">


        <div class="row-fluid">

            <div class="span9 content-pad">


                <?php
                if (have_posts()) :

                    $i = 0;
                    while (have_posts()) : the_post();

                        $p = new Evento();

                        get_template_part('loop', 'evento');

                    endwhile;

                else :
                    ?>

                    <p>Nada encontrado</p>

                <?php
                endif; // end have_posts() check
                ?>

            </div>

            <div class="span3">

                <?php
                $t = new Citacao();
                $cit = $t->tag('todas,curso,evento,eventos,cursos');

                if ($cit):
                    ?>

                    <div class="media-vertical theme-<?php echo rand(1, 5)?> clearfix">

                        <?php if($cit->thumb):?>
                            <div class="pull-left">
                                <img class="media-object" src="<?php echo $cit->thumb?>">
                            </div>
                        <?php endif;?>
                        <div class="media-body">

                            <div class="media-desc">
                                <?php echo $cit->content?>
                            </div>

                        </div>
                    </div>

                <?php
                endif;
                ?>


            </div>


        </div>

        <?php echo oowp_pagination(); ?>

    </div>


<?php get_footer(); ?>