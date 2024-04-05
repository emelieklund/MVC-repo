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

    #[Route("/api/quote", name: "quote")]
    public function jsonQuote(): Response
    {
        $number = random_int(0, 2);

        $quotes = ["Life is like riding a bicycle. To keep your balance, you must keep moving.",
            "Anyone who has never made a mistake has never tried anything new.",
            "If you cant explain it simply, you dont understand it well enough."
        ];

        $date = date("Y-m-d");

        date_default_timezone_set("Europe/Stockholm");
        $time = date("h:i:sa");

        $data = [
            'lucky-quote' => $quotes[$number],
            'date' => $date,
            'time' => $time,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
