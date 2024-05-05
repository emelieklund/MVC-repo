<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardGraphic.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Tests if returned value is of type str.
     */
    public function testIfNameReturnedAsStr()
    {
        $graphicCard = new CardGraphic("K", "♠");

        $this->assertIsString($graphicCard->getImageName());
    }

    /**
     * Tests if returned value is of type int.
     */
    public function testIfRankReturnedAsInt()
    {
        $suit = ['♠', '♥', '♣', '♦'];
        $rank = ["2", "A", "J", "Q", "K"];
        $graphicDeck = [];

        foreach ($suit as $s) {
            foreach ($rank as $r) {
                $graphicCard = new CardGraphic($r, $s);
                $graphicDeck[] = $graphicCard;
                $this->assertIsInt($graphicCard->getRankAsNumber());
            }
        }

    }
}
