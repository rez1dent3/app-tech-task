<?php

namespace App\JsonApi;

use Neomerx\JsonApi\Contracts\Encoder\EncoderInterface;
use Neomerx\JsonApi\Contracts\Schema\SchemaContainerInterface;

class Factory extends \Neomerx\JsonApi\Factories\Factory
{

    /**
     * @param SchemaContainerInterface $container
     * @return EncoderInterface
     */
    public function createEncoder(SchemaContainerInterface $container): EncoderInterface
    {
        return new Encoder($this, $container);
    }

}
