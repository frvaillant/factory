<?php

namespace App\Transformers\Factory;

use App\Transformers\Attribute\TransformerSupports;
use App\Transformers\EntityTransformer;
use App\Transformers\Interface\TransformerInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class TransformerFactory
{
    private iterable $transformers;

    /**
     * @param iterable $transformers
     *
     * see services.yaml for configuration
     */
    public function __construct(#[TaggedIterator('app.transformer')] iterable $transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * @param object $entity
     * @return TransformerInterface
     */
    public function getTransformer(object $entity): TransformerInterface
    {
        $entityClass = $entity::class;

        foreach ($this->transformers as $transformer) {

            if (!$transformer instanceof TransformerInterface) {
                continue;
            }

            if ($this->transformerSupports($transformer, $entityClass)) {
                return $transformer;
            }
        }

        return new EntityTransformer();
    }

    private function transformerSupports(TransformerInterface $transformer, string $entityClass)
    {
        $reflectionClass = new \ReflectionClass($transformer);

        foreach ($reflectionClass->getAttributes(TransformerSupports::class) as $attribute) {

            /** @var TransformerSupports $instance */
            $instance = $attribute->newInstance();

            if ($instance->supports === $entityClass) {
                return true;
            }
        }

        return false;
    }
}