<?php

declare(strict_types=1);

namespace App\Tests\Unit\Movie\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use App\Movie\Domain\Model\Movie;
use App\Movie\Domain\Query\GetRandomMoviesQuery;
use App\Movie\Domain\ValueObject\MovieTitle;
use App\Movie\Infrastructure\ApiPlatform\Resource\MovieResource;
use App\Movie\Infrastructure\ApiPlatform\State\Provider\MoviesRandomProvider;
use App\Shared\CQRS\Domain\Query\QueryBusInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MoviesRandomProviderTest extends TestCase
{
    #[DataProvider('provideRandomMoviesData')]
    public function testProvideReturnsRandomMovies(array $moviesData, int $expectedCount): void
    {
        $queryBus = $this->createMock(QueryBusInterface::class);
        $queryBus->expects($this->once())
            ->method('ask')
            ->with($this->isInstanceOf(GetRandomMoviesQuery::class))
            ->willReturn(array_map(fn ($title): Movie => new Movie(new MovieTitle($title)), $moviesData));

        $operation = $this->createMock(Operation::class);

        $provider = new MoviesRandomProvider($queryBus);
        $movies = $provider->provide($operation, [], []);

        $this->assertCount($expectedCount, $movies);
        $this->assertContainsOnlyInstancesOf(MovieResource::class, $movies);
    }

    public static function provideRandomMoviesData(): \Generator
    {
        yield [['Movie 1', 'Movie 2', 'Movie 3'], 3];
        yield [['Movie 1'], 1];
        yield [[], 0];
        yield [['Movie 1', 'Movie 2', 'Movie 3', 'Movie 4'], 4];
    }
}
