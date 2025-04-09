<?php

namespace App\Contracts;

interface CustomerDataProviderInterface
{
    public function fetchCustomers(int $count): array;
}
