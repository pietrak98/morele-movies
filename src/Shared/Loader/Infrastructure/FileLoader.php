<?php

declare(strict_types=1);

namespace App\Shared\Loader\Infrastructure;

use App\Shared\Loader\Domain\LoaderInterface;

final class FileLoader implements LoaderInterface
{
    #[\Override]
    public function load(string $filePath): array
    {
        return include $filePath;
    }
}
