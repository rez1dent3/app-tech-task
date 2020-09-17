<?php

namespace App\Service\Payment;

use App\Entity\Order;

interface PaySystemInterface
{
    /**
     * @param Order $order
     * @return string
     */
    public function paymentPageUrl(Order $order): string;

    /**
     * @param Order $order
     * @return bool
     */
    public function check(Order $order): bool;
}
