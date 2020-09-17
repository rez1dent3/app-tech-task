<?php

namespace App\JsonApi\Deserializer;

use Neomerx\JsonApi\Schema\Error;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

abstract class JsonApiDeserializer
{

    /**
     * @var null|array
     */
    protected ?array $rawData = null;

    /**
     * @var Error[]
     */
    protected array $errors = [];

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * JsonApiDeserializer constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     * @throws
     */
    public function validate(): bool
    {
        /**
         * @var $error ConstraintViolation
         */
        foreach ($this->check() as $error) {
            $this->errors[] = new Error(
                current($error->getParameters()),
                null,
                null,
                422,
                $error->getCode(),
                $error->getMessage(),
                null,
                ['pointer' => $error->getPropertyPath()],
            );
        }

        return empty($this->errors);
    }

    /**
     * @return array|null
     * @throws
     */
    public function getRawData(): ?array
    {
        if (!$this->rawData) {
            $content = $this->request->getContent();
            $this->rawData = \json_decode(
                $content,
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        }

        return $this->rawData;
    }

    /**
     * @return ConstraintViolationListInterface
     * @throws
     */
    protected function check(): ConstraintViolationListInterface
    {
        return Validation::createValidator()->validate(
            $this->getRawData(),
            $this->constraint(),
            $this->groupSequence(),
        );
    }

    /**
     * @return Assert\GroupSequence
     */
    protected function groupSequence(): Assert\GroupSequence
    {
        return new Assert\GroupSequence(['Default']);
    }

    /**
     * @return Assert\Collection
     */
    protected function constraint(): Assert\Collection
    {
        return new Assert\Collection([
            'data' => new Assert\Collection($this->rules()),
        ]);
    }

    abstract protected function rules(): array;

}
