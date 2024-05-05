<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DeckOfCards.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Tests first and last value of getDeckSorted().
     */
    public function testGetDeckSorted()
    {
        $deck = new DeckOfCards();

        $sorted = $deck->getDeckSorted();

        $this->assertEquals("[A♠]", $sorted[0]);
        $this->assertEquals("[K♦]", end($sorted));
    }

    /**
     * Tests if shuffled deck contains 52 items.
     */
    public function testGetDeckShuffled()
    {
        $deck = new DeckOfCards();

        $shuffled = $deck->getDeckShuffled();

        $this->assertEquals(52, count($shuffled));
    }

    /**
     * Tests if first value of getGraphicDeck() if ace_of_spades.
     */
    public function testGetGraphicDeck()
    {
        $deck = new DeckOfCards();
        $firstCard = $deck->getGraphicDeck()[0];

        $this->assertEquals("ace_of_spades", $firstCard);
    }

    /**
     * Tests if draw() returns string.
     */
    public function testDrawReturnString()
    {
        $deck = new DeckOfCards();
        $card = $deck->draw();

        $this->assertIsString($card);
    }

    /**
     * Tests if drawGraphic() returns object of class CardGraphic.
     */
    public function testDrawGraphicReturnType()
    {
        $deck = new DeckOfCards();
        $cardGraphic = $deck->drawGraphic();

        $this->assertInstanceOf("\App\Card\CardGraphic", $cardGraphic);
    }

    /**
     * Tests if deck contains 42 items after drawNumber(10).
     */
    public function testDrawNumberAndGetNrOfCards()
    {
        $deck = new DeckOfCards();

        $deck->drawNumber(10);

        $this->assertEquals(42, $deck->getNrOfCards());
    }

}
