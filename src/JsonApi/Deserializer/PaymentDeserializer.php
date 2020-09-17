<?php

namespace App\JsonApi\Deserializer;

use App\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class PaymentDeserializer extends JsonApiDeserializer
{

    /**
     * @var Order
     */
    protected Order $order;

    /**
     * PaymentDeserializer constructor.
     * @param Request $request
     * @param Order $order
     */
    public function __construct(Request $request, Order $order)
    {
        parent::__construct($request);
        $this->order = $order;
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            'type' => new Assert\EqualTo(['value' => 'payments']),
            'attributes' => new Assert\Collection([
                'amount' => new Assert\EqualTo([
                    'value' => $this->order->getAmount(),
                    'message' => 'Invalid order value',
                ]),
            ]),
        ];
    }

    /**
     * @return float
     * @throws
     */
    public function getAmount(): float
    {
        $rawData = \current($this->getRawData());
        return $rawData['attributes']['amount'];
    }

}
