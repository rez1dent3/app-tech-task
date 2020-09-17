<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\JsonApi\Controller\JsonApiInterface;
use App\JsonApi\Deserializer\OrderDeserializer;
use App\JsonApi\Deserializer\PaymentDeserializer;
use App\Service\Payment\PaySystemInterface;
use Doctrine\ORM\EntityManager;
use App\JsonApi\Encoder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController implements JsonApiInterface
{

    /**
     * @param Encoder $encoder
     * @param ContainerBuilder $containerBuilder
     * @param Request $request
     * @return JsonResponse
     * @throws
     */
    public function store(Encoder $encoder, ContainerBuilder $containerBuilder, Request $request): Response
    {
        $deserializer = new OrderDeserializer($request);
        if (!$deserializer->validate()) {
            return $encoder
                ->jsonApiErrors($deserializer->getErrors())
                ->setStatusCode(422)
            ;
        }

        /**
         * @var EntityManager $entityManager
         */
        $entityManager = $containerBuilder
            ->get('doctrine.entity_manager')
        ;

        /**
         * @var Product[] $products
         */
        $products = $entityManager
            ->getRepository(Product::class)
            ->findById($deserializer->getProductIds())
        ;

        $order = new Order();
        $entityManager->beginTransaction();
        try {
            $order->addProducts($products);
            $entityManager->persist($order);
            $entityManager->flush();
            $entityManager->commit();
        } catch (\Throwable $throwable) {
            $entityManager->rollback();
        }

        return $encoder
            ->jsonApiResponse($order)
            ->setStatusCode(201)
        ;
    }

    /**
     * @param Encoder $encoder
     * @param ContainerBuilder $containerBuilder
     * @param Order $order
     * @return Response
     * @throws
     */
    public function payment(Encoder $encoder, ContainerBuilder $containerBuilder, Order $order): Response
    {
        /**
         * @var Request $request
         */
        $request = $containerBuilder->get('request');
        $deserializer = new PaymentDeserializer($request, $order);
        if (!$deserializer->validate()) {
            return $encoder
                ->jsonApiErrors($deserializer->getErrors())
                ->setStatusCode(422)
            ;
        }

        if ($order->isNewStatus()) {
            /**
             * @var PaySystemInterface $paymentSystem
             */
            $paymentSystem = $containerBuilder->get('payment.ya');
            if ($paymentSystem->check($order)) {
                /**
                 * @var EntityManager $entityManager
                 */
                $entityManager = $containerBuilder->get('doctrine.entity_manager');
                $order->setStatus(Order::STATUS_PAID);
                $entityManager->flush($order);
            }
        }

        return $encoder
            ->jsonApiResponse($order)
        ;
    }

}
