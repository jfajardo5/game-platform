<x-app-layout>
	<div class="py-12">
        <div x-data="game()" class="mx-auto overflow-hidden bg-white shadow-xl max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg">
			<div x-show="gameIsOver" class="flex flex-col items-center justify-center text-center">
				<span  x-text="flashMessage" class="fixed z-10 p-3 mt-20 font-bold text-white bg-green-700 border border-gray-300 rounded-lg shadow-lg animate__animated animate__fadeInUp"></span>
			</div>
			<div class="flex flex-row justify-between p-4">
				<h2>Dealer: <span x-text="dealerScore"></span> pts</h2>
            	<h2>Player: <span x-text="playerScore"></span> pts</h2>
        	</div>
            <div class="flex flex-col p-8 h-80">
                <div class="flex flex-row items-center justify-center space-around">
                	<template x-for="card in dealerCards" :key="card">
						<div class="flex flex-col items-center justify-center p-4 text-center animate__animated animate__slower animate__fadeIn">
							<label x-text="card.name + ' of ' + card.group"></label>
							<image :src="card.image_url" class="w-32 p-2">
						</div>
                	</template>
                </div>
            </div>
			<div class="flex flex-col p-8 h-80">
                <div class="flex flex-row items-center justify-center space-around">
                	<template x-for="card in playerCards" :key="card">
						<div class="flex flex-col items-center justify-center p-4 text-center animate__animated animate__slower animate__fadeIn">
							<label x-text="card.name + ' of ' + card.group"></label>
							<image :src="card.image_url" class="w-32 p-2">
						</div>
                	</template>
                </div>
            </div>
			<div class="flex flex-col items-center justify-center text-center">
				<label>Your balance: $<span x-text="playerBalance"></span></label>
			</div>
            <div class="flex flex-row flex-wrap justify-center p-4">
                <button x-bind:disabled="gameRunning" x-show="!gameIsOver && !playerHolds" @click="playerHits();gameLogic()" @mouseover="hitHover = true" @mouseover.away="hitHover = false" :class="{'animate__animated animate__infinite animate__pulse relative bg-gray-800 text-white p-3 m-2 px-14 rounded text-xl font-bold overflow-hidden' : hitHover, 'relative bg-gray-800 text-white p-3 m-2 px-14 rounded text-xl font-bold overflow-hidden' : !hitHover}">Hit</button>
                <button x-bind:disabled="gameRunning" x-show="!gameIsOver && (rounds != 0)" @click="playerSits();gameLogic()" @mouseover="foldHover = true" @mouseover.away="foldHover = false" :class="{'animate__animated animate__infinite animate__pulse relative bg-gray-800 text-white p-3 m-2 px-12 rounded text-xl font-bold overflow-hidden' : foldHover, 'relative bg-gray-800 text-white p-3 m-2 px-12 rounded text-xl font-bold overflow-hidden' : !foldHover}">Fold</button>
				<button x-show="gameIsOver" @click="resetGame()" @mouseover="resetHover = true" @mouseover.away="resetHover = false" :class="{'animate__animated animate__infinite animate__pulse relative bg-gray-800 text-white p-3 m-2 px-12 rounded text-xl font-bold overflow-hidden' : resetHover, 'relative bg-gray-800 text-white p-3 m-2 px-12 rounded text-xl font-bold overflow-hidden' : !resetHover}">Play Again!</button>
			</div>
        </div>
    </div>
    <script>
    	function game() {
    		return {
    			rounds: 0,
				gameRunning: false,
				playerBalance: 300,
				gameIsOver: false,
	    		dealerScore: 0,
	    		playerScore: 0,
	    		dealerCards: [],
	    		playerCards: [],
	    		playerHolds: false,
	    		hitHover: false,
	    		foldHover: false,
				resetHover: false,
				flashMessage: "",
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
	    		async gameLogic() {
	    			await pause(500);
	    			if(this.dealerCanHit()) {
	    				this.dealerHits();
	    			}
	    			this.calculatePlayerScore();
	    			this.calculateDealerScore();
	    			if(this.gameOver()) {
						this.announceWinner();
						await pause(300);
	    				this.gameIsOver = true;
	    			}
	    			this.rounds++;
					this.gameRunning = false;
	    		},
	    		dealerCanHit() {
	    			if(this.dealerScore >= 17) {
	    				return false;
	    			}
	    			return true;
	    		},
	    		playerHits() {
					this.gameRunning = true;
					if(this.rounds == 0) {
						this.playerBalance -= 30;
					}
	    			if(!this.playerHolds) {
						this.playerCards.push(this.cards.shift());
	    			}
	    		},
	    		async playerSits() {
					this.gameRunning = true;
	    			this.playerHolds = true;
					while(this.dealerCanHit()) {
						await this.gameLogic();
					}
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
	    			} else if(this.dealerScore < 21 && this.playerScore < 21) {
	    				return false;
	    			}
	    			return true;
	    		},
	    		async announceWinner() {
	    			if(this.playerScore > this.dealerScore && this.playerScore <= 21) {
	    				this.flashMessage = "Player wins!";
						this.playerBalance += 45;
	    			} else if(this.dealerScore > this.playerScore && this.dealerScore <= 21) {
	    				this.flashMessage = "Dealer wins!";
	    			} else if(this.playerScore > 21) {
	    				this.flashMessage = "Dealer wins!";
	    			} else if(this.dealerScore > 21) {
	    				this.flashMessage = "Player wins!";
						this.playerBalance += 45;
	    			} else if(this.dealerScore == this.playerScore) {
	    				this.flashMessage = "It's a draw!";
						this.playerBalance += 30;
	    			}
	    		},
				resetGame() {
					this.rounds = 0;
					this.gameIsOver= false;
					this.dealerScore = 0;
					this.playerScore = 0;
					this.dealerCards = [];
					this.playerCards = [];
					this.playerHolds = false;
				}
	    	}
    	}

    	function pause(milliseconds = 1000) {
            return new Promise(resolve => setTimeout(resolve, milliseconds));
        }
    </script>
</x-app-layout>