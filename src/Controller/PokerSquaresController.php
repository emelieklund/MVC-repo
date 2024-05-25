<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\Card\GameBoard;
use App\Card\PokerSquare;
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
        $session->set("game_board", $gameBoard);

        $counter = -1;
        $session->set("counter", $counter);

        return $this->redirectToRoute('poker_play');
    }

    #[Route("/proj/bet", name: "poker_bet", methods: ['POST'])]
    public function postBet(SessionInterface $session, Request $request): Response
    {
        $id = intval($request->request->get('id'));
        $pointsGuessed = $request->request->get('points');
        $bet = $request->request->get('bet');

        $session->set("id", $id);
        $session->set("points_guessed", $pointsGuessed);
        $session->set("bet", $bet);

        $counter = 0;
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
        // Initialize card deck
        if ($session->has("deck_session")) {
            $deck = $session->get("deck_session");
        } else {
            $deck = new DeckOfCards();
        }

        $counter = $session->get("counter");

        $allColPoints = [];
        $allRowPoints = [];

        $gameBoard = $session->get("game_board");

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
            "all_col_points" => $allColPoints,
            "all_row_points" => $allRowPoints,
            "sum" => array_sum($allColPoints) + array_sum($allRowPoints),
            "counter" => $session->get("counter"),
            "users" => $userRepository->findAll(),
            "id" => $session->get("id"),
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
