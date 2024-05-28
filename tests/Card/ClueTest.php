<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DeckOfCards.
 */
class ClueTest extends TestCase
{
    /**
     * Tests if poker hand makes a pair
     */
    public function testGetClue(): void
    {
        $column = [[1, "ace_of_hearts"], [6, "ace_of_spades"], [11, "jack_of_hearts"], [16, "jack_of_spades"], [21, "null"]];
        $currentCard = "jack_of_diamonds";

        $clue = new Clue($column, $currentCard);

        $points = $clue->getClue();

        $this->assertEquals($points, 25);
    }

    /**
     * Tests if poker hand makes a pair
     */
    public function testGetClueIfNoPoints(): void
    {
        $column = [[1, "ace_of_hearts"], [6, "2_of_spades"], [11, "jack_of_clubs"], [16, "5_of_spades"], [21, "null"]];
        $currentCard = "9_of_hearts";

        $clue = new Clue($column, $currentCard);

        $points = $clue->getClue();

        $this->assertEquals($points, 0);
    }
}
