<?php

declare(strict_types=1);

namespace App\Shared\CQRS\Infrastructure;

use App\Shared\CQRS\Domain\Command\CommandBusInterface;
use App\Shared\CQRS\Domain\Command\CommandInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements CommandBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    /**
     * @template T
     *
     * @param CommandInterface<T> $command
     *
     * @return T
     */
    #[\Override]
    public function dispatch(CommandInterface $command): mixed
    {
        try {
            /* @var T */
            return $this->handle($command);
        } catch (HandlerFailedException $handlerFailedException) {
            if ($exception = current($handlerFailedException->getWrappedExceptions())) {
                throw $exception;
            }

            throw $handlerFailedException;
        }
    }
}
