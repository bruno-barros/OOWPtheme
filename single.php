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
        $obj = get_post_type_object( $wp_query->query['post_type'] );
        if($obj)
        {
            echo $obj->labels->name;
        }
        else
        {
            echo 'Novidades';
        }
        ?>
    </h2>


    <div class="content -content-pad">


        <div class="row-fluid">


            <div class="span9">


                <?php
                if (have_posts()) :

                    $i = 0;
                    while (have_posts()) : the_post();

                        $p = new Novidade();

                        get_template_part('content', 'post');

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

            <div class="span3">


                <?php
                $obj = get_post_type_object( $wp_query->query['post_type'] );
                if(isset($wp_query->query['post_type']))
                {
                    get_template_part('sidebar', $wp_query->query['post_type']);
                }
                else
                {
                    get_template_part('sidebar', 'novidades');
                }
                ?>



            </div>


        </div>

        <?php echo oowp_pagination(); ?>

    </div>


<?php get_footer(); ?>