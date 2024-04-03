<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JSONController extends AbstractController
{
    #[Route("/api", name: "json_routes")]
    public function routes(): Response
    {
        $data = [];

        return $this->render('json_routes.html.twig', $data);
    }

    #[Route("/api/quote")]
    public function jsonNumber(): Response
    {
        $number = random_int(0, 2);

        $quotes = ["Life is like riding a bicycle. To keep your balance, you must keep moving.",
            "Anyone who has never made a mistake has never tried anything new.",
            "If you can't explain it simply, you don't understand it well enough."
        ];

        $data = [
            'lucky-quote' => $quotes[$number],
        ];

        return new JsonResponse($data);
    }
}
