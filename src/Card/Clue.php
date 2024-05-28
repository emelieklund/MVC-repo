<?php

namespace App\Card;

/**
 * Clue class
 */
class Clue
{
    /**
     * @var array<CardHolder> $gameBoard     Array that keeps all card holders
     */
    private $testColOrRow = [];

    /**
     * Constructor to create a GameBoard.
     *
     */
    public function __construct(array $colOrRow, string $currentCard)
    {
        foreach ($colOrRow as $holder) {
            if ($holder[1] === "null") {
                $holder[1] = $currentCard;
            }
            $this->testColOrRow[] = $holder;
        }
    }

    /**
     * Get clue
     *
     * @return int<CardHolder>
     */
    public function getClue(): int
    {
        $pokerSquare = new PokerSquare($this->testColOrRow);

        $pokerHand = $pokerSquare->whichPokerHand();

        return $pokerHand;
    }
}
