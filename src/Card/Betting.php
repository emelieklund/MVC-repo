<?php

namespace App\Card;

/**
 * Class for betting
 */
class Betting
{
    /**
     * @var int $pointsGuessed      Points that player guessed
     */
    private $pointsGuessed = 0;

    /**
     * @var int $pointsReceived     Points that player received
     */
    private $pointsReceived = 0;

    /**
     * Constructor to create a Bet
     *
     * @param int $pointsGuessed
     * @param int $pointsReceived
     */
    public function __construct(int $pointsGuessed, int $pointsReceived)
    {
        $this->pointsGuessed = $pointsGuessed;
        $this->pointsReceived = $pointsReceived;
    }

    /**
     * Checks if guessed points are less, same as or higher than points received.
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
     * Calculates profit if player wins. If player guessed under 20 points, profit will be 0.
     *
     * @return float
     */
    public function playerWins(): float
    {
        $profit = 1;

        if ($this->pointsGuessed > 20) {
            $profit = 1 + (0.4 * $this->pointsGuessed / 100);
        }

        return $profit;
    }

    /**
     * Calculates loss if player looses. If player guessed under 20 points, player will loose 100 % of bet.
     *
     * @return float
     */
    public function playerLooses(): float
    {
        $loss = 1;

        if ($this->pointsGuessed > 240) {
            $loss = 0.05;
        } elseif ($this->pointsGuessed > 20) {
            $loss = 0.4 * $this->pointsGuessed / 100;
        }

        return $loss;
    }
}
