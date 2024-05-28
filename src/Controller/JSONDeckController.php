<?php

namespace App\Controller;

use App\Card\DeckOfCards;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JSONDeckController extends AbstractController
{
    #[Route("/api/deck", name: "json_deck", format: 'json')]
    public function jsonDeck(): Response
    {
        $deck = new DeckOfCards();

        $data = [
            "deck" => $deck->getDeckSorted(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/shuffle", name: "json_shuffle", methods: ['POST'])]
    public function jsonShuffle(SessionInterface $session): Response
    {
        if ($session->has("deck_shuffle")) {
            $deck = $session->get("deck_shuffle");
        } else {
            $deck = new DeckOfCards();
        }

        $session->set("deck_shuffle", $deck);

        $data = [
            "shuffle" => $deck->getDeckShuffled(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/draw", name: "json_draw", methods: ['POST'])]
    public function jsonDraw(SessionInterface $session): Response
    {
        if ($session->has("deck_shuffle")) {
            $deck = $session->get("deck_shuffle");
        } else {
            $deck = new DeckOfCards();
        }

        $session->set("deck_shuffle", $deck);

        $data = [
            "draw" => $deck->draw(),
            "cards_left" => $deck->getNrOfCards(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/draw/get_nr", name: "get_nr", methods: ['POST'])]
    public function jsonGetNumber(Request $request): Response
    {
        $num = $request->request->get('num');

        return $this->redirectToRoute('json_draw_nr', ['number' => $num], 307);
    }

    #[Route("/api/deck/draw/{number<\d+>}", name: "json_draw_nr", methods: ['POST'])]
    public function jsonDrawNumber(int $number, SessionInterface $session): Response
    {
        if ($session->has("deck_shuffle")) {
            $deck = $session->get("deck_shuffle");
        } else {
            $deck = new DeckOfCards();
        }

        if ($deck->getNrOfCards() === 0) {
            $deck = new DeckOfCards();
        }

        if ($number > $deck->getNrOfCards()) {
            $number = $deck->getNrOfCards();
        }

        $session->set("deck_shuffle", $deck);

        $data = [
            "drawHand" => $deck->drawNumber($number),
            "cards_left" => $deck->getNrOfCards(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/game}", name: "score")]
    public function currentScore(SessionInterface $session): Response
    {
        $game = $session->get("game");

        $data = [
            "score_player" => $game->getScorePlayer(),
            "score_bank" => $game->getScoreBank(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
