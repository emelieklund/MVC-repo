<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\Card\GameBoard;
use App\Card\PokerSquare;
use App\Card\Clue;

use App\Controller\UserController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\User;
use App\Repository\UserRepository;

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

        $counter = -1;

        if ($session->has("deck_session")) {
            $deck = $session->get("deck_session");
        } else {
            $deck = new DeckOfCards();
        }

        $card = $deck->drawGraphic();

        $session->set("game_board", $gameBoard);
        $session->set("deck_session", $deck);
        $session->set("counter", $counter);
        $session->set("card", $card);
        $session->set("new_card", "not_used");

        return $this->redirectToRoute('poker_play');
    }

    #[Route("/proj/bet", name: "poker_bet", methods: ['POST'])]
    public function postBet(SessionInterface $session, Request $request): Response
    {
        $id = intval($request->request->get('id'));
        $pointsGuessed = $request->request->get('points');
        $bet = $request->request->get('bet');

        $counter = 0;

        $session->set("id", $id);
        $session->set("points_guessed", $pointsGuessed);
        $session->set("bet", $bet);
        $session->set("counter", $counter);

        return $this->redirectToRoute('poker_play');
    }

    #[Route("/proj/nobet", name: "poker_no_bet")]
    public function noBet(SessionInterface $session): Response
    {
        $counter = 0;

        $session->set("counter", $counter);

        return $this->redirectToRoute('poker_play');
    }

    #[Route("/proj/play", name: "poker_play")]
    public function play(
        SessionInterface $session,
        UserRepository $userRepository
    ): Response {
        $counter = $session->get("counter");
        $gameBoard = $session->get("game_board");

        $allColPoints = [];
        $allRowPoints = [];

        foreach ($gameBoard->columns() as $col) {
            $pokerSquare = new PokerSquare($col);

            if ($gameBoard->ifFull($col)) {
                $pokerSquare->setPoints();
            }
            array_push($allColPoints, $pokerSquare->getPoints());
        }

        foreach ($gameBoard->rows() as $row) {
            $pokerSquare = new PokerSquare($row);

            if ($gameBoard->ifFull($row)) {
                $pokerSquare->setPoints();
            }
            array_push($allRowPoints, $pokerSquare->getPoints());
        }

        $card = $session->get("card");

        $session->set("game_board", $gameBoard);

        $data = [
            "card" => $card->getImageName(),
            "game_board" => $gameBoard->getIdAndCard(),
            "all_col_points" => $allColPoints,
            "all_row_points" => $allRowPoints,
            "sum" => array_sum($allColPoints) + array_sum($allRowPoints),
            "counter" => $session->get("counter"),
            "users" => $userRepository->findAll(),
            "id" => $session->get("id"),
            "clue" => $session->get("clue"),
            "col_hands" => $session->get("clue_colhands"),
            "row_hands" => $session->get("clue_rowhands"),
            "new_card" => $session->get("new_card"),
        ];

        return $this->render('poker-squares/play.html.twig', $data);
    }

    #[Route("/proj/place/{id}/{card}", name: "place_card")]
    public function placeCard(int $id, string $card, SessionInterface $session): Response
    {
        $gameBoard = $session->get("game_board");

        foreach ($gameBoard->getObjects() as $holder) {
            if ($holder->getHolderId() === $id) {
                $holder->setHolderCard($card);
            }
        }

        if ($session->has("deck_session")) {
            $deck = $session->get("deck_session");
        } else {
            $deck = new DeckOfCards();
        }

        $card = $deck->drawGraphic();

        $counter = $session->get("counter");

        $session->set("card", $card);
        $session->set("deck_session", $deck);
        $session->set("counter", $counter += 1);
        $session->set("game_board", $gameBoard);
        $session->set("clue", "clue_passed");

        return $this->redirectToRoute('poker_play');
    }

    #[Route("/proj/play/clue", name: "clue")]
    public function clue(SessionInterface $session): Response
    {
        $gameBoard = $session->get("game_board");
        $currentCard = $session->get("card")->getImageName();

        $colHands = [];
        $rowHands = [];

        foreach ($gameBoard->columns() as $col) {
            if ($gameBoard->ifFourCards($col)) {
                $clue = new Clue($col, $currentCard);
                $colHands[] = $clue->getClue();
            } else {
                $colHands[] = 0;
            }
        }

        foreach ($gameBoard->rows() as $row) {
            if ($gameBoard->ifFourCards($row)) {
                $clue = new Clue($row, $currentCard);
                $rowHands[] = $clue->getClue();
            } else {
                $rowHands[] = 0;
            }
        }

        $session->set("clue", "clue");
        $session->set("clue_colhands", $colHands);
        $session->set("clue_rowhands", $rowHands);

        return $this->redirectToRoute('poker_play');
    }

    #[Route("/proj/new", name: "new_card")]
    public function newCard(SessionInterface $session): Response
    {
        if ($session->has("deck_session")) {
            $deck = $session->get("deck_session");
        } else {
            $deck = new DeckOfCards();
        }

        $card = $deck->drawGraphic();

        $session->set("new_card", "used");
        $session->set("card", $card);

        return $this->redirectToRoute('poker_play');
    }

    #[Route("/proj/about", name: "about_ps")]
    public function aboutPokerSquare(): Response
    {
        return $this->render('poker-squares/about.html.twig');
    }

    #[Route("/proj/about/database", name: "about_database")]
    public function aboutDatabase(): Response
    {
        return $this->render('poker-squares/about_database.html.twig');
    }
}
