<?php

namespace App\Card;

/**
 * Class for Poker Square game
 */
class PokerSquare
{
    /**
     * @var array $ranks
     */
    protected $ranks = [];

    /**
     * @var string $suits
     */
    protected $suits = [];

    /**
     * Constructor to create a GraphicCard.
     *
     * @param string $rank The rank of the card.
     * @param string $suit The suit of the card.
     */
    public function __construct($colOrRow)
    {
        foreach ($colOrRow as $holder) {
            $card = explode("_of_", $holder[1]);
            $this->ranks[] = $this->rankAsNumber($card[0]);
            $this->suits[] = $card[1] ?? null;
        }
    }

    /**
     * Converts rank/suit and presents value of graphic card.
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
     * Check if pair
     *
     * @return bool
     */
    public function onePair(): bool
    {
        $removeDuplicates = array_unique($this->ranks);
        if (count($removeDuplicates) !== 4) {
            echo "not pair";
            return false;
        }
        echo "pair!";
        return true;
    }

    /**
     * Check if two pairs
     *
     * @return bool
     */
    public function twoPairs(): bool
    {
        //
    }

    /**
     * Check if straight
     *
     * @return bool
     */
    public function straight(): bool
    {
        sort($this->ranks);
        $count = 0;

        for ($i = 0; $i < 4; $i++) {
            echo $this->ranks[$i];
            if ($this->ranks[$i + 1] - $this->ranks[$i] === 1) {
                $count += 1;
            }
        }

        if ($count === 4) {
            echo "straight!";
            return true;
        }

        echo "not straight";

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
            echo "not flush";
            return false;
        }

        echo "flush!";
        return true;
    }
}
