<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Helmich\JsonAssert\JsonAssertions;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeeControllerTest extends WebTestCase
{
    use JsonAssertions;

    protected KernelBrowser $client;

    protected EntityManagerInterface $em;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->em = self::bootKernel()->getContainer()->get('doctrine')->getManager();
    }

    public function testDeleteEmployee(): void
    {
        $randomNumber = mt_rand();
        $email = "test_controller_$randomNumber@delete.test";

        $employee = (new User())
            ->setFirstName('TestController')
            ->setLastName('Delete')
            ->setEmail($email)
            ->setFirstDay(new \DateTimeImmutable('2024-10-10'))
            ->setSalary(101);

        $this->em->persist($employee);
        $this->em->flush();

        $this->client->request('DELETE', '/api/v1/employee/'.$employee->getId());

        $this->assertResponseIsSuccessful();
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testCreateEmployee(): void
    {
        $randomNumber = mt_rand();
        $email = "test_controller_$randomNumber@create.test";
        $employee = [
            'firstName' => 'TestController',
            'lastName' => 'Create',
            'email' => $email,
            'firstDay' => '2024-10-10',
            'salary' => 101,
        ];

        $this->client->request('POST', '/api/v1/employee', [], [], [], json_encode($employee, JSON_THROW_ON_ERROR));

        $this->assertResponseIsSuccessful();

        $responseContent = json_decode($this->client->getResponse()->getContent(), null, 512, JSON_THROW_ON_ERROR);

        $schema = [
            'type' => 'object',
            'required' => ['id'],
            'properties' => [
                'id' => ['type' => 'integer'],
            ],
        ];

        $this->assertJsonDocumentMatchesSchema($responseContent, $schema);
    }

    public function testEmployees(): void
    {
        $randomNumber = mt_rand();
        $email = "test_controller_$randomNumber@get.test";

        $employee = (new User())
            ->setFirstName('TestController')
            ->setLastName('Get')
            ->setEmail($email)
            ->setFirstDay(new \DateTimeImmutable('2024-10-10'))
            ->setSalary(101);

        $this->em->persist($employee);
        $this->em->flush();

        $this->client->request('GET', '/api/v1/employees');

        $responseContent = json_decode($this->client->getResponse()->getContent(), null, 512, JSON_THROW_ON_ERROR);

        $schema = [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'firstName', 'lastName', 'email', 'firstDay', 'salary'],
                        'properties' => [
                            'firstName' => ['type' => 'string'],
                            'lastName' => ['type' => 'string'],
                            'email' => ['type' => 'string'],
                            'firstDay' => ['type' => 'string'],
                            'salary' => ['type' => 'integer'],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, $schema);
    }

    public function testUpdateEmployee(): void
    {
        $randomNumber = mt_rand();
        $email = "test_controller_$randomNumber@update.test";

        $employee = (new User())
            ->setFirstName('TestController')
            ->setLastName('Update')
            ->setEmail($email)
            ->setFirstDay(new \DateTimeImmutable('2024-10-10'))
            ->setSalary(101);

        $this->em->persist($employee);
        $this->em->flush();

        $this->client->request('PUT', '/api/v1/employee/'.$employee->getId(), [], [], [], json_encode([
            'firstName' => 'Update',
            'lastName' => 'Test Controller',
            'salary' => $randomNumber,
        ], JSON_THROW_ON_ERROR));

        $this->assertResponseIsSuccessful();
        $responseContent = json_decode($this->client->getResponse()->getContent(), null, 512, JSON_THROW_ON_ERROR);

        $schema = [
            'type' => 'object',
            'required' => ['id'],
            'properties' => [
                'id' => ['type' => 'integer'],
            ],
        ];

        $this->assertJsonDocumentMatchesSchema($responseContent, $schema);
    }
}
