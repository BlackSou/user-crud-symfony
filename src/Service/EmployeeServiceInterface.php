<?php

namespace App\Service;

use App\DTO\Employee\EmployeeListResponse;
use App\DTO\Employee\CreateEmployeeRequest;
use App\DTO\IdResponse;

interface EmployeeServiceInterface
{
    public function getEmployees(): EmployeeListResponse;

    public function createEmployee(CreateEmployeeRequest $createEmployeeRequest): IdResponse;
}
