<?php

namespace App\Contracts;

interface CompanyStore extends Repository
{
    public function getLogoName(string $name, int $id): string;
}
