<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DeckOfCards.
 */
class CardHolderTest extends TestCase
{
    /**
     * Tests holder ID
     */
    public function testGetHolderID(): void
    {
        $holder = new CardHolder(4);

        $this->assertEquals(4, $holder->getHolderID());
    }

        /**
     * Tests convert string rank to int rank
     */
    public function testGetHolderCard(): void
    {
        $holder = new CardHolder(4);
        $holder->setHolderCard("2_of_spades");

        $this->assertEquals("2_of_spades", $holder->getHolderCard());
    }
}