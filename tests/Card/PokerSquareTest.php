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
    public function testRankToNumber(): void
    {
        $column = [[1, "2_of_hearts"], [6, "3_of_hearts"], [11, "4_of_hearts"], [16, "5_of_hearts"], [21, "6_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertEquals(13, $pokerSquare->rankAsNumber("king"));
    }

    /**
     * Tests if poker hand makes a two pairs
     */
    public function testIfTwoPairs(): void
    {
        $column = [[1, "2_of_hearts"], [6, "2_of_spades"], [11, "4_of_hearts"], [16, "4_of_clubs"], [21, "6_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertTrue($pokerSquare->twoPairs());
    }

    /**
     * Tests if poker hand makes a three of a kind
     */
    public function testIfThreeOfAKind(): void
    {
        $column = [[1, "2_of_hearts"], [6, "2_of_spades"], [11, "2_of_clubs"], [16, "4_of_clubs"], [21, "6_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertTrue($pokerSquare->threeOfAKind());
    }

    /**
     * Tests if poker hand makes a straight
     */
    public function testIfStraight(): void
    {
        $column = [[1, "2_of_hearts"], [6, "3_of_hearts"], [11, "4_of_hearts"], [16, "5_of_hearts"], [21, "6_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertTrue($pokerSquare->straight());
    }

    /**
     * Tests if poker hand makes a straight with an ace
     */
    public function testIfStraightWithAce(): void
    {
        $column = [[1, "ace_of_hearts"], [6, "10_of_hearts"], [11, "jack_of_hearts"], [16, "queen_of_hearts"], [21, "king_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertTrue($pokerSquare->straight());
    }

    /**
     * Tests if poker hand makes a flush
     */
    public function testIfFlush(): void
    {
        $column = [[1, "2_of_hearts"], [6, "3_of_hearts"], [11, "4_of_hearts"], [16, "5_of_hearts"], [21, "6_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertTrue($pokerSquare->flush());
    }

    /**
     * Tests if poker hand makes a full house
     */
    public function testIfFullHouse(): void
    {
        $column = [[1, "2_of_hearts"], [6, "2_of_spades"], [11, "4_of_hearts"], [16, "4_of_clubs"], [21, "4_of_diamonds"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertTrue($pokerSquare->fullHouse());
    }

    /**
     * Tests if poker hand makes a four of a kind
     */
    public function testIfFourOfAKind(): void
    {
        $column = [[1, "2_of_hearts"], [6, "2_of_spades"], [11, "2_of_clubs"], [16, "2_of_diamonds"], [21, "6_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertTrue($pokerSquare->fourOfAKind());
    }

    /**
     * Tests if poker hand makes a straight flush
     */
    public function testIfStraightFlush(): void
    {
        $column = [[1, "2_of_hearts"], [6, "3_of_hearts"], [11, "4_of_hearts"], [16, "5_of_hearts"], [21, "6_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertTrue($pokerSquare->straightFlush());
    }

    /**
     * Tests if poker hand makes a straight flush
     */
    public function testIfRoyalStraightFlush(): void
    {
        $column = [[1, "ace_of_hearts"], [6, "10_of_hearts"], [11, "jack_of_hearts"], [16, "queen_of_hearts"], [21, "king_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertTrue($pokerSquare->royalStraightFlush());
    }

}
