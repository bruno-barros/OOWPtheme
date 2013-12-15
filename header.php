<?php
/**
 * The Header for our theme.
 *
 *
 * @package OOWPtheme
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="pt-BR" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="pt-BR" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="pt-BR" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="pt-BR" class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width" />

<title><?php wp_title( '&gt;', true, 'right' )?> <?php bloginfo('name')?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!--[if lt IE 9]>
<script src="<?php echo js_folder('html5shiv.respond.min.js'); ?>" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php 

//var_dump(get_template_directory_uri());

?>

<header id="header" class="row">

	<div class="container">
		
		<div class="row">
			
			<div class="span12 well">
				
				<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
				/** ========================================================================
				 * 	Escreve HTML do menu personalizado
				 * ------------------------------------------------------------------------
				 */
				io('menuPrincipal')->render();
				?>

				<p><?php echo bbec_current_edition('name')?></p>
			</div>

		</div><!-- row -->

	</div><!-- container -->

</header>
<!-- #header -->