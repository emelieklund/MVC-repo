<?php

namespace App\Card;

/**
 * Class for card holder
 */
class CardHolder
{
    /**
     * @var int $holderId     Holder ID
     */
    private $holderId;

    /**
     * @var string $holderCard     Name of card in holder (or "null")
     */
    private $holderCard = "null";

    /**
     * Constructor to create a CardHolder.
     *
     * @param int $holderId
     */
    public function __construct(int $holderId)
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
