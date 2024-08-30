<?php

declare(strict_types=1);

namespace App\Movie\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Movie\Domain\Query\GetMovieQuery;
use App\Movie\Infrastructure\ApiPlatform\Resource\MovieResource;
use App\Shared\CQRS\Domain\Query\QueryBusInterface;

final readonly class MovieItemProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {}

    #[\Override]
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?MovieResource
    {
        $movie = $this->queryBus->ask(new GetMovieQuery($uriVariables['title']));

        return $movie ? MovieResource::fromModel($movie) : null;
    }
}
