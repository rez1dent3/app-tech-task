<?php

namespace App\Service\Payment;

use App\Entity\Order;
use GuzzleHttp\Client;

abstract class PaySystemBase implements PaySystemInterface
{

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * PaySystemBase constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Order $order
     * @return bool
     */
    public function check(Order $order): bool
    {
        try {
            $paymentUrl = $this->paymentPageUrl($order);
            $response = $this->client->head($paymentUrl);
            return $response->getStatusCode() === 200;
        } catch (\Throwable $throwable) {
            return false;
        }
    }

}
