<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DeckOfCards.
 */
class GameBoardTest extends TestCase
{
    /**
     * @var array<string> $drawHand     A randomized hand with 25 cards, to be tested with.
     */
    private $drawHand = [
        "5_of_spades",
        "3_of_spades",
        "9_of_hearts",
        "6_of_hearts",
        "4_of_clubs",
        "5_of_hearts",
        "4_of_diamonds",
        "5_of_diamonds",
        "9_of_diamonds",
        "7_of_clubs",
        "2_of_diamonds",
        "10_of_clubs",
        "2_of_hearts",
        "Q_of_clubs",
        "4_of_hearts",
        "4_of_spades",
        "3_of_diamonds",
        "6_of_diamonds",
        "J_of_clubs",
        "A_of_diamonds",
        "J_of_diamonds",
        "A_of_clubs",
        "2_of_spades",
        "5_of_clubs",
        "10_of_hearts"
    ];

    /**
     * Tests getObject() method for GameBoard.
     */
    public function testGameBoardGetObjects(): void
    {
        $gameBoard = new GameBoard();

        $objects = $gameBoard->getObjects();

        for ($i = 0; $i < 25; $i++) {
            $objects[$i]->setHolderCard($this->drawHand[$i]);
        }

        $card = $objects[2]->getHolderCard();

        $this->assertEquals("9_of_hearts", $card);
    }

    /**
     * Tests getHolderIds() method for GameBoard.
     */
    public function testGameBoardGetHolderIds(): void
    {
        $gameBoard = new GameBoard();

        $holderIds = $gameBoard->getHolderIds();

        $this->assertEquals($holderIds[4], 5);
    }

    /**
     * Tests getHolderCards() method for GameBoard.
     */
    public function testGameBoardGetHolderCards(): void
    {
        $gameBoard = new GameBoard();

        $objects = $gameBoard->getObjects();

        for ($i = 0; $i < 25; $i++) {
            $objects[$i]->setHolderCard($this->drawHand[$i]);
        }

        $holderCards = $gameBoard->getHolderCards();

        $this->assertEquals($holderCards[24], "10_of_hearts");
    }

    /**
     * Tests getIdAndCard() method for GameBoard.
     */
    public function testGameBoardGetIdAndCard(): void
    {
        $gameBoard = new GameBoard();

        $objects = $gameBoard->getObjects();

        for ($i = 0; $i < 25; $i++) {
            $objects[$i]->setHolderCard($this->drawHand[$i]);
        }

        $idAndCard = $gameBoard->getIdAndCard();

        $this->assertEquals($idAndCard[9], [10, "7_of_clubs"]);
    }

    /**
     * Tests columns() method for GameBoard.
     */
    public function testGameBoardColumns(): void
    {
        $gameBoard = new GameBoard();

        $columns = $gameBoard->columns();

        $this->assertEquals(count($columns), 5);
        $this->assertEquals($columns[1][1][0], 7);
    }

    /**
     * Tests rows() method for GameBoard.
     */
    public function testGameBoardRows(): void
    {
        $gameBoard = new GameBoard();

        $objects = $gameBoard->getObjects();

        for ($i = 0; $i < 25; $i++) {
            $objects[$i]->setHolderCard($this->drawHand[$i]);
        }

        $rows = $gameBoard->rows();

        $this->assertEquals(count($rows), 5);
        $this->assertEquals($rows[2][2][1], "2_of_hearts");
    }

    /**
     * Tests ifFull() method for GameBoard when full.
     */
    public function testGameBoardIfFullTrue(): void
    {
        $gameBoard = new GameBoard();

        $objects = $gameBoard->getObjects();

        for ($i = 0; $i < 25; $i++) {
            $objects[$i]->setHolderCard($this->drawHand[$i]);
        }

        $rows = $gameBoard->rows();

        $this->assertTrue($gameBoard->ifFull($rows[1]));
    }

    /**
     * Tests ifFull() method for GameBoard when not full.
     */
    public function testGameBoardIfFullFalse(): void
    {
        $gameBoard = new GameBoard();

        $rows = $gameBoard->rows();

        $this->assertFalse($gameBoard->ifFull($rows[1]));
    }

    /**
     * Tests ifFourCards() method for GameBoard when true.
     */
    public function testGameBoardIfFourCardsTrue(): void
    {
        $gameBoard = new GameBoard();

        $objects = $gameBoard->getObjects();

        $cards = ["ace_of_diamonds", "2_of_clubs", "null", "10_of_hearts", "8_of_diamonds"];

        for ($i = 0; $i < 5; $i++) {
            $objects[$i]->setHolderCard($cards[$i]);
        }

        $rows = $gameBoard->rows();

        $testRow = $rows[0];

        $this->assertTrue($gameBoard->ifFourCards($testRow));
    }

    /**
     * Tests ifFourCards() method for GameBoard when false.
     */
    public function testGameBoardIfFourCardsFalse(): void
    {
        $gameBoard = new GameBoard();

        $objects = $gameBoard->getObjects();

        $cards = ["ace_of_diamonds", "2_of_clubs", "null", "10_of_hearts", "null"];

        for ($i = 0; $i < 5; $i++) {
            $objects[$i]->setHolderCard($cards[$i]);
        }

        $rows = $gameBoard->rows();

        $testRow = $rows[0];

        $this->assertFalse($gameBoard->ifFourCards($testRow));
    }
}
