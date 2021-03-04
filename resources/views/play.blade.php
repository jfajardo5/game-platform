<x-app-layout>
	<div class="py-12">
        <div x-data="game()" class="mx-auto overflow-hidden bg-white shadow-xl max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg">
            <div class="flex flex-row flex-wrap justify-center ">
                <button @click="playerHits();gameLogic()">Player Hit</button>
                <button @click="playerSits();gameLogic()">Player Sit</button>
            </div>
            <div class="flex flex-col">
            	<h2>Dealer Cards:</h2>
                <div class="flex flex-row items-center space-around">
                	<template x-for="card in dealerCards" :key="card">
						<div class="flex flex-col items-center justify-center p-4 text-center">
							<label :text="card.name"></label>
							<image :src="card.image_url" class="w-40 p-2">
						</div>
                	</template>
                </div>
            </div>
			<div class="flex flex-col">
            	<h2>Player Cards:</h2>
                <div class="flex flex-row items-center space-around">
                	<template x-for="card in playerCards" :key="card">
						<div class="flex flex-col items-center justify-center p-4 text-center">
							<label :text="card.name"></label>
							<image :src="card.image_url" class="w-40 p-2">
						</div>
                	</template>
                </div>
            </div>
        </div>
    </div>
    <script>
    	function game() {
    		return {
    			rounds: 0,
	    		dealerScore: 0,
	    		playerScore: 0,
	    		dealerCards: [],
	    		playerCards: [],
	    		playerHolds: false,
	    		cards:[
	    			@foreach($cards as $card)
	    				{
	    					'name': '{{$card->name}}',
	    					'group': '{{$card->group}}',
	    					'value': '{{$card->value}}',
	    					'image_url': '{{$card->image_url}}'
	    				},
	    			@endforeach
	    		],
	    		gameLogic() {
	    			if(this.dealerCanHit()) {
	    				this.dealerHits();
	    			}
	    			this.calculatePlayerScore();
	    			this.calculateDealerScore();
	    			if(this.gameOver() || this.playerHolds) {
	    				this.announceWinner();
	    			}
	    			this.rounds++;
	    		},
	    		dealerCanHit() {
	    			if(this.dealerScore >= 17) {
	    				return false;
	    			}
	    			return true;
	    		},
	    		playerHits() {
	    			if(!this.playerHolds) {
						this.playerCards.push(this.cards.shift());
	    			}
	    		},
	    		playerSits() {
	    			this.playerHolds = true;
	    		},
	    		dealerHits() {
					this.dealerCards.push(this.cards.shift());
	    		},
	    		calculatePlayerScore() {
	    			this.playerScore = 0;
	    			for(let i = 0; i < this.playerCards.length; i++) {
	    				if(this.playerCards[i].value == 'ace' && (this.playerScore + 11 > 21)) {
	    					this.playerScore += 1;
	    				} else if(this.playerCards[i].value == 'ace') {
	    					this.playerScore += 11;
	    				} else {
	    					this.playerScore += parseInt(this.playerCards[i].value);
	    				}
	    			}
	    		},
	    		calculateDealerScore() {
	    			this.dealerScore = 0;
	    			for(let i = 0; i < this.dealerCards.length; i++) {
	    				if(this.dealerCards[i].value == 'ace' && (this.dealerScore + 11 > 21)) {
	    					this.dealerScore += 1;
	    				} else if(this.dealerCards[i].value == 'ace') {
	    					this.dealerScore += 11;
	    				} else {
	    					this.dealerScore += parseInt(this.dealerCards[i].value);
	    				}
	    			}
	    		},
	    		gameOver() {
	    			if(!this.dealerCanHit() && this.playerHolds) {
	    				return true;
	    			} else if(this.dealerScore <= 21 && this.playerScore <= 21) {
	    				return false;
	    			}
	    			return true;
	    		},
	    		announceWinner() {
	    			if(this.playerScore > this.dealerScore && this.playerScore <= 21) {
	    				alert('Player wins!');
	    			} else if(this.dealerScore > this.playerScore && this.dealerScore <= 21) {
	    				alert('Dealer wins!');
	    			} else if(this.dealerScore > 21) {
	    				alert('Player wins!');
	    			} else if(this.playerScore > 21) {
	    				alert('Dealer wins!');
	    			} else if(this.dealerScore == this.playerScore) {
	    				alert('It\'s a draw!');
	    			}
	    		}
	    	}
    	}
    </script>
</x-app-layout>