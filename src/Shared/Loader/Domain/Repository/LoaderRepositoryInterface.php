<?php

namespace App\Shared\Loader\Domain\Repository;

use App\Shared\Loader\Domain\Model\Loader;

interface LoaderRepositoryInterface
{
    public function find(): Loader;
}
