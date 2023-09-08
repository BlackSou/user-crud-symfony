<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationFailedException extends \RuntimeException
{
    public function __construct(private readonly ConstraintViolationListInterface $violations)
    {
        parent::__construct('Failed validation');
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
