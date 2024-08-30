<?php

declare(strict_types=1);

namespace App\Movie\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Movie\Domain\Model\Movie;
use App\Movie\Infrastructure\ApiPlatform\State\Provider\MovieItemProvider;
use App\Movie\Infrastructure\ApiPlatform\State\Provider\MoviesByLetterAndEvenLengthProvider;
use App\Movie\Infrastructure\ApiPlatform\State\Provider\MoviesCollectionProvider;
use App\Movie\Infrastructure\ApiPlatform\State\Provider\MoviesRandomProvider;

#[ApiResource(
    shortName: 'Movie',
    operations: [
        // queries
        new GetCollection(
            uriTemplate: '/movies/random',
            openapiContext: [
                'summary' => 'Get 3 random movies',
            ],
            provider: MoviesRandomProvider::class
        ),
        new GetCollection(
            uriTemplate: '/movies/starting-with-w-and-even-chars',
            openapiContext: [
                'summary' => 'Get movies starting with a specific letter and having an even number of characters',
            ],
            provider: MoviesByLetterAndEvenLengthProvider::class
        ),
        new GetCollection(
            uriTemplate: '/movies/more-than-one-word',
            openapiContext: [
                'summary' => 'Get movies with more than one word in the title',
            ],
            provider: MoviesM::class
        ),
        // commands

        // basic crud
        new GetCollection(
            provider: MoviesCollectionProvider::class,
        ),
        new Get(
            uriTemplate: '/movies/{title}',
            provider: MovieItemProvider::class,
        ),
    ]
)]
final readonly class MovieResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        private string $title
    ) {}

    public static function fromModel(Movie $movie): self
    {
        return new self($movie->getTitle()->toString());
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
