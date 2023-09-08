<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\DTO\ApiErrorResponse;
use App\DTO\Employee\CreateEmployeeRequest;
use App\DTO\Employee\EmployeeListResponse;
use App\DTO\Employee\UpdateEmployeeRequest;
use App\DTO\IdResponse;
use App\Service\EmployeeServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    public function __construct(private readonly EmployeeServiceInterface $employeeService)
    {
    }

    #[Route('/api/v1/employees', name: 'get employees', methods: ['GET'])]
    #[OA\Tag(name: 'Employee API')]
    #[OA\Response(response: 200, description: 'Get employees', content: new Model(type: EmployeeListResponse::class))]
    public function employees(): Response
    {
        return $this->json($this->employeeService->getEmployees());
    }

    /*#[Route('/api/v1/employee/{id}', name: 'employee', methods: ['GET'])]
    public function employee(int $id): Response
    {
        return $this->json(null);
    }*/

    #[Route('/api/v1/employee', name: 'create employee', methods: ['POST'])]
    #[OA\Tag(name: 'Employee API')]
    #[OA\Response(response: 200, description: 'Create employee', content: new Model(type: IdResponse::class))]
    #[OA\Response(response: 400, description: 'Validation failed', content: new Model(type: ApiErrorResponse::class))]
    #[OA\RequestBody(content: new Model(type: CreateEmployeeRequest::class))]
    public function createEmployee(#[RequestBody] CreateEmployeeRequest $createEmployeeRequest): Response
    {
        return $this->json($this->employeeService->createEmployee($createEmployeeRequest));
    }

    #[Route('/api/v1/employee/{id}', name: 'update employee', methods: ['PUT'])]
    #[OA\Tag(name: 'Employee API')]
    #[OA\Response(response: 200, description: 'Update employee', content: new Model(type: IdResponse::class))]
    #[OA\Response(response: 400, description: 'Validation failed', content: new Model(type: ApiErrorResponse::class))]
    #[OA\RequestBody(content: new Model(type: UpdateEmployeeRequest::class))]
    public function updateEmployee(int $id, #[RequestBody] UpdateEmployeeRequest $updateEmployeeRequest): Response
    {
        return $this->json($this->employeeService->updateEmployee($id, $updateEmployeeRequest));
    }

    #[Route('/api/v1/employee/{id}', name: 'delete employee', methods: ['DELETE'])]
    #[OA\Tag(name: 'Employee API')]
    #[OA\Response(response: 200, description: 'Delete employee', content: new Model(type: EmployeeListResponse::class))]
    #[OA\Response(response: 404, description: 'Employee not found', content: new Model(type: ApiErrorResponse::class))]
    public function deleteEmployee(int $id): Response
    {
        $this->employeeService->deleteEmployee($id);

        return $this->json('User deleted');
    }
}
