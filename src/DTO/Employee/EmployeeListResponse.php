<?php

namespace App\DTO\Employee;

class EmployeeListResponse
{
    /**
     * @param EmployeeListItem[] $items
     */
    public function __construct(private readonly array $items)
    {
    }

    /**
     * @return EmployeeListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

}
