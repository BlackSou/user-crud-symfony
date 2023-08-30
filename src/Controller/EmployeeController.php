<?php

namespace App\Controller;

use App\DTO\ApiErrorResponse;
use App\DTO\CreateEmployeeRequest;
use App\Service\EmployeeServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    public function __construct(private readonly EmployeeServiceInterface $employeeService)
    {
    }

    #[Route('/api/v1/employee', name: 'employee', methods: ['POST'])]
    #[OA\Tag(name: 'Employee API')]
    #[OA\Response(response: 200, description: 'Create a employee', attachables: [new Model(type: EmployeeServiceInterface::class)])]
    #[OA\Response(response: 400, description: 'Employee duplicate', attachables: [new Model(type: ApiErrorResponse::class)])]
    #[OA\RequestBody(attachables: [new Model(type: CreateEmployeeRequest::class)])]
    public function createEmployee(#[RequestBody] CreateEmployeeRequest $createEmployeeRequest): Response
    {
        return $this->json($this->employeeService->createEmployee($createEmployeeRequest));
    }
}
