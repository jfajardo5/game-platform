<div x-data="game()" class="py-8">
    <div class="mx-auto overflow-hidden bg-white shadow-xl max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg">
        <div class="flex flex-col items-center justify-center p-3 text-center">
            <span x-show.transition="rounds > 0" class="text-lg animate__animated animate__fadeIn">Round: {{ $rounds }}</span>
        </div>
        <div class="flex flex-row flex-wrap items-center justify-between p-8">
            <span class="text-lg">Dealer Score: {{ $dealerScore }} pts</span>
            <span class="text-lg">Player Score: {{ $playerScore }} pts</span>
        </div>
        <div class="flex flex-row flex-wrap items-center justify-center p-3 mb-2 h-36 lg:h-64">
            <template x-for="card in dealerCards">
                <div class="flex flex-col items-center justify-center p-2 text-center animate__animated animate__flipInY">
                    <span x-text="card.name + ' of ' + card.group" class="text-sm lg:text-lg"></span>
                    <img :src="card.image_url" class="w-16 lg:w-32">
                </div>
            </template>
        </div>
        <div class="flex flex-col items-center justify-center">
            <div x-show.transition="gameIsOver" class="fixed z-10 flex flex-col items-center justify-center px-6 py-4 m-4 text-center text-green-700 bg-green-100 border border-green-400 rounded-lg shadow-xl w-96 animate__animated animate__backInDown" role="alert">
                    <strong class="text-3xl font-bold">{{ $flashMessage }}</strong>
                    <button x-show="gameIsOver" wire:click="mount()" class="px-4 py-2 m-2 font-bold text-white transition bg-black border-b-4 border-gray-700 rounded max-w-16 hover:bg-gray-400 hover:border-gray-500">Play Again?</button>
                </div>
        </div>
        <hr>
        <div class="flex flex-row flex-wrap items-center justify-center p-3 h-36 lg:h-64">
            <template x-for="card in playerCards">
                <div class="flex flex-col items-center justify-center p-2 text-center animate__animated animate__flipInY">
                    <span x-text="card.name + ' of ' + card.group" class="text-sm lg:text-lg"></span>
                    <img :src="card.image_url" class="w-16 lg:w-32">
                </div>
            </template>
        </div>
        <div class="flex flex-row items-center justify-center p-4">
            <button x-bind:disabled="gameRunning" x-show="!gameIsOver" wire:click="hitRound()" class="py-2 m-2 font-bold text-white transition bg-black border-b-4 border-gray-700 rounded px-7 hover:bg-gray-400 hover:border-gray-500">Hit!</button>
            <button x-bind:disabled="gameRunning" x-show="rounds > 0 && !gameIsOver" wire:click="stand()" class="px-4 py-2 m-2 font-bold text-white transition bg-black border-b-4 border-gray-700 rounded hover:bg-gray-400 hover:border-gray-500">Stand</button>
        </div>
        <div class="p-4 text-center">
            <label class="text-xl">Your balance: ${{ $playerBalance }}</label>
        </div>
    </div>
</div>
<script>
    function game() {
        return {
            rounds: @entangle('rounds'),
            gameRunning: @entangle('gameRunning'),
            gameIsOver: @entangle('gameIsOver'),
            playerCards: @entangle('playerCards'),
            dealerCards: @entangle('dealerCards')
        }
    }
</script>
