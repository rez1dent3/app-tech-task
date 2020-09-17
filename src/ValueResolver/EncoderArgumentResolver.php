<?php

namespace App\ValueResolver;

use App\JsonApi\Encoder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class EncoderArgumentResolver implements ArgumentValueResolverInterface
{

    /**
     * @var ContainerBuilder
     */
    protected ContainerBuilder $builder;

    /**
     * @param ContainerBuilder $builder
     */
    public function __construct(ContainerBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @inheritdoc
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === Encoder::class;
    }

    /**
     * @inheritdoc
     * @throws
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield $this->builder->get('jsonapi.encoder');
    }

}
