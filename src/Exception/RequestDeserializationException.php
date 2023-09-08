<?php

namespace App\Exception;

class RequestDeserializationException extends \RuntimeException
{
    public function __construct(\Throwable $throwable)
    {
        parent::__construct('Error while deserialization request body', 0, $throwable);
    }
}
