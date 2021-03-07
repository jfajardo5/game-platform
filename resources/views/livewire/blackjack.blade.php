<div x-data="game()" class="mx-auto overflow-hidden bg-white shadow-xl max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg">
    <div class="p-6 text-center">
        <label class="text-xl">Your balance: ${{ $player_balance }}</label>
    </div>
    <div x-show="game_started" class="flex flex-row flex-wrap items-center justify-center p-1 text-center sm:justify-between animate__animated animate__slow animate__fadeIn">
        <span class="p-4 text-xl"><strong>Dealer:</strong> {{ $dealer_score }} pts</span>
        <span class="p-4 text-xl"><strong>You:</strong> {{ $player_score }} pts</span>
    </div>
    <div x-show.transition="!game_started" class="flex flex-col items-center justify-center px-3 py-1 lg:py-10">
        <div id="dialog" class="w-full mx-2 bg-gray-900 border-gray-600 rounded-lg shadow-xl">
            <div id="header" class="p-4 text-white">
                <span class="text-xl font-bold">Blackjack Rules</span>
            </div>
            <div id="body" class="p-4 bg-gray-100">
                <ul class="p-6 text-lg list-disc">
                    <li class="p-1 lg:p-4">The goal of blackjack is to beat the dealer's hand without going over 21.</li>
                    <li class="p-1 lg:p-4">Face cards are worth 10. Aces are worth 11 unless they would bring you over 21, at which point they are worth 1.</li>
                    <li class="p-1 lg:p-4">To 'Hit' is to ask for another card. To 'Stand' is to hold your total and end your turn.</li>
                    <li class="p-1 lg:p-4">If you go over 21 you bust, and the dealer wins regardless of the dealer's hand.</li>
                    <li class="p-1 lg:p-4">Dealer will hit until his/her cards total 17 or higher.</li>
                    <li class="p-1 lg:p-4">Buy in is $30. Win is $45.</li>
                    <li class="p-1 lg:p-4">If you go bust, we'll hand you $300 so you can keep playing. Aim for millions!</li>
                </ul>
            </div>
        </div>
    </div>
    <div x-show.transition="game_started" class="flex flex-row flex-wrap items-center justify-center p-3 mb-2" style="min-height: 12rem;">
        <template x-for="card in dealer_cards">
            <div class="flex flex-col items-center justify-center p-2 text-center animate__animated animate__flipInY">
                <span x-text="card.name + ' of ' + card.group" class="hidden text-md lg:text-lg md:block"></span>
                <img :src="card.image_url" class="w-16 lg:w-32">
            </div>
        </template>
    </div>
    <div class="flex flex-col items-center justify-center">
        <div x-show.transition="game_is_over" class="fixed z-10 flex flex-col items-center justify-center w-64 px-6 py-4 m-4 text-center text-green-700 bg-green-100 border border-green-400 rounded-lg shadow-xl lg:w-96 animate__animated animate__backInDown" role="alert">
            <strong class="text-xl font-bold lg:text-3xl">{{ $flash_message }}</strong>
            <button x-show="game_is_over" wire:click="mount()" class="px-4 py-2 m-2 font-bold text-white transition bg-black border-b-4 border-gray-700 rounded max-w-16 hover:bg-gray-400 hover:border-gray-500">Play Again?</button>
        </div>
    </div>
    <hr x-show.transition="game_started">
    <div x-show.transition="game_started" class="flex flex-row flex-wrap items-center justify-center p-3" style="min-height: 12rem;">
        <template x-for="card in player_cards">
            <div class="flex flex-col items-center justify-center p-2 text-center animate__animated animate__flipInY">
                <span x-text="card.name + ' of ' + card.group" class="hidden text-md lg:text-lg md:block"></span>
                <img :src="card.image_url" class="w-16 lg:w-32">
            </div>
        </template>
    </div>
    <div class="flex flex-col items-center justify-center p-3 text-center">
        <span x-show.transition="rounds > 0" class="text-lg animate__animated animate__fadeIn">Round: {{ $rounds }}</span>
    </div>
    <div class="flex flex-row items-center justify-center p-2 lg:p-4">
        <button x-text="play_button_text()" x-bind:disabled="game_running" x-show="!game_is_over" wire:click="hit_round();" @click="start_game();" class="py-2 m-2 font-bold text-white transition bg-black border-b-4 border-gray-700 rounded px-7 hover:bg-gray-400 hover:border-gray-500"></button>
        <button x-bind:disabled="game_running" x-show="rounds > 0 && !game_is_over" wire:click="stand()" class="px-4 py-2 m-2 font-bold text-white transition bg-black border-b-4 border-gray-700 rounded hover:bg-gray-400 hover:border-gray-500">Stand</button>
    </div>
</div>
<script>
    function game() {
        return {
            game_started: false,
            rounds: @entangle('rounds'),
            game_running: @entangle('game_running'),
            game_is_over: @entangle('game_is_over'),
            player_cards: @entangle('player_cards'),
            dealer_cards: @entangle('dealer_cards'),
            start_game() {
                this.game_started = true;
            },
            play_button_text() {
                if(this.rounds > 0) {
                    return 'Hit!';
                }
                return 'Play!';
            }
        }
    }
</script>
