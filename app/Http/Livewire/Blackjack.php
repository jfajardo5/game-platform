<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PlayingCard;

class Blackjack extends Component
{

    private $payoutAmount = 45;
    private $betAmount = 30;
    public $rounds;
    public $gameRunning;
    public $playerBalance = 300;
    public $gameIsOver;
    public $dealerScore;
    public $playerScore;
    public $dealerCards;
    public $playerCards;
    public $playerStands;
    public $flashMessage;
    public $cards;
    public $winner;

    protected $listeners = [
        'playerGetsCard' => 'playerHits',
        'dealerGetsCard' => 'dealerHits'
    ];

    public function mount()
    {

        $this->gameIsOver = false;
        $this->rounds = 0;
        $this->flashMessage = "";
        $this->gameRunning = false;
        $this->dealerScore = 0;
        $this->playerScore = 0;
        $this->dealerCards = collect();
        $this->playerCards = collect();
        $this->playerStands = false;
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

            $this->playerBalance -= $this->betAmount;

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

            $this->payout();

            return 'You win!';

        }

        if($this->playerScore <= 21 && $this->playerScore > $this->dealerScore) {

            $this->payout();

            return 'You win!';

        }

        if($this->dealerScore <= 21 && $this->dealerScore > $this->playerScore) {

            return 'Dealer wins!';

        }

        $this->playerStands += $this->betAmount;

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

    public function payout()
    {

        $this->playerBalance += $this->payoutAmount;

    }

}
