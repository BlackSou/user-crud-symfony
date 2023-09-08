<?php

namespace App\DTO\Employee;

class EmployeeListItem
{
    private int $id;

    private string $firstName;

    private string $lastName;

    private string $email;

    private \DateTimeInterface $firstDay;

    private int $salary;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstDay(): \DateTimeInterface
    {
        return $this->firstDay;
    }

    public function setFirstDay(\DateTimeInterface $firstDay): self
    {
        $this->firstDay = $firstDay;

        return $this;
    }

    public function getSalary(): int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }
}
