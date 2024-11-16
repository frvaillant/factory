<?php

namespace App\Transformers\Interface;


interface TransformerInterface
{
    public function transform(object $entity): array;

}