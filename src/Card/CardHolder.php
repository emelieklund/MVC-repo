<?php

namespace App\Card;

/**
 * Class for card holder
 */
class CardHolder
{
    private $holderId;

    private $holderCard = "null";

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

    /**
     * Get holder card
     *
     * @return string
     */
    public function getHolderCard(): string
    {
        return $this->holderCard;
    }
}
