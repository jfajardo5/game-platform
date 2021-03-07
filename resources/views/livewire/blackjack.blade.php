<div x-data="game()" class="mx-auto overflow-hidden bg-white shadow-xl max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg">
    <div class="flex flex-col items-center justify-center p-3 text-center">
        <span x-show.transition="rounds > 0" class="text-lg animate__animated animate__fadeIn">Round: {{ $rounds }}</span>
    </div>
    <div class="flex flex-row flex-wrap items-center justify-center p-8 text-center sm:justify-between">
        <span class="text-xl">Dealer Score: {{ $dealer_score }} pts</span>
        <span class="text-xl">Player Score: {{ $player_score }} pts</span>
    </div>
    <div class="flex flex-row flex-wrap items-center justify-center p-3 mb-2 h-36 lg:h-64">
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
    <hr x-show.transition="rounds > 0">
    <div class="flex flex-row flex-wrap items-center justify-center p-3 h-36 lg:h-64">
        <template x-for="card in player_cards">
            <div class="flex flex-col items-center justify-center p-2 text-center animate__animated animate__flipInY">
                <span x-text="card.name + ' of ' + card.group" class="hidden text-md lg:text-lg md:block"></span>
                <img :src="card.image_url" class="w-16 lg:w-32">
            </div>
        </template>
    </div>
    <div class="flex flex-row items-center justify-center p-4">
        <button x-bind:disabled="game_running" x-show="!game_is_over" wire:click="hit_round()" class="py-2 m-2 font-bold text-white transition bg-black border-b-4 border-gray-700 rounded px-7 hover:bg-gray-400 hover:border-gray-500">Hit!</button>
        <button x-bind:disabled="game_running" x-show="rounds > 0 && !game_is_over" wire:click="stand()" class="px-4 py-2 m-2 font-bold text-white transition bg-black border-b-4 border-gray-700 rounded hover:bg-gray-400 hover:border-gray-500">Stand</button>
    </div>
    <div class="p-4 text-center">
        <label class="text-xl">Your balance: ${{ $player_balance }}</label>
    </div>
</div>
<script>
    function game() {
        return {
            rounds: @entangle('rounds'),
            game_running: @entangle('game_running'),
            game_is_over: @entangle('game_is_over'),
            player_cards: @entangle('player_cards'),
            dealer_cards: @entangle('dealer_cards')
        }
    }
</script>
