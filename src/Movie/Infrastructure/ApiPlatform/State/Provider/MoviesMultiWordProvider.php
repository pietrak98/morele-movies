<?php

declare(strict_types=1);

namespace App\Movie\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Movie\Domain\Query\GetMultiWordMoviesQuery;
use App\Movie\Infrastructure\ApiPlatform\Resource\MovieResource;
use App\Shared\CQRS\Domain\Query\QueryBusInterface;

final readonly class MoviesMultiWordProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {}

    #[\Override]
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $movies = $this->queryBus->ask(new GetMultiWordMoviesQuery());

        return array_map(fn ($movie): MovieResource => MovieResource::fromModel($movie), $movies);
    }
}
