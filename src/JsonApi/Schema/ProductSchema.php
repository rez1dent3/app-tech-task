<?php

namespace App\JsonApi\Schema;

use App\Entity\Product;
use Neomerx\JsonApi\Contracts\Schema\ContextInterface;
use Neomerx\JsonApi\Schema\BaseSchema;

class ProductSchema extends BaseSchema
{

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'products';
    }

    /**
     * @param Product $model
     * @return string|null
     */
    public function getId($model): ?string
    {
        return $model->getId();
    }

    /**
     * @param Product $model
     * @param ContextInterface $context
     * @return iterable
     */
    public function getAttributes($model, ContextInterface $context): iterable
    {
        return [
            'name' => $model->getName(),
            'price' => $model->getPrice(),
            'created_at' => $model->getCreatedAt(),
            'updated_at' => $model->getUpdatedAt(),
        ];
    }

    /**
     * @param Product $model
     * @param ContextInterface $context
     * @return iterable
     */
    public function getRelationships($model, ContextInterface $context): iterable
    {
        return [];
    }

}
