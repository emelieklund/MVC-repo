<?php

namespace App\Card;

/**
 * Class for card holder
 */
class GameBoard
{
    /**
     * @var array<CardHolder> $gameBoard     Array that keeps all card holders
     */
    private $gameBoard = [];

    /**
     * Constructor to create a GameBoard.
     *
     */
    public function __construct()
    {
        for ($i = 1; $i <= 25; $i++) {
            $cardHolder = new CardHolder($i);
            $this->gameBoard[] = $cardHolder;
        }
    }

    /**
     * Get all items
     *
     * @return array<CardHolder>
     */
    public function getObjects(): array
    {
        $objects = [];
        foreach ($this->gameBoard as $holder) {
            $objects[] = $holder;
        }

        return $objects;
    }

    /**
     * Get all holders
     *
     * @return array<int>
     */
    public function getHolderIds(): array
    {
        $holderIds = [];
        foreach ($this->gameBoard as $holder) {
            $holderIds[] = $holder->getHolderId();
        }

        return $holderIds;
    }

    /**
     * Get all holder cards
     *
     * @return array<string>
     */
    public function getHolderCards(): array
    {
        $holderCards = [];
        foreach ($this->gameBoard as $holder) {
            $holderCards[] = $holder->getHolderCard();
        }

        return $holderCards;
    }

    /**
     * Get both holder id and card name
     *
     * @return array<mixed>
     */
    public function getIdAndCard(): array
    {
        $idAndCard = [];
        foreach ($this->gameBoard as $holder) {
            $idAndCard[] = [$holder->getHolderId(), $holder->getHolderCard()];
        }

        return $idAndCard;
    }

    /**
     * Get all columns
     *
     * @return array<mixed>
     */
    public function columns(): array
    {
        $column1 = [];
        $column2 = [];
        $column3 = [];
        $column4 = [];
        $column5 = [];
        $allColumns = [];

        foreach ($this->gameBoard as $holder) {
            if ($holder->getHolderId() % 5 === 1) {
                $column1[] = [$holder->getHolderId(), $holder->getHolderCard()];
            } elseif ($holder->getHolderId() % 5 === 2) {
                $column2[] = [$holder->getHolderId(), $holder->getHolderCard()];
            } elseif ($holder->getHolderId() % 5 === 3) {
                $column3[] = [$holder->getHolderId(), $holder->getHolderCard()];
            } elseif ($holder->getHolderId() % 5 === 4) {
                $column4[] = [$holder->getHolderId(), $holder->getHolderCard()];
            } elseif ($holder->getHolderId() % 5 === 0) {
                $column5[] = [$holder->getHolderId(), $holder->getHolderCard()];
            }
        }

        array_push($allColumns, $column1, $column2, $column3, $column4, $column5);

        return $allColumns;
    }

    /**
     * Get all rows
     *
     * @return array<mixed>
     */
    public function rows(): array
    {
        $row1 = [];
        $row2 = [];
        $row3 = [];
        $row4 = [];
        $row5 = [];
        $allRows = [];

        foreach ($this->gameBoard as $holder) {
            if ($holder->getHolderId() < 6) {
                $row1[] = [$holder->getHolderId(), $holder->getHolderCard()];
            } elseif ($holder->getHolderId() > 5 && $holder->getHolderId() < 11) {
                $row2[] = [$holder->getHolderId(), $holder->getHolderCard()];
            } elseif ($holder->getHolderId() > 10 && $holder->getHolderId() < 16) {
                $row3[] = [$holder->getHolderId(), $holder->getHolderCard()];
            } elseif ($holder->getHolderId() > 15 && $holder->getHolderId() < 21) {
                $row4[] = [$holder->getHolderId(), $holder->getHolderCard()];
            } elseif ($holder->getHolderId() > 20) {
                $row5[] = [$holder->getHolderId(), $holder->getHolderCard()];
            }
        }

        array_push($allRows, $row1, $row2, $row3, $row4, $row5);

        return $allRows;
    }

    /**
     * Returns true if column/row is full
     *
     * @return bool
     */
    public function ifFull(array $colOrRow): bool
    {
        foreach ($colOrRow as $holder) {
            if ($holder[1] === "null") {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns true if column/row has four placed cards
     *
     * @return bool
     */
    public function ifFourCards(array $colOrRow): bool
    {
        $testCol = [];
        foreach ($colOrRow as $holder) {
            if ($holder[1] === "null") {
                $testCol[] = $holder[1];
            }
        }

        if (count($testCol) === 1) {
            return true;
        }

        return false;
    }
}
