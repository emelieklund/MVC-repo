<?php

namespace App\Card;

/**
 * Class for betting
 */
class Betting
{
    /**
     * @var int $pointsGuessed     Points that player guessed
     */
    private $pointsGuessed = 0;

    /**
     * @var int $pointsReceived     Points that player received
     */
    private $pointsReceived = 0;

    /**
     * Constructor to create a Bet
     *
     * @param int $pointsGuessed The points player entered
     * @param int $pointsReceived The points player received
     */
    public function __construct($pointsGuessed, $pointsReceived)
    {
        $this->pointsGuessed = $pointsGuessed;
        $this->pointsReceived = $pointsReceived;
    }

    /**
     * Checks if guessed points is same or greater than points received
     *
     * @return float
     */
    public function pointChecker(): float
    {
        if ($this->pointsReceived >= $this->pointsGuessed) {
            return $this->playerWins();
        }

        return $this->playerLooses();
    }

    /**
     * Calculates profit if player wins
     *
     * @return float
     */
    public function playerWins(): float
    {
        $profit = 0;

        if ($this->pointsGuessed > 20) {
            $profit = 1 + (0.4 * $this->pointsGuessed / 100);
        }

        return $profit;
    }

    /**
     * Calculates loss if player looses
     *
     * @return float
     */
    public function playerLooses(): float
    {
        $loss = 1;

        if ($this->pointsGuessed > 20) {
            $loss = 1 - (0.4 * $this->pointsGuessed / 100);
        }

        return $loss;
    }
}
