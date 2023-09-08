<?php

namespace App\Service;

use App\DTO\Employee\EmployeeListItem;
use App\DTO\Employee\EmployeeListResponse;
use App\DTO\Employee\CreateEmployeeRequest;
use App\DTO\IdResponse;
use App\Entity\User;
use App\Exception\EmployeeDuplicateException;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeService implements EmployeeServiceInterface
{
    public function __construct(private readonly UserRepository $userRepository, private readonly EntityManagerInterface $em)
    {
    }

    public function getEmployees(): EmployeeListResponse
    {
        $employees = $this->userRepository->findBy([], ['id' => Criteria::ASC]);

        $items = array_map([$this, 'map'], $employees);

        return new EmployeeListResponse($items);
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

    private function map(User $user): EmployeeListItem
    {
        return (new EmployeeListItem())
            ->setId($user->getId())
            ->setFirstName($user->getFirstName())
            ->setLastName($user->getLastName())
            ->setEmail($user->getEmail())
            ->setFirstDay($user->getFirstDay())
            ->setSalary($user->getSalary());
    }
}
