<?php

namespace App\Card;

/**
 * Class for card holder
 */
class CardHolder
{
    protected $holderId;

    protected $holderCard = "null";

    public function __construct($holderId)
    {
        $this->holderId = $holderId;
    }

    /**
     * Get holder ID
     *
     * @return int
     */
    public function getHolderId(): int
    {
        return $this->holderId;
    }

    /**
     * Set card to holder ID
     *
     * @return void
     */
    public function setHolderCard(string $card): void
    {
        $this->holderCard = $card;
    }

    // getter method for card name (null if not set yet)

    /**
     * Get holder card
     *
     * @return string
     */
    public function getHolderCard(): string
    {
        return $this->holderCard;
    }

    // method that returns card value
}
