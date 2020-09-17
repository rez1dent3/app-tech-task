<?php

namespace App\Service\Payment;

use App\Entity\Order;

class HttpStat400PaymentService extends PaySystemBase
{

    /**
     * @param Order $order
     * @return string
     */
    public function paymentPageUrl(Order $order): string
    {
        return 'https://httpstat.us/400';
    }

}
