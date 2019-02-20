<?php

namespace App\Contracts;

interface EmployeeStore extends Repository
{
    public function getPaginatedEmployees(string $sortBy, string $order, int $num, $where = null);
}
