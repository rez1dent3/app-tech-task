<?php

namespace App\JsonApi;

use App\JsonApi\Response\JsonApiResponse;
use Neomerx\JsonApi\Contracts\Schema\ErrorInterface;

class Encoder extends \Neomerx\JsonApi\Encoder\Encoder
{

    /**
     * @param object|iterable|null $data
     * @return JsonApiResponse
     */
    public function jsonApiResponse($data): JsonApiResponse
    {
        return new JsonApiResponse($this->encodeData($data));
    }

    /**
     * @param iterable $errors
     * @return JsonApiResponse
     */
    public function jsonApiErrors(iterable $errors): JsonApiResponse
    {
        return new JsonApiResponse($this->encodeErrors($errors));
    }

    /**
     * @param ErrorInterface $error
     * @return JsonApiResponse
     */
    public function jsonApiError(ErrorInterface $error): JsonApiResponse
    {
        return new JsonApiResponse($this->encodeError($error));
    }

}
