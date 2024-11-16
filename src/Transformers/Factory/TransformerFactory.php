<?php

namespace App\Transformers\Factory;

use App\Transformers\Attribute\TransformerSupports;
use App\Transformers\EntityTransformer;
use App\Transformers\Interface\TransformerInterface;
use Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class TransformerFactory
{
    private ?TransformerInterface $transformer;

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
        foreach ($this->transformers as $transformer) {
            if(
                !$transformer instanceof EntityTransformer
                && $this->transformerSupports($transformer, $entity::class)
            ) {
                    return $transformer;
            }
        }

        return new EntityTransformer();
    }

    private function transformerSupports(TransformerInterface $transformer, string $fqcn)
    {
        $class = new \ReflectionClass($transformer);
        $attributes = $class->getAttributes();
        foreach ($attributes as $attribute) {
            if($attribute->getName() === TransformerSupports::class && $attribute->getArguments()['supports'] === $fqcn) {
                return true;
            }
        }
        return false;
    }
}