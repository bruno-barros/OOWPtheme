<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WPtheme
 */
?>

<div class="over-footer row">
    <div class="span4">

        <?php
        // facebook
        if (is_active_sidebar('sidebar-2')):
            dynamic_sidebar('sidebar-2');
        endif;
        ?>

    </div>

    <div class="span8">

        <div class="content-blue">

            <?php
            $news = new NovidadeCollection(array(
                'posts_per_page' => 2
            ));

            if ($news->count()):
                foreach ($news->posts as $new):
                    $n = new Novidade($new, true);
                    ?>

                    <a class="media-horizontal clearfix" href="<?php echo $n->permalink ?>">

                        <?php if($n->thumb):?>
                        <div class="pull-left">
                            <img class="media-object" src="<?php echo $n->thumb ?>">
                        </div>
                        <?php endif;?>

                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $n->title ?></h4>

                            <div class="media-desc">
                                <?php echo $n->excerpt ?>
                            </div>

                            <span class="btn btn-small btn-warning">saiba mais</span>

                        </div>
                    </a>

                <?php
                endforeach;
            endif;
            ?>


        </div>

    </div>
</div>
<!--over-footer-->


<footer id="footer" class="row">

    <div class="span12">
        <?php
        /** ========================================================================
         *    Menu footer
         * ------------------------------------------------------------------------
         */
        io('menuFooter')->render();
        ?>
    </div>

    <div class="span12">

        <div class="footer-center">
            <a href="http://www.omb.org.br">www.omb.org.br</a> • <a href="mailto:omb@omb.org.br">omb@omb.org.br</a>
        </div>

        <div class="footer-left">
            <img src="<?php echo img_folder('logo-omb-pb.png') ?>" alt="OMB"/>
        </div>

        <div class="footer-right">
            <a href="http://foliocomunica.com.br" class="credits"><img src="<?php echo img_folder('folio.png') ?>"
                                                                       alt="Fólio Comunicação"/></a>
        </div>

        <div class="footer-copy">
            Todos os direitos reservados &copy; <?php echo date("Y") ?> - Organização Montessori do Brasil
        </div>

    </div>


</footer>


<?php wp_footer(); ?>


</div>
<!--hole-site-wrapper-->

</body>
</html>