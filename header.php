<?php
/**
 * The Header for our theme.
 *
 *
 * @package OOWPtheme
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html lang="pt-BR" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html lang="pt-BR" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html lang="pt-BR" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="pt-BR" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width"/>

    <title><?php wp_title('&gt;', true, 'right') ?> <?php bloginfo('name') ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>

    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400italic,700italic,400,700' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
    <script src="<?php echo js_folder('html5shiv.respond.min.js'); ?>" type="text/javascript"></script>
    <![endif]-->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php

//var_dump(get_template_directory_uri());

?>

<div class="hole-site-wrapper container">

    <header id="header" class="-container">


        <div class="row">

            <div class="span12">


                <div class="logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img src="<?php echo img_folder('logo-omb.png')?>" alt="<?php bloginfo('name'); ?>"/>
                </a>
                </div>

                <div class="maria"></div>

                <div class="navbar header-menu">
                    <div class="navbar-inner">
                        <div class="container">

                            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </a>

                            <!-- Everything you want hidden at 940px or less, place within here -->
                            <div class="nav-collapse collapse">
                                <?php
                                /** ========================================================================
                                 *    Escreve HTML do menu personalizado
                                 * ------------------------------------------------------------------------
                                 */
                                io('menuPrincipal')->render();
                                ?>
                            </div>

                        </div>
                    </div>
                </div>




            </div>

        </div>
        <!-- row -->


    </header>
    <!-- #header -->