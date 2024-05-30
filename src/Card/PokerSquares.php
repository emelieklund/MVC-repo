<?php

namespace App\Card;

/**
 * Class for Poker Square game
 */
class PokerSquares
{
    /**
     * @var array<int> $ranks
     */
    private $ranks = [];

    /**
     * @var array<string> $suits
     */
    private $suits = [];

    /**
     * @var int $points
     */
    private $points = 0;

    /**
     * Constructor to create a PokerSquare.
     *
     * @param array<mixed> $colOrRow
     */
    public function __construct(array $colOrRow)
    {
        foreach ($colOrRow as $holder) {
            $card = explode("_of_", $holder[1]);
            $this->ranks[] = $this->rankAsNumber($card[0]);
            $this->suits[] = $card[1] ?? "null";
        }
        sort($this->ranks);
    }

    /**
     * Converts rank from string to int
     *
     * @return int
     */
    public function rankAsNumber(string $imageName): int
    {
        $ranks = ['king', 'queen', 'jack', 'ace'];
        $numbers = [13, 12, 11, 1];
        $rank = 0;

        for ($i = 0; $i < 4; $i++) {
            if (str_starts_with($imageName, $ranks[$i])) {
                $rank = $numbers[$i];
                break;
            }
            $rank = intval($imageName);
        }

        return $rank;
    }

    /**
     * Checks which poker hand
     *
     * @return int
     */
    public function whichPokerHand(): int
    {
        $pokerHand = new PokerHand($this->ranks, $this->suits);

        if ($pokerHand->royalStraightFlush()) {
            return 100;
        } elseif ($pokerHand->straightFlush()) {
            return 75;
        } elseif ($pokerHand->fourOfAKind()) {
            return 50;
        } elseif ($pokerHand->fullHouse()) {
            return 25;
        } elseif ($pokerHand->flush()) {
            return 20;
        } elseif ($pokerHand->straight()) {
            return 15;
        } elseif ($pokerHand->threeOfAKind()) {
            return 10;
        } elseif ($pokerHand->twoPairs()) {
            return 5;
        } elseif ($pokerHand->onePair()) {
            return 2;
        }

        return 0;
    }

    /**
     * Set points to column
     *
     * @return void
     */
    public function setPoints(): void
    {
        $this->points = $this->whichPokerHand();
    }

    /**
     * Get points of column
     *
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }
}
