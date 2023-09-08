<?php

namespace App\Exception;

class EmployeeNotFoundException extends \RuntimeException
{

    public function __construct()
    {
        parent::__construct('Employee not found');
    }
}
