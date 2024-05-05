<?php

namespace App\Movies\Application\Service;

use App\Movies\Domain\Model\Movie;
use App\Movies\Domain\Repository\MovieRepositoryInterface;
use App\Movies\Domain\Service\MovieRecommendationServiceInterface;
use App\Movies\Infrastructure\Repository\MovieRepository;
use App\Shared\Utils\StringUtil;

readonly class MovieRecommendationService implements MovieRecommendationServiceInterface
{
    /**
     * @param MovieRepository $movieRepository
     */
    public function __construct(
        private MovieRepositoryInterface $movieRepository
    ) {
    }

    /**
     * @return Movie[]
     * @throws \Exception
     */
    public function getRandomMovies(int $count = 3): array
    {
        $movies = $this->movieRepository->findAll();
        shuffle($movies);

        return array_slice($movies, 0, $count);
    }

    /**
     * @return Movie[]
     * @throws \Exception
     */
    public function getMoviesStartingWithWAndEvenChars(): array
    {
        $movies = $this->movieRepository->findAll();

        return array_filter($movies, static fn (Movie $movie): bool => str_starts_with($movie->getTitle(), 'W') && 0 === mb_strlen($movie->getTitle()) % 2
        );
    }

    /**
     * @return Movie[]
     * @throws \Exception
     */
    public function getMoviesWithMoreThanOneWord(): array
    {
        $movies = $this->movieRepository->findAll();

        return array_filter($movies, static fn (Movie $movie): bool => StringUtil::countWords($movie->getTitle()) > 1
        );
    }
}
