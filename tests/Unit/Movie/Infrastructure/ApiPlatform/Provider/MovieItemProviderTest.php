<?php

declare(strict_types=1);

namespace App\Tests\Unit\Movie\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use App\Movie\Domain\Model\Movie;
use App\Movie\Domain\Query\GetMovieQuery;
use App\Movie\Domain\ValueObject\MovieTitle;
use App\Movie\Infrastructure\ApiPlatform\Resource\MovieResource;
use App\Movie\Infrastructure\ApiPlatform\State\Provider\MovieItemProvider;
use App\Shared\CQRS\Domain\Query\QueryBusInterface;
use PHPUnit\Framework\TestCase;

final class MovieItemProviderTest extends TestCase
{
    /**
     * @dataProvider provideMovieData
     */
    public function testProvideReturnsMovieByTitle(?Movie $movie, ?string $expectedTitle): void
    {
        $queryBus = $this->createMock(QueryBusInterface::class);
        $queryBus->expects($this->once())
            ->method('ask')
            ->with($this->isInstanceOf(GetMovieQuery::class))
            ->willReturn($movie);

        $operation = $this->createMock(Operation::class);

        $provider = new MovieItemProvider($queryBus);
        $result = $provider->provide($operation, ['title' => 'Inception'], []);

        if (null === $expectedTitle) {
            $this->assertNull($result);
        } else {
            $this->assertInstanceOf(MovieResource::class, $result);
            $this->assertEquals($expectedTitle, $result->getTitle());
        }
    }

    public static function provideMovieData(): \Generator
    {
        yield [new Movie(new MovieTitle('Inception')), 'Inception'];
        yield [new Movie(new MovieTitle('The Matrix')), 'The Matrix'];
        yield [null, null];
    }
}
