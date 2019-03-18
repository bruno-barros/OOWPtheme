<?php

class Citacao extends Wcollection
{

    protected $tags = array();

    public function __construct($args = array())
    {
        parent::__construct(
            array_merge(array(
                'post_type' => 'citacoes'
            ), $args)
        );
    }

    public function tag($tags = '')
    {

        $cit = new self(array(
            'orderby'        => 'rand',
            'posts_per_page' => 1,
            'tax_query'      => array(
                array(
                    'taxonomy'         => 'citacao_tag',
                    'field'            => 'slug',
                    'terms'            => $this->parsetags($tags),
                    'include_children' => false
                )
            )
        ));

        if (!$cit->posts)
        {
            return null;
        }

        return new Wpost($cit->posts[0], false);
    }


    private function parsetags($tags = '')
    {
        if (strlen($tags))
        {
            $aTags = explode(',', $tags);
        }
        else
        {
            return null;
        }

        $tgs = array();

        foreach ($aTags as $t)
        {
            $tgs[] = trim($t);
        }

        return $tgs;
    }
}