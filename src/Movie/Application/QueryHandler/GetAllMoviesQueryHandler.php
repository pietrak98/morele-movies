<?php

declare(strict_types=1);

namespace App\Movie\Application\QueryHandler;

use App\Movie\Domain\Query\GetAllMoviesQuery;
use App\Movie\Domain\Repository\MovieRepositoryInterface;
use App\Shared\CQRS\Domain\Query\AsQueryHandler;

#[AsQueryHandler]
final readonly class GetAllMoviesQueryHandler
{
    public function __construct(
        private MovieRepositoryInterface $movieRepository
    ) {}

    public function __invoke(GetAllMoviesQuery $query): array
    {
        return $this->movieRepository->findAll();
    }
}
