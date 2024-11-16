<?php

namespace App\Transformers;


use App\Transformers\Interface\TransformerInterface;

class EntityTransformer implements TransformerInterface
{
    public function transform(object $entity): array
    {
        return [
            'id' => $entity->getId(),
        ];
    }

}