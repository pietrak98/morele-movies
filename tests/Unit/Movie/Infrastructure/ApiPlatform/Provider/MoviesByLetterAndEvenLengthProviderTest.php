<?php

declare(strict_types=1);

namespace App\Tests\Unit\Movie\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use App\Movie\Domain\Model\Movie;
use App\Movie\Domain\Query\GetMoviesByLetterAndEvenLengthQuery;
use App\Movie\Domain\ValueObject\MovieTitle;
use App\Movie\Infrastructure\ApiPlatform\State\Provider\MoviesByLetterAndEvenLengthProvider;
use App\Shared\CQRS\Domain\Query\QueryBusInterface;
use PHPUnit\Framework\TestCase;

final class MoviesByLetterAndEvenLengthProviderTest extends TestCase
{
    /**
     * @dataProvider provideMoviesStartingWithLetterData
     */
    public function testProvideReturnsMoviesStartingWithLetter(array $moviesData, array $expectedTitles): void
    {
        $queryBus = $this->createMock(QueryBusInterface::class);
        $queryBus->expects($this->once())
            ->method('ask')
            ->with($this->isInstanceOf(GetMoviesByLetterAndEvenLengthQuery::class))
            ->willReturn(array_map(fn ($title): Movie => new Movie(new MovieTitle($title)), $moviesData));

        $operation = $this->createMock(Operation::class);

        $provider = new MoviesByLetterAndEvenLengthProvider($queryBus);
        $movies = $provider->provide($operation, [], []);

        $this->assertCount(count($expectedTitles), $movies);
        foreach ($movies as $key => $movieResource) {
            $this->assertEquals($expectedTitles[$key], $movieResource->getTitle());
        }
    }

    public static function provideMoviesStartingWithLetterData(): \Generator
    {
        yield [['Wolverine', 'Wonder Woman', 'Wolf'], ['Wolverine', 'Wonder Woman', 'Wolf']];
        yield [['Avatar', 'Aquaman'], ['Avatar', 'Aquaman']];
        yield [[], []];
    }
}
