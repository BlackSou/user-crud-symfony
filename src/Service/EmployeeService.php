<?php

namespace App\Service;

use App\DTO\CreateEmployeeRequest;
use App\DTO\IdResponse;
use App\Entity\User;
use App\Exception\EmployeeDuplicateException;
use App\Repository\UserRepository;

class EmployeeService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function createEmployee(CreateEmployeeRequest $createEmployeeRequest): IdResponse
    {
        if ($this->userRepository->hasDuplicateEmail($createEmployeeRequest->getEmail())) {
            throw new EmployeeDuplicateException();
        }

        $user = (new User())
            ->setFirstName($createEmployeeRequest->getFirstName())
            ->setLastName($createEmployeeRequest->getLastName())
            ->setEmail($createEmployeeRequest->getEmail())
            ->setFirstDay($createEmployeeRequest->getFirstDay())
            ->setSalary($createEmployeeRequest->getSalary());

        $this->userRepository->saveAndCommit($user);

        return new IdResponse($user->getId());
    }
}
