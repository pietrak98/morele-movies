<?php

namespace App\Movies\Domain\Model;

readonly class Movie
{
    public function __construct(
        private string $title
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
