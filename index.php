<?php
/**
 * The main template file.
 *
 * @package OOWPtheme
 */

get_header();
?>

    <h2 class="title-tab">

        <?php
        if(is_category())
        {
            $c = get_category(get_queried_object());
            echo $c->name;
        }
        else if($wp_query->query['post_type'] == 'post')
        {
            echo 'Novidades';
        }
        else{

            $obj = get_post_type_object( $wp_query->query['post_type'] );
            echo $obj->labels->name;
        }
        ?>
    </h2>


    <div class="content content-pad">


        <div class="row-fluid">




                <?php
                if (have_posts()) :

                    $i = 0;
                    while (have_posts()) : the_post();

                        $p = new Novidade();

                        get_template_part('content', 'box');

                        if ($i == 3)
                        {
                            $i = 0;
                            echo '</div><div class="row-fluid">';
                        }
                        else
                        {
                            $i++;
                        }

                    endwhile;

                else :
                    ?>

                    <p>Nada encontrado</p>

                <?php
                endif; // end have_posts() check
                ?>




        </div>

        <?php echo oowp_pagination();?>

    </div>


<?php get_footer(); ?>