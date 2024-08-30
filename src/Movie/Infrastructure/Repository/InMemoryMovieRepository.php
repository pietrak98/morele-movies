<?php

declare(strict_types=1);

namespace App\Movie\Infrastructure\Repository;

use App\Movie\Domain\Model\Movie;
use App\Movie\Domain\Repository\MovieRepositoryInterface;
use App\Movie\Domain\ValueObject\MovieTitle;
use App\Shared\Loader\Domain\LoaderInterface;

final readonly class InMemoryMovieRepository implements MovieRepositoryInterface
{
    private array $movies;

    public function __construct(LoaderInterface $loader, string $filePath)
    {
        $this->movies = array_map(
            fn (string $title): Movie => new Movie(new MovieTitle($title)),
            $loader->load($filePath)
        );
    }

    #[\Override]
    public function findAll(): array
    {
        return $this->movies;
    }

    #[\Override]
    public function findByTitle(string $title): ?Movie
    {
        foreach ($this->movies as $movie) {
            if ($movie->getTitle()->toString() === $title) {
                return $movie;
            }
        }

        return null;
    }
}
