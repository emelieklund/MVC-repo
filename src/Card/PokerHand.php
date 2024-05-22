<?php

namespace App\Card;

/**
 * Class for Poker Square game
 */
class PokerHand extends PokerSquare
{
    /**
     * @var array $ranks
     */
    private $ranks = [];

    /**
     * @var string $suits
     */
    private $suits = [];

    /**
     * @var int $points
     */
    private $points = 0;

    // /**
    //  * Constructor to create a PokerHand.
    //  *
    //  * @param array $colOrRow
    //  */
    // public function __construct($colOrRow)
    // {
    //     parent::__construct($colOrRow);
    // }

    /**
     * Check if pair
     *
     * @return bool
     */
    public function onePair(): bool
    {
        $countValues = array_count_values($this->ranks);

        foreach ($countValues as $count) {
            if ($count === 2) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if two pairs
     *
     * @return bool
     */
    public function twoPairs(): bool
    {
        $countValues = array_count_values($this->ranks);

        foreach (array_count_values($countValues) as $count) {
            if ($count === 2) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if three of a kind
     *
     * @return bool
     */
    public function threeOfAKind(): bool
    {
        $countValues = array_count_values($this->ranks);

        foreach ($countValues as $count) {
            if ($count === 3) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if straight
     *
     * @return bool
     */
    public function straight(): bool
    {
        $count = 0;

        if ($this->ranks === [1, 10, 11, 12, 13]) {
            $this->ranks = [10, 11, 12, 13, 14];
        }

        for ($i = 0; $i < 4; $i++) {
            if ($this->ranks[$i + 1] - $this->ranks[$i] === 1) {
                $count += 1;
            }
        }

        if ($count === 4) {
            return true;
        }

        return false;
    }

    /**
     * Check if flush
     *
     * @return bool
     */
    public function flush(): bool
    {
        $removeDuplicates = array_unique($this->suits);
        if (count($removeDuplicates) !== 1) {
            return false;
        }

        return true;
    }

    /**
     * Check if full house
     *
     * @return bool
     */
    public function fullHouse(): bool
    {
        if ($this->onePair() && $this->threeOfAKind()) {
            return true;
        }

        return false;
    }

    /**
     * Check if four of a kind
     *
     * @return bool
     */
    public function fourOfAKind(): bool
    {
        $countValues = array_count_values($this->ranks);

        foreach ($countValues as $count) {
            if ($count === 4) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if straight flush
     *
     * @return bool
     */
    public function straightFlush(): bool
    {
        if ($this->straight() && $this->flush()) {
            return true;
        }

        return false;
    }

    /**
     * Check if royal straight flush
     *
     * @return bool
     */
    public function royalStraightFlush(): bool
    {
        if ($this->straight() && $this->flush() && in_array(14, $this->ranks)) {
            return true;
        }

        return false;
    }
}
