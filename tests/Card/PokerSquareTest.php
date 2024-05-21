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
     * Tests if poker hand makes a flush
     */
    public function testIfFlush(): void
    {
        $column = [[1, "2_of_hearts"], [6, "3_of_hearts"], [11, "4_of_hearts"], [16, "5_of_hearts"], [21, "6_of_hearts"]];
        $pokerSquare = new PokerSquare($column);

        $this->assertTrue($pokerSquare->flush());
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

}
