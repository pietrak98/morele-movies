<?php

namespace App\Tests\Movies;

use App\Movies\Application\Service\MovieRecommendationService;
use App\Movies\Domain\Model\Movie;
use App\Movies\Domain\Repository\MovieRepositoryInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProviderExternal;

class MovieRecommendationServiceTest extends TestCase
{
    private MovieRecommendationService $movieRecommendationService;

    #[DataProviderExternal(MovieRecommendationDataProvider::class, 'provideRandomMoviesData')]
    public function testGetRandomMovies(int $count, int $expectedCount): void
    {
        $moviesData = array_fill(0, $count, ['title' => 'Dummy Movie']);

        $movieRepositoryMock = $this->createMock(MovieRepositoryInterface::class);
        $movieRepositoryMock->method('findAll')->willReturn(array_map(fn($movie) => new Movie($movie['title']), $moviesData));

        $this->movieRecommendationService = new MovieRecommendationService($movieRepositoryMock);

        $movies = $this->movieRecommendationService->getRandomMovies($expectedCount);
        $this->assertCount($expectedCount, $movies);
    }

    #[DataProviderExternal(MovieRecommendationDataProvider::class, 'provideMoviesStartingWithWAndEvenCharsData')]
    public function testGetMoviesStartingWithWAndEvenChars(array $moviesData, array $expectedResult): void
    {
        $movieRepositoryMock = $this->createMock(MovieRepositoryInterface::class);
        $movieRepositoryMock->method('findAll')->willReturn(array_map(fn($movie) => new Movie($movie), $moviesData));

        $this->movieRecommendationService = new MovieRecommendationService($movieRepositoryMock);

        $moviesResult = $this->movieRecommendationService->getMoviesStartingWithWAndEvenChars();
        $moviesResultArray = array_map(fn($movie) => $movie->getTitle(), $moviesResult);

        $this->assertEquals($expectedResult, array_values($moviesResultArray));
    }

    #[DataProviderExternal(MovieRecommendationDataProvider::class, 'provideMoviesWithMoreThanOneWordData')]
    public function testGetMoviesWithMoreThanOneWord(array $moviesData, array $expectedResult): void
    {
        $movieRepositoryMock = $this->createMock(MovieRepositoryInterface::class);
        $movieRepositoryMock->method('findAll')->willReturn(array_map(fn($movie) => new Movie($movie), $moviesData));

        $this->movieRecommendationService = new MovieRecommendationService($movieRepositoryMock);

        $moviesResult = $this->movieRecommendationService->getMoviesWithMoreThanOneWord();
        $moviesResultArray = array_map(fn($movie) => $movie->getTitle(), $moviesResult);

        $this->assertEquals($expectedResult, array_values($moviesResultArray));
    }
}
