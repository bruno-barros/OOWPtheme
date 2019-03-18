<?php

class HomeFeatured {

    protected $args;

    function __construct()
    {
        $args = array(
            'posts_per_page' => 3,
            'post_type' => 'page',
            'orderby'        => 'rand'
        );

        $this->args = $this->naHome($args);


    }

    public function get()
    {
        return new Wcollection($this->args);
    }


    /**
     * Insere busca pelo metadado 'wpcf-de', retornando apenas
     * datas futuras
     * @param  array  $args Argumentos para filtrar
     * @return array
     */
    public function naHome($args = array())
    {
        // $date = new DateTime();
        $meta = array(
            'meta_query' => array(
                array(
                    'key' => 'wpcf-na-home',
                    'value' => 1,
                    'compare' => '='
                )
            )
        );
        return array_merge($args, $meta);
    }
}