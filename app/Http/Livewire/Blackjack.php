<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PlayingCard;
use Illuminate\Database\Eloquent\Collection;

class Blackjack extends Component
{

    public $rounds;
    public $gameRunning;
    public $playerBalance;
    public $gameIsOver;
    public $dealerScore;
    public $playerScore;
    public $dealerCards;
    public $playerCards;
    public $playerStands;
    public $dealerStands;
    public $flashMessage;
    public $cards;
    public $winner;

    public function mount()
    {

        $this->rounds = 0;
        $this->gameRunning = false;
        $this->playerBalance = 300;
        $this->gameIsOver = false;
        $this->dealerScore = 0;
        $this->playerScore = 0;
        $this->dealerCards = new Collection;
        $this->playerCards = new Collection;
        $this->playerStands = false;
        $this->dealerStands = false;
        $this->flashMessage = "";
        $this->cards = PlayingCard::inRandomOrder()->get();

    }

    public function render()
    {

        return view('livewire.blackjack');

    }

    public function stand()
    {
        
        $this->gameRunning = true;

        $this->playerStands = true;

        if($this->isGameOver()) {

            $this->flashMessage = $this->determineWinner();

            return false;

        }

        if($this->dealerCanHit()) {

            $this->dealerHits();

        }

        $this->rounds++;

        $this->stand();

    }

    public function hitRound()
    {

        $this->gameRunning = true;

        if($this->rounds == 0) {

            $this->playerBalance -= 30;

        }

        $this->playerHits();

        if($this->dealerCanHit()) {

            $this->dealerHits();

        }

        $this->rounds++;

        if($this->isGameOver()) {

            $this->flashMessage = $this->determineWinner();

            return false;

        }

        $this->gameRunning = false;

    }

    public function determineWinner()
    {

        if($this->playerScore > 21) {

            return 'Dealer wins!';

        }

        if($this->dealerScore > 21) {

            return 'Player wins!';

        }

        if($this->playerScore <= 21 && $this->playerScore > $this->dealerScore) {

            return 'Player wins!';

        }

        if($this->dealerScore <= 21 && $this->dealerScore > $this->playerScore) {

            return 'Dealer wins!';

        }

        return 'It\'s a draw!';

    }

    public function playerHits()
    {

        $card = $this->cards->shift();

        $card->value = $this->parseCardValue($card->value, $this->playerScore);
        
        $this->playerCards->push($card);

        $this->playerScore += $card->value;

    }

    public function dealerHits()
    {

        $card = $this->cards->shift();

        $card->value = $this->parseCardValue($card->value, $this->playerScore);

        $this->dealerCards->push($card);

        $this->dealerScore += $card->value;

    }

    public function dealerCanHit()
    {

        if($this->dealerScore < 17) {

            return true;

        }

        return false;

    }

    public function parseCardValue($value, $score) 
    {

        if($value == 'ace') {
            
            if($score + 11 > 21) {
            
                return 1;
            
            }

            return 11;

        }

        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    public function isGameOver()
    {

        if($this->playerScore >= 21 || $this->dealerScore >= 21|| ($this->playerStands && !$this->dealerCanHit()) || ($this->playerStands && ($this->dealerScore > $this->playerScore)) || $this->gameIsOver ) {

            $this->gameIsOver = true;
            
            return true;

        }

        return false;

    }

}
