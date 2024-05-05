<?php

namespace App\Card;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class for a card, containing two properties, one constructor and one method.
 */
class Game
{
    /**
     * @var int $scorePlayer     Player's score
     */
    private $scorePlayer = 0;
    /**
     * @var int $scoreBank     Bank's score
     */
    private $scoreBank = 0;

    /**
     * Save score player
     *
     * @return void
     */
    public function saveScorePlayer(SessionInterface $session, int $score): void
    {
        $this->scorePlayer = $score;
    }

    /**
     * Save score bank
     *
     * @return void
     */
    public function saveScoreBank(SessionInterface $session): void
    {
        $this->scoreBank = $session->get("score1");
    }

    /**
     * Get score player
     *
     * @return int
     */
    public function getScorePlayer(): int
    {
        return $this->scorePlayer;
    }

    /**
     * Get score player
     *
     * @return int
     */
    public function getScoreBank(): int
    {
        return $this->scoreBank;
    }

    /**
     * Presents value of card.
     *
     * @return void
     */
    public function nextPlayer(SessionInterface $session): void
    {
        $session->set("whose_turn", "Bank");
    }
}
