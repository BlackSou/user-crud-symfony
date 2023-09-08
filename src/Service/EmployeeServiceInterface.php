<?php

namespace App\Service;

use App\DTO\Employee\CreateEmployeeRequest;
use App\DTO\IdResponse;

interface EmployeeServiceInterface
{
    public function createEmployee(CreateEmployeeRequest $createEmployeeRequest): IdResponse;
}
