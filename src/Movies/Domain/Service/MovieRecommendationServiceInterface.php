<?php

namespace App\Movies\Domain\Service;

use App\Movies\Domain\Repository\MovieRepositoryInterface;

interface MovieRecommendationServiceInterface
{
    public function __construct(MovieRepositoryInterface $movieRepository);

    public function getRandomMovies(int $count = 3): array;

    public function getMoviesStartingWithWAndEvenChars(): array;

    public function getMoviesWithMoreThanOneWord(): array;
}
