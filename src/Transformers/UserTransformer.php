<?php

namespace App\Service\Transformers;

use App\Service\Entity\User;
use App\Transformers\Attribute\TransformerSupports;
use App\Transformers\Interface\TransformerInterface;

#[TransformerSupports(supports: User::class)]
class UserTransformer implements TransformerInterface
{
    /**
     * @param object $entity
     *
     * Here $entity is App\Entity\User
     *
     * @return array
     */
    public function transform(object $entity): array
    {
        return [
            'id' => $entity->getId(),
            'name' => $entity->getLastname()
        ];
    }

}