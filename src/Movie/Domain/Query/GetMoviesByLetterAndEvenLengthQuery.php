<?php

declare(strict_types=1);

namespace App\Movie\Domain\Query;

use App\Movie\Domain\Model\Movie;
use App\Shared\CQRS\Domain\Query\QueryInterface;

/**
 * @implements QueryInterface<Movie>
 */
final readonly class GetMoviesByLetterAndEvenLengthQuery implements QueryInterface
{
    public function __construct(
        public string $letter
    ) {}
}
