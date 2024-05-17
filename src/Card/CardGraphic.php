<?php

namespace App\Card;

/**
 * Class for a graphic card, extending original Card class. Contains one method.
 */
class CardGraphic extends Card
{
    /**
     * @var int $num
     */
    protected $num = 0;
    /**
     * Constructor to create a GraphicCard.
     *
     * @param string $rank The rank of the card.
     * @param string $suit The suit of the card.
     */
    public function __construct($rank, $suit)
    {
        parent::__construct($rank, $suit);
    }

    /**
     * Converts rank/suit and presents value of graphic card.
     *
     * @return string representing a file name (excluding file extension)
     */
    public function getImageName(): string
    {
        $rankShort = ['K', 'Q', 'J', 'A'];
        $rank = ['king', 'queen', 'jack', 'ace'];

        for ($i = 0; $i < 4; $i++) {
            if ($this->rank === $rankShort[$i]) {
                $this->rank = $rank[$i];
                break;
            }
        }

        $suitShort = ['♠', '♥', '♣', '♦'];
        $suit = ['spades', 'hearts', 'clubs', 'diamonds'];

        for ($i = 0; $i < 4; $i++) {
            if ($this->suit === $suitShort[$i]) {
                $this->suit = $suit[$i];
                break;
            }
        }

        return $this->rank . '_of_' . $this->suit;
    }

    /**
     * Converts rank/suit and presents value of graphic card.
     *
     * @return int
     */
    public function getRankAsNumber(): int
    {
        $ranks = ['k', 'q', 'j', 'a'];
        $numbers = [13, 12, 11, 1];

        for ($i = 0; $i < 4; $i++) {
            if (str_starts_with($this->getImageName(), $ranks[$i])) {
                $this->num = $numbers[$i];
                break;
            } else {
                $this->num = intval($this->rank);
            }
        }

        return $this->num;
    }
}
