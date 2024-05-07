<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MoviesController extends AbstractController
{
    public function __construct(
        private MovieRepository $movieRepository,
        private SerializerInterface $serializer
    ) {}

    #[Route('/movies', methods: ['GET'])]
    public function list(Request $request, MovieRepository $movieRepository): JsonResponse
    {
        $filterMovie = $request->query->get('filterMovie');

        if ($filterMovie === 'recenti') {

            $movies = $this->movieRepository->findBy([], ['releaseDate' => 'DESC']);
            
        } elseif ($filterMovie === 'rating') {

            $movies = $this->movieRepository->findBy([], ['rating' => 'DESC']);

        } else {

            $movies = $this->movieRepository->findAll();
        }

        if (isset($movies)) {
            $data = $this->serializer->serialize($movies, "json", ["groups" => "default"]);
        } else {
            $data = null;
        }

        return new JsonResponse($data, json: true);


        $response = new Response();

        $response->headers->set('Access-Control-Allow-Origin', 'http://172.22.208.1:5173');

        return $response;
    }
}
