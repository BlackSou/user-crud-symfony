<?php

namespace App\Service;

use App\DTO\Employee\CreateEmployeeRequest;
use App\DTO\IdResponse;
use App\Entity\User;
use App\Exception\EmployeeDuplicateException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeService implements EmployeeServiceInterface
{
    public function __construct(private readonly UserRepository $userRepository, private readonly EntityManagerInterface $em)
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

        $this->em->persist($user);
        $this->em->flush();

        return new IdResponse($user->getId());
    }
}
