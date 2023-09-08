<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\DTO\ApiErrorResponse;
use App\DTO\Employee\CreateEmployeeRequest;
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

    #[Route('/api/v1/employee', name: 'create employee', methods: ['POST'])]
    #[OA\Tag(name: 'Employee API')]
    #[OA\Response(response: 200, description: 'Create employee', content: new Model(type: IdResponse::class))]
    #[OA\Response(response: 400, description: 'Validation failed', content: new Model(type: ApiErrorResponse::class))]
    #[OA\RequestBody(content: new Model(type: CreateEmployeeRequest::class))]
    public function createEmployee(#[RequestBody] CreateEmployeeRequest $createEmployeeRequest): Response
    {
        return $this->json($this->employeeService->createEmployee($createEmployeeRequest));
    }
}
