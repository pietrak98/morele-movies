<?php

declare(strict_types=1);

namespace App\Movie\Application\QueryHandler;

use App\Movie\Domain\Query\GetMoviesByLetterAndEvenLengthQuery;
use App\Movie\Domain\Repository\MovieRepositoryInterface;
use App\Shared\CQRS\Domain\Query\AsQueryHandler;

#[AsQueryHandler]
final readonly class GetMoviesByLetterAndEvenLengthQueryHandler
{
    public function __construct(
        private MovieRepositoryInterface $movieRepository
    ) {}

    public function __invoke(GetMoviesByLetterAndEvenLengthQuery $query): array
    {
        $movies = $this->movieRepository->findAll();

        return array_filter($movies, fn ($movie): bool => $movie->getTitle()->startsWithLetter($query->letter)
            && $movie->getTitle()->hasEvenLength());
    }
}
