<?php

declare(strict_types=1);

namespace App\Tests\Unit\Movie\Application\QueryHandler;

use App\Movie\Application\QueryHandler\GetMovieQueryHandler;
use App\Movie\Domain\Model\Movie;
use App\Movie\Domain\Query\GetMovieQuery;
use App\Movie\Domain\Repository\MovieRepositoryInterface;
use App\Movie\Domain\ValueObject\MovieTitle;
use PHPUnit\Framework\TestCase;

final class GetMovieQueryHandlerTest extends TestCase
{
    /**
     * @dataProvider provideMovieData
     */
    public function testHandleReturnsMovieByTitle(?Movie $movie, ?string $expectedTitle): void
    {
        $movieRepository = $this->createMock(MovieRepositoryInterface::class);
        $movieRepository->expects($this->once())
            ->method('findByTitle')
            ->with('Inception')
            ->willReturn($movie);

        $handler = new GetMovieQueryHandler($movieRepository);
        $result = $handler(new GetMovieQuery('Inception'));

        if (null === $expectedTitle) {
            $this->assertNull($result);
        } else {
            $this->assertEquals($expectedTitle, $result->getTitle()->toString());
        }
    }

    public static function provideMovieData(): \Generator
    {
        yield [new Movie(new MovieTitle('Inception')), 'Inception'];
        yield [new Movie(new MovieTitle('The Matrix')), 'The Matrix'];
        yield [null, null];
    }
}
