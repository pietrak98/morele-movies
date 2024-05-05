<?php

namespace App\Shared\Loader\Domain\Model;

class Loader implements LoaderInterface
{
    public function __construct(private $source)
    {
    }

    public function getSource()
    {
        return $this->source;
    }
}
