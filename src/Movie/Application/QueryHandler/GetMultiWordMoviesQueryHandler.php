<?php

declare(strict_types=1);

namespace App\Movie\Application\QueryHandler;

use App\Movie\Domain\Query\GetMultiWordMoviesQuery;
use App\Movie\Domain\Repository\MovieRepositoryInterface;
use App\Shared\CQRS\Domain\Query\AsQueryHandler;

#[AsQueryHandler]
final readonly class GetMultiWordMoviesQueryHandler
{
    public function __construct(
        private MovieRepositoryInterface $movieRepository
    ) {}

    public function __invoke(GetMultiWordMoviesQuery $query): array
    {
        $movies = $this->movieRepository->findAll();

        return array_filter($movies, fn ($movie): bool => $movie->getTitle()->wordCount() > 1);
    }
}
