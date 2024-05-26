<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DeckOfCards.
 */
class PokerHandTest extends TestCase
{
    /**
     * Tests if poker hand makes a pair
     */
    public function testIfOnePair(): void
    {
        //$col = [[1, "2_of_hearts"], [6, "2_of_spades"], [11, "4_of_hearts"], [16, "5_of_clubs"], [21, "6_of_hearts"]];
        $ranks = [2, 2, 4, 5, 6];
        $suits = ["hearts", "spades", "hearts", "clubs", "hearts"];
        $pokerHand = new PokerHand($ranks, $suits);

        $this->assertTrue($pokerHand->onePair());
    }

    /**
     * Tests if poker hand makes two pairs
     */
    public function testIfTwoPairs(): void
    {
        $ranks = [2, 2, 4, 4, 6];
        $suits = ["hearts", "spades", "hearts", "clubs", "hearts"];
        $pokerHand = new PokerHand($ranks, $suits);

        $this->assertTrue($pokerHand->twoPairs());
    }

    /**
     * Tests if poker hand NOT makes two pairs
     */
    public function testIfTwoPairsFalse(): void
    {
        //$col = [[1, "2_of_hearts"], [6, "2_of_spades"], [11, "4_of_hearts"], [16, "5_of_clubs"], [21, "6_of_hearts"]];
        $ranks = [2, 2, 4, 5, 6];
        $suits = ["hearts", "spades", "hearts", "clubs", "hearts"];
        $pokerHand = new PokerHand($ranks, $suits);

        $this->assertFalse($pokerHand->twoPairs());
    }


    /**
     * Tests if poker hand makes a three of a kind
     */
    public function testIfThreeOfAKind(): void
    {
        $ranks = [2, 2, 2, 4, 6];
        $suits = ["hearts", "spades", "hearts", "clubs", "hearts"];
        $pokerHand = new PokerHand($ranks, $suits);

        $this->assertTrue($pokerHand->threeOfAKind());
    }

        /**
     * Tests if poker hand NOT makes a three of a kind
     */
    public function testIfThreeOfAKindFalse(): void
    {
        $ranks = [2, 2, 3, 4, 6];
        $suits = ["hearts", "spades", "hearts", "clubs", "hearts"];
        $pokerHand = new PokerHand($ranks, $suits);

        $this->assertFalse($pokerHand->threeOfAKind());
    }

    /**
     * Tests if poker hand makes a straight
     */
    public function testIfStraight(): void
    {
        $ranks = [2, 3, 4, 5, 6];
        $suits = ["hearts", "spades", "hearts", "clubs", "hearts"];        
        $pokerHand = new PokerHand($ranks, $suits);

        $this->assertTrue($pokerHand->straight());
    }

    /**
     * Tests if poker hand NOT makes a straight
     */
    public function testIfStraightFalse(): void
    {
        $ranks = [2, 3, 5, 6, 7];
        $suits = ["hearts", "spades", "hearts", "clubs", "hearts"];        
        $pokerHand = new PokerHand($ranks, $suits);

        $this->assertFalse($pokerHand->straight());
    }

    /**
     * Tests if poker hand makes a flush
     */
    public function testIfFlush(): void
    {
        $ranks = [2, 4, 8, 5, 3];
        $suits = ["hearts", "hearts", "hearts", "hearts", "hearts"];        
        $pokerHand = new PokerHand($ranks, $suits);

        $this->assertTrue($pokerHand->flush());
    }

    /**
     * Tests if poker hand makes a full house
     */
    public function testIfFullHouse(): void
    {
        $ranks = [2, 2, 8, 8, 8];
        $suits = ["hearts", "spades", "hearts", "diamonds", "clubs"];        
        $pokerHand = new PokerHand($ranks, $suits);

        $this->assertTrue($pokerHand->fullHouse());
    }

    /**
     * Tests if poker hand makes a four of a kind
     */
    public function testIfFourOfAKind(): void
    {
        $ranks = [2, 8, 8, 8, 8];
        $suits = ["hearts", "spades", "hearts", "diamonds", "clubs"];        
        $pokerHand = new PokerHand($ranks, $suits);

        $this->assertTrue($pokerHand->fourOfAKind());
    }

    /**
     * Tests if poker hand makes a straight flush
     */
    public function testIfStraightFlush(): void
    {
        $ranks = [4, 5, 6, 7, 8];
        $suits = ["hearts", "hearts", "hearts", "hearts", "hearts"];        
        $pokerHand = new PokerHand($ranks, $suits);

        $this->assertTrue($pokerHand->straightFlush());
    }

    /**
     * Tests if poker hand makes a straight flush
     */
    public function testIfRoyalStraightFlush(): void
    {
        $ranks = [10, 11, 12, 13, 1];
        $suits = ["hearts", "hearts", "hearts", "hearts", "hearts"];        
        $pokerHand = new PokerHand($ranks, $suits);

        $this->assertTrue($pokerHand->royalStraightFlush());
    }
}
