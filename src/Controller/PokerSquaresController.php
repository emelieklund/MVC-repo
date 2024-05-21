<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\Card\GameBoard;
use App\Card\PokerSquare;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokerSquaresController extends AbstractController
{
    #[Route("/proj", name: "poker_squares")]
    public function game(SessionInterface $session): Response
    {
        $session->clear();

        $gameBoard = new GameBoard();
        $session->set("game_board", $gameBoard);

        return $this->redirectToRoute('poker_play');
    }

    #[Route("/proj/play", name: "poker_play")]
    public function play(SessionInterface $session): Response
    {
        // Initialize card deck
        if ($session->has("deck_session")) {
            $deck = $session->get("deck_session");
        } else {
            $deck = new DeckOfCards();
        }

        if ($session->has("counter")) {
            $counter = $session->get("counter");
        } else {
            $counter = 0;
        }

        //echo $counter;

        $gameBoard = $session->get("game_board");

        $columns = $gameBoard->columns();
        $column1 = $columns[0]; // första kolumnen, bestående av 5 arrayer

        if ($gameBoard->ifFull($column1)) {
            $pokerSquare = new PokerSquare($column1);
            //$pokerSquare->onePair($column1);
            //$pokerSquare->flush($column1);
            $pokerSquare->straight($column1);
        }

        // Draw card from deck
        $card = $deck->drawGraphic();

        // Save to session
        $session->set("deck_session", $deck);
        $session->set("game_board", $gameBoard);

        $data = [
            "card" => $card->getImageName(),
            "holders" => $gameBoard->getHolderIds(),
            "holder_cards" => $gameBoard->getHolderCards(),
            "game_board" => $gameBoard->getIdAndCard(),
        ];

        return $this->render('poker-squares/play.html.twig', $data);
    }

    #[Route("/proj/place/{id}/{card}", name: "place_card")]
    public function placeCard(int $id, string $card, SessionInterface $session): Response
    {
        // Counter that keeps track on what round it is
        if ($session->has("counter")) {
            $counter = $session->get("counter");
        } else {
            $counter = 0;
        }

        $counter += 1;

        $session->set("counter", $counter);

        $gameBoard = $session->get("game_board");

        foreach ($gameBoard->getObjects() as $holder) {
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

    #[Route("/proj/session", name: "poker_session")]
    public function session(SessionInterface $session): Response
    {
        $all = $session->all();

        $gameBoard = $session->get("game_board");

        $data = [
            "session_all" => $all,
            "keys" => array_keys($all),
            "game_board" => $gameBoard->getHolderIds(),
            "cards" => $gameBoard->getHolderCards(),
        ];

        return $this->render('poker-squares/poker_session.html.twig', $data);
    }

    #[Route("/proj/about", name: "about_ps")]
    public function aboutPokerSquare(): Response
    {
        return $this->render('poker-squares/poker_squares.html.twig');
    }
}
