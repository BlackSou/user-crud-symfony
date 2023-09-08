<?php

namespace App\EventListener;

use App\DTO\ApiErrorResponse;
use App\DTO\ApiErrorValidationDetails;
use App\Exception\ValidationFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationExceptionListener
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        if (!($throwable instanceof ValidationFailedException)) {
            return;
        }

        $data = $this->serializer->serialize(
            new ApiErrorResponse($throwable->getMessage(), $this->formatViolations($throwable->getViolations())),
            JsonEncoder::FORMAT,
        );

        $event->setResponse(new JsonResponse($data, Response::HTTP_BAD_REQUEST, [], true));
    }

    private function formatViolations(ConstraintViolationListInterface $violations): ApiErrorValidationDetails
    {
        $details = new ApiErrorValidationDetails();

        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $details->addViolation($violation->getPropertyPath(), $violation->getMessage());
        }

        return $details;
    }
}
