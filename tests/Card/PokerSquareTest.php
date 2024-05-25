<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DeckOfCards.
 */
class PokerSquareTest extends TestCase
{
    /**
     * Tests convert string rank to int rank
     */
    public function testRankAsNumber(): void
    {
        $column = [[1, "2_of_hearts"], [6, "3_of_hearts"], [11, "4_of_hearts"], [16, "5_of_hearts"], [21, "6_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertEquals(13, $pokerSquare->rankAsNumber("king"));
    }

    /**
     * Tests how many points received (royal straight flush)
     */
    public function testWhichPokerHandRoyalStraightFlush(): void
    {
        $column = [[1, "ace_of_hearts"], [6, "10_of_hearts"], [11, "jack_of_hearts"], [16, "queen_of_hearts"], [21, "king_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertEquals($pokerSquare->whichPokerHand(), 100);
    }

    /**
     * Tests how many points received after setting points (straight, 15 p)
     */
    public function testWhichPokerHandStraight(): void
    {
        $column = [[1, "2_of_hearts"], [6, "3_of_spades"], [11, "4_of_clubs"], [16, "5_of_hearts"], [21, "6_of_diamonds"]];
        $pokerSquare = new PokerSquare($column);

        $pokerSquare->setPoints();

        $this->assertEquals($pokerSquare->getPoints(), 15);
    }

}
