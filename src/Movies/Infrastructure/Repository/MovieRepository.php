<?php

namespace App\Movies\Infrastructure\Repository;

use App\Movies\Domain\Model\Movie;
use App\Movies\Domain\Repository\MovieRepositoryInterface;
use App\Shared\Loader\Application\LoaderService;

readonly class MovieRepository implements MovieRepositoryInterface
{
    public function __construct(
        private LoaderService $loaderService
    ) {
    }

    /**
     * @return Movie[]
     * @throws \Exception
     */
    public function findAll(): array
    {
        $moviesData = $this->loaderService->load();

        $movies = [];
        foreach ($moviesData as $title) {
            $movies[] = new Movie($title);
        }

        return $movies;
    }
}
