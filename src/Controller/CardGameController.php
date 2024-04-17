<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }

    #[Route("/card/deck", name: "deck")]
    public function deck(
        SessionInterface $session
    ): Response
    {
        $deck = new DeckOfCards();

        $data = [
            "deck" => $deck->getDeckSorted(),
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/graphic", name: "graphic")]
    public function graphic(): Response
    {
        $cardGraphic = new DeckOfCards();

        $data = [
            "deck" => $cardGraphic->getGraphicDeck(),
        ];

        return $this->render('card/graphic.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "shuffle")]
    public function shuffle(
        SessionInterface $session
    ): Response
    {
        $deck = new DeckOfCards();

        $session->clear();

        $data = [
            "shuffled" => $deck->getDeckShuffled(),
        ];

        return $this->render('card/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "draw")]
    public function draw(
        SessionInterface $session
    ): Response
    {
        if ($session->has("deck_session")) {
            $deck = $session->get("deck_session");
        } else {
            $deck = new DeckOfCards();
        }

        $session->set("deck_session", $deck);

        $data = [
            "draw" => $deck->draw(),
            "cards_left" => $deck->getNrOfCards(),
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "draw_number")]
    public function drawNumber(
        int $num,
        SessionInterface $session
        ): Response
    {
        if ($session->has("deck_session")) {
            $deck = $session->get("deck_session");
        } else {
            $deck = new DeckOfCards();
        }

        $session->set("deck_session", $deck);

        $data = [
            "number" => $num,
            "drawHand" => $deck->drawNumber($num),
            "deck" => $deck->getDeckSorted(),
            "cards_left" => $deck->getNrOfCards(),
        ];

        return $this->render('card/draw-number.html.twig', $data);
    }

    #[Route("/session", name: "session")]
    public function session(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $all = $session->all();

        $deck_session = $session->get("deck_session");

        $data = [
            "session_all" => $all,
            "keys" => array_keys($all),
            "deck_session" => $deck_session->getDeckSorted(),
        ];

        return $this->render('session.html.twig', $data);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function deleteSession(
        SessionInterface $session
    ): Response
    {
        $this->addFlash(
            'notice',
            'Session was successfully deleted!'
        );

        $session->clear();

        return $this->redirectToRoute('session');
    }
}
