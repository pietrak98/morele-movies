<?php

namespace App\Movies\Application\Controller\Api;

use App\Movies\Application\Service\MovieRecommendationService;
use App\Movies\Domain\Service\MovieRecommendationServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/movies', name: 'movie.')]
#[AsController]
readonly class MovieRecommendationController
{
    /**
     * @param Serializer                 $serializer
     * @param MovieRecommendationService $movieRecommendationService
     */
    public function __construct(
        private SerializerInterface $serializer,
        private MovieRecommendationServiceInterface $movieRecommendationService
    ) {
    }

    #[Route('/random', name: 'random', methods: [Request::METHOD_GET])]
    public function getRandomMovies(int $count = 3): JsonResponse
    {
        $movies = $this->movieRecommendationService->getRandomMovies($count);

        $serializedMovies = $this->serializer->serialize($movies, 'json');

        return new JsonResponse($serializedMovies, Response::HTTP_OK, [], true);
    }

    #[Route('/starting-with-w-and-even-chars', name: 'starting_with_w_and_even_chars', methods: [Request::METHOD_GET])]
    public function getMoviesStartingWithWAndEvenChars(): JsonResponse
    {
        $movies = $this->movieRecommendationService->getMoviesStartingWithWAndEvenChars();

        $serializedMovies = $this->serializer->serialize($movies, 'json');

        return new JsonResponse($serializedMovies, Response::HTTP_OK, [], true);
    }

    #[Route('/more-than-one-word', name: 'more_than_one_word', methods: [Request::METHOD_GET])]
    public function getMoviesWithMoreThanOneWord(): JsonResponse
    {
        $movies = $this->movieRecommendationService->getMoviesWithMoreThanOneWord();

        $serializedMovies = $this->serializer->serialize($movies, 'json');

        return new JsonResponse($serializedMovies, Response::HTTP_OK, [], true);
    }
}
