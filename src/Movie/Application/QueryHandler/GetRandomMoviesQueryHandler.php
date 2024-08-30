<?php

declare(strict_types=1);

namespace App\Movie\Application\QueryHandler;

use App\Movie\Domain\Query\GetRandomMoviesQuery;
use App\Movie\Domain\Repository\MovieRepositoryInterface;
use App\Shared\CQRS\Domain\Query\AsQueryHandler;

#[AsQueryHandler]
final readonly class GetRandomMoviesQueryHandler
{
    public function __construct(
        private MovieRepositoryInterface $movieRepository
    ) {}

    public function __invoke(GetRandomMoviesQuery $query): array
    {
        $movies = $this->movieRepository->findAll();
        shuffle($movies);

        return array_slice($movies, 0, $query->count);
    }
}
