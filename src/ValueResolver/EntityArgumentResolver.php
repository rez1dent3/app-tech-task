<?php

namespace App\ValueResolver;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EntityArgumentResolver implements ArgumentValueResolverInterface
{

    /**
     * @var null|object
     */
    protected ?object $entity;

    /**
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritdoc
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $id = $request->attributes->getInt('id');

        if (!$id) {
            return false;
        }

        if (strpos($argument->getType(), 'App\Entity') !== 0) {
            return false;
        }

        $this->entity = $this->entityManager
            ->getRepository($argument->getType())
            ->find($id)
        ;

        if (!$this->entity) {
            throw new NotFoundHttpException(
                \sprintf('Resource "%s" not found', $argument->getType())
            );
        }

        return (bool)$this->entity;
    }

    /**
     * @inheritdoc
     * @throws
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield $this->entity;
    }

}
