<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PlayingCard;

class Blackjack extends Component
{

    private $payout_amount = 45;
    private $bet_amount = 30;
    public $rounds;
    public $game_running;
    public $player_balance;
    public $game_is_over;
    public $dealer_score;
    public $player_score;
    public $dealer_cards;
    public $player_cards;
    public $player_stands;
    public $flash_message;
    public $cards;
    public $winner;

    public function mount()
    {
        if((auth()->user()->balance - $this->bet_amount < 0)) {
            $this->reset_balance();
        }
        $this->game_is_over = false;
        $this->rounds = 0;
        $this->flash_message = "";
        $this->game_running = false;
        $this->player_balance = auth()->user()->balance;
        $this->dealer_score = 0;
        $this->player_score = 0;
        $this->dealer_cards = collect();
        $this->player_cards = collect();
        $this->player_stands = false;
        $this->cards = PlayingCard::inRandomOrder()->get();

    }

    public function render()
    {

        return view('livewire.blackjack');

    }

    /**
     *  Player stands, dealer plays until dealer_score >= 17.
     * 
     *  @param void
     * 
     *  @return boolean
     */
    public function stand()
    {
        
        $this->game_running = true;

        $this->player_stands = true;

        if($this->is_game_over()) {

            $this->flash_message = $this->determine_winner();

            return false;

        }

        if($this->dealer_can_hit()) {

            $this->dealer_hits();

        }

        $this->rounds++;

        $this->stand();

    }

    /**
     *  Player hits, dealer plays if possible.
     * 
     *  @param void
     * 
     *  @return boolean
     */
    public function hit_round()
    {
        
        $this->game_running = true;

        if($this->rounds == 0) {

            $this->deduct_balance();

        }

        $this->player_hits();

        if($this->dealer_can_hit()) {

            $this->dealer_hits();

        }

        $this->rounds++;

        if($this->is_game_over()) {

            $this->flash_message = $this->determine_winner();

            return false;

        }

        $this->game_running = false;

    }

    /**
     *  Determines who won the game.
     * 
     *  @param void
     * 
     *  @return string
     */
    public function determine_winner()
    {

        if($this->player_score > 21) {

            return 'Dealer wins!';

        }

        if($this->dealer_score > 21) {

            $this->payout($this->payout_amount);

            return 'You win!';

        }

        if($this->player_score <= 21 && $this->player_score > $this->dealer_score) {

            $this->payout($this->payout_amount);

            return 'You win!';

        }

        if($this->dealer_score <= 21 && $this->dealer_score > $this->player_score) {

            return 'Dealer wins!';

        }

        $this->payout($this->bet_amount);

        return 'It\'s a draw!';

    }

    /**
     *  Adds card to player's hand.
     * 
     *  @param void
     * 
     *  @return void
     */
    public function player_hits()
    {

        $card = $this->cards->shift();

        $card->value = $this->parse_card_value($card->value, $this->player_score);
        
        $this->player_cards->push($card);

        $this->player_score += $card->value;

    }

    /**
     *  Adds card to dealer's hand.
     * 
     *  @param void
     * 
     *  @return void
     */
    public function dealer_hits()
    {

        $card = $this->cards->shift();

        $card->value = $this->parse_card_value($card->value, $this->player_score);

        $this->dealer_cards->push($card);

        $this->dealer_score += $card->value;

    }

    /**
     *  Player stands, dealer plays until dealer_score >= 17.
     * 
     *  @param void
     * 
     *  @return boolean
     */
    public function dealer_can_hit()
    {

        if($this->dealer_score < 17) {

            return true;

        }

        return false;

    }

    /**
     *  Return card value. Determines whether Ace is worth 11 or 1.
     * 
     *  @param string $value
     *  @param int $score
     *  
     *  @return int
     */
    public function parse_card_value($value, $score) 
    {

        if($value == 'ace') {
            
            if($score + 11 > 21) {
            
                return 1;
            
            }

            return 11;

        }

        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     *  Determines if game is over.
     * 
     *  @param void
     * 
     *  @return bool
     */
    public function is_game_over()
    {

        if($this->player_score >= 21 || $this->dealer_score >= 21|| ($this->player_stands && !$this->dealer_can_hit()) || ($this->player_stands && ($this->dealer_score > $this->player_score)) || $this->game_is_over ) {

            $this->game_is_over = true;
            
            return true;

        }

        return false;

    }

    /**
     *  Adds payout to player's balance.
     * 
     *  @param void
     * 
     *  @return void
     */
    public function payout($amount = 30)
    {

        auth()->user()->balance += $amount;

        $this->player_balance = auth()->user()->balance;

        auth()->user()->save();

    }

    public function deduct_balance()
    {

        auth()->user()->balance -= $this->bet_amount;

        $this->player_balance = auth()->user()->balance;

        auth()->user()->save();

    }

    public function reset_balance()
    {

        auth()->user()->balance = 300;

        auth()->user()->save();

    }

}
