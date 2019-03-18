<?php
/**
 * Modelo para formulário.
 *
 * @package OOWPtheme
 */
/** ========================================================================
 *    Processa envio de formulário
 * ------------------------------------------------------------------------
 */
if (was_form_sent())
{
    // OK, vamos enviar!
    $m = new Wmail();
//    $m->debugModeOn();
    $m->setSubject('Mensagem pelo site');
    $m->respondTo($_POST['email'], $_POST['nome']);
    $m->setTemplate('email/contato.html');
    $m->setRules(array(
        array('nome', 'string', true, 3),
        array('email', 'email', true),
        array('mensagem', 'string', true, 10),
    ));
    // optional
    // $m->setTemlateVars(array(
    //     'nome' => $_POST['nome'],
    //     'email' => $_POST['email'],
    //     'mensagem' => $_POST['mensagem'],
    // ));
    //    $m->setAttachment('file');
    $m->sendAndRedirect();
}

get_header();
?>



    <h2 class="title-tab">
        Contato
    </h2>


    <div class="content">


        <div class="row-fluid">


            <div class="span9 content-pad">

                <?php
                // setup $post
                the_post();

                $p = new Wpost($post);

                ?>


                <?php echo $p->content; ?>

                <br>
                <br>

                <?php
                /** ========================================================================
                 *     Retorno do envio
                 * ------------------------------------------------------------------------
                 */
                if (form_returned_success()):
                    ?>
                    <div class="alert alert-success animated bounceInDown">
                        <b>Mensagem enviada com sucesso.</b>
                    </div>
                <?php
                endif;
                if (form_returned_error()):
                    ?>
                    <div class="alert alert-error animated bounceInDown">
                        <p><b>Houve um erro ao enviar sua mensagem.</b></p>
                        <?php
                        if (form_returned_message()):
                            echo '<p>' . form_returned_message() . '</p>';
                        endif;
                        ?>
                    </div>
                <?php
                endif;
                ?>

                <?php echo form_open('', array('class' => 'form-horizontal')) ?>

                <div class="control-group">
                    <label class="control-label" for="field_nome">Nome</label>

                    <div class="controls">
                        <input type="text" name="nome" id="field_nome" placeholder="" class="input-large required"
                               value="<?php echo set_value('nome') ?>">
                        <?php echo form_error('nome') ?>
                    </div>
                </div>
                <!-- control-group -->

                <div class="control-group">
                    <label class="control-label" for="field_email">E-mail</label>

                    <div class="controls">
                        <input type="email" name="email" id="field_email" placeholder="" class="input-large required"
                               value="<?php echo set_value('email') ?>">
                        <?php echo form_error('email') ?>
                    </div>
                </div>
                <!-- control-group -->

                <div class="control-group">
                    <label class="control-label" for="field_mensagem">Mensagem</label>

                    <div class="controls">
                        <textarea name="mensagem" id="field_mensagem" cols="30" rows="6"
                                  class="input-xxlarge required"><?php echo set_value('mensagem') ?></textarea>
                        <?php echo form_error('mensagem') ?>
                    </div>
                </div>
                <!-- control-group -->

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Enviar mensagem</button>
                </div>

                <?php echo form_close() ?>

            </div>

            <div class="span3">

                <?php
                $t = new Citacao();
                $cit = $t->tag('todas,contato,institucional');

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


    </div>




<?php get_footer(); ?>