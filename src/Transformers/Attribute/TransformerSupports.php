<?php

namespace App\Transformers\Attribute;

use Attribute;

#[Attribute]
class TransformerSupports
{

    /**
     * @param string $supports
     *
     * FQCN of supported type
     */
    public function __construct(public string $supports)
    {
    }

}