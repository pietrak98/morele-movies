<?php

declare(strict_types=1);

namespace App\Tests\Unit\Movie\Application\QueryHandler;

use App\Movie\Application\QueryHandler\GetMoviesByLetterAndEvenLengthQueryHandler;
use App\Movie\Domain\Model\Movie;
use App\Movie\Domain\Query\GetMoviesByLetterAndEvenLengthQuery;
use App\Movie\Domain\Repository\MovieRepositoryInterface;
use App\Movie\Domain\ValueObject\MovieTitle;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class GetMoviesByLetterAndEvenLengthQueryHandlerTest extends TestCase
{
    #[DataProvider('provideMoviesData')]
    public function testHandleFiltersMoviesStartingWithLetter(array $moviesData, string $letter, array $expectedTitles): void
    {
        $movieRepository = $this->createMock(MovieRepositoryInterface::class);
        $movieRepository->expects($this->once())
            ->method('findAll')
            ->willReturn(array_map(fn ($title): Movie => new Movie(new MovieTitle($title)), $moviesData));

        $handler = new GetMoviesByLetterAndEvenLengthQueryHandler($movieRepository);
        $movies = $handler(new GetMoviesByLetterAndEvenLengthQuery($letter));

        $movieTitles = array_map(fn ($movie) => $movie->getTitle()->toString(), $movies);

        sort($movieTitles);
        sort($expectedTitles);

        $this->assertCount(count($expectedTitles), $movies);
        $this->assertSame($expectedTitles, $movieTitles);
    }

    public static function provideMoviesData(): \Generator
    {
        yield [['Wolverine', 'Wonder Woman', 'Wolf'], 'W', ['Wonder Woman', 'Wolf']];
        yield [['Avatar', 'Aquaman'], 'A', ['Avatar']];
        yield [['Batman', 'Superman'], 'C', []];
        yield [[], 'W', []];
    }
}
