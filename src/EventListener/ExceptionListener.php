<?php

namespace App\EventListener;

use App\DTO\ApiErrorResponse;
use App\Service\ExceptionHandler\ExceptionMapping;
use App\Service\ExceptionHandler\ExceptionMappingResolver;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionListener
{
    public function __construct(
        private readonly ExceptionMappingResolver $mappingResolver,
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer,
        private readonly bool $isDebug
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        $mapping = $this->mappingResolver->resolve($throwable::class);
        if (null === $mapping) {
            $mapping = ExceptionMapping::fromCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($mapping->getCode() >= Response::HTTP_INTERNAL_SERVER_ERROR || $mapping->isLoggable()) {
            $this->logger->error($throwable->getMessage(), [
                'trace' => $throwable->getTraceAsString(),
                'previous' => null !== $throwable->getPrevious() ? $throwable->getPrevious()->getMessage() : '',
            ]);
        }

        $message = $mapping->isHidden() ? Response::$statusTexts[$mapping->getCode()] : $throwable->getMessage();
        $details = $this->isDebug ? ['trace' => $throwable->getTraceAsString()] : $throwable->getMessage();
        $data = $this->serializer->serialize(new ApiErrorResponse($message, $details), JsonEncoder::FORMAT);

        $response = new JsonResponse($data, $mapping->getCode(), [], true);

        $event->setResponse($response);
    }
}
