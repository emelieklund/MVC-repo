<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game.
 */
class GameTest extends TestCase
{
    /**
     * Test getScorePlayer() after saveScorePlayer().
     */
    public function testGetScorePlayer(): void
    {
        $game = new Game();

        $game->saveScorePlayer(10);

        $scorePlayer = $game->getScorePlayer();

        $this->assertEquals(10, $scorePlayer);
    }

    /**
     * Test if getScoreBank() returns empty value when saveScoreBank() isn't set.
     */
    public function testGetScoreBankEmpty(): void
    {
        $game = new Game();

        $scoreBank = $game->getScoreBank();

        $this->assertEmpty($scoreBank);
    }
}
