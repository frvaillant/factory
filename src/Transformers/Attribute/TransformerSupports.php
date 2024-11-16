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
    public function __construct(private string $supports)
    {
    }

    /**
     * @return string
     */
    public function getSupports(): string
    {
        return $this->supports;
    }
}