<?php

namespace App\Card;

/**
 * Class for Poker Square game
 */
class PokerSquare
{
    /**
     * @var array<int> $ranks
     */
    private $ranks = [];

    /**
     * @var array<string> $suits
     */
    private $suits = [];

    /**
     * @var int $points
     */
    private $points = 0;

    /**
     * Constructor to create a GraphicCard.
     *
     * @param array<array> $colOrRow
     */
    public function __construct(array $colOrRow)
    {
        foreach ($colOrRow as $holder) {
            $card = explode("_of_", $holder[1]);
            $this->ranks[] = $this->rankAsNumber($card[0]);
            $this->suits[] = $card[1] ?? "null";
        }
        sort($this->ranks);
    }

    /**
     * Converts rank from string to int
     *
     * @return int
     */
    public function rankAsNumber(string $imageName): int
    {
        $ranks = ['king', 'queen', 'jack', 'ace'];
        $numbers = [13, 12, 11, 1];
        $rank = 0;

        for ($i = 0; $i < 4; $i++) {
            if (str_starts_with($imageName, $ranks[$i])) {
                $rank = $numbers[$i];
                break;
            } else {
                $rank = intval($imageName);
            }
        }

        return $rank;
    }

    /**
     * Converts rank from string to int
     *
     * @return array<int>
     */
    public function getRanks(): array
    {
        sort($this->ranks);
        return $this->ranks;
    }

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

    /**
     * Checks which poker hand
     *
     * @return int
     */
    public function whichPokerHand(): int
    {
        if ($this->royalStraightFlush()) {
            return 100;
        } elseif ($this->straightFlush()) {
            return 75;
        } elseif ($this->fourOfAKind()) {
            return 50;
        } elseif ($this->fullHouse()) {
            return 25;
        } elseif ($this->flush()) {
            return 20;
        } elseif ($this->straight()) {
            return 15;
        } elseif ($this->threeOfAKind()) {
            return 10;
        } elseif ($this->twoPairs()) {
            return 5;
        } elseif ($this->onePair()) {
            return 2;
        } else {
            return 0;
        }
    }

    /**
     * Set points to column
     *
     * @return void
     */
    public function setPoints(): void
    {
        $this->points = $this->whichPokerHand();
    }

    /**
     * Get points of column
     *
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }
}
