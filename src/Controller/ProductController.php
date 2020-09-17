<?php

namespace App\Controller;

use App\Entity\Product;
use App\JsonApi\Controller\JsonApiInterface;
use App\JsonApi\Response\JsonApiResponse;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Faker\Generator;
use App\JsonApi\Encoder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController implements JsonApiInterface
{

    /**
     * @param Encoder $encoder
     * @param EntityManager $entityManager
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function index(Encoder $encoder, EntityManager $entityManager, Request $request): Response
    {
        /**
         * @var ProductRepository $productRepository
         */
        $productRepository = $entityManager
            ->getRepository(Product::class)
        ;

        $paginator = $productRepository->paginate(
            $request->get('page', 1),
        );

        return $encoder
            ->withMeta(['total' => \count($paginator)])
            ->jsonApiResponse($paginator->getIterator())
        ;
    }

    /**
     * @param Encoder $encoder
     * @param ContainerBuilder $containerBuilder
     * @param EntityManager $entityManager
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function fixtures(Encoder $encoder, ContainerBuilder $containerBuilder, EntityManager $entityManager): Response
    {
        /**
         * @var $faker Generator
         */
        $faker = $containerBuilder->get('faker');

        $products = [];
        for ($i = 0; $i < 20; ++$i) {
            $product = new Product();
            $product->setName($faker->word);
            $price = $faker->randomFloat(2, 1, 10_000);
            $product->setPrice($price);
            $products[] = $product;

            $entityManager->persist($product);
        }

        $entityManager->flush();

        return $encoder
            ->jsonApiResponse($products)
            ->setStatusCode(201)
        ;
    }

    /**
     * @param Encoder $encoder
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Encoder $encoder, Product $product): Response
    {
        return $encoder->jsonApiResponse($product);
    }

}
