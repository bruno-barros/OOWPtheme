<?php
/**
 * The template for displaying search forms in Twenty Eleven
 *
 * @package WPtheme
 */
?>
<form role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" id="formsearch">
    <fieldset>
        <label title="Pesquisar">
        <input type="text" name="s" id="search" value="<?php echo get_search_query() ?>" placeholder="<?php esc_attr_e( 'Pesquisar' ); ?>" />                            
        <input type="submit" id="searchsubmit" value="OK" />
        </label>
    </fieldset>
</form>
