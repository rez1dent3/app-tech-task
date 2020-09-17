<?php

namespace App\Service\Payment;

use App\Entity\Order;

class YaPaymentService extends PaySystemBase
{

    /**
     * @param Order $order
     * @return string
     */
    public function paymentPageUrl(Order $order): string
    {
        return 'https://ya.ru';
    }

}
