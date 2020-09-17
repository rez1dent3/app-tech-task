<?php

namespace App\JsonApi\Schema;

use App\Entity\Order;
use Neomerx\JsonApi\Contracts\Schema\ContextInterface;
use Neomerx\JsonApi\Schema\BaseSchema;

class OrderSchema extends BaseSchema
{

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'orders';
    }

    /**
     * @param Order $model
     * @return string|null
     */
    public function getId($model): ?string
    {
        return $model->getId();
    }

    /**
     * @param Order $model
     * @param ContextInterface $context
     * @return iterable
     */
    public function getAttributes($model, ContextInterface $context): iterable
    {
        return [
            'amount' => $model->getAmount(),
            'status' => $model->getStatus(),
            'user_id' => $model->getUserId(),
            'created_at' => $model->getCreatedAt(),
            'updated_at' => $model->getUpdatedAt(),
        ];
    }

    /**
     * @param Order $model
     * @param ContextInterface $context
     * @return iterable
     */
    public function getRelationships($model, ContextInterface $context): iterable
    {
        return [];
    }

}
