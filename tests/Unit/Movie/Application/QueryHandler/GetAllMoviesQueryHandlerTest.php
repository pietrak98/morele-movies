<?php

declare(strict_types=1);

namespace App\Tests\Unit\Movie\Application\QueryHandler;

use App\Movie\Application\QueryHandler\GetAllMoviesQueryHandler;
use App\Movie\Domain\Model\Movie;
use App\Movie\Domain\Query\GetAllMoviesQuery;
use App\Movie\Domain\Repository\MovieRepositoryInterface;
use App\Movie\Domain\ValueObject\MovieTitle;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class GetAllMoviesQueryHandlerTest extends TestCase
{
    #[DataProvider('provideMoviesData')]
    public function testHandleReturnsAllMovies(array $moviesData, int $expectedCount): void
    {
        $movieRepository = $this->createMock(MovieRepositoryInterface::class);
        $movieRepository->expects($this->once())
            ->method('findAll')
            ->willReturn(array_map(fn ($title): Movie => new Movie(new MovieTitle($title)), $moviesData));

        $handler = new GetAllMoviesQueryHandler($movieRepository);
        $movies = $handler(new GetAllMoviesQuery());

        $this->assertCount($expectedCount, $movies);
        foreach ($movies as $key => $movie) {
            $this->assertEquals($moviesData[$key], $movie->getTitle()->toString());
        }
    }

    public static function provideMoviesData(): \Generator
    {
        yield [['Inception', 'The Matrix'], 2];
        yield [['The Matrix'], 1];
        yield [[], 0];
        yield [['Inception', 'The Matrix', 'Avatar', 'The Dark Knight'], 4];
    }
}
