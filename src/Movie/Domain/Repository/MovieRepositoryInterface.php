<?php

declare(strict_types=1);

namespace App\Movie\Domain\Repository;

use App\Movie\Domain\Model\Movie;

interface MovieRepositoryInterface
{
    /**
     * @return array<Movie>
     */
    public function findAll(): array;

    /**
     * Finds a movie by its title.
     */
    public function findByTitle(string $title): ?Movie;
}
