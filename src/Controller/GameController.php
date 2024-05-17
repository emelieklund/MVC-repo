<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\Card\Game;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render('game/game.html.twig');
    }

    #[Route("/game/doc", name: "doc")]
    public function doc(): Response
    {
        return $this->render('game/doc.html.twig');
    }

    #[Route("/game/init", name: "init")]
    public function init(SessionInterface $session): Response
    {
        $session->clear();
        $game = new Game();
        $session->set("game", $game);

        return $this->redirectToRoute('play');
    }

    #[Route("/game/play", name: "play")]
    public function play(SessionInterface $session): Response
    {
        // Initialize card deck
        if ($session->has("deck_session")) {
            $deck = $session->get("deck_session");
        } else {
            $deck = new DeckOfCards();
        }

        // Initialize card hand
        if ($session->has("hand_session")) {
            $hand = $session->get("hand_session");
        } else {
            $hand = new CardHand();
        }

        // Define whose turn it is
        if ($session->has("whose_turn")) {
            $whoseTurn = $session->get("whose_turn");
        } else {
            $whoseTurn = "Player";
        }

        $card = $deck->drawGraphic();
        $hand->addGraphic($card);

        $score1 = $hand->getSum();
        $score2 = 0;

        foreach ($hand->getGraphicValues() as $c) {
            if (str_starts_with($c, 'ace')) {
                $score2 = $score1 + 13;
            }
        }

        $session->set("deck_session", $deck);
        $session->set("hand_session", $hand);
        $session->set("score1", $score1);
        $session->set("score2", $score2);
        $session->set("whose_turn", $whoseTurn);

        $data = [
            "hand" => $hand->getGraphicValues(),
            "score1" => $score1,
            "score2" => $score2,
            "turn" => $whoseTurn,
            "score_player" => $session->get("score_player"),
        ];

        return $this->render('game/play.html.twig', $data);
    }

    #[Route("/game/stay", name: "stay")]
    public function stay(SessionInterface $session): Response
    {
        $game = $session->get("game");

        if ($session->get("whose_turn") === "Player") {
            $game->nextPlayer($session);
            if ($session->get("score2") !== 0 && $session->get("score2") < 21) {
                $game->saveScorePlayer($session->get("score2"));
            } else {
                $game->saveScorePlayer($session->get("score1"));
            }
            $scorePlayer = $game->getScorePlayer();
            $session->set("score_player", $scorePlayer);

            $session->remove('hand_session');
            $session->remove('score1');
            $session->remove('score2');

            return $this->redirectToRoute('play');
        }
        $game->saveScoreBank($session);
        $scoreBank = $game->getScoreBank();
        $session->set("score_bank", $scoreBank);

        return $this->redirectToRoute('game_over');
    }

    #[Route("/game/over", name: "game_over")]
    public function gameOver(SessionInterface $session): Response
    {
        if ($session->get("whose_turn") === 'Player') {
            $session->set("score_player", $session->get("score1"));
        }

        $data = [
            "score_player" => $session->get("score_player"),
            "score_bank" => $session->get("score_bank"),
        ];

        return $this->render('game/game-over.html.twig', $data);
    }
}
