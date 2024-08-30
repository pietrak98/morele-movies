<?php

declare(strict_types=1);

namespace App\Tests\Unit\Movie\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use App\Movie\Domain\Model\Movie;
use App\Movie\Domain\Query\GetAllMoviesQuery;
use App\Movie\Domain\ValueObject\MovieTitle;
use App\Movie\Infrastructure\ApiPlatform\Resource\MovieResource;
use App\Movie\Infrastructure\ApiPlatform\State\Provider\MoviesCollectionProvider;
use App\Shared\CQRS\Domain\Query\QueryBusInterface;
use PHPUnit\Framework\TestCase;

final class MovieCollectionProviderTest extends TestCase
{
    /**
     * @dataProvider provideMoviesData
     */
    public function testProvideReturnsAllMovies(array $moviesData, int $expectedCount): void
    {
        $queryBus = $this->createMock(QueryBusInterface::class);
        $queryBus->expects($this->once())
            ->method('ask')
            ->with($this->isInstanceOf(GetAllMoviesQuery::class))
            ->willReturn(array_map(fn ($title): Movie => new Movie(new MovieTitle($title)), $moviesData));

        $operation = $this->createMock(Operation::class);

        $provider = new MoviesCollectionProvider($queryBus);
        $movies = $provider->provide($operation, [], []);

        $this->assertCount($expectedCount, $movies);
        $this->assertContainsOnlyInstancesOf(MovieResource::class, $movies);
    }

    public static function provideMoviesData(): \Generator
    {
        yield [['Inception', 'The Matrix'], 2];
        yield [['The Matrix'], 1];
        yield [[], 0];
        yield [['Inception', 'The Matrix', 'Avatar', 'The Dark Knight'], 4];
    }
}
