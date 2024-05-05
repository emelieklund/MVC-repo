<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    /**
     * Adds three cards and tests if getNumberOfCards() returns 3.
     */
    public function testNumberOfCards()
    {
        $card1 = new Card("K", "♠");
        $card2 = new Card("Q", "♥");
        $card3 = new Card("J", "♣");

        $cardHand = new CardHand();
        $cardHand->add($card1);
        $cardHand->add($card2);
        $cardHand->add($card3);

        $this->assertEquals(3, $cardHand->getNumberCards());
    }

    /**
     * Adds Card to CardHand and tests if method getValues() returns value of type string.
     */
    public function testGetValuesReturnTypeString()
    {
        $card = new Card("K", "♠");
        $cardHand = new CardHand();

        $cardHand->add($card);

        $this->assertIsString($cardHand->getValues()[0]);
    }

    /**
     * Adds two cards and tests getGraphicValue() method of first card and getSum() of both cards.
     */
    public function testGetValuesAndGetSumOfGraphicCardHand()
    {
        $card1 = new CardGraphic("K", "♠");
        $card2 = new CardGraphic("Q", "♥");
        $cardHand = new CardHand();

        $cardHand->addGraphic($card1);
        $cardHand->addGraphic($card2);

        $this->assertEquals("king_of_spades", $cardHand->getGraphicValues()[0]);
        $this->assertEquals(25, $cardHand->getSum());
    }
}
