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
     * Tests how many points received (no poker hand)
     */
    public function testWhichPokerHandNoPokerHand(): void
    {
        $column = [[1, "ace_of_hearts"], [6, "2_of_clubs"], [11, "8_of_diamonds"], [16, "10_of_hearts"], [21, "king_of_spades"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertEquals($pokerSquare->whichPokerHand(), 0);
    }

    /**
     * Tests how many points received (one pair)
     */
    public function testWhichPokerHandOnePair(): void
    {
        $column = [[1, "ace_of_hearts"], [6, "ace_of_spades"], [11, "jack_of_hearts"], [16, "queen_of_hearts"], [21, "king_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertEquals($pokerSquare->whichPokerHand(), 2);
    }

    /**
     * Tests how many points received (two pairs)
     */
    public function testWhichPokerHandTwoPairs(): void
    {
        $column = [[1, "ace_of_hearts"], [6, "ace_of_spades"], [11, "jack_of_hearts"], [16, "jack_of_spades"], [21, "king_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertEquals($pokerSquare->whichPokerHand(), 5);
    }

    /**
     * Tests how many points received (three of a kind)
     */
    public function testWhichPokerHandThreeOfAKind(): void
    {
        $column = [[1, "ace_of_hearts"], [6, "ace_of_spades"], [11, "ace_of_diamonds"], [16, "jack_of_spades"], [21, "king_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertEquals($pokerSquare->whichPokerHand(), 10);
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

    /**
     * Tests how many points received (flush)
     */
    public function testWhichPokerHandFlush(): void
    {
        $column = [[1, "ace_of_hearts"], [6, "2_of_hearts"], [11, "5_of_hearts"], [16, "8_of_hearts"], [21, "king_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertEquals($pokerSquare->whichPokerHand(), 20);
    }

    /**
     * Tests how many points received (full house)
     */
    public function testWhichPokerHandFullHouse(): void
    {
        $column = [[1, "ace_of_hearts"], [6, "ace_of_spades"], [11, "8_of_spades"], [16, "8_of_hearts"], [21, "8_of_clubs"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertEquals($pokerSquare->whichPokerHand(), 25);
    }

    /**
     * Tests how many points received (four of a kind)
     */
    public function testWhichPokerHandFourOfAKind(): void
    {
        $column = [[1, "ace_of_hearts"], [6, "ace_of_spades"], [11, "ace_of_clubs"], [16, "ace_of_diamonds"], [21, "8_of_clubs"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertEquals($pokerSquare->whichPokerHand(), 50);
    }

    /**
     * Tests how many points received (straight flush)
     */
    public function testWhichPokerHandStraightFlush(): void
    {
        $column = [[1, "3_of_spades"], [6, "4_of_spades"], [11, "5_of_spades"], [16, "6_of_spades"], [21, "7_of_spades"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertEquals($pokerSquare->whichPokerHand(), 75);
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

}
