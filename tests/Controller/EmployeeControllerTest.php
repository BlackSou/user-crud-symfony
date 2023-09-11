<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeeControllerTest extends WebTestCase
{
    protected KernelBrowser $client;

    protected ?EntityManagerInterface $em;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->em = self::bootKernel()->getContainer()->get('doctrine')->getManager();
    }

    public function testDeleteEmployee(): void
    {
        $employee = (new User())
            ->setFirstName('A')
            ->setLastName('B')
            ->setEmail('a@b.test')
            ->setFirstDay(new \DateTimeImmutable('2024-10-10'))
            ->setSalary(100);

        $this->em->persist($employee);
        $this->em->flush();

        $this->client->request('DELETE', '/api/v1/employee/'.$employee->getId());

        $this->assertResponseIsSuccessful();
    }

    public function testCreateEmployee(): void
    {

    }

    public function testEmployees(): void
    {
    }

    public function testUpdateEmployee(): void
    {
    }
}
