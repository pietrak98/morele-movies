<?php

declare(strict_types=1);

namespace App\Movie\Domain\Model;

use App\Movie\Domain\ValueObject\MovieTitle;

final readonly class Movie
{
    public function __construct(
        private MovieTitle $title
    ) {}

    public function getTitle(): MovieTitle
    {
        return $this->title;
    }
}
