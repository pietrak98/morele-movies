<?php

declare(strict_types=1);

namespace App\Movie\Application\QueryHandler;

use App\Movie\Domain\Model\Movie;
use App\Movie\Domain\Query\GetMovieQuery;
use App\Movie\Domain\Repository\MovieRepositoryInterface;
use App\Shared\CQRS\Domain\Query\AsQueryHandler;

#[AsQueryHandler]
final readonly class GetMovieQueryHandler
{
    public function __construct(
        private MovieRepositoryInterface $movieRepository
    ) {}

    public function __invoke(GetMovieQuery $query): ?Movie
    {
        return $this->movieRepository->findByTitle($query->title);
    }
}
