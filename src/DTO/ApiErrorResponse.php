<?php

declare(strict_types=1);

namespace App\DTO;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

class ApiErrorResponse
{
    public function __construct(private readonly string $message, private readonly mixed $details = null)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    #[OA\Property(type: 'object', nullable: true, oneOf: [
        new OA\Schema(ref: new Model(type: ApiErrorDebugDetails::class)),
        new OA\Schema(ref: new Model(type: ApiErrorValidationDetails::class))]
    )]
    public function getDetails(): mixed
    {
        return $this->details;
    }
}
