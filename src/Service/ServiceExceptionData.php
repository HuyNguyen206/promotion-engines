<?php

namespace App\Service;

use Symfony\Component\Validator\ConstraintViolationList;

class ServiceExceptionData
{
    public function __construct(protected int $statusCode, protected  string $type, protected ConstraintViolationList $violationList)
    {

    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function toArray()
    {
        $result = [];
        /**
         * @todo
         * Extract the validation error message in violationList to the comment format below
         */
        foreach ($this->violationList as $violation) {
            $result[] = $violation->getMessage();
        }

        return $result;
//        return [
//            'type' => 'ViolationList',
//            'title' => 'An error occur',
//            'description' => 'This value should be positive',
//            'violations' => [
//                'propertyPath' => 'quantity',
//                'message' => 'This value should be positive'
//            ]
//        ];
    }

}