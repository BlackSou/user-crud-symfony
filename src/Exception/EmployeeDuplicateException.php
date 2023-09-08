<?php

namespace App\Exception;

class EmployeeDuplicateException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Employee duplicate');
    }
}
