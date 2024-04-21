<?php

namespace App\Card;

/**
 * Class for a card, containing two properties, one constructor and one method.
 */
class Card
{
    /**
     * @var string $rank     Card rank
     * @var string $suit     Card suit
     */
    protected $rank;
    protected $suit;

    /**
     * Constructor to create a Card.
     *
     * @param string $rank The rank of the card.
     * @param string $suit The suit of the card.
     */
    public function __construct($rank, $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
    }

    /**
     * Presents value of card.
     *
     * @return string formatted as a card.
     */
    public function getValue(): string
    {
        return '[' . $this->rank . $this->suit . ']';
    }
}
