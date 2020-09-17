<?php

namespace App\JsonApi\Deserializer;

use Symfony\Component\Validator\Constraints as Assert;

class OrderDeserializer extends JsonApiDeserializer
{

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            'type' => new Assert\EqualTo(['value' => 'orders']),
            'attributes' => new Assert\Collection([]),
            'relationships' => new Assert\Collection([
                'products' => new Assert\Collection([
                    'data' => new Assert\Required([
                        new Assert\Type('array'),
                        new Assert\Count(['min' => 1]),
                        new Assert\All([
                            new Assert\Collection([
                                'type' => new Assert\EqualTo(['value' => 'products']),
                                'id' => new Assert\Positive(),
                            ]),
                        ]),
                    ]),
                ]),
            ]),
        ];
    }

    /**
     * @return int[]
     * @throws
     */
    public function getProductIds(): array
    {
        $productIds = [];
        $rawData = \current($this->getRawData());
        foreach ($rawData['relationships']['products']['data'] as $datum) {
            $productIds[] = $datum['id'];
        }

        return $productIds;
    }

}
