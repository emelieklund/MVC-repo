<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected properties.
     */
    public function testCreateCard()
    {
        $card = new Card("A", "♥");
        $this->assertInstanceOf("\App\Card\Card", $card);

        $res = $card->getValue();
        $this->assertNotEmpty($res);
    }
}
