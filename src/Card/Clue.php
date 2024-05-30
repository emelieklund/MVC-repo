<?php

namespace App\Card;

/**
 * Clue class
 */
class Clue
{
    /**
     * @var array<CardHolder> $testColOrRow     Array that keeps all card holders
     */
    private $testColOrRow = [];

    /**
     * Constructor to create a Clue. Adds all four objects from colOrRow and the current card that hasn't been placed yet.
     *
     * @param array<mixed> $colOrRow
     * @param string $currentCard
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
     * Get clue by creating a theoretical poker hand.
     *
     * @return int
     */
    public function getClue(): int
    {
        $pokerSquares = new PokerSquares($this->testColOrRow);

        $pokerHand = $pokerSquares->whichPokerHand();

        return $pokerHand;
    }
}
