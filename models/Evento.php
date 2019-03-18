<?php

class Evento extends Wpost
{
    public $metaDataDe;
    public $metaDataAte;


    /**
     * Taxonomia para categoria
     * category (default), false
     * @var string
     */
    protected $categoryTax = 'eventos_categoria';

    /**
     * Taxonomia para tags
     * post_tag (default), false
     * @var string
     */
    protected $tagTax = '';

    public function __construct($post = null, $mainQuery = true)
    {
        parent::__construct($post, $mainQuery);

        $this->metaDataDe  = $this->getMeta('wpcf-data-de-inicio');
        $this->metaDataAte = $this->getMeta('wpcf-data-de-termino');
    }

    /**
     * Baseado no timestamp retorna apenas o dia
     * @return [type] [description]
     */
    public function presentDia1()
    {
        return date("d", $this->metaDataDe);
    }

    public function presentMes1()
    {
        return substr(__(date("F", $this->metaDataDe)), 0, 3);
    }

    public function presentAno1()
    {
        return date("Y", $this->metaDataDe);
    }

    public function presentDia2()
    {
        return date("d", $this->metaDataAte);
    }

    public function presentMes2()
    {
        return substr(__(date("F", $this->metaDataAte)), 0, 3);
    }

    public function presentAno2()
    {
        return date("Y", $this->metaDataAte);
    }
}