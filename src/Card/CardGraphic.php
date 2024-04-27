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
        switch ($this->rank) {
            case 'K':
                $this->rank = 'king';
                break;
            case 'Q':
                $this->rank = 'queen';
                break;
            case 'J':
                $this->rank = 'jack';
                break;
            case 'A':
                $this->rank = 'ace';
                break;
        }

        switch ($this->suit) {
            case '♠':
                $this->suit = 'spades';
                break;
            case '♥':
                $this->suit = 'hearts';
                break;
            case '♣':
                $this->suit = 'clubs';
                break;
            case '♦':
                $this->suit = 'diamonds';
                break;
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
        if (str_starts_with($this->getImageName(), 'k')) {
            $this->num = 13;
        } elseif (str_starts_with($this->getImageName(), 'q')) {
            $this->num = 12;
        } elseif (str_starts_with($this->getImageName(), 'j')) {
            $this->num = 11;
        } elseif (str_starts_with($this->getImageName(), 'a')) {
            $this->num = 1;
        } else {
            $this->num = intval($this->rank);
        }

        return $this->num;
    }
}
