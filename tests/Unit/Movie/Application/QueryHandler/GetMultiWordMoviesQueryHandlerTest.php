<?php

declare(strict_types=1);

namespace App\Tests\Unit\Movie\Application\QueryHandler;

use App\Movie\Application\QueryHandler\GetMultiWordMoviesQueryHandler;
use App\Movie\Domain\Model\Movie;
use App\Movie\Domain\Query\GetMultiWordMoviesQuery;
use App\Movie\Domain\Repository\MovieRepositoryInterface;
use App\Movie\Domain\ValueObject\MovieTitle;
use PHPUnit\Framework\TestCase;

final class GetMultiWordMoviesQueryHandlerTest extends TestCase
{
    /**
     * @dataProvider provideMoviesData
     */
    public function testHandleFiltersMoviesWithMoreThanOneWord(array $moviesData, array $expectedTitles): void
    {
        $movieRepository = $this->createMock(MovieRepositoryInterface::class);
        $movieRepository->expects($this->once())
            ->method('findAll')
            ->willReturn(array_map(fn ($title): Movie => new Movie(new MovieTitle($title)), $moviesData));

        $handler = new GetMultiWordMoviesQueryHandler($movieRepository);
        $movies = $handler(new GetMultiWordMoviesQuery());

        $this->assertCount(count($expectedTitles), $movies);
        foreach ($movies as $key => $movie) {
            $this->assertEquals($expectedTitles[$key], $movie->getTitle()->toString());
        }
    }

    public static function provideMoviesData(): \Generator
    {
        yield [['Test Test', 'The Dark Knight', 'Batman'], ['Test Test', 'The Dark Knight']];
        yield [['Inception', 'Avatar'], []];
        yield [[], []];
    }
}
