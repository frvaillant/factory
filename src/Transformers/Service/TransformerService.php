<?php

namespace App\Transformers;

use App\Transformers\Factory\TransformerFactory;

final class TransformerService
{

    private TransformerFactory $factory;

    public function __construct(TransformerFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     *
     * Delegate this service to its related Transformer
     */
    public function __call(string $method, array $arguments): mixed
    {
        if (count($arguments) === 0 || is_object(!$arguments[0])) {
            throw new \InvalidArgumentException('The first argument must be an object.');
        }

        $entity = $arguments[0];

        $transformer = $this->factory->getTransformer($entity);

        if (!method_exists($transformer, $method)) {
            throw new \BadMethodCallException(sprintf(
                'Method "%s" does not exist on transformer "%s".',
                $method,
                get_class($transformer)
            ));
        }

        return $transformer->$method(...$arguments);
    }

}