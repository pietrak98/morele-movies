<?php

declare(strict_types=1);

namespace App\Movie\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Movie\Domain\Query\GetMoviesByLetterAndEvenLengthQuery;
use App\Movie\Infrastructure\ApiPlatform\Resource\MovieResource;
use App\Shared\CQRS\Domain\Query\QueryBusInterface;

final readonly class MoviesByLetterAndEvenLengthProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {}

    #[\Override]
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $letter = $context['filters']['letter'] ?? 'W';
        $movies = $this->queryBus->ask(new GetMoviesByLetterAndEvenLengthQuery($letter));

        return array_map(fn ($movie): MovieResource => MovieResource::fromModel($movie), $movies);
    }
}
