<?php
/**
 * Modelo para formulário.
 *
 * @package OOWPtheme
 */

get_header();

/** ========================================================================
 *    Processa envio de formulário
 * ------------------------------------------------------------------------
 */
if(was_form_sent()){
    // OK, vamos enviar!
    $m = new Wmail();
    $m->setTemplate('email');
    $m->setTemlateVars(array(
        'nome' => $_POST['nome']
    ));
    $m->setSubject('contato');
    $m->respondTo($_POST['email'], $_POST['nome']);
//    $m->setAttachment('file');
    $m->send();
    $m->redirect();
}
?>

<div id="page">
	
	<div class="container">
		
		<div class="row">

			<div id="main" class="span9 site-content" role="main">


			<?php 
			/*
			|=================================================================================
			|	Se existe página
			|---------------------------------------------------------------------------------
			*/
			$page = new Wpost();
			?>
			<h1 class="page-title"><?php echo $page->title ?></h1>
			<?php echo $page->content?>

			<br>
			<br>

			<?php 
            /** ========================================================================
             *     Retorno do envio
             * ------------------------------------------------------------------------
             */
            if(form_returned_success()):
            ?>
            <div class="alert alert-success animated bounceInDown">
                <b>Mensagem enviada com sucesso.</b>
            </div>
            <?php 
            endif;
            if(form_returned_error()):
            ?>
            <div class="alert alert-error animated bounceInDown">
                <p><b>Houve um erro ao enviar sua mensagem.</b></p>
                <?php 
                if(form_returned_message()):
                    echo '<p>' . form_returned_message() . '</p>';
                endif;
                ?>
            </div>
            <?php 
            endif;
            ?>

			<?php echo form_open() ?>
			
			<div class="control-group">
                <label class="control-label" for="field_nome">Nome</label>
                <div class="controls">
                    <input type="text" name="nome" id="field_nome" placeholder="" class="input-large required">
                </div>
            </div><!-- control-group -->

            <div class="control-group">
                <label class="control-label" for="field_email">E-mail</label>
                <div class="controls">
                    <input type="email" name="email" id="field_email" placeholder="" class="input-large required">
                </div>
            </div><!-- control-group -->

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enviar mensagem</button>
            </div>

			<?php echo form_close() ?>

			</div><!-- main -->

			<?php get_sidebar(); ?>
	
		</div><!-- row -->

	</div><!-- container -->

</div><!-- #page -->


<?php get_footer(); ?>