<?php

namespace App\DTO\Employee;

use Symfony\Component\Validator\Constraints as Assert;

class CreateEmployeeRequest
{
    #[Assert\NotBlank]
    private string $firstName;

    #[Assert\NotBlank]
    private string $lastName;

    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private string $email;

    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual('today')]
    private \DateTimeInterface $firstDay;

    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(100)]
    #[Assert\Type('numeric')]
    private int $salary;

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
