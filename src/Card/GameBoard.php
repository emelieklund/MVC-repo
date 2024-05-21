<?php

namespace App\Card;

/**
 * Class for card holder
 */
class GameBoard
{
    private $gameBoard = [];

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
     * @return array
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
            $holders[] = $holder->getHolderCard();
        }

        return $holders;
    }

    /**
     * Get both holder id and card name
     *
     * @return array
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
     * Get column 1
     *
     * @return array
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
            if ($holder->getHolderId() % 5 === 1 ) {
                $column1[] = [$holder->getHolderId(), $holder->getHolderCard()];
            }
            if ($holder->getHolderId() % 5 === 2 ) {
                $column2[] = [$holder->getHolderId(), $holder->getHolderCard()];
            }
            if ($holder->getHolderId() % 5 === 3 ) {
                $column3[] = [$holder->getHolderId(), $holder->getHolderCard()];
            }
            if ($holder->getHolderId() % 5 === 4 ) {
                $column4[] = [$holder->getHolderId(), $holder->getHolderCard()];
            }
            if ($holder->getHolderId() % 5 === 0 ) {
                $column5[] = [$holder->getHolderId(), $holder->getHolderCard()];
            }
        }
        $allColumns[] = $column1;
        $allColumns[] = $column2;
        $allColumns[] = $column3;
        $allColumns[] = $column4;
        $allColumns[] = $column5;

        return $allColumns;
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
}
