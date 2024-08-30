<?php

declare(strict_types=1);

namespace App\Tests\Unit\Movie\Application\QueryHandler;

use App\Movie\Application\QueryHandler\GetRandomMoviesQueryHandler;
use App\Movie\Domain\Model\Movie;
use App\Movie\Domain\Query\GetRandomMoviesQuery;
use App\Movie\Domain\Repository\MovieRepositoryInterface;
use App\Movie\Domain\ValueObject\MovieTitle;
use PHPUnit\Framework\TestCase;

final class GetRandomMoviesQueryHandlerTest extends TestCase
{
    /**
     * @dataProvider provideMoviesData
     */
    public function testHandleReturnsRandomMovies(array $moviesData, int $expectedCount): void
    {
        $movieRepository = $this->createMock(MovieRepositoryInterface::class);
        $movieRepository->expects($this->once())
            ->method('findAll')
            ->willReturn(array_map(fn ($title): Movie => new Movie(new MovieTitle($title)), $moviesData));

        $handler = new GetRandomMoviesQueryHandler($movieRepository);
        $movies = $handler(new GetRandomMoviesQuery($expectedCount));

        $this->assertCount(min($expectedCount, count($moviesData)), $movies);
    }

    public static function provideMoviesData(): \Generator
    {
        yield [['Movie 1', 'Movie 2', 'Movie 3'], 2];
        yield [['Movie 1', 'Movie 2'], 3];
        yield [[], 0];
        yield [['Movie 1', 'Movie 2', 'Movie 3', 'Movie 4'], 4];
    }
}
