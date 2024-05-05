<?php

namespace App\Shared\Loader\Infrastructure;

use App\Shared\Loader\Domain\Model\Loader;
use App\Shared\Loader\Domain\Repository\LoaderRepositoryInterface;

class LoaderRepository implements LoaderRepositoryInterface
{
    public function __construct(private $source)
    {
    }

    public function find(): Loader
    {
        return new Loader($this->source);
    }
}
