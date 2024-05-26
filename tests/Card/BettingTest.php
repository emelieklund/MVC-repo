<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DeckOfCards.
 */
class BettingTest extends TestCase
{
    /**
     * Tests convert string rank to int rank
     */
    public function testBetWin(): void
    {
        $pointsGuessed = 100;
        $pointsReceived = 120;

        $betting = new Betting($pointsGuessed, $pointsReceived);

        $this->assertEquals(1.4, $betting->pointChecker());
    }

    /**
     * Tests convert string rank to int rank
     */
    public function testBetLoss(): void
    {
        $pointsGuessed = 150;
        $pointsReceived = 80;

        $betting = new Betting($pointsGuessed, $pointsReceived);

        $this->assertEquals(0.6, $betting->pointChecker());
    }

    /**
     * Tests convert string rank to int rank
     */
    public function testBetLossPointsGuessedOver240(): void
    {
        $pointsGuessed = 250;
        $pointsReceived = 80;

        $betting = new Betting($pointsGuessed, $pointsReceived);

        $this->assertEquals(0.05, $betting->pointChecker());
    }
}
