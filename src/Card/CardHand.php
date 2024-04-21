<?php

namespace App\Card;

/**
 * Class for a card hand, containing one property and three methods.
 */
class CardHand
{
    /**
     * @var array $hand
     */
    private $hand = [];

    /**
     * Adds object of class Card to $hand.
     *
     * @return void
     */
    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    /**
     * Counts number of cards in $hand.
     *
     * @return int
     */
    public function getNumberCards(): int
    {
        return count($this->hand);
    }

    /**
     * Returns all values (cards) in $hand.
     *
     * @return int
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }
}
