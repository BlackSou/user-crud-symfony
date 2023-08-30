<?php

namespace App\DTO;

class CreateEmployeeRequest
{
    #[NotBlank]
    private string $firstName;

    #[NotBlank]
    private string $lastName;

    #[Email]
    #[NotBlank]
    private string $email;

    #[NotBlank]
    #[Assert\GreaterThan('today')]
    private int $firstDay;

    #[NotBlank]
    #[Assert\GreaterThanOrEqual(100)]
    private float $salary;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFirstDay(): int
    {
        return $this->firstDay;
    }

    public function setFirstDay(int $firstDay): void
    {
        $this->firstDay = $firstDay;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): void
    {
        $this->salary = $salary;
    }
}
