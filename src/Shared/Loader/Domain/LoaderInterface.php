<?php

declare(strict_types=1);

namespace App\Shared\Loader\Domain;

interface LoaderInterface
{
    public function load(string $filePath): array;
}
