<?php

namespace App\Card;

/**
 * Class for a card deck, containing two properties and some methods.
 */
class DeckOfCards
{
    /**
     * @var array $rank     All 13 ranks in a card deck.
     * @var array $suit     All 4 suits in a card deck.
     * @var array $deck     Representing card deck.
     */
    private $rank = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
    private $suit = ['♠', '♥', '♣', '♦'];
    private $deck = [];

    /**
     * Constructor to create a CardDeck.
     */
    public function __construct()
    {
        foreach ($this->suit as $s) {
            foreach ($this->rank as $r) {
                $card = new Card($r, $s);
                $this->deck[] = $card;
            }
        }
    }

    /**
     * Creates the deck, using $rank and $suit.
     *
     * @return array with all cards.
     */
    public function getDeckSorted(): array
    {
        $sorted = [];
        foreach ($this->deck as $card) {
            $sorted[] = $card->getValue();
        }
        return $sorted;
    }

    /**
     * Takes the sorted deck and shuffles it.
     *
     * @return array with all cards, shuffled.
     */
    public function getDeckShuffled(): array
    {
        $shuffled = [];
        $deck = $this->getDeckSorted();
        shuffle($deck);
        foreach ($deck as $card) {
            $shuffled[] = $card;
        }
        return $shuffled;
    }

    /**
     * Creates graphic deck, using $rank and $suit.
     *
     * @return array with all cards.
     */
    public function getGraphicDeck(): array
    {
        $graphicDeck = [];
        foreach ($this->suit as $s) {
            foreach ($this->rank as $r) {
                $card = new CardGraphic($r, $s);
                $graphicDeck[] = $card->getImageName();
            }
        }
        return $graphicDeck;
    }

    /**
     * Takes a random nr between 0 and the amount of cards in the deck.
     *
     * @return string that represents the randomized card.
     */
    public function draw(): string
    {
        $randNr = rand(0, count($this->deck) - 1);
        $card = $this->deck[$randNr];
        array_splice($this->deck, $randNr, 1);

        return $card->getValue();
    }

    /**
     * Takes a random nr between 0 and the amount of cards in the deck, $number times, and adds it to $cardHand.
     *
     * @return array that represents the randomized card hand.
     */
    public function drawNumber(int $number): array
    {
        $cardHand = new CardHand();

        for ($i = 0; $i < $number; $i++) {
            $randNr = rand(0, count($this->deck) - 1);
            $card = $this->deck[$randNr];
            array_splice($this->deck, $randNr, 1);
            $cardHand->add($card);
        }

        return $cardHand->getValues();
    }

    /**
     * Counts the amount of cards left in the deck.
     *
     * @return int
     */
    public function getNrOfCards(): int
    {
        return count($this->deck);
    }
}
