<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\Card\GameBoard;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokerSquaresController extends AbstractController
{
    #[Route("/poker", name: "poker_squares")]
    public function game(SessionInterface $session): Response
    {
        $session->clear();

        $gameBoard = new GameBoard();
        $session->set("game_board", $gameBoard);

        return $this->redirectToRoute('poker_play');
    }

    #[Route("/poker/play", name: "poker_play")]
    public function play(SessionInterface $session): Response
    {
        // Initialize card deck
        if ($session->has("deck_session")) {
            $deck = $session->get("deck_session");
        } else {
            $deck = new DeckOfCards();
        }

        $gameBoard = $session->get("game_board");

        // Draw card from deck
        $card = $deck->drawGraphic();

        // Save to session
        $session->set("deck_session", $deck);
        $session->set("game_board", $gameBoard);

        $data = [
            "card" => $card->getImageName(),
            "holders" => $gameBoard->getHolders(),
            "holder_cards" => $gameBoard->getHolderCards(),
            "game_board" => $gameBoard->getBoth(),
        ];

        return $this->render('poker-squares/play.html.twig', $data);
    }

    #[Route("/poker/place/{id}/{card}", name: "place_card")]
    public function placeCard(int $id, string $card, SessionInterface $session): Response
    {
        $gameBoard = $session->get("game_board");

        $getOne = $gameBoard->getHolders();

        foreach ($gameBoard->getItems() as $holder) {
            if ($holder->getHolderId() === $id) {
                $holder->setHolderCard($card);
            }
        }

        $session->set("game_board", $gameBoard);

        // $data = [
        //     "id" => $id,
        //     "card" => $card,
        // ];

        //return $this->render('poker-squares/test.html.twig', $data);

        return $this->redirectToRoute('poker_play');
    }

    #[Route("/poker/session", name: "poker_session")]
    public function session(SessionInterface $session): Response
    {
        $all = $session->all();

        $gameBoard = $session->get("game_board");

        $data = [
            "session_all" => $all,
            "keys" => array_keys($all),
            "game_board" => $gameBoard->getHolders(),
            "cards" => $gameBoard->getHolderCards(),
        ];

        return $this->render('poker-squares/poker_session.html.twig', $data);
    }

    #[Route("/poker/about", name: "about_ps")]
    public function aboutPokerSquare(): Response
    {
        return $this->render('poker-squares/poker_squares.html.twig');
    }
}
