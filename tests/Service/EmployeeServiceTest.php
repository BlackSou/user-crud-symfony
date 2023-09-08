<?php

namespace App\Tests\Service;

use App\DTO\Employee\CreateEmployeeRequest;
use App\DTO\Employee\EmployeeListItem;
use App\DTO\Employee\EmployeeListResponse;
use App\DTO\Employee\UpdateEmployeeRequest;
use App\DTO\IdResponse;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\EmployeeService;
use App\Tests\AbstractBaseTestCase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeServiceTest extends AbstractBaseTestCase
{
    private UserRepository $userRepository;

    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->em = $this->createMock(EntityManagerInterface::class);
    }

    public function testGetEmployees(): void
    {
        $randomNumber = mt_rand();
        $employee = $this->createEmployee($randomNumber);

        $this->userRepository->expects($this->once())
            ->method('findBy')
            ->with([], ['id' => Criteria::ASC])
            ->willReturn([$employee]);

        $employeeItem = (new EmployeeListItem())
            ->setId($randomNumber)
            ->setFirstName('A')
            ->setLastName('B')
            ->setEmail('a@b.test')
            ->setFirstDay(new \DateTimeImmutable('2024-10-10'))
            ->setSalary(100);

        $this->assertEquals(
            new EmployeeListResponse([$employeeItem]),
            $this->createService()->getEmployees(),
        );
    }

    public function testCreateEmployee(): void
    {
        $randomNumber = mt_rand();

        $createEmployeeRequest = (new CreateEmployeeRequest())
            ->setFirstName('A')
            ->setLastName('B')
            ->setEmail('a@b.test')
            ->setFirstDay(new \DateTimeImmutable('2024-10-10'))
            ->setSalary(100);

        $expectedEmployee = (new User())
            ->setFirstName('A')
            ->setLastName('B')
            ->setEmail('a@b.test')
            ->setFirstDay(new \DateTimeImmutable('2024-10-10'))
            ->setSalary(100);

        $this->userRepository->expects($this->once())
            ->method('hasDuplicateEmail')
            ->with('a@b.test')
            ->willReturn(false);

        $this->em->expects($this->once())
            ->method('persist')
            ->with($expectedEmployee)
            ->willReturnCallback(function (User $employee) use ($randomNumber) {
                $this->setEntityId($employee, $randomNumber);
            });

        $this->em->expects($this->once())
            ->method('flush');

        $this->assertEquals(
            new IdResponse($randomNumber),
            $this->createService()->createEmployee($createEmployeeRequest)
        );
    }

    public function testUpdateEmployee(): void
    {
        $randomNumber = mt_rand();

        $updateEmployeeRequest = (new UpdateEmployeeRequest())
            ->setFirstName('AA')
            ->setLastName('BB')
            ->setSalary(1000);

        $employee = $this->createEmployee($randomNumber);

        $this->userRepository->expects($this->once())
            ->method('getUserById')
            ->with($randomNumber)
            ->willReturn($employee);

        $this->em->expects($this->once())
            ->method('flush');

        $this->createService()->updateEmployee($randomNumber, $updateEmployeeRequest);
    }

    public function testDeleteEmployee(): void
    {
        $employee = new User();
        $randomNumber = mt_rand();

        $this->userRepository->expects($this->once())
            ->method('getUserById')
            ->with($randomNumber)
            ->willReturn($employee);

        $this->em->expects($this->once())
            ->method('remove')
            ->with($employee);

        $this->em->expects($this->once())
            ->method('flush');

        $this->createService()->deleteEmployee($randomNumber);
    }

    public function createEmployee(int $id): User
    {
        $employee = (new User())
            ->setFirstName('A')
            ->setLastName('B')
            ->setEmail('a@b.test')
            ->setFirstDay(new \DateTimeImmutable('2024-10-10'))
            ->setSalary(100);

        $this->setEntityId($employee, $id);

        return $employee;
    }

    private function createService(): EmployeeService
    {
        return new EmployeeService($this->userRepository, $this->em);
    }
}
