<?php

namespace App\Card;

/**
 * Class for card holder
 */
class GameBoard
{
    protected $gameBoard = [];

    public function __construct()
    {
        for ($i = 0; $i < 25; $i++) {
            $cardHolder = new CardHolder($i);
            $this->gameBoard[] = $cardHolder;
        }
    }

    /**
     * Get all items
     *
     * @return array
     */
    public function getItems(): array
    {
        $items = [];
        foreach ($this->gameBoard as $holder) {
            $items[] = $holder;
        }

        return $items;
    }

    /**
     * Get all holders
     *
     * @return array<int>
     */
    public function getHolders(): array
    {
        $holders = [];
        foreach ($this->gameBoard as $holder) {
            $holders[] = $holder->getHolderId();
        }

        return $holders;
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
    public function getBoth(): array
    {
        $both = [];
        foreach ($this->gameBoard as $holder) {
            $both[] = [$holder->getHolderId(), $holder->getHolderCard()];
        }

        return $both;
    }
}
