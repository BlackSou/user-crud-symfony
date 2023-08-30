<?php

namespace App\Service;

use App\DTO\CreateEmployeeRequest;

interface EmployeeServiceInterface
{
    public function getProductsByCategory(int $categoryId): CreateEmployeeRequest;
}
