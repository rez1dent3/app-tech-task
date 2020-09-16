<?php

namespace App\ValueResolver;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class EntityManagerArgumentResolver implements ArgumentValueResolverInterface
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
        return $argument->getType() === EntityManager::class;
    }

    /**
     * @inheritdoc
     * @throws
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield $this->builder->get('doctrine.entity_manager');
    }

}
