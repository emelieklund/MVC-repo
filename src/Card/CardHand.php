<?php

namespace App\Card;

/**
 * Class for a card hand, containing one property and three methods.
 */
class CardHand
{
    /**
     * @var array<Card> $hand
     */
    private $hand = [];
    /**
     * @var array<CardGraphic> $handGraphic
     */
    private $handGraphic = [];

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
     * Adds object of class CardGraphic to $hand.
     *
     * @return void
     */
    public function addGraphic(CardGraphic $cardGraphic): void
    {
        $this->handGraphic[] = $cardGraphic;
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
     * @return array<string>
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

    /**
     * Returns all values (cards) in $hand.
     *
     * @return array<string>
     */
    public function getGraphicValues(): array
    {
        $values = [];
        foreach ($this->handGraphic as $card) {
            $values[] = $card->getImageName();
        }
        return $values;
    }

    /**
     * Returns all values (cards) in $hand.
     *
     * @return int
     */
    public function getSum(): int
    {
        $sum = 0;
        foreach ($this->handGraphic as $card) {
            $sum += $card->getRankAsNumber();
        }
        return $sum;
    }
}
