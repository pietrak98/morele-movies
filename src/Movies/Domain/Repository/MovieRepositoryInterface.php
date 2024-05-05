<?php

namespace App\Movies\Domain\Repository;

interface MovieRepositoryInterface
{
    public function findAll(): array;
}
