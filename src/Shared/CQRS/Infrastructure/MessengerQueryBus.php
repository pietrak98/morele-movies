<?php

declare(strict_types=1);

namespace App\Shared\CQRS\Infrastructure;

use App\Shared\CQRS\Domain\Query\QueryBusInterface;
use App\Shared\CQRS\Domain\Query\QueryInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerQueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @template T
     *
     * @param QueryInterface<T> $query
     *
     * @return T
     */
    #[\Override]
    public function ask(QueryInterface $query): mixed
    {
        try {
            /* @var T */
            return $this->handle($query);
        } catch (HandlerFailedException $handlerFailedException) {
            if ($exception = current($handlerFailedException->getWrappedExceptions())) {
                throw $exception;
            }

            throw $handlerFailedException;
        }
    }
}
