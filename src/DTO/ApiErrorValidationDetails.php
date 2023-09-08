<?php

namespace App\DTO;

class ApiErrorValidationDetails
{
    /**
     * @var ApiErrorValidationDetailsItem[]
     */
    private array $violations = [];

    public function addViolation(string $field, string $message): void
    {
        $this->violations[] = new ApiErrorValidationDetailsItem($field, $message);
    }

    /**
     * @return ApiErrorValidationDetailsItem[]
     */
    public function getViolations(): array
    {
        return $this->violations;
    }
}
