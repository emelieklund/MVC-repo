<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Test cases for class Game.
 */
class GameTest extends TestCase
{
    /**
     * Test getScorePlayer() after saveScorePlayer().
     */
    public function testGetScorePlayer()
    {
        $game = new Game();
        $session = new Session();

        $game->saveScorePlayer($session, 10);

        $scorePlayer = $game->getScorePlayer();

        $this->assertEquals(10, $scorePlayer);
    }

    /**
     * Test if getScoreBank() returns empty value when saveScoreBank() isn't set.
     */
    public function testGetScoreBankEmpty()
    {
        $game = new Game();

        $scoreBank = $game->getScoreBank();

        $this->assertEmpty($scoreBank);
    }
}
