<?php

declare(strict_types=1);

namespace App\Tests\Movies;

use Generator;

readonly class MovieRecommendationDataProvider
{
    public static function provideRandomMoviesData(): Generator
    {
        yield [3, 3];
        yield [0, 0];
        yield [10, 8];
    }

    public static function provideMoviesStartingWithWAndEvenCharsData(): Generator
    {
        yield [
            'moviesData' => [
                'Wolverine',
                'Wolf',
                'Wonder Woman',
                'Witcher',
                'Warcraft',
            ],
            'expectedResult' => [
                'Wolf',
                'Wonder Woman',
                'Warcraft'
            ]
        ];
        yield [
            'moviesData' => [
                'WandaVision',
                'Wyatt Earp',
                'Willy Wonka',
                'Warrior',
            ],
            'expectedResult' => [
                'Wyatt Earp',
            ]
        ];
        yield [
            'moviesData' => [
                'Thor',
                'Guardians of the Galaxy',
                'Black Widow',
                'Iron Man',
            ],
            'expectedResult' => []
        ];
        yield [
            'moviesData' => [],
            'expectedResult' => [],
        ];
    }

    public static function provideMoviesWithMoreThanOneWordData(): Generator
    {
        yield [
            'moviesData' => [
                'Test',
                'Test Test',
                'Test Test Test',
                'Test🇪🇭',
                'Test😆Test',
                'Test🇪🇭Test',
            ],
            'expectedResult' => [
                'Test Test',
                'Test Test Test',
            ]
        ];
        yield [
            'moviesData' => [
                'Szczęki',
                'Incepcja',
                'Skazani na Shawshank',
                'Dwunastu gniewnych ludzi',
            ],
            'expectedResult' => [
                'Skazani na Shawshank',
                'Dwunastu gniewnych ludzi',
            ]
        ];
        yield [
            'moviesData' => [
                'Batman',
                'Superman',
                'Spider-Man'
            ],
            'expectedResult' => []
        ];
    }
}
